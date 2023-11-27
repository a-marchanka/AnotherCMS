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

if (!$details_id || $action == 'create') {
	$error_msg .= $SYS_WARN_MSG['not_all_mandatory'];
} else {
	// PREPARING TO UPDATE
	$in_var['modifytime'] = time();
	if (!$in_var['bill_nr']) $in_var['bill_nr'] = 0;
	if (!is_numeric($in_var['bill_total_gross'])) $in_var['bill_total_gross'] = 0;
	if (!is_numeric($in_var['bill_total_nett'])) $in_var['bill_total_nett'] = 0;
	if (!$in_var['bill_receipt']) $in_var['bill_receipt'] = '';
	if (!$in_var['discount_code']) $in_var['discount_code'] = '';
	if (!is_numeric($in_var['discount_price'])) $in_var['discount_price'] = 0;
	if (!$in_var['delivery_receipt']) $in_var['delivery_receipt'] = '';
	if (!$in_var['payment_code']) $in_var['payment_code'] = '';
	if (!is_numeric($in_var['payment_gross'])) $in_var['payment_gross'] = 0;
	if (!is_numeric($in_var['payment_nett'])) $in_var['payment_nett'] = 0;
	if (!$in_var['txn_nr']) $in_var['txn_nr'] = '';
	if (!$in_var['delivery_code']) $in_var['delivery_code'] = '';
	if (!is_numeric($in_var['delivery_gross'])) $in_var['delivery_gross'] = 0;
	if (!is_numeric($in_var['delivery_nett'])) $in_var['delivery_nett'] = 0;
	if (!is_numeric($in_var['weight_kg_sum'])) $in_var['weight_kg_sum'] = 0;
	if (!is_numeric($in_var['length_cm_max'])) $in_var['length_cm_max'] = 0;
	if (!$in_var['status']) $in_var['status'] = 0;
	if (!$in_var['createtime']) $in_var['createtime'] = time();
	if ($in_var['status'] == 3 && $in_var['old_status'] != 3) $in_var['closetime'] = time();
	if (!$in_var['paytime']) $in_var['paytime'] = 0;
	// -----------
	$in_db_var['bill_nr'] = $in_var['bill_nr'];
	$in_db_var['bill_total_gross'] = $in_var['bill_total_gross'];
	$in_db_var['bill_total_nett'] = $in_var['bill_total_nett'];
	$in_db_var['bill_receipt'] = '\''.htmlDecode($in_var['bill_receipt']).'\'';
	$in_db_var['discount_code'] = '\''.$in_var['discount_code'].'\'';
	$in_db_var['discount_price'] = $in_var['discount_price'];
	$in_db_var['delivery_receipt'] = '\''.htmlDecode($in_var['delivery_receipt']).'\'';
	$in_db_var['payment_code'] = '\''.$in_var['payment_code'].'\'';
	$in_db_var['payment_gross'] = $in_var['payment_gross'];
	$in_db_var['payment_nett'] = $in_var['payment_nett'];
	$in_db_var['txn_nr'] = '\''.$in_var['txn_nr'].'\'';
	$in_db_var['delivery_code'] = '\''.$in_var['delivery_code'].'\'';
	$in_db_var['delivery_gross'] = $in_var['delivery_gross'];
	$in_db_var['delivery_nett'] = $in_var['delivery_nett'];
	$in_db_var['weight_kg_sum'] = $in_var['weight_kg_sum'];
	$in_db_var['length_cm_max'] = $in_var['length_cm_max'];
	$in_db_var['status'] = $in_var['status'];
	$in_db_var['createtime'] = $in_var['createtime'];
	$in_db_var['closetime'] = $in_var['closetime'];
	$in_db_var['paytime'] = $in_var['paytime'];
	$in_db_var['modifytime'] = $in_var['modifytime'];
	$valide = 1;
}
//print $details_id;
if ($valide == 1) {
	if ($details_id) {
		if (orderUpdate(DB_PREFIX, $db_link, $details_id, $in_db_var)) {
			$warning_msg .= $SYS_WARN_MSG['updated'];
			$success = ($subaction == 'save_close')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notupdated'];
	} else
		$error_msg .= $SYS_WARN_MSG['notcreated'];
} else
	$error_msg .= $validate_array['error_msg'];

if ($details_id) $in_var['id'] = $details_id;

//print_r($in_var);
assignArray($in_var, 'details');

?>
