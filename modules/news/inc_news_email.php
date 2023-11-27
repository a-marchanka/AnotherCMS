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

$details_id = 0;
if (!empty($_POST['details_id']) || !empty($_GET['details_id']))
$details_id = (!empty($_POST['details_id'])) ? $_POST['details_id'] : $_GET['details_id'];
if (!is_numeric($details_id)) $details_id = 0;

$in_var = array('name' => '', 'email' => '', 'howlong' => '', 'ip' => '');

// include FUNCs
include 'modules/news/func_news_email.php';

$success = 0;
$in_db_var = array();

// get config
$cfg_local = configGetInfo(DB_PREFIX, $db_link, 113); // news module
// local variables
foreach ($cfg_local as $tmp_var => $tmp_param)
	$$tmp_var = $tmp_param;

if ($action == 'create') {
	// validate email
	$email_id = 0;
	$valid = 0;
	$error_msg = '';
	$warning_msg = '';
	$in_var = trimRequestValues($in_var);
	//print_r($in_var);
	// verify
	if (!$in_var['email'] || $in_var['ip'] == 'empty' || !$in_var['ip'])
		$error_msg .= $SYS_WARN_MSG['contact_mandatory'];
	else {
		// erify email
		if (!isValidEmail($in_var['email']))
			$error_msg .= $SYS_WARN_MSG['email_invalid'];
		else {
		// verify sent online
		$referer = $_SERVER['HTTP_HOST'];
		$url = parse_url($site_url);
		$ali = parse_url($site_alias);
		if ( strpos($in_var['name'], 'http:') !== false  ||
		     strpos($in_var['name'], 'bitcoin') !== false  ||
		     !(preg_match("#^".$url['host']."#i", $referer) || preg_match("#^".$ali['host']."#i", $referer)) )
			$error_msg .= $SYS_WARN_MSG['contact_notsend']; // not online
		else {
			$tpl_html = 'news_request.tpl';
			// PREPARING TO ADD
			if ($in_var['howlong'] == 1)
				$validetime = mktime(0, 0, 0, 1, 1, date("Y")+2);
			elseif ($in_var['howlong'] == 2)
				$validetime = mktime(0, 0, 0, 1, 1, date("Y")+3);
			else $tpl_html = 'news_reject.tpl';
			// try to find existing
			$email_id = emailGetId(DB_PREFIX, $db_link, $in_var['email'], $menu_info['id']);
			if ($email_id == 0 && $tpl_html == 'news_request.tpl') {
				// add
				$in_db_var['enabled'] = 0;
				$in_db_var['priority'] = 3;
				$in_db_var['email'] = '\''.$in_var['email'].'\'';
				$in_db_var['name'] = '\''.$in_var['name'].'\'';
				$in_db_var['menu_id'] = $menu_info['id'];
				$in_db_var['modifytime'] = time();
				$in_db_var['validetime'] = $validetime;
				$in_db_var['createnick'] = '\''.$in_var['createnick'].'\'';
				$email_id = emailInsert(DB_PREFIX, $db_link, $in_db_var);
			}
			if ($email_id) {
				$link['link_accept'] = $site_url.'/'.$menu_info['name'].'?action=accept&amp;subaction=newsletter&amp;details_id='.$email_id.'&amp;mid='.md5($email_id.$in_var['email']);
				$link['link_reject'] = $site_url.'/'.$menu_info['name'].'?action=reject&amp;subaction=newsletter&amp;details_id='.$email_id.'&amp;mid='.md5($email_id.$in_var['email']);
				$html_email = replaceContentWithValues(getContentFromPath($site_dir.$usr_tpl.$tpl_html), $link);
				//echo $html_email;
				// send email
				if (mailerSendSimple($sys_mx, $in_var['email'], $nwj_email, $nwj_email, '', '', 'Newsletter-Bestaetigung', $html_email, ''))
					if ($tpl_html == 'news_request.tpl') $warning_msg .= ($warning_msg)?('<br>'):('').$SYS_WARN_MSG['email_created'];
					else $warning_msg .= ($warning_msg)?('<br>'):('').$SYS_WARN_MSG['email_rejection'];
				else
					$error_msg .= ($error_msg)?('<br>'):('').$SYS_WARN_MSG['email_notcreated'];
				unset($html_email);
			}
		} }
	}
	// ASSIGN DETAILS
	assignArray($in_var, 'items');
}
if ($action == 'accept' || $action == 'reject') {
	$mid = htmlEncode($_GET['mid']);
	$in_var = emailGetInfo(DB_PREFIX, $db_link, $details_id);
	if ($in_var) if ($mid == md5($details_id.$in_var['email'])) {
		if ($action == 'accept')
			if (emailUpdate(DB_PREFIX, $db_link, $details_id, array('enabled'=>1))) $warning_msg .= ($warning_msg)?('<br>'):('').$SYS_WARN_MSG['email_accepted'];
			else $error_msg .= ($error_msg)?('<br>'):('').$SYS_WARN_MSG['email_notaccepted'];
		if ($action == 'reject')
			if (emailDelete(DB_PREFIX, $db_link, $details_id, $menu_info['id'])) $warning_msg .= ($warning_msg)?('<br>'):('').$SYS_WARN_MSG['email_rejected'];
			else $error_msg .= ($error_msg)?('<br>'):('').$SYS_WARN_MSG['email_notrejected'];
	}
}
$action = 'list';

?>
