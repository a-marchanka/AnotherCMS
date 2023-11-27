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
$validate_array = menuValidateDetails($subaction);

//print $details_id;
if ($validate_array['valid']) {
	if ($details_id) {
		// modify menu info
		if (menuUpdate(DB_PREFIX, $db_link, $details_id, $in_db_var)) {
			$warning_msg .= $SYS_WARN_MSG['updated'];
			// content info
			if ($in_var['content_type'] == 'static' && $in_var['content_htm'] && !empty($editor_content)) {
				if (!fmSaveContent($site_dir.$files_dir.$in_var['content_htm'], $editor_content)) {
					if ($error_msg) $error_msg .= '<br />';
					$error_msg .= $SYS_WARN_MSG['f_notupdated'];
				}
			}
			$success = ($subaction == 'save_close_menu' || $subaction == 'save_close_mceedit')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notupdated'];
	} else {
		// add info
		$details_id = menuInsert(DB_PREFIX, $db_link, $in_db_var);
		if ($details_id) {
			// content info
			if ($in_var['content_type'] == 'static' && $in_var['content_htm'] && !empty($editor_content)) {
				if (!fmSaveContent($site_dir.$files_dir.$in_var['content_htm'], $editor_content)) {
					if ($error_msg) $error_msg .= '<br />';
					$error_msg .= $SYS_WARN_MSG['f_notupdated'];
				}
			}
			$success = ($subaction == 'save_close_menu' || $subaction == 'save_close_mceedit')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notcreated'];
	}
} else
	$error_msg .= $validate_array['error_msg'];

if ($details_id) $in_var['id'] = $details_id;

$in_var['role_ids_arr'] = explode(',', $in_var['role_ids']);
//print_r($in_var);
assignArray($in_var, 'details');

?>
