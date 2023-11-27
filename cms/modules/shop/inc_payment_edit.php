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
	if (!$in_var['code']) $in_var['code'] = '';
	if (!$in_var['title']) $in_var['title'] = '';
	if (!is_numeric($in_var['price'])) $in_var['price'] = 0.0;
	if (!is_numeric($in_var['tax'])) $in_var['tax'] = 0.0;
	if (!$in_var['price_type']) $in_var['price_type'] = 'fix';
	if (!$in_var['country_code']) $in_var['country_code'] = '--';
	if (!$in_var['currency']) $in_var['currency'] = '';
	if (!$in_var['enabled']) $in_var['enabled'] = 0;
	$in_db_var['code'] = '\''.$in_var['code'].'\'';
	$in_db_var['title'] = '\''.$in_var['title'].'\'';
	$in_db_var['price'] = $in_var['price'];
	$in_db_var['tax'] = $in_var['tax'];
	$in_db_var['price_type'] = '\''.$in_var['price_type'].'\'';
	$in_db_var['country_code'] = '\''.$in_var['country_code'].'\'';
	$in_db_var['currency'] = '\''.$in_var['currency'].'\'';
	$in_db_var['enabled'] = $in_var['enabled'];
	$valide = 1;
	}
}
//print $details_id;
if ($valide == 1) {
	if ($details_id) {
		if (paymentUpdate(DB_PREFIX, $db_link, $details_id, $in_db_var)) {
			$warning_msg .= $SYS_WARN_MSG['updated'];
			$success = ($subaction == 'save_close')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notupdated'];
	} else {
		// add info
		$details_id = paymentInsert(DB_PREFIX, $db_link, $in_db_var);
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
