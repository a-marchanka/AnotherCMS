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

$in_var = array('id' => '', 'nick' => '', 'pass' => '', 'password_confirm' => '', 'sig' => '', 'agent' => '',
		'role_id' => '', 'role' => '', 'active' => '', 'lastvisit' => '', 'dtree_cnt' => '', 'descr' => '');

$search_var = array('sort' => '', 'filter' => '', 'page' => '');

$sort_list = array(
	'0' => array('id' => 'up_nick', 'title' => $SYS_WARN_MSG['nick'].' &uarr;'),
	'1' => array('id' => 'dw_nick', 'title' => $SYS_WARN_MSG['nick'].' &darr;'),
	'2' => array('id' => 'up_role_id', 'title' => $SYS_WARN_MSG['role'].' &uarr;'),
	'3' => array('id' => 'dw_role_id', 'title' => $SYS_WARN_MSG['role'].' &darr;'),
	'4' => array('id' => 'up_lastvisit', 'title' => $SYS_WARN_MSG['date'].' &uarr;'),
	'5' => array('id' => 'dw_lastvisit', 'title' => $SYS_WARN_MSG['date'].' &darr;')
	);
assignArray($sort_list, 'sort_list');

$success = 0;
$details = array('active' => 1);
$in_db_var = array();
$out_var = array();
$acc_items = 50;

// include ROLES LIST
include 'modules/user/func_role.php';
assignArray(roleGetAll(DB_PREFIX, $db_link), 'roles_list');

switch ($action) {
case 'delete':
	if ($subaction == 'user') {
		if ($details_id && $user_info['id'] != $details_id) {
			// delete profiles
			if (profileDeleteValues(DB_PREFIX, $db_link, $details_id)) {
				$warning_msg .= $SYS_WARN_MSG['p_deleted'];
				// delete user
				if (userDelete(DB_PREFIX, $db_link, $details_id))
					$warning_msg .= '<br />'.$SYS_WARN_MSG['u_deleted'];
				else
					$error_msg .= $SYS_WARN_MSG['user_notdeleted'];
			} else
				$error_msg .= ' '.$SYS_WARN_MSG['notdeleted'];
		}
	}
	if ($subaction == 'role') {
		// get empty roles
		$out_var = roleGetEmpty(DB_PREFIX, $db_link);
		for ($i = 0; $i < sizeof($out_var); $i ++) {
			// delete dtree to role
			if (roleDtreeDelete(DB_PREFIX, $db_link, $out_var[$i]['id'])) {
				$warning_msg .= $SYS_WARN_MSG['r_deleted'];
				// delete role
				if (!roleDelete(DB_PREFIX, $db_link, $out_var[$i]['id']))
					$error_msg .= '<br />'. $out_var[$i]['role'].' '.$SYS_WARN_MSG['notdeleted'];
			} else
				$error_msg .= $SYS_WARN_MSG['notdeleted'];
		}
	}
	$action = 'list';
//------------------------------------------------------------
case 'list':
	// clean-up inactive user
	if (userCleanUp(DB_PREFIX, $db_link, $usr_def_role)) $warning_msg .= $SYS_WARN_MSG['cleanup'];
	if ($subaction == 'csv') {
		// create CSV
		exportCSV(userGetNick(DB_PREFIX, $db_link, '@'), 'cms_user', $chr_set, $csv_separator);
		$tpl = 'core_empty.tpl';
		$view_mode = 2;
	} else {
		// list
		include 'inc_user_list.php';
		$view_mode = 1;
	}
break;
//------------------------------------------------------------
case 'details':
	if ($subaction == 'user') {
		if ($details_id) $details = userGetInfo(DB_PREFIX, $db_link, $details_id);
		// assign variables
		assignArray($details, 'details');
		$tpl = 'user_details.tpl';
		$view_mode = 1;
		$action = 'list';
	}
	if ($subaction == 'role') {
		if ($details_id) {
			$details = roleGetInfo(DB_PREFIX, $db_link, $details_id);
			//print_r($details);
			$out_var = roleGetDtree(DB_PREFIX, $db_link, $details_id);
			//print_r($out_var);
		}
		// assign variables
		assignArray($details, 'details');
		assignArray($out_var, 'entry_list');
		unset($details);
		unset($out_var);
		$tpl = 'role_details.tpl';
		$view_mode = 1;
		$action = 'list';
	}
break;
//------------------------------------------------------------
case 'edit':
case 'create':
	if ($action == 'create') $details_id = 0; // empty for new

	if ($subaction == 'user' || $subaction == 'save_close_user') {
		if ($subaction == 'user') $tpl = 'user_details.tpl';
		// edit
		include 'inc_user_edit.php';
		// edit and list
		if ($success > 0) include 'inc_user_list.php';
		else $tpl = 'user_details.tpl';
	}
	if ($subaction == 'role' || $subaction == 'save_close_role') {
		if ($subaction == 'role') $tpl = 'role_details.tpl';
		// edit
		include 'inc_role_edit.php';
		// edit and list
		if ($success > 0) include 'inc_user_list.php';
		else $tpl = 'role_details.tpl';
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
	$smarty->display((($tpl) ? ($tpl) : ('user_details.tpl')));
} else
	$right_frame = ($tpl) ? ($tpl) : ('user_list.tpl');

// unset variables
unset($in_var);
unset($out_var);

?>
