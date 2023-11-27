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

if (!$in_var['bill_email'] || !$in_var['bill_name'] || !$in_var['bill_surname'] || !$in_var['bill_street'] || !$in_var['bill_postcode'] || !$in_var['bill_city']) {
	$error_msg .= $SYS_WARN_MSG['not_all_mandatory'];
} else {
	if ($action == 'edit' && !$details_id)
		$error_msg .=  $SYS_WARN_MSG['action_wrong'];
	else {
	// PREPARING TO UPDATE
	$in_var['modifytime'] = time();
	if (!$in_var['cust_name']) $in_var['cust_name'] = '';
	if (!$in_var['cust_surname']) $in_var['cust_surname'] = '';
	if (!$in_var['cust_title']) $in_var['cust_title'] = '';
	if (!$in_var['cust_reference']) $in_var['cust_reference'] = '';
	if (!$in_var['cust_firm']) $in_var['cust_firm'] = '';
	if (!$in_var['bill_firm_vat_nr']) $in_var['bill_firm_vat_nr'] = '';
	if (!$in_var['bill_email']) $in_var['bill_email'] = '';
	if (!$in_var['bill_tel']) $in_var['bill_tel'] = '';
	if (!$in_var['cust_street']) $in_var['cust_street'] = '';
	if (!$in_var['cust_postcode']) $in_var['cust_postcode'] = '';
	if (!$in_var['cust_city']) $in_var['cust_city'] = '';
	if (!$in_var['cust_country_code']) $in_var['cust_country_code'] = '';
	if (!$in_var['bill_nr']) $in_var['bill_nr'] = 0;
	if (!$in_var['bill_name']) $in_var['bill_name'] = '';
	if (!$in_var['bill_surname']) $in_var['bill_surname'] = '';
	if (!$in_var['bill_title']) $in_var['bill_title'] = '';
	if (!$in_var['bill_reference']) $in_var['bill_reference'] = '';
	if (!$in_var['bill_firm']) $in_var['bill_firm'] = '';
	if (!$in_var['bill_street']) $in_var['bill_street'] = '';
	if (!$in_var['bill_postcode']) $in_var['bill_postcode'] = '';
	if (!$in_var['bill_city']) $in_var['bill_city'] = '';
	if (!$in_var['bill_country_code']) $in_var['bill_country_code'] = '';
	if (!is_numeric($in_var['bill_birth_year'])) $in_var['bill_birth_year'] = 0;
	if (!is_numeric($in_var['terms_flag'])) $in_var['terms_flag'] = 0;
	if (!is_numeric($in_var['last_step'])) $in_var['last_step'] = 0;
	if (!$in_var['status']) $in_var['status'] = 0;
	if (!$in_var['notes']) $in_var['notes'] = '';
	if (!$in_var['agent']) $in_var['agent'] = '';
	if (!$in_var['createtime']) $in_var['createtime'] = time();
	if ($in_var['status'] == 3 && $in_var['old_status'] != 3) $in_var['closetime'] = time();
	if (!$in_var['paytime']) $in_var['paytime'] = 0;
	if (!$in_var['createnick']) $in_var['createnick'] = '';
	// -----------
	$in_db_var['cust_name'] = '\''.$in_var['cust_name'].'\'';
	$in_db_var['cust_surname'] = '\''.$in_var['cust_surname'].'\'';
	$in_db_var['cust_title'] = '\''.$in_var['cust_title'].'\'';
	$in_db_var['cust_reference'] = '\''.$in_var['cust_reference'].'\'';
	$in_db_var['cust_firm'] = '\''.$in_var['cust_firm'].'\'';
	$in_db_var['bill_firm_vat_nr'] = '\''.$in_var['bill_firm_vat_nr'].'\'';
	$in_db_var['bill_email'] = '\''.$in_var['bill_email'].'\'';
	$in_db_var['bill_tel'] = '\''.$in_var['bill_tel'].'\'';
	$in_db_var['cust_street'] = '\''.$in_var['cust_street'].'\'';
	$in_db_var['cust_postcode'] = '\''.$in_var['cust_postcode'].'\'';
	$in_db_var['cust_city'] = '\''.$in_var['cust_city'].'\'';
	$in_db_var['cust_country_code'] = '\''.$in_var['cust_country_code'].'\'';
	$in_db_var['bill_birth_year'] = $in_var['bill_birth_year'];
	$in_db_var['bill_nr'] = $in_var['bill_nr'];
	$in_db_var['bill_name'] = '\''.$in_var['bill_name'].'\'';
	$in_db_var['bill_surname'] = '\''.$in_var['bill_surname'].'\'';
	$in_db_var['bill_title'] = '\''.$in_var['bill_title'].'\'';
	$in_db_var['bill_reference'] = '\''.$in_var['bill_reference'].'\'';
	$in_db_var['bill_firm'] = '\''.$in_var['bill_firm'].'\'';
	$in_db_var['bill_street'] = '\''.$in_var['bill_street'].'\'';
	$in_db_var['bill_postcode'] = '\''.$in_var['bill_postcode'].'\'';
	$in_db_var['bill_city'] = '\''.$in_var['bill_city'].'\'';
	$in_db_var['bill_country_code'] = '\''.$in_var['bill_country_code'].'\'';
	$in_db_var['terms_flag'] = $in_var['terms_flag'];
	$in_db_var['last_step'] = $in_var['last_step'];
	$in_db_var['status'] = $in_var['status'];
	$in_db_var['notes'] = '\''.$in_var['notes'].'\'';
	$in_db_var['agent'] = '\''.$in_var['agent'].'\'';
	$in_db_var['createtime'] = $in_var['createtime'];
	$in_db_var['closetime'] = $in_var['closetime'];
	$in_db_var['paytime'] = $in_var['paytime'];
	$in_db_var['modifytime'] = $in_var['modifytime'];
	$in_db_var['createnick'] = '\''.$in_var['createnick'].'\'';
	$valide = 1;
	}
}
//print $details_id;
if ($valide == 1) {
	if ($details_id) {
		if (orderUpdate(DB_PREFIX, $db_link, $details_id, $in_db_var)) {
			$warning_msg .= $SYS_WARN_MSG['updated'];
			$success = ($subaction == 'save_close')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notupdated'];
	} else {
		// add info
		$details_id = orderInsert(DB_PREFIX, $db_link, $in_db_var);
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
