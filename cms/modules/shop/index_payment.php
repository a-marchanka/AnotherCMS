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
 
$in_var = array('id'=>'', 'code'=>'', 'title'=>'', 'country_code'=>'', 'price'=>'', 'price_type'=>'', 'currency'=>'', 'tax'=>'', 'enabled'=>'', 'modifytime'=>'');

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
include 'modules/shop/func_payment.php';

switch ($action) {
case 'delete':
	if ($details_id) {
		if (paymentDelete(DB_PREFIX, $db_link, $details_id))
			$warning_msg .= $SYS_WARN_MSG['deleted'];
		else
			$error_msg .= $SYS_WARN_MSG['notdeleted'];
	}
	$action = 'list';
//------------------------------------------------------------
case 'list':
	// list
	include 'inc_payment_list.php';
	$view_mode = 1;
break;
//------------------------------------------------------------
case 'details':
	// DISPLAY DOCUMENT
	if ($subaction == 'payment') {
		if ($details_id) {
			// assign details
			$details = paymentGetInfo(DB_PREFIX, $db_link, $details_id);
		} else {
			$details['code'] = 'cash';
			$details['title'] = 'Cash and self pick up';
			$details['price'] = 0.0;
			$details['price_type'] = 'fix';
			$details['country_code'] = '--';
			$details['currency'] = $shp_currency;
			$details['tax'] = 19.0;
			$details['enabled'] = 1;
		}
		assignArray($details, 'details');
		unset($details);
		$tpl = 'shop_payment_details.tpl';
		$view_mode = 1;
		$action = 'list';
	}
break;
//------------------------------------------------------------
case 'edit':
case 'create':
	if ($action == 'create') $details_id = 0; // empty for new

	if ($subaction == 'payment') $tpl = 'shop_payment_details.tpl';
	// edit
	include 'inc_payment_edit.php';

	if ($subaction == 'save_close') {
		if ($success > 0) include 'inc_payment_list.php';
		else $tpl = 'shop_payment_details.tpl';
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
	$smarty->display((($tpl) ? ($tpl) : ('shop_payment_details.tpl')));
} else {
	$right_frame = ($tpl) ? ($tpl) : ('shop_payment_list.tpl');
}

// unset variables
unset($in_var);
unset($out_var);

?>
