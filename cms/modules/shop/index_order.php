<?php
/* ================================================= ##
##             COPYRIGHTS © Another CMS              ##
## ================================================= ##
## PRODUCT : CMS(CONTENT MANAGEMENT SYSTEM)          ##
## LICENSE : GNU(General Public License v.3)         ##
## TECHNOLOGIES : PHP & Sqlite                       ##
## WWW : www.zapms.de | www.marchenko.de             ##
## E-MAIL : andrey@marchenko.de                      ##
## ================================================= */

$details_id = 0;

if (!empty($_POST['details_id']) || !empty($_GET['details_id']))
$details_id = (!empty($_POST['details_id'])) ? $_POST['details_id'] : $_GET['details_id'];
if (!is_numeric($details_id)) $details_id = 0;

$in_var = array('id'=>'', 'cust_name'=>'', 'cust_surname'=>'', 'cust_title'=>'', 'cust_reference'=>'', 'cust_firm'=>'', 'bill_email'=>'', 'bill_tel'=>'',
		'cust_street'=>'', 'cust_postcode'=>'', 'cust_city'=>'', 'cust_country_code'=>'', 'bill_birth_year'=>'', 'bill_name'=>'', 'bill_surname'=>'',
		'bill_title'=>'', 'bill_reference'=>'', 'bill_firm'=>'', 'bill_firm_vat_nr'=>'', 'bill_street'=>'', 'bill_postcode'=>'', 'bill_city'=>'',
		'bill_country_code'=>'', 'bill_total_gross'=>'', 'bill_total_nett'=>'', 'bill_nr'=>'', 'bill_receipt'=>'', 'delivery_receipt'=>'', 'delivery_code'=>'',
		'delivery_gross'=>'', 'delivery_nett'=>'', 'tracking_nr'=>'', 'payment_code'=>'', 'payment_gross'=>'', 'payment_nett'=>'', 'txn_nr'=>'',
		'discount_code'=>'', 'discount_price'=>'', 'weight_kg_sum'=>'', 'length_cm_max'=>'', 'terms_flag'=>'', 'last_step'=>'', 'notes'=>'',
		'status'=>'', 'old_status'=>'', 'agent'=>'', 'createtime'=>'', 'modifytime'=>'', 'closetime'=>'', 'paytime'=>'', 'createnick'=>'');

$search_var = array('sort' => '', 'filter' => '', 'page' => '');

$sort_list = array(
	'0' => array('id' => 'up_status', 'title' => $SYS_WARN_MSG['status'].' &uarr;'),
	'1' => array('id' => 'dw_status', 'title' => $SYS_WARN_MSG['status'].' &darr;'),
	'2' => array('id' => 'up_modifytime', 'title' => $SYS_WARN_MSG['date'].' &uarr;'),
	'3' => array('id' => 'dw_modifytime', 'title' => $SYS_WARN_MSG['date'].' &darr;')
	);
assignArray($sort_list, 'sort_list');

$success = 0;
$in_db_var = array();
$out_var = array();
$delivery_list = array();
$payment_list = array();
$country_list = array();
$basket_list = array();
// assign module variables
$smarty->assign('tinymce_css', $tinymce_css);

// GET CONFIG DATA
$cfg_local = configGetInfo(DB_PREFIX, $db_link, 115); // shop module
foreach ($cfg_local as $tmp_var=>$tmp_param)
	$$tmp_var = $tmp_param;
$smarty->assign('currency', $shp_currency);

// ord_status - status_list
$tmp = explode(';', htmlDecode($ord_status));
for ($i=0; $i<sizeof($tmp); $i++) {
	$tmp_var = explode('=', $tmp[$i]);
	$status_array[$i] = array('id' => trim($tmp_var[0]), 'title' => trim($tmp_var[1]));
}
assignArray($status_array, 'status_list');

// db functions
include 'modules/shop/func_order.php';
include 'modules/shop/func_product.php';
include 'modules/mailer.php';

$delivery_list = getDeliveryList(DB_PREFIX, $db_link);
$payment_list = getPaymentList(DB_PREFIX, $db_link);
$country_list = getCountryList(DB_PREFIX, $db_link);
assignArray($delivery_list, 'delivery_list');
assignArray($payment_list, 'payment_list');
assignArray($country_list, 'country_list');

switch ($action) {
case 'delete':
	if ($details_id) {
		if (orderDelete(DB_PREFIX, $db_link, $details_id) && basketCleanup(DB_PREFIX, $db_link))
			$warning_msg .= $SYS_WARN_MSG['deleted'];
		else
			$error_msg .= $SYS_WARN_MSG['notdeleted'];
	}
	$action = 'list';
//------------------------------------------------------------
case 'list':
	// list
	include 'inc_order_list.php';
	$view_mode = 1;
break;
//------------------------------------------------------------
case 'details':
	// reference
	$ref_list = array('mr_id'=>$SYS_WARN_MSG['mr_id'],'mr_ref'=>$SYS_WARN_MSG['mr_ref'],'ms_id'=>$SYS_WARN_MSG['ms_id'],'ms_ref'=>$SYS_WARN_MSG['ms_ref']);
	assignArray($ref_list, 'reference_list');
	// display next bill
	$smarty->assign('bill_nr_next', orderGetNextBill(DB_PREFIX, $db_link));
	if ($subaction == 'order') {
		if ($details_id) {
			// assign details
			$details = orderGetInfo(DB_PREFIX, $db_link, $details_id);
		} else {
			$details['sid'] = '';
			$details['bill_nr'] = 0;
			$details['cust_name'] = '';
			$details['cust_surname'] = '';
			$details['cust_title'] = '';
			$details['cust_reference'] = '';
			$details['cust_firm'] = '';
			$details['bill_firm_vat_nr'] = '';
			$details['bill_tel'] = '';
			$details['bill_email'] = '';
			$details['bill_birth_year'] = '';
			$details['cust_street'] = '';
			$details['cust_postcode'] = '';
			$details['cust_city'] = '';
			$details['cust_country_code'] = '';
			$details['bill_name'] = '';
			$details['bill_surname'] = '';
			$details['bill_title'] = '';
			$details['bill_reference'] = '';
			$details['bill_firm'] = '';
			$details['bill_street'] = '';
			$details['bill_postcode'] = '';
			$details['bill_city'] = '';
			$details['bill_country_code'] = '';
			$details['terms_flag'] = 1;
			$details['last_step'] = 1;
			$details['notes'] = '';
			$details['status'] = 0;
			$details['agent'] = '';
			$details['createtime'] = 0;
			$details['modifytime'] = 0;
			$details['closetime'] = 0;
			$details['paytime'] = 0;
			$details['createnick'] = '';
		}
		assignArray($details, 'details');
		unset($details);
		$tpl = 'shop_order_details.tpl';
		$view_mode = 1;
		$action = 'list';
	}
	if ($subaction == 'options') {
		if ($details_id) {
			// assign details
			$details = orderGetInfo(DB_PREFIX, $db_link, $details_id);
			if (isset($details['bill_receipt'])) $details['bill_receipt'] = htmlEncode($details['bill_receipt']);
			if (isset($details['delivery_receipt'])) $details['delivery_receipt'] = htmlEncode($details['delivery_receipt']);
		} else {
			$details['bill_nr'] = 0;
			$details['bill_total_gross'] = 0.0;
			$details['bill_total_nett'] = 0.0;
			$details['bill_receipt'] = '';
			$details['tracking_nr'] = '';
			$details['discount_code'] = '';
			$details['discount_price'] = 0.0;
			$details['delivery_receipt'] = '';
			$details['payment_code'] = '';
			$details['payment_gross'] = 0.0;
			$details['payment_nett'] = 0.0;
			$details['txn_nr'] = '';
			$details['delivery_code'] = '';
			$details['delivery_gross'] = 0.0;
			$details['delivery_nett'] = 0.0;
			$details['weight_kg_sum'] = 0.0;
			$details['length_cm_max'] = 0.0;
			$details['status'] = 0;
			$details['createtime'] = 0;
			$details['modifytime'] = 0;
			$details['closetime'] = 0;
			$details['paytime'] = 0;
		}
		assignArray($details, 'details');
		unset($details);
		$tpl = 'shop_order_options.tpl';
		$view_mode = 1;
		$action = 'list';
	}
	if ($subaction == 'bill' || $subaction == 'bill_email' || $subaction == 'delivery' || $subaction == 'delivery_email' || $subaction == 'dunning' || $subaction == 'dunning_email') {
		// get info
		$details = orderGetInfo(DB_PREFIX, $db_link, $details_id, $format_dec_point, $format_ths_sep);
		// country, delivery and payment
		for ($i = 0; $i < sizeof($country_list); $i ++) {
		if ($country_list[$i]['country_code'] == $details['cust_country_code']) $details['cust_country'] = $country_list[$i]['country'];
		if ($country_list[$i]['country_code'] == $details['bill_country_code'])	$details['bill_country'] = $country_list[$i]['country'];
		}
		for ($i = 0; $i < sizeof($delivery_list); $i ++) {
		if ($delivery_list[$i]['code'] == $details['delivery_code']) $details['delivery'] = $delivery_list[$i]['title'];
		}
		for ($i = 0; $i < sizeof($payment_list); $i ++) {
		if ($payment_list[$i]['code'] == $details['payment_code']) $details['payment'] = $payment_list[$i]['title'];
		}
		if (isset($details['bill_receipt'])) $details['bill_receipt'] = htmlDecode($details['bill_receipt']);
		if (isset($details['delivery_receipt'])) $details['delivery_receipt'] = htmlDecode($details['delivery_receipt']);
		$details['cust_reference'] = buildReference($ref_list, $details['cust_name'], $details['cust_surname'], $details['cust_title'], $details['cust_reference']);
		$details['current_date'] = date('d.m.Y');
		// merge all
		$details = array_merge($details, $cfg_local);
		//print_r($details);
		$tmp_subj = '';
		$tpl_html = '';
		if ($subaction == 'bill' || $subaction == 'bill_email') { $tpl_html = 'shop_order_bill.tpl'; $tmp_subj = 'Rechnung '.$details['bill_nr']; }
		if ($subaction == 'delivery' || $subaction == 'delivery_email') { $tpl_html = 'shop_order_delivery.tpl'; $tmp_subj = 'Lieferschein '.$details['bill_nr']; }
		if ($subaction == 'dunning' || $subaction == 'dunning_email') { $tpl_html = 'shop_order_dunning.tpl'; $tmp_subj = 'Zahlungserinnerung '.$details['bill_nr']; }
		// content
		$tmp_log = replaceContentWithValues(getContentFromPath($site_dir.$usr_tpl.$tpl_html), $details);
		// send email
		if ($subaction == 'bill_email' || $subaction == 'delivery_email' || $subaction == 'dunning_email') {
			if (mailerSendSimple($sys_mx, $details['bill_email'], $details['bill_email'], $details['cnt_email'], $details['cnt_email'], '', $tmp_subj, $tmp_log, $site_url.'/images/w3.css')) {
				$warning_msg .= $SYS_WARN_MSG['email_sent'];
				$success = 1;
			} else $error_msg .= $SYS_WARN_MSG['email_notsend'];
		}
		$smarty->assign('subaction', $subaction);
		$smarty->assign('log', '<div class="w3-small">'.$tmp_log.'</div>');
		unset($tmp_log);
		unset($tpl_html);
		unset($details);
		$tpl = 'shop_order_email_src.tpl';
		$view_mode = 2;
		$action = 'list';
	}
break;
//------------------------------------------------------------
case 'edit':
case 'create':
	// reference
	$ref_list = array('mr_id'=>$SYS_WARN_MSG['mr_id'],'mr_ref'=>$SYS_WARN_MSG['mr_ref'],'ms_id'=>$SYS_WARN_MSG['ms_id'],'ms_ref'=>$SYS_WARN_MSG['ms_ref']);
	assignArray($ref_list, 'reference_list');
	// take next bill
	$smarty->assign('bill_nr_next', orderGetNextBill(DB_PREFIX, $db_link));
	// verify input
	$in_var = trimRequestValues($in_var);
	// select display forms
	if ($action == 'create') $details_id = 0; // empty for new
	if ($subaction == 'order') $tpl = 'shop_order_details.tpl';
	if ($subaction == 'order_options') $tpl = 'shop_order_options.tpl';
	// edit product
	if ($subaction == 'order' || $subaction == 'save_close') include 'inc_order_edit.php';
	// edit prices
	if ($subaction == 'order_options' || $subaction == 'save_close_options') include 'inc_order_options_edit.php';
	// take basket into stock
	if ($details_id && $in_var['status'] > 0 && $in_var['old_status'] > 0) {
		$order_sid = orderGetSid(DB_PREFIX, $db_link, $details_id);
		if ($order_sid) {
		$basket_list = basketList(DB_PREFIX, $db_link, $order_sid); //print_r($basket_list);
		if ($basket_list) foreach ($basket_list as $item) {
			$cnt_minus = $item['amount_total'] - $item['amount'];
			$cnt_plus = $item['amount_total'] + $item['amount'];
			// product minus
			if ( $in_var['status'] != 4 && $in_var['old_status'] == 4 )
				productUpdate(DB_PREFIX, $db_link, $item['id'], array('amount_total'=>$cnt_minus));
			// product back when canceled
			if ( $in_var['status'] == 4 && $in_var['old_status'] != 4 )
				productUpdate(DB_PREFIX, $db_link, $item['id'], array('amount_total'=>$cnt_plus));
		}
		}
		unset($basket_list);
	}
	// list
	if ($subaction == 'save_close') {
		if ($success > 0) include 'inc_order_list.php';
		else $tpl = 'shop_order_details.tpl';
	}
	if ($subaction == 'save_close_options') {
		if ($success > 0) include 'inc_order_list.php';
		else $tpl = 'shop_order_options.tpl';
	}
	$view_mode = 1;
	$action = 'list';
break;
//------------------------------------------------------------
default:
	$error_msg = $SYS_WARN_MSG['action_wrong'];
	$tpl = 'core_error.tpl';
	$action = 'list';
	$view_mode = 1;
}
//------------------------------------------------------------
// VIEW
if ($view_mode > 1) {
	$smarty->assign('error_msg', $error_msg);
	$smarty->assign('warning_msg', $warning_msg);
	$smarty->assign('success', $success);
	$smarty->assign('SID', $SID);
	$smarty->display((($tpl) ? ($tpl) : ('shop_order_details.tpl')));
} else {
	$right_frame = ($tpl) ? ($tpl) : ('shop_order_list.tpl');
}

// unset variables
unset($in_var);
unset($out_var);

?>
