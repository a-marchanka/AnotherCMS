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
// print_r($in_var);
if (!$in_var['code']) {
	$error_msg .= $SYS_WARN_MSG['not_all_mandatory'];
} else {
	if ($action == 'edit' && !$details_id)
		$error_msg .=  $SYS_WARN_MSG['action_wrong'];
	else {
	// PREPARING TO UPDATE
	$in_var['modifytime'] = time();
	if (!$in_var['reusable']) $in_var['reusable'] = 0;
	if (!$in_var['enabled']) $in_var['enabled'] = 0;
	if (!is_numeric($in_var['price'])) $in_var['price'] = 0.0;
	if (!$in_var['price_type']) $in_var['price_type'] = 'fix';
	if (!$in_var['active_from']) $in_var['active_from'] = '01.01.2000';
	if (!$in_var['active_to']) $in_var['active_to'] = '01.01.2030';
	// convert time
	$tmp_date = $in_var['active_from'];
	$tmp_day = substr($tmp_date,0,2);
	$tmp_month = substr($tmp_date,3,2);
	$tmp_year = substr($tmp_date,6,4);
	$tmp_time = mktime(0, 0, 0, $tmp_month, $tmp_day, $tmp_year);
	$in_var['active_from'] = $tmp_time;
	// convert time
	$tmp_date = $in_var['active_to'];
	$tmp_day = substr($tmp_date,0,2);
	$tmp_month = substr($tmp_date,3,2);
	$tmp_year = substr($tmp_date,6,4);
	$tmp_time = mktime(0, 0, 0, $tmp_month, $tmp_day, $tmp_year);
	$in_var['active_to'] = $tmp_time;
	if ($in_var['active_from'] >= $in_var['active_to']) $in_var['active_from'] = $in_var['active_to'];
	$in_db_var['code'] = '\''.$in_var['code'].'\'';
	$in_db_var['price'] = $in_var['price'];
	$in_db_var['title'] = '\''.$in_var['title'].'\'';
	$in_db_var['price_type'] = '\''.$in_var['price_type'].'\'';
	$in_db_var['pattern'] = '\''.$in_var['pattern'].'\'';
	$in_db_var['active_from'] = $in_var['active_from'];
	$in_db_var['active_to'] = $in_var['active_to'];
	$in_db_var['reusable'] = $in_var['reusable'];
	$in_db_var['enabled'] = $in_var['enabled'];
	$in_db_var['modifytime'] = $in_var['modifytime'];
	$in_db_var['createnick'] = '\''.$in_var['createnick'].'\'';
	$valide = 1;
	}
}
//print $details_id;
if ($valide == 1) {
	if ($details_id) {
		if (discountUpdate(DB_PREFIX, $db_link, $details_id, $in_db_var)) {
			$warning_msg .= $SYS_WARN_MSG['updated'];
			$success = ($subaction == 'save_close')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notupdated'];
	} else {
		// add info
		$details_id = discountInsert(DB_PREFIX, $db_link, $in_db_var);
		if ($details_id) {
			$warning_msg .= $SYS_WARN_MSG['created'];
			$success = ($subaction == 'save_close')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notcreated'];
	}
} else
	$error_msg .= $validate_array['error_msg'];

if ($details_id) $in_var['id'] = $details_id;

//print_r($in_var);
assignArray($in_var, 'details');

?>
