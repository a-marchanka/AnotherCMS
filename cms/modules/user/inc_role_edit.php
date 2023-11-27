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
$validate_array = roleValidateDetails($action);
//print_r($in_var);
if ($validate_array['valid']) {
	if ($details_id) {
		// modify role info
		if (roleUpdate(DB_PREFIX, $db_link, $details_id, $in_db_var)) {
			$success = 1;
			// modify dtree attr
			$entry_list = roleGetDtree(DB_PREFIX, $db_link, $details_id);
			for ($i = 0; $i < $in_var['dtree_cnt']; $i ++) {
				$dtree_role_id = $entry_list[$i]['dtree_role_id'];
				$attr = (!empty($_POST['dr'.$dtree_role_id])) ? $_POST['dr'.$dtree_role_id] : '0';
				if ($entry_list[$i]['entry_attr'] != $attr)
					if (roleDtreeUpdate(DB_PREFIX, $db_link, $dtree_role_id, $attr) && $success == 1) $success = 1;
					else $success = 0;
			}
			if ($success == 1) $warning_msg .= $SYS_WARN_MSG['updated'];
			else $error_msg .= $SYS_WARN_MSG['notupdated'];
		} else
			$error_msg .= $SYS_WARN_MSG['notupdated'];
	} else {
		// add role info
		$details_id = roleInsert(DB_PREFIX, $db_link, $in_db_var);
		if ($details_id) {
			$success = 1;
			// add dtree to role info
			$entry_list = roleGetDtreeAll(DB_PREFIX, $db_link);
			for ($i = 0; $i < sizeof($entry_list); $i ++) {
				if (roleDtreeInsert(DB_PREFIX, $db_link, $entry_list[$i]['entry_id'], $details_id) && $success == 1) $success = 1;
				else $success = 0;
			}
			if ($success == 1) $warning_msg .= $SYS_WARN_MSG['created'];
			else $error_msg .= $SYS_WARN_MSG['notcreated'];
		} else
			$error_msg .= $SYS_WARN_MSG['notcreated'];
	}
} else
	$error_msg .= $validate_array['error_msg'];

if ($details_id) $in_var['id'] = $details_id;

//print_r($in_var);
assignArray($in_var, 'details');

$entry_list = roleGetDtree(DB_PREFIX, $db_link, $details_id);
assignArray($entry_list, 'entry_list');
unset($details);
unset($entry_list);

?>
