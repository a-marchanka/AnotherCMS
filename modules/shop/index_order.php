<?php
/* ==================================================== ##
##             COPYRIGHTS © Another CMS                 ##
## ==================================================== ##
## PRODUCT : CMS(CONTENT MANAGEMENT SYSTEM)             ##
## LICENSE : GNU(General Public License v.3)            ##
## TECHNOLOGIES : PHP & Sqlite                          ##
## WWW : www.zapms.de | www.marchenko.de                ##
## E-MAIL : andrey@marchenko.de                         ##
## ==================================================== */

if (!$subaction) $subaction = '';
$def_id = 5; // default user id like none or anonymous

$in_var = array(
	'ip'=>'', 'id'=>'', 'sid'=>'', 'cust_name'=>'', 'cust_surname'=>'', 'cust_title'=>'', 'cust_reference'=>'', 'cust_firm'=>'', 'bill_firm_vat_nr'=>'',
	'bill_email'=>'', 'bill_tel'=>'', 'cust_street'=>'', 'cust_postcode'=>'', 'cust_city'=>'', 'cust_country_code'=>'', 'bill_name'=>'', 'bill_surname'=>'',
	'bill_title'=>'', 'bill_reference'=>'',	'bill_firm'=>'', 'bill_street'=>'', 'bill_postcode'=>'', 'bill_city'=>'', 'bill_country_code'=>'', 'bill_birth_year'=>'',
	'terms_flag'=>'', 'notes'=>'', 'delivery_code'=>'', 'delivery_gross'=>'', 'delivery_nett'=>'', 'tracking_nr'=>'', 'payment_code'=>'', 'payment_gross'=>'',
	'payment_nett'=>'', 'txn_nr'=>'', 'bill_nr'=>'', 'discount_code'=>'', 'discount_price'=>'', 'basket'=>'', 'basket_gross'=>'', 'basket_nett'=>'',
	'weight_kg_sum'=>'', 'length_cm_max'=>'', 'last_step'=>'', 'notes'=>'', 'status'=>'', 'agent'=>'', 'createtime'=>'', 'modifytime'=>'', 'closetime'=>'',
	'paytime'=>'', 'createnick'=>'', 'total_gross' => '', 'total_nett' => '', 'agent' => '');

$delivery_list = array();
$payment_list = array();
$country_list = array();
$ref_list = array();
$basket_list = array();
$discount_list = array();
$order_list = array('bill_reference'=>'', 'bill_country_code'=>'DE', 'bill_birth_year'=>'1971', 'cust_reference'=>'', 'cust_country_code'=>'DE');
$in_db_var = array();
$item = array();
$tab = 1;
$or_cnt = 0;
$bs_cnt = 0;
$details_id = 0;
$tpl = 'content_default.tpl';

// get details id
if (!empty($_POST['details_id']) || !empty($_GET['details_id']))
$details_id = (!empty($_POST['details_id'])) ? $_POST['details_id'] : $_GET['details_id'];
if (!is_numeric($details_id)) $details_id = 0;

// GET CONFIG DATA
$cfg_shop = configGetInfo(DB_PREFIX, $db_link, 115); // shop module
foreach ($cfg_shop as $tmp_var=>$tmp_param)
	$$tmp_var = $tmp_param;
$cfg_paym = configGetInfo(DB_PREFIX, $db_link, 128); // payments
foreach ($cfg_paym as $tmp_var=>$tmp_param)
	$$tmp_var = $tmp_param;

// include
include 'modules/shop/func_shop_basket.php';
include 'modules/shop/func_shop_order.php';
include 'modules/shop/func_shop_paypal.php';

if (!$sid) { $sid = ''; $action = 'list'; $subaction = ''; $error_msg = $SYS_WARN_MSG['session_old']; }

switch ($action) {
case 'list':
	$tpl = 'content_shop_order_list.tpl';
	// number of order and basket
	$or_cnt = orderLines(DB_PREFIX, $db_link, $sid);
	$bs_cnt = basketLines(DB_PREFIX, $db_link, $sid);
	//----------------------------
	if ($bs_cnt) {
		$in_var = trimRequestValues($in_var);
		//----------------------------
		// basket
		$basket_list = basketList(DB_PREFIX, $db_link, $sid, $format_dec_point, $format_ths_sep);
		$basket_kg = 0;
		$basket_cm = 0;
		$basket_amount = 0;
		$basket_price = 0;
		$basket_price_nett = 0;
		$basket_subprice = 0;
		$basket_subprice_nett = 0;
		$discount_price = 0;
		$discount_code = '';
		if ($basket_list) foreach ($basket_list as $item) {
			$basket_kg += $item['weight_kg'];
			if ($item['length_cm'] > $basket_cm) $basket_cm = $item['length_cm'];
			$basket_amount += $item['amount'];
			$basket_price += $item['total_price'];
			$basket_price_nett += $item['total_price_nett'];
			$basket_subprice += $item['subtotal_price'];
			$basket_subprice_nett += $item['subtotal_price_nett'];
			$discount_price += $item['subtotal_price'] - $item['total_price'];
			$discount_code = $item['discount_code'];
		}
		$smarty->assign('basket_amount', $basket_amount);
		//----------------------------
		// reference
		$ref_list = array('mr_id'=>$SYS_WARN_MSG['mr_id'],'mr_ref'=>$SYS_WARN_MSG['mr_ref'],'ms_id'=>$SYS_WARN_MSG['ms_id'],'ms_ref'=>$SYS_WARN_MSG['ms_ref']);
		assignArray($ref_list, 'reference_list');
		//----------------------------
		// country
		$country_list = getCountryList(DB_PREFIX, $db_link);
		assignArray($country_list, 'country_list');
		//----------------------------
		// delivery
		$delivery_list = getDeliveryList(DB_PREFIX, $db_link, $in_var['cust_country_code'], $basket_kg, $basket_cm, $format_dec_point, $format_ths_sep);
		assignArray($delivery_list, 'delivery_list');
		//----------------------------
		// payment
		$payment_list = getPaymentList(DB_PREFIX, $db_link, $in_var['bill_country_code'], $basket_price, $format_dec_point, $format_ths_sep);
		assignArray($payment_list, 'payment_list');
	}
	// refresh
	if ($subaction == 'refresh' && $bs_cnt) {
		// bill address
		if ( $in_var['bill_email'] && $in_var['bill_name'] && $in_var['bill_surname'] && $in_var['bill_street'] && $in_var['bill_postcode'] && $in_var['bill_city'] && $in_var['bill_country_code'] && $in_var['bill_birth_year'] ) {
			// PREPARING TO UPDATE
			$in_var['modifytime'] = time();
			$in_db_var['sid'] = '\''.$in_var['sid'].'\'';
			$in_db_var['modifytime'] = $in_var['modifytime'];
			$in_db_var['bill_email'] = '\''.$in_var['bill_email'].'\'';
			$in_db_var['bill_tel'] = '\''.$in_var['bill_tel'].'\'';
			$in_db_var['bill_birth_year'] = $in_var['bill_birth_year'];
			$in_db_var['bill_firm_vat_nr'] = '\''.$in_var['bill_firm_vat_nr'].'\'';
			$in_db_var['bill_name'] = '\''.$in_var['bill_name'].'\'';
			$in_db_var['bill_surname'] = '\''.$in_var['bill_surname'].'\'';
			$in_db_var['bill_title'] = '\''.$in_var['bill_title'].'\'';
			$in_db_var['bill_reference'] = '\''.$in_var['bill_reference'].'\'';
			$in_db_var['bill_firm'] = '\''.$in_var['bill_firm'].'\'';
			$in_db_var['bill_street'] = '\''.$in_var['bill_street'].'\'';
			$in_db_var['bill_postcode'] = '\''.$in_var['bill_postcode'].'\'';
			$in_db_var['bill_city'] = '\''.$in_var['bill_city'].'\'';
			$in_db_var['bill_country_code'] = '\''.$in_var['bill_country_code'].'\'';
			$in_db_var['last_step'] = 1;
			$in_db_var['status'] = 0;
			$in_db_var['notes'] = '\''.$in_var['notes'].'\'';
			// discount
			$in_db_var['discount_code'] = '\''.$discount_code.'\'';
			$in_db_var['discount_price'] = $discount_price;
			$in_db_var['createnick'] = '\''.$in_var['createnick'].'\'';
			$tab = 1;
			// cusotmer address
			if ( $in_var['cust_name'] && $in_var['cust_surname'] && $in_var['cust_street'] && $in_var['cust_postcode'] && $in_var['cust_city'] && $in_var['cust_country_code'] && $in_var['terms_flag'] ) {
				$in_db_var['cust_firm'] = '\''.$in_var['cust_firm'].'\'';
				$in_db_var['cust_name'] = '\''.$in_var['cust_name'].'\'';
				$in_db_var['cust_surname'] = '\''.$in_var['cust_surname'].'\'';
				$in_db_var['cust_title'] = '\''.$in_var['cust_title'].'\'';
				$in_db_var['cust_reference'] = '\''.$in_var['cust_reference'].'\'';
				$in_db_var['cust_street'] = '\''.$in_var['cust_street'].'\'';
				$in_db_var['cust_postcode'] = '\''.$in_var['cust_postcode'].'\'';
				$in_db_var['cust_city'] = '\''.$in_var['cust_city'].'\'';
				$in_db_var['cust_country_code'] = '\''.$in_var['cust_country_code'].'\'';
				$in_db_var['terms_flag'] = $in_var['terms_flag'];
				$in_db_var['last_step'] = 2;
				// reset delivery
				$in_db_var['delivery_receipt'] = '\'\'';
				$in_db_var['delivery_code'] = '\'\'';
				$in_db_var['delivery_gross'] = 0;
				$in_db_var['delivery_nett'] = 0;
				$in_db_var['weight_kg_sum'] = 0;
				$in_db_var['length_cm_max'] = 0;
				// reset payment
				$in_db_var['bill_receipt'] = '\'\'';
				$in_db_var['payment_code'] = '\'\'';
				$in_db_var['payment_gross'] = 0;
				$in_db_var['payment_nett'] = 0;
				$tab = 2;
				// delivery
				if ( $in_var['delivery_code'] ) {
					$delivery_code = $in_var['delivery_code'];
					$delivery_title = '';
					$delivery_price = 0;
					$delivery_price_nett = 0;
					foreach ($delivery_list as $item) if ($item['delivery_code'] == $delivery_code) {
					$delivery_title = $item['delivery_title'];
					$delivery_price = $item['price'];
					$delivery_price_nett = $item['price_nett'];
					}
					$in_db_var['delivery_code'] = '\''.$delivery_code.'\'';
					$in_db_var['delivery_gross'] = $delivery_price;
					$in_db_var['delivery_nett'] = $delivery_price_nett;
					$in_db_var['weight_kg_sum'] = $basket_kg;
					$in_db_var['length_cm_max'] = $basket_cm;
					$in_db_var['last_step'] = 3;
					$tab = 3;
					// payment
					if ( $in_var['payment_code'] ) {
						$payment_code = $in_var['payment_code'];
						$payment_title = '';
						$payment_price = 0;
						$payment_price_nett = 0;
						foreach ($payment_list as $item) if ($item['payment_code'] == $payment_code) {
						$payment_title = $item['payment_title'];
						$payment_price = $item['price'];
						$payment_price_nett = $item['price_nett'];
						}
						$in_db_var['payment_code'] = '\''.$payment_code.'\'';
						$in_db_var['payment_gross'] = $payment_price;
						$in_db_var['payment_nett'] = $payment_price_nett;
						$in_db_var['last_step'] = 4;
						$tab = 4;
					} else $tab = 3;
				} else $tab = 2;
			} else $tab = 1;
		} else $tab = 1;
		//----------------------------
		// delivery and bill receipt
		if ($tab == 4) {
			$total_price = $basket_price + $payment_price + $delivery_price;
			$total_price_nett = $basket_price_nett + $payment_price_nett + $delivery_price_nett;
			$delv_service = '';
			$delv_receipt = '<table class="w3-table w3-bordered"><tbody><tr><th>Nr</th><th>Produkt</th><th class="w3-right-align">Anzahl</th></tr>';
			$bill_receipt = '<table class="w3-table w3-bordered"><tbody><tr><th>Nr</th><th>Produkt</th><th class="w3-right-align">Preis</th><th class="w3-right-align">Anzahl</th><th class="w3-right-align">Gesamtpreis</th></tr>';
			if ($basket_list) foreach ($basket_list as $item) {
			// product minus
			$cnt_minus = $item['amount_total'] - $item['amount'];
			productMinus(DB_PREFIX, $db_link, $item['id'], $cnt_minus);
			// delivery receipt
			$delv_receipt .= '<tr><td>'.$item['pr_number'].'</td><td>'.$item['title_1'].' '.$item['title_2'].'</td><td class="w3-right-align">'.$item['amount'].'</td></tr>';
			if ($item['descr']) $delv_service .= '<hr><b>'.$item['title_1'].' '.$item['title_2'].'</b><br>'.$item['descr'];
			// bill receipt
			$bill_receipt .= '<tr><td>'.$item['pr_number'].'</td><td>'.$item['title_1'].' '.$item['title_2'].'</td>';
			$bill_receipt .= '<td class="w3-right-align">'.$item['currency'].' '.$item['single_price_str'].'</td><td class="w3-right-align">'.$item['amount'].'</td>';
			$bill_receipt .= '<td class="w3-right-align">'.$item['currency'].' '.$item['subtotal_price_str'].'</td></tr>';
			}
			$delv_receipt .= '</tbody></table>'.$delv_service;
			if ($basket_subprice) $bill_receipt .= '<tr><td colspan="4" class="w3-right-align">Zwischensumme</td><td class="w3-right-align">'.number_format($basket_subprice, 2, $format_dec_point, $format_ths_sep).'</td></tr>';
			if ($discount_code) $bill_receipt .= '<tr><td colspan="4" class="w3-right-align">Gutschrift ('.$discount_code.')</td><td class="w3-right-align"> -'.number_format($discount_price, 2, $format_dec_point, $format_ths_sep).'</td></tr>';
			if ($payment_price) $bill_receipt .= '<tr><td colspan="4" class="w3-right-align">Zahlungskosten ('.$payment_title.')</td><td class="w3-right-align">'.number_format($payment_price, 2, $format_dec_point, $format_ths_sep).'</td></tr>';
			if ($delivery_price) $bill_receipt .= '<tr><td colspan="4" class="w3-right-align">Versandkosten ('.$delivery_title.')</td><td class="w3-right-align">'.number_format($delivery_price, 2, $format_dec_point, $format_ths_sep).'</td></tr>';
			$bill_receipt .= '<tr><td colspan="4" class="w3-right-align"><b>Total</b></td><td class="w3-right-align"><b>'.number_format($total_price, 2, $format_dec_point, $format_ths_sep).'</b></td></tr>';
			$bill_receipt .= '<tr><td colspan="4" class="w3-right-align">Total Netto</td><td class="w3-right-align">'.number_format($total_price_nett, 2, $format_dec_point, $format_ths_sep).'</td></tr>';
			$bill_receipt .= '</tbody></table>';
			// -------
			// PAYPAL
			$ppl_answer = array();
			if ($in_var['payment_code'] == 'paypal') {
				$return_url = $site_url.'/order?action=details&subaction=checkout&sid='.$sid;
				$cancel_url = $site_url.'/order?action=list&sid='.$sid;
				// get order details
				$txn_nr = 'na';
				$txn_nr = orderGetTxn(DB_PREFIX, $db_link, $sid);
				if ($txn_nr != 'na') {
					$ppl_answer = paypalShowOrder($ppl_url, $ppl_client_id, $ppl_client_secret, $txn_nr);
					//print_r($ppl_answer);
					if ($ppl_answer['status'] != 'PAYER_ACTION_REQUIRED' && $ppl_answer['status'] != 'APPROVED') $txn_nr = 'na';
					if ($ppl_answer['total_price'] != $total_price) $txn_nr = 'na';
				}
				if ($txn_nr == 'na') {
					$ppl_answer = paypalCreateOrder($ppl_url, $ppl_client_id, $ppl_client_secret, $ppl_locale, $ppl_currency, $return_url, $cancel_url, $details_id, $total_price);
					//print_r($ppl_answer);
					if ($ppl_answer['status'] == 'PAYER_ACTION_REQUIRED') {
						$txn_nr = $ppl_answer['txn_nr'];
						orderUpdateTxn(DB_PREFIX, $db_link, $sid, $txn_nr);
					} else $error_msg = $SYS_WARN_MSG['shop_payment_error'];
				}
				$smarty->assign('ppl_client_id', $ppl_client_id);
				$smarty->assign('ppl_locale', $ppl_locale);
				$smarty->assign('ppl_currency', $ppl_currency);
				$smarty->assign('ppl_checkout', $ppl_checkout);
				$smarty->assign('ppl_txn', $txn_nr);
			}
			// -------
			// update db
			$in_db_var['createtime'] = time();
			$in_db_var['bill_total_gross'] = $total_price;
			$in_db_var['bill_total_nett'] = $total_price_nett;
			$in_db_var['bill_receipt'] = '\''.$bill_receipt.'\'';
			$in_db_var['delivery_receipt'] = '\''.$delv_receipt.'\'';
			// assign
			$smarty->assign('bill_receipt', $bill_receipt);
			unset($delv_service);
			unset($delv_receipt);
			unset($bill_receipt);
		}
		//----------------------------
		// update - insert
		if ($or_cnt) {
			if (orderUpdate(DB_PREFIX, $db_link, $sid, $details_id, $in_db_var)) $warning_msg = $SYS_WARN_MSG['updated'];
			else $error_msg = $SYS_WARN_MSG['notupdated'];
		} else {
			$details_id = orderInsert(DB_PREFIX, $db_link, $sid, $in_db_var);
			if ($details_id) $warning_msg = $SYS_WARN_MSG['updated'];
			else $error_msg = $SYS_WARN_MSG['notupdated'];
		}
		$in_var['id'] = $details_id;
	}
	//----------------------------
	// order
	if ($details_id == 0) assignArray(orderGetInfo(DB_PREFIX, $db_link, $sid, $format_dec_point, $format_ths_sep), 'details');
	else assignArray($in_var, 'details');
	$smarty->assign('tab', $tab);

	$view_mode = 1;
break;
//------------------------------------------------------------
case 'details':
	$tpl = 'content_shop_order_list.tpl';
	$tab = 1;
	// number of order and basket
	$or_cnt = orderLines(DB_PREFIX, $db_link, $sid);
	$bs_cnt = basketLines(DB_PREFIX, $db_link, $sid);
	// close order
	//if ($subaction == 'checkout' && $bs_cnt && $or_cnt) {
		// take all info
		$order_list = orderGetInfo(DB_PREFIX, $db_link, $sid, $format_dec_point, $format_ths_sep);
		// close order and basket
		if ($order_list['id'] && $order_list['delivery_code'] && $order_list['payment_code']) {
		if (orderFinish(DB_PREFIX, $db_link, $sid, $order_list['id']) && basketFinish(DB_PREFIX, $db_link, $sid)) {
			$warning_msg = $SYS_WARN_MSG['updated'];
			// all lists
			$ref_list = array('mr_id'=>$SYS_WARN_MSG['mr_id'],'mr_ref'=>$SYS_WARN_MSG['mr_ref'],'ms_id'=>$SYS_WARN_MSG['ms_id'],'ms_ref'=>$SYS_WARN_MSG['ms_ref']);
			$country_list = getCountryList(DB_PREFIX, $db_link);
			$delivery_list = getDeliveryList(DB_PREFIX, $db_link, $order_list['cust_country_code'], 0, 0, $format_dec_point, $format_ths_sep);
			$payment_list = getPaymentList(DB_PREFIX, $db_link, $order_list['bill_country_code'], 0, $format_dec_point, $format_ths_sep);
			// country, delivery and payment
			foreach ($country_list as $item) {
			if ($item['country_code'] == $order_list['cust_country_code']) $order_list['cust_country'] = $item['country'];
			if ($item['country_code'] == $order_list['bill_country_code']) $order_list['bill_country'] = $item['country'];
			}
			foreach ($delivery_list as $item) {
			if ($item['delivery_code'] == $order_list['delivery_code']) $order_list['delivery'] = $item['delivery_title'];
			}
			foreach ($payment_list as $item) {
			if ($item['payment_code'] == $order_list['payment_code']) $order_list['payment'] = $item['payment_title'];
			}
			if (isset($order_list['bill_receipt'])) $order_list['bill_receipt'] = htmlDecode($order_list['bill_receipt']);
			if (isset($order_list['delivery_receipt'])) $order_list['delivery_receipt'] = htmlDecode($order_list['delivery_receipt']);
			$order_list['cust_reference'] = buildReference($ref_list, $order_list['cust_name'], $order_list['cust_surname'], $order_list['cust_title'], $order_list['cust_reference']);
			$order_list['current_date'] = date('d.m.Y');
			$order_list = array_merge($order_list, $cfg_shop);
			// select template
			switch ($order_list['payment_code']) {
			case 'prepaid': $tpl_html = 'shop_order_email_prepaid.tpl'; break;
			case 'postpaid': $tpl_html = 'shop_order_email_postpaid.tpl'; break;
			case 'elv': $tpl_html = 'shop_order_email_elv.tpl'; break;
			case 'post': $tpl_html = 'shop_order_email_post.tpl'; break;
			case 'cash': $tpl_html = 'shop_order_email_cash.tpl'; break;
			case 'paypal': $tpl_html = 'shop_order_email_paypal.tpl'; break;
			case 'creditcard': $tpl_html = 'shop_order_email_creditcard.tpl'; break;
			case 'sofortueberweisung': $tpl_html = 'shop_order_email_postpaid.tpl'; break;
			default: $tpl_html = 'shop_order_email_prepaid.tpl';
			}
			$html_email = replaceContentWithValues(getContentFromPath($site_dir.$usr_tpl.$tpl_html), $order_list);
			$smarty->assign('log', $html_email);
			// send email
			if (mailerSendSimple($sys_mx, $order_list['bill_email'], $order_list['bill_email'], $cnt_email, $cnt_email, '', 'Shop order Nr.'.$order_list['id'], $html_email, $site_url.'/images/w3.css'))
				$warning_msg .= ($warning_msg)?('<br>'):('').$SYS_WARN_MSG['email_sent'];
			else
				$error_msg .= ($warning_msg)?('<br>'):('').$SYS_WARN_MSG['email_notsent'];
			unset($html_email);
			// -------
			// PAYPAL
			$ppl_answer = array();
			if ($order_list['payment_code'] == 'paypal') {
				$txn_nr = orderGetTxn(DB_PREFIX, $db_link, $sid);
				if ($txn_nr != 'na') {
					$ppl_answer = paypalCaptureOrder($ppl_url, $ppl_client_id, $ppl_client_secret, $txn_nr);
					//print_r($ppl_answer);
					if ($ppl_answer['status'] == 'COMPLETED')
						orderUpdatePaytime(DB_PREFIX, $db_link, $sid);
					else $error_msg = $SYS_WARN_MSG['shop_payment_error'];
				}
			}
			// -------
		} else $error_msg = $SYS_WARN_MSG['notupdated'];
		$tab = 5;
		}
	//}
	$smarty->assign('tab', $tab);

	$view_mode = 1;
break;
//------------------------------------------------------------
case 'edit':
case 'create':
	$view_mode = 1;
	$action = 'list';
break;
//------------------------------------------------------------
default:
	$error_msg = $SYS_WARN_MSG['action_wrong'];
	$action = 'list';
	$view_mode = 1;
}

unset($delivery_list);
unset($payment_list);
unset($country_list);
unset($ref_list);
unset($basket_list);
unset($discount_list);
unset($order_list);
unset($cfg_shop);
unset($cfg_paym);
//------------------------------------------------------------
// VIEW
if ($view_mode > 1) {
	$smarty->assign('error_msg', $error_msg);
	$smarty->assign('warning_msg', $warning_msg);
	$smarty->assign('SID', $SID);
	$smarty->display($tpl);
} else
	$smarty->assign('pattern_content', $tpl);

?>
