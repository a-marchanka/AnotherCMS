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

// include MAILER
include 'modules/mailer.php';

// info
$valid = 0;
$warning_msg = '';
$error_msg = '';
$in_var = trimRequestValues($in_var);
//print_r($in_var);
// verify
if (!$in_var['nick'] || !$in_var['role_id'])
	$error_msg .= $SYS_WARN_MSG['not_all_mandatory'];
else {
	if ($in_var['pass'] != $in_var['password_confirm'])
		$error_msg .=  $SYS_WARN_MSG['password_notconfirm'];
	else {
		if ($action == 'create' && !$in_var['pass'])
			$error_msg .=  $SYS_WARN_MSG['password_missed'];
		else {
			if ($action == 'edit' && !$details_id)
				$error_msg .=  $SYS_WARN_MSG['action_wrong'];
			else {
				// PREPARING TO UPDATE
				$in_var['lastvisit'] = time();
				if (!$in_var['active']) $in_var['active'] = 0;
				if ($in_var['pass']) $in_db_var['pass'] = '\''.md5($in_var['pass']).'\'';
				if ($action == 'create') {
					$in_var['agent'] = $_SERVER['HTTP_USER_AGENT'];
					$in_db_var['agent'] = '\''.$in_var['agent'].'\'';
				}
				$in_db_var['sig'] = '\''.$in_var['sig'].'\'';
				$in_db_var['lastvisit'] = $in_var['lastvisit'];
				$in_db_var['active'] = $in_var['active'];
				$in_db_var['nick'] = '\''.strtolower($in_var['nick']).'\'';
				$in_db_var['descr'] = '\''.$in_var['descr'].'\'';
				$in_db_var['role_id'] = $in_var['role_id'];
				$valid = 1;
			}
		}
	}
}
//print_r($in_var);
if ($valid == 1) {
	if ($details_id) {
		// modify user info
		if (userUpdate(DB_PREFIX, $db_link, $details_id, $in_db_var)) {
			$warning_msg .= $SYS_WARN_MSG['updated'];
			$success = ($subaction == 'save_close')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notupdated'];
	} else {
		// add user info
		$details_id = userInsert(DB_PREFIX, $db_link, $in_db_var);
		if ($details_id) {
			// add profile info for module prefixes
			if (!profileInsertValues(DB_PREFIX, $db_link, $details_id))
				$error_msg .= $SYS_WARN_MSG['notcreated'];
			// send email
			if (!$error_msg && strpos($in_var['nick'],'@') !== false) {
				// verify email
				if (!isValidEmail($in_var['nick']))
					$error_msg .= $SYS_WARN_MSG['email_invalid'];
				else {
					$syn_var = array('nick'=>'User', 'pass'=>'Password');
					if ( mailerSendSimple($sys_mx, $in_var['nick'], $sys_email, $sys_email, '', '', 'New Account '.$site_url, $SYS_WARN_MSG['u_created'].'<hr />', $email_style, $in_var, $syn_var) )
						$warning_msg .= $SYS_WARN_MSG['email_sent'].'<br />';
				}
			}
			$warning_msg .= $SYS_WARN_MSG['u_created'];
			$success = ($subaction == 'save_close')?(2):(1);
		} else
			$error_msg .= $SYS_WARN_MSG['notcreated'];
	}
}

if ($details_id) $in_var['id'] = $details_id;

//print_r($in_var);
assignArray($in_var, 'details');

?>
