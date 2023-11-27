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
if ($action == 'edit' && !$details_id)
	$error_msg .=  $SYS_WARN_MSG['action_wrong'];
else {
	if ($in_var['family_ids'] != $in_var['family_ids_old']) {
		$valide = 1;
		if ($in_var['family_ids']) {
			$ids = array();
			$ids = explode(',', $in_var['family_ids']);
			$sum = sizeof($ids);
			for ($i = 0; $i < $sum; $i ++) if (!is_numeric($ids[$i])) { $valide = 0; $error_msg .=  $SYS_WARN_MSG['format_wrong']; break; }
		}
		if ($valide == 1) {
			$in_var['modifytime'] = time();
			$in_db_var['family_ids'] = '\''.$in_var['family_ids'].'\'';
			$in_db_var['modifytime'] = $in_var['modifytime'];
			if (productUpdate(DB_PREFIX, $db_link, $details_id, $in_db_var)) {
				$warning_msg .= $SYS_WARN_MSG['updated'];
				$success = ($subaction == 'save_close_options')?(2):(1);
			} else
				$error_msg .= $SYS_WARN_MSG['notupdated'];
		}
	} else $success = ($subaction == 'save_close_options')?(2):(1);
	// assign family products
	$details_items = productFamilyInfo(DB_PREFIX, $db_link, $in_var['family_ids']);
	assignArray($details_items, 'details_items');
	unset($details_items);
}
if ($details_id) $in_var['id'] = $details_id;
// assign all products
assignArray(productShortAll(DB_PREFIX, $db_link), 'details_all');
assignArray($in_var, 'details');

?>
