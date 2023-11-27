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
if (!$in_var['title']) {
	$error_msg .= $SYS_WARN_MSG['not_all_mandatory'];
} else {
	if ($action == 'edit' && !$details_id)
		$error_msg .=  $SYS_WARN_MSG['action_wrong'];
	else {
	// PREPARING TO UPDATE
	$in_var['modifytime'] = time();
	if (!$in_var['pr_number']) $in_var['pr_number'] = '';
	if (!$in_var['menu_main_id']) $in_var['menu_main_id'] = 0;
	if (!$in_var['product_type']) $in_var['product_type'] = 'product';
	if (!is_numeric($in_var['priority']) || !$in_var['priority']) $in_var['priority'] = 0;
	if (!$in_var['title']) $in_var['title'] = '';
	if (!$in_var['descr']) $in_var['descr'] = '';
	if (!$in_var['image']) $in_var['image'] = '';
	if (!is_numeric($in_var['amount_total']) || !$in_var['amount_total']) $in_var['amount_total'] = 0;
	if (!is_numeric($in_var['amount']) || !$in_var['amount']) $in_var['amount'] = 1;
	if (!is_numeric($in_var['amount_1']) || !$in_var['amount_1']) $in_var['amount_1'] = $in_var['amount'];
	if (!is_numeric($in_var['amount_2']) || !$in_var['amount_2']) $in_var['amount_2'] = $in_var['amount_1'];
	if (!is_numeric($in_var['amount_3']) || !$in_var['amount_3']) $in_var['amount_3'] = $in_var['amount_2'];
	if (!is_numeric($in_var['price']) || !$in_var['price']) $in_var['price'] = 0.0;
	if (!is_numeric($in_var['price_1']) || !$in_var['price_1']) $in_var['price_1'] = $in_var['price'];
	if (!is_numeric($in_var['price_2']) || !$in_var['price_2']) $in_var['price_2'] = $in_var['price_1'];
	if (!is_numeric($in_var['price_3']) || !$in_var['price_3']) $in_var['price_3'] = $in_var['price_2'];
	if (!is_numeric($in_var['tax'])) $in_var['tax'] = 0.0;
	if (!$in_var['currency']) $in_var['currency'] = '';
	if (!is_numeric($in_var['weight_kg']) || !$in_var['weight_kg']) $in_var['weight_kg'] = 0.0;
	if (!is_numeric($in_var['length_cm']) || !$in_var['length_cm']) $in_var['length_cm'] = 0.0;
	if (!$in_var['family_ids']) $in_var['family_ids'] = '';
	if (!$in_var['status']) $in_var['status'] = 0;
	if (!$in_var['modifytime']) $in_var['modifytime'] = 0;
	if (!$in_var['createnick']) $in_var['createnick'] = '';
	// -----------
	$in_db_var['pr_number'] = '\''.$in_var['pr_number'].'\'';
	$in_db_var['menu_main_id'] = $in_var['menu_main_id'];
	$in_db_var['product_type'] = '\''.$in_var['product_type'].'\'';
	$in_db_var['priority'] = $in_var['priority'];
	$in_db_var['title'] = '\''.$in_var['title'].'\'';
	$in_db_var['descr'] = '\''.htmlDecode($in_var['descr']).'\'';
	$in_db_var['image'] = '\''.$in_var['image'].'\'';
	$in_db_var['amount_total'] = $in_var['amount_total'];
	$in_db_var['amount'] = $in_var['amount'];
	$in_db_var['amount_1'] = $in_var['amount_1'];
	$in_db_var['amount_2'] = $in_var['amount_2'];
	$in_db_var['amount_3'] = $in_var['amount_3'];
	$in_db_var['price'] = $in_var['price'];
	$in_db_var['price_1'] = $in_var['price_1'];
	$in_db_var['price_2'] = $in_var['price_2'];
	$in_db_var['price_3'] = $in_var['price_3'];
	$in_db_var['tax'] = $in_var['tax'];
	$in_db_var['currency'] = '\''.$in_var['currency'].'\'';
	$in_db_var['weight_kg'] = $in_var['weight_kg'];
	$in_db_var['length_cm'] = $in_var['length_cm'];
	$in_db_var['family_ids'] = '\''.$in_var['family_ids'].'\'';
	$in_db_var['status'] = $in_var['status'];
	$in_db_var['modifytime'] = $in_var['modifytime'];
	$in_db_var['createnick'] = '\''.$in_var['createnick'].'\'';
	$valide = 1;
	}
}
//print $details_id;
if ($valide == 1) {
	if ($details_id) {
		if (productUpdate(DB_PREFIX, $db_link, $details_id, $in_db_var)) {
			$warning_msg .= $SYS_WARN_MSG['updated'];
			$success = ($subaction == 'save_close')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notupdated'];
	} else {
		// add info
		$details_id = productInsert(DB_PREFIX, $db_link, $in_db_var);
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
