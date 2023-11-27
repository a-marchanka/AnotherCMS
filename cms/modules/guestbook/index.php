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

$in_var = array('id' => '', 'menu_id' => '', 'status' => '', 'name' => '', 'email' => '', 'message' => '',
		'ip' => '', 'agent' => '', 'ui_lang' => '', 'modifytime' => '', 'createnick' => '');

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
$details = array('status' => 2);
$in_db_var = array();
$out_var = array();

// GET CONFIG DATA
$gsb_items = (!empty($gsb_items)&&is_numeric($gsb_items)) ? ($gsb_items) : (100);

// gsb_status - status_list
$tmp = explode(';', htmlDecode($gsb_status));
for ($i=0; $i<sizeof($tmp); $i++) {
	$tmp_var = explode('=', $tmp[$i]);
	$gsb_status_array[$i] = array('id' => trim($tmp_var[0]), 'title' => trim($tmp_var[1]));
}
assignArray($gsb_status_array, 'status_list');

include 'modules/menu/func_menu.php';
assignArray(menuGetAll(DB_PREFIX, $db_link), 'search_list');

// db functions
include 'modules/guestbook/func_guestbook.php';

switch ($action) {
case 'delete':
	if ($details_id) {
		if (guestbookDelete(DB_PREFIX, $db_link, $details_id))
			$warning_msg .= $SYS_WARN_MSG['deleted'];
		else
			$error_msg .= $SYS_WARN_MSG['notdeleted'];
	}
	$action = 'list';
//------------------------------------------------------------
case 'list':
	// clean-up deleted menu
	if (guestbookCleanUp(DB_PREFIX, $db_link)) $warning_msg .= $SYS_WARN_MSG['cleanup'];
	// list
	include 'inc_guestbook_list.php';
	$view_mode = 1;
break;
//------------------------------------------------------------
case 'details':
	if ($subaction == 'guestbook') {
		$tpl = 'guestbook_details.tpl';
		if ($details_id) $details = guestbookGetInfo(DB_PREFIX, $db_link, $details_id);
		// assign variables
		assignArray($details, 'details');
		unset($details);
		$view_mode = 1;
		$action = 'list';
	}
break;
//------------------------------------------------------------
case 'edit':
case 'create':
	if ($action == 'create') $details_id = 0; // empty for new

	if ($subaction == 'guestbook') $tpl = 'guestbook_details.tpl';
	// edit
	include 'inc_guestbook_edit.php';

	if ($subaction == 'save_close') {
		if ($success > 0) include 'inc_guestbook_list.php';
		else $tpl = 'guestbook_details.tpl';
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
	$smarty->display((($tpl) ? ($tpl) : ('guestbook_details.tpl')));
} else
	$right_frame = ($tpl) ? ($tpl) : ('guestbook_list.tpl');

// unset variables
unset($in_var);
unset($out_var);

?>
