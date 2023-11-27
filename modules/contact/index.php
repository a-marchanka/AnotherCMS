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

$in_var = array('perm' => '', 'email' => '', 'message' => '', 'copy' => '', 'ip' => '', 'agent' => '', 'menu_id' => '', 'modifytime' => '');

$in_synonym = array('email' => 'E-mail', 'message' => 'Nachricht');

// Template
$tpl = 'contact_form.tpl';

$success = 0;
$in_db_var = array();

// get config
$cfg_local = configGetInfo(DB_PREFIX, $db_link, 114); // feedback module
// local variables
foreach ($cfg_local as $tmp_var => $tmp_param)
	$$tmp_var = $tmp_param;

switch ($action) {
case 'list':
case 'login':
case 'logout':
	$view_mode = 1;
break;
//------------------------------------------------------------
case 'create':
	// CONTACT-SEND
	if ($subaction == 'contact') {
		// validate contact
		$valid = 0;
		$error_msg = '';
		$warning_msg = '';
		$in_var = trimRequestValues($in_var);
		// verify
		if (!$in_var['email'] || !$in_var['perm'] || strlen($in_var['message']) < 10 || $in_var['ip'] == 'empty' || !$in_var['ip'])
			$error_msg .= $SYS_WARN_MSG['contact_mandatory'];
		else {
			// verify email
			if (!isValidEmail($in_var['email']))
				$error_msg .= $SYS_WARN_MSG['email_invalid'];
			else {
			// verify sent online
			$referer = $_SERVER['HTTP_HOST'];
			$url = parse_url($site_url);
			$ali = parse_url($site_alias);
			if ( strpos($in_var['message'], 'http:') !== false  ||
			     strpos($in_var['message'], 'https:') !== false ||
			     strpos($in_var['message'], 'href=') !== false  ||
			     strpos($in_var['message'], 'bitcoin wallet') !== false  ||
			     !(preg_match("#^".$url['host']."#i", $referer) || preg_match("#^".$ali['host']."#i", $referer)) )
				$error_msg .= $SYS_WARN_MSG['contact_notsend']; // not online
			else {
				// PREPARING TO ADD
				$in_var['modifytime'] = time();
				$in_var['agent'] = $_SERVER['HTTP_USER_AGENT'];
				if (!$in_var['menu_id']) $in_var['menu_id'] = $menu_info['id'];
				$in_db_var['ip'] = '\''.$in_var['ip'].'\'';
				$in_db_var['agent'] = '\''.$in_var['agent'].'\'';
				$in_db_var['name'] = '\''.$in_var['email'].'\'';
				$in_db_var['email'] = '\''.$in_var['email'].'\'';
				$in_db_var['ui_lang'] = '\''.$ui_lang.'\'';
				$in_db_var['message'] = '\''.$in_var['message'].'\'';
				$in_db_var['status'] = 4;
				$in_db_var['menu_id'] = $in_var['menu_id'];
				$in_db_var['modifytime'] = $in_var['modifytime'];
				$valid = 1;
				// verify for spam
				if (guestbookGetCount(DB_PREFIX, $db_link, (time()-$spam_expire), $in_var['ip'], $in_var['agent']) == 0) {
				if (guestbookInsert(DB_PREFIX, $db_link, $in_db_var)) {
					$gsb_from = $gsb_to;
					if ($in_var['email']) $gsb_reply = $in_var['email'];
					if ($in_var['copy'] == 1) $gsb_cc = $in_var['email'];
					if (mailerSendSimple($sys_mx, $gsb_to, $gsb_reply, $gsb_from, $gsb_cc, $gsb_bcc, $gsb_subj, $SYS_WARN_MSG['contact_msg'].'<hr />', $email_style, $in_var, $in_synonym)) {
						$warning_msg .= $SYS_WARN_MSG['contact_send'];
						$success = 1;
					} else
						$error_msg .= $SYS_WARN_MSG['contact_notsend'];
				} else
					$error_msg .= $SYS_WARN_MSG['book_notcreated'];
				} else
					$error_msg .= $SYS_WARN_MSG['book_spam'];
			}
			}
		}
		// ASSIGN CONTACT DETAILS
		//print_r($in_var);
		assignArray($in_var, 'contact');
		$view_mode = 1;
	}
break;
//------------------------------------------------------------
default:
	$error_msg = $SYS_WARN_MSG['action_wrong'];
	$action = 'list';
	$view_mode = 1;
}
//------------------------------------------------------------
// VIEW
	if ($view_mode > 1) {
		$smarty->assign('error_msg', $error_msg);
		$smarty->assign('warning_msg', $warning_msg);
		$smarty->assign('SID', $SID);
		$smarty->display($tpl);
	} else
		$smarty->assign('pattern_content', $tpl);
	$smarty->assign('success', $success);

?>
