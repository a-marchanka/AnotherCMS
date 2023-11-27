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

$details_id = 1;

$cfg_details_var = array();

// GET CONFIG DATA
$cfg_details_var = configGetAll(DB_PREFIX, $db_link, $auth_id);
$sum = sizeof($cfg_details_var);
if (!$sum)
	$error_msg = $SYS_WARN_MSG['no_results'];

switch ($action) {
case 'delete':
break;
	
case 'list':
	// ASSIGN
	assignArray($cfg_details_var, 'cfg_list');
break;
	
case 'details':
break;
	
case 'create':
break;
	
case 'edit':
	// loop Post
	for ($i = 0; $i < $sum; $i ++) {
		$cfg_id = $cfg_details_var[$i]['id'];
		$var_name = 'cfg_'.$cfg_id;
		$$var_name = htmlEncode(trim($_POST[$var_name])); // replace html
		if ($$var_name != $cfg_details_var[$i]['value']) {
			$cfg_details_var[$i]['value'] = $$var_name;
			$cfg_details_var[$i]['status'] = 1;
			if (configUpdate(DB_PREFIX, $db_link, $cfg_id, '\''.$$var_name.'\''))
				$warning_msg = $SYS_WARN_MSG['conf_updated'];
			else
				$error_msg .= $SYS_WARN_MSG['notupdated'].' '.$cfg_details_var[$i]['description'].'. ';
		}
	}
	// ASSIGN
	assignArray($subaction, 'subaction');
	assignArray($cfg_details_var, 'cfg_list');
	$action = 'list';
break;
//------------------------------------------------------------
default:
	$error_msg = $SYS_WARN_MSG['action_wrong'];
	$tpl = 'core_error.tpl';
	$action = 'list';
	$view_mode = 1;
}
//------------------------------------------------------------
// VIEW
if ($view_mode > 1) {
	$smarty->assign('error_msg', $error_msg);
	$smarty->assign('warning_msg', $warning_msg);
	$smarty->assign('SID', $SID);
	$smarty->display((($tpl) ? ($tpl) : ('core_config.tpl')));
} else {
	$right_frame = ($tpl) ? ($tpl) : ('core_config.tpl');
}

unset($cfg_details_var);

?>
