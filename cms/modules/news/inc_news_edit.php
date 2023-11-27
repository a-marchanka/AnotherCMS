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
if (!$in_var['title'] || !$in_var['menu_id'] || !$in_var['ui_lang']) {
	$error_msg .= $SYS_WARN_MSG['not_all_mandatory'];
} else {
	if ($action == 'edit' && !$details_id)
		$error_msg .=  $SYS_WARN_MSG['action_wrong'];
	else {
	// PREPARING TO UPDATE
	$in_var['modifytime'] = time();
	if (!$in_var['status']) $in_var['status'] = 0;
	if (!$in_var['menu_id']) $in_var['menu_id'] = 0;
	if (!$in_var['ui_lang']) $in_var['ui_lang'] = 'en';
	if (!$in_var['validetime']) $in_var['validetime'] = '01.01.2030';
	// convert time
	$tmp_date = $in_var['validetime'];
	$tmp_day = substr($tmp_date,0,2);
	$tmp_month = substr($tmp_date,3,2);
	$tmp_year = substr($tmp_date,6,4);
	$tmp_time = mktime(0, 0, 0, $tmp_month, $tmp_day, $tmp_year);
	$in_var['validetime'] = $tmp_time;
	// db var
	$in_db_var['priority'] = $in_var['priority'];
	$in_db_var['title'] = '\''.$in_var['title'].'\'';
	$in_db_var['ui_lang'] = '\''.$in_var['ui_lang'].'\'';
	$in_db_var['message'] = '\''.linkToLytebox( emailToUnicode( htmlDecode($in_var['message']) ), $in_var['title']).'\'';
	$in_db_var['status'] = $in_var['status'];
	$in_db_var['menu_id'] = $in_var['menu_id'];
	$in_db_var['modifytime'] = $in_var['modifytime'];
	$in_db_var['validetime'] = $in_var['validetime'];
	$in_db_var['createnick'] = '\''.$in_var['createnick'].'\'';
	$valide = 1;
	}
}
//print $details_id;
if ($valide == 1) {
	if ($details_id) {
		if (newsUpdate(DB_PREFIX, $db_link, $details_id, $in_db_var)) {
			$warning_msg .= $SYS_WARN_MSG['updated'];
			$success = ($subaction == 'save_close')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notupdated'];
	} else {
		// add info
		$details_id = newsInsert(DB_PREFIX, $db_link, $in_db_var);
		if ($details_id) {
			$warning_msg .= $SYS_WARN_MSG['created'];
			$success = ($subaction == 'save_close')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notcreated'];
	}
}

if ($details_id) $in_var['id'] = $details_id;

//print_r($in_var);
assignArray($in_var, 'details');

?>
