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

$in_var = array('id'=>'', 'priority'=>'', 'code'=>'', 'title'=>'', 'country_code'=>'', 'country'=>'', 'weight_kg1'=>'', 'weight_kg2'=>'', 'weight_kg3'=>'', 'weight_kg4'=>'',
		'price_kg1'=>'', 'price_kg2'=>'', 'price_kg3'=>'', 'price_kg4'=>'', 'length_cm1'=>'', 'length_cm2'=>'', 'length_cm3'=>'', 'length_cm4'=>'',
		'price_cm1'=>'', 'price_cm2'=>'', 'price_cm3'=>'', 'price_cm4'=>'', 'currency'=>'', 'tax'=>'', 'enabled'=>'', 'modifytime'=>'');

$search_var = array('sort'=>'', 'filter'=>'', 'page'=>'');

$sort_list = array(
	'0'=>array('id'=>'up_code', 'title'=>$SYS_WARN_MSG['title'].' &uarr;'),
	'1'=>array('id'=>'dw_code', 'title'=>$SYS_WARN_MSG['title'].' &darr;'),
	'2'=>array('id'=>'up_enabled', 'title'=>$SYS_WARN_MSG['status'].' &uarr;'),
	'3'=>array('id'=>'dw_enabled', 'title'=>$SYS_WARN_MSG['status'].' &darr;')
	);
assignArray($sort_list, 'sort_list');

$success = 0;
$in_db_var = array();
$out_var = array();

// GET CONFIG DATA
$cfg_local = configGetInfo(DB_PREFIX, $db_link, 115); // shop module
foreach ($cfg_local as $tmp_var=>$tmp_param)
	$$tmp_var = $tmp_param;
$smarty->assign('currency', $shp_currency);

// db functions
include 'modules/shop/func_delivery.php';

switch ($action) {
case 'delete':
	if ($details_id) {
		if (deliveryDelete(DB_PREFIX, $db_link, $details_id))
			$warning_msg .= $SYS_WARN_MSG['deleted'];
		else
			$error_msg .= $SYS_WARN_MSG['notdeleted'];
	}
	$action = 'list';
//------------------------------------------------------------
case 'list':
	// list
	include 'inc_delivery_list.php';
	$view_mode = 1;
break;
//------------------------------------------------------------
case 'details':
	// DISPLAY DOCUMENT
	if ($subaction == 'delivery') {
		if ($details_id) {
			// assign details
			$details = deliveryGetInfo(DB_PREFIX, $db_link, $details_id);
		} else {
			$search_s = $cfg_profile['dlv_sort'];
			$search_var = explodeRequestValues($search_s);
			$details['code'] = 'dhl';
			$details['title'] = '';
			$details['country_code'] = '--';
			$details['country'] = $cnt_country;
			$details['weight_kg1'] = '';
			$details['weight_kg2'] = '';
			$details['weight_kg3'] = '';
			$details['weight_kg4'] = '';
			$details['price_kg1'] = 0.0;
			$details['price_kg2'] = 0.0;
			$details['price_kg3'] = 0.0;
			$details['price_kg4'] = 0.0;
			$details['length_cm1'] = '';
			$details['length_cm2'] = '';
			$details['length_cm3'] = '';
			$details['length_cm4'] = '';
			$details['price_cm1'] = 0.0;
			$details['price_cm2'] = 0.0;
			$details['price_cm3'] = 0.0;
			$details['price_cm4'] = 0.0;
			$details['tax'] = 19.0;
			$details['currency'] = $shp_currency;
			$details['enabled'] = 0;
		}
		assignArray($details, 'details');
		unset($details);
		$tpl = 'shop_delivery_details.tpl';
		$view_mode = 1;
		$action = 'list';
	}
break;
//------------------------------------------------------------
case 'edit':
case 'create':
	if ($action == 'create') $details_id = 0; // empty for new

	if ($subaction == 'delivery') $tpl = 'shop_delivery_details.tpl';
	// edit
	include 'inc_delivery_edit.php';

	if ($subaction == 'save_close') {
		if ($success > 0) include 'inc_delivery_list.php';
		else $tpl = 'shop_delivery_details.tpl';
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
	$smarty->display((($tpl) ? ($tpl) : ('shop_delivery_details.tpl')));
} else {
	$right_frame = ($tpl) ? ($tpl) : ('shop_delivery_list.tpl');
}

// unset variables
unset($in_var);
unset($out_var);

?>
