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

$in_var = array('id'=>'', 'code'=>'', 'title'=>'', 'price'=>'', 'price_type'=>'', 'pattern'=>'', 'active_from'=>'', 'active_to'=>'', 'reusable'=>'', 'enabled'=>'', 'modifytime'=>'', 'createnick'=>'');
$search_var = array('sort'=>'', 'filter'=>'', 'page'=>'');
$sort_list = array(
	'0'=>array('id'=>'up_title', 'title'=>$SYS_WARN_MSG['title'].' &uarr;'),
	'1'=>array('id'=>'dw_title', 'title'=>$SYS_WARN_MSG['title'].' &darr;'),
	'2'=>array('id'=>'up_enabled', 'title'=>$SYS_WARN_MSG['status'].' &uarr;'),
	'3'=>array('id'=>'dw_enabled', 'title'=>$SYS_WARN_MSG['status'].' &darr;'),
	'4'=>array('id'=>'up_active_to', 'title'=>$SYS_WARN_MSG['date'].' &uarr;'),
	'5'=>array('id'=>'dw_active_to', 'title'=>$SYS_WARN_MSG['date'].' &darr;')
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
include 'modules/shop/func_discount.php';
// fm functions
include 'modules/fm/func_fm.php';

switch ($action) {
case 'delete':
	if ($details_id) {
		if (discountDelete(DB_PREFIX, $db_link, $details_id))
			$warning_msg .= $SYS_WARN_MSG['deleted'];
		else
			$error_msg .= $SYS_WARN_MSG['notdeleted'];
	}
	$action = 'list';
//------------------------------------------------------------
case 'list':
	// list
	include 'inc_discount_list.php';
	$view_mode = 1;
break;
//------------------------------------------------------------
case 'details':
	// forms
	if ($subaction == 'preview') {
		$details = discountGetInfo(DB_PREFIX, $db_link, $details_id, $format_dec_point, $format_ths_sep);
		if ($details['pattern']) {
			$details = array_merge($details, $cfg_local);
			//print_r($details);
			$smarty->assign('log', replaceContentWithValues(getContentFromPath($site_dir.$usr_tpl.$details['pattern']), $details));
		}
		unset($details);
		$tpl = 'core_log.tpl';
		$view_mode = 2;
		$action = 'list';
	}
	// details	
	if ($subaction == 'discount') {
		// assign templates
		assignArray(fmGetFileList($site_dir.$usr_tpl, 'file', 'tpl'), 'tpl_list');
		if ($details_id) {
			// assign details
			$details = discountGetInfo(DB_PREFIX, $db_link, $details_id, $format_dec_point, $format_ths_sep);
		} else {
			$details['title'] = 'campagne';
			$details['price'] = 0.5;
			$details['price_type'] = 'fix';
			$details['enabled'] = 1;
			$details['reusable'] = 0;
			$details['pattern'] = '';
			$details['active_from'] = time();
			$details['active_to'] = mktime(0, 0, 0, 1, 1, 2030);
		}
		assignArray($details, 'details');
		unset($details);
		$tpl = 'shop_discount_details.tpl';
		$view_mode = 1;
		$action = 'list';
	}
break;
//------------------------------------------------------------
case 'edit':
case 'create':
	if ($action == 'create') $details_id = 0; // empty for new

	if ($subaction == 'discount') $tpl = 'shop_discount_details.tpl';
	// edit
	include 'inc_discount_edit.php';

	if ($subaction == 'save_close') {
		if ($success > 0) include 'inc_discount_list.php';
		else $tpl = 'shop_discount_details.tpl';
	} else {
		// assign details
		assignArray(fmGetFileList($site_dir.$usr_tpl, 'file', 'tpl'), 'tpl_list');
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
	$smarty->display((($tpl) ? ($tpl) : ('shop_discount_details.tpl')));
} else {
	$right_frame = ($tpl) ? ($tpl) : ('shop_discount_list.tpl');
}

// unset variables
unset($in_var);
unset($out_var);

?>
