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

// info
$valide = 0;

// verify
$in_var = trimRequestValues($in_var);
//print_r($in_var);
if (!$in_var['name'] || !$in_var['message'])
	$error_msg .= $SYS_WARN_MSG['not_all_mandatory'];
else {
	if ($action == 'edit' && !$details_id)
		$error_msg .=  $SYS_WARN_MSG['action_wrong'];
	else {
		// PREPARING TO UPDATE
		$in_var['modifytime'] = time();
		if (!$in_var['status']) $in_var['status'] = 0;
		if (!$in_var['menu_id']) $in_var['menu_id'] = 0;
		if ($action == 'create') {
			$in_var['agent'] = $_SERVER['HTTP_USER_AGENT'];
			$in_db_var['agent'] = '\''.$in_var['agent'].'\'';
		}
		$in_db_var['ip'] = '\''.$in_var['ip'].'\'';
		$in_db_var['name'] = '\''.$in_var['name'].'\'';
		$in_db_var['email'] = '\''.$in_var['email'].'\'';
		$in_db_var['ui_lang'] = '\''.$in_var['ui_lang'].'\'';
		$in_db_var['message'] = '\''.$in_var['message'].'\'';
		$in_db_var['status'] = $in_var['status'];
		$in_db_var['menu_id'] = $in_var['menu_id'];
		$in_db_var['modifytime'] = $in_var['modifytime'];
		$valide = 1;
	}
}
//print $details_id;
if ($valide == 1) {
	if ($details_id) {
		if (guestbookUpdate(DB_PREFIX, $db_link, $details_id, $in_db_var)) {
			$warning_msg .= $SYS_WARN_MSG['updated'];
			$success = ($subaction == 'save_close')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notupdated'];
	} else {
		// add info
		$details_id = guestbookInsert(DB_PREFIX, $db_link, $in_db_var);
		if ($details_id) {
			$warning_msg .= $SYS_WARN_MSG['created'];
			$success = ($subaction == 'save_close')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notcreated'];
	}
}

if ($details_id) $in_var['id'] = $details_id;

assignArray($in_var, 'details');

?>
