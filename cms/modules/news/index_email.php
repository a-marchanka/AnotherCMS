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

$in_var = array('id' => '', 'priority' => '', 'menu_id' => '', 'email' => '', 'name' => '', 'surname' => '', 'title' => '', 'firm' => '', 'enabled' => '', 'validetime' => '', 'modifytime' => '', 'createnick' => '');
$search_var = array('sort' => '', 'menu_id' => '', 'filter' => '', 'page' => '');
$sort_list = array(
	'0' => array('id' => 'up_menu_id', 'title' => $SYS_WARN_MSG['webpage'].' &uarr;'),
	'1' => array('id' => 'dw_menu_id', 'title' => $SYS_WARN_MSG['webpage'].' &darr;'),
	'2' => array('id' => 'up_status', 'title' => $SYS_WARN_MSG['status'].' &uarr;'),
	'3' => array('id' => 'dw_status', 'title' => $SYS_WARN_MSG['status'].' &darr;'),
	'4' => array('id' => 'up_modifytime', 'title' => $SYS_WARN_MSG['date'].' &uarr;'),
	'5' => array('id' => 'dw_modifytime', 'title' => $SYS_WARN_MSG['date'].' &darr;')
	);
assignArray($sort_list, 'sort_list');

$success = 0;
$in_db_var = array();
$out_var = array();

// GET CONFIG DATA
$cfg_local = configGetInfo(DB_PREFIX, $db_link, 113); // news module
foreach ($cfg_local as $tmp_var=>$tmp_param)
	$$tmp_var = $tmp_param;

include 'modules/news/func_email.php';
include 'modules/menu/func_menu.php';
assignArray(menuGetAll(DB_PREFIX, $db_link), 'search_list');

switch ($action) {
case 'delete':
	if ($details_id)
		if (emailDelete(DB_PREFIX, $db_link, $details_id)) $warning_msg .= $SYS_WARN_MSG['deleted'];
		else $error_msg .= $SYS_WARN_MSG['notdeleted'];
	$action = 'list';
//------------------------------------------------------------
case 'list':
	// prolong subscriptions
	if ($subaction == 'prolong') if (emailProlong(DB_PREFIX, $db_link)) $warning_msg .= $SYS_WARN_MSG['updated'];
	// clean-up deleted menu  // clean-up status
	if (emailValideTime(DB_PREFIX, $db_link) && emailCleanUp(DB_PREFIX, $db_link)) $warning_msg .= $SYS_WARN_MSG['cleanup'];
	// list
	include 'inc_email_list.php';
	$view_mode = 1;
break;
//------------------------------------------------------------
case 'details':
	// DISPLAY DOCUMENT
	if ($subaction == 'item') {
		if ($details_id) {
			// assign email details
			$details = emailGetInfo(DB_PREFIX, $db_link, $details_id);
		} else {
			$search_s = $cfg_profile['nwe_sort'];
			$search_var = explodeRequestValues($search_s);
			$details['menu_id'] = (isset($search_var['menu_id']))?($search_var['menu_id']):(0);
			$details['email'] = 'email@';
			$details['enabled'] = 1;
			$details['priority'] = 2;
			$details['validetime'] = mktime(0, 0, 0, 1, 1, date("Y")+2);
		}
		assignArray($details, 'details');
		unset($details);
		$tpl = 'news_email_details.tpl';
		$view_mode = 1;
		$action = 'list';
	}
break;
//------------------------------------------------------------
case 'edit':
case 'create':
	if ($action == 'create') $details_id = 0; // empty for new

	if ($subaction == 'item') $tpl = 'news_email_details.tpl';
	// edit
	include 'inc_email_edit.php';

	if ($subaction == 'save_close') {
		if ($success > 0) include 'inc_email_list.php';
		else $tpl = 'news_email_details.tpl';
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
$smarty->assign('success', $success);
if ($view_mode > 1) {
	$smarty->assign('error_msg', $error_msg);
	$smarty->assign('warning_msg', $warning_msg);
	$smarty->assign('SID', $SID);
	$smarty->display((($tpl) ? ($tpl) : ('news_email_details.tpl')));
} else {
	$right_frame = ($tpl) ? ($tpl) : ('news_email_list.tpl');
}

// unset variables
unset($in_var);
unset($out_var);

?>
