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

if (!$subaction) $subaction = 'basket';
$def_id = 5; // default user id like none or anonymous

$in_var = array('ip'=>'', 'cnt'=>'', 'discount_code'=>'');

$items_list = array();
$item = array();
$ds_info = array();
$ds_factor = 0;
$ds_type = 'fix';
$ds_code = '';
$basket_amount = 0;
$total_price = 0;
$total_price_nett = 0;
$bs_cnt = 0;
$tpl = 'content_default.tpl';

// GET CONFIG DATA
$cfg_local = configGetInfo(DB_PREFIX, $db_link, 115); // shop module
foreach ($cfg_local as $tmp_var=>$tmp_param)
	$$tmp_var = $tmp_param;

// include
include 'modules/shop/func_shop_basket.php';

if (!$sid) { $sid = ''; $action = 'list'; $subaction = ''; $error_msg = $SYS_WARN_MSG['session_old']; }

switch ($action) {
case 'list':
	$tpl = 'content_shop_basket_list.tpl';
	// read amounts
	$bs_cnt = basketLines(DB_PREFIX, $db_link, $sid);
	// refresh
	if ($subaction == 'refresh' && $bs_cnt) {
		$in_var = trimRequestValues($in_var);
		$tmp_pid = 0;
		$tmp_cnt = 0;
		//update basket
		for ($i = 0; $i < $in_var['cnt']; $i ++) {
			$id_s = 'id'.$i;
			$cnt_s = 'cnt'.$i;
			$tmp_pid = isset($_POST[$id_s])?$_POST[$id_s]:0;
			$tmp_cnt = isset($_POST[$cnt_s])?$_POST[$cnt_s]:0;
			if (isset($tmp_pid) && isset($tmp_cnt)) {
				if ($tmp_pid < 0) $tmp_pid = 0;
				if ($tmp_cnt < 0) $tmp_cnt = 0;
				if (basketUpdate(DB_PREFIX, $db_link, $sid, $tmp_pid, $tmp_cnt)) $warning_msg = $SYS_WARN_MSG['updated'];
				else $error_msg = $SYS_WARN_MSG['notupdated'];
			}
		}
		// update discount
		if ($in_var['discount_code']) $ds_code = $in_var['discount_code'];
		else discountClear(DB_PREFIX, $db_link, $sid);
	}
	// list all
	// find discount code
	if (!$ds_code && $bs_cnt > 0) $ds_code = discountInBasket(DB_PREFIX, $db_link, $sid);
	// discount: enabled and active
	if ($ds_code && $bs_cnt > 0) {
		$ds_info = discountInfo(DB_PREFIX, $db_link, $ds_code, $format_dec_point, $format_ths_sep);
		// if not reusable find order
		if ($ds_info) if ($ds_info['reusable'] == 0) {
			$cnt = discountInOrder(DB_PREFIX, $db_link, $ds_code);
			if ($cnt > 0) { // reset if already used
				$ds_info = array();
				discountClear(DB_PREFIX, $db_link, $sid);
			}
		}
		// calculate factor
		if ($ds_info) if ($ds_info['price'] > 0) {
			if ($ds_info['price_type'] == 'pct') {
				$ds_factor = round((0 - $ds_info['price']), 3);
				$ds_type = $ds_info['price_type'];
			} else $ds_factor = round((0 - $ds_info['price'] / $bs_cnt), 3);
			// update discount
			discountUpdate(DB_PREFIX, $db_link, $sid, $ds_type, $ds_factor, $ds_code);
		}
	}
	// list
	$items_list = basketList(DB_PREFIX, $db_link, $sid, $format_dec_point, $format_ths_sep);
	foreach ($items_list as $item) {
		$basket_amount += $item['amount'];
		$total_price += $item['total_price'];
		$total_price_nett += $item['total_price_nett'];
	}
	// assign basket list
	assignArray($items_list, 'items_list');
	// assign discount
	assignArray($ds_info, 'discount_info');
	// assign subtotal
	assignArray(array( 'currency'=>$shp_currency, 'total_price'=>$total_price, 'total_price_str'=>number_format($total_price,2,$format_dec_point,$format_ths_sep),
			   'total_price_nett'=>$total_price_nett, 'total_price_nett_str'=>number_format($total_price_nett,3,$format_dec_point,$format_ths_sep)
			    ), 'sum_list');
	unset($items_list);
	unset($item);
	$view_mode = 1;
break;
//------------------------------------------------------------
case 'details':
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
// short info
$smarty->assign('basket_amount', $basket_amount);

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
