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

$user_info = array();
$auth_id = 0;

include 'modules/user/func_user.php';

$nick = htmlEncode((!empty($_POST['nick'])) ? $_POST['nick'] : '');
$pwd = htmlEncode((!empty($_POST['pwd'])) ? $_POST['pwd'] : '');
$sig = htmlEncode((!empty($_POST['sig'])) ? $_POST['sig'] : 'empty');
$referer = $_SERVER['HTTP_HOST'];
$agent = $_SERVER['HTTP_USER_AGENT'];
$url = parse_url($site_url);
$ali = parse_url($site_alias);
// verify
if ( strlen($nick) >= 3 && strlen($nick) <= 50 && strlen($pwd) >= 3 && strlen($pwd) <= 30 && $sig != 'empty' &&
    (preg_match("#^".$url['host']."#i", $referer) || preg_match("#^".$ali['host']."#i", $referer)) ) {
    // find user id
    $user_info = userGetByNick(DB_PREFIX, $db_link, $nick);
	$auth_id = (!empty($user_info['id']))?($user_info['id']):(0);
	if ($auth_id) {
		if ($user_info['active'] && ($user_info['fouls'] == 0 || ($user_info['fouls'] > 0 && time()-$user_info['lastvisit'] > 30))) {
			if ($user_info['pass'] == md5($pwd)) {
				$sid = md5(uniqid(rand(),1));
				sessUpdate($sid, $auth_id);
				// Clean-Up the auth folder, delete all files that 7 days old
				$tmp_dir = dir(SESS_DIR);
				while (false !== ($tmp_file = $tmp_dir->read())) {
					if ($tmp_file == "." || $tmp_file == ".." || $tmp_file == "index.php")
						continue;
					$tmp_path = SESS_DIR.$tmp_file;
					if ((time()-filemtime($tmp_path))/86400 > 7) // hours
						unlink($tmp_path);
				}
				$tmp_dir->close();
				// user is accepted
				userSetLastVisit(DB_PREFIX, $db_link, $auth_id);
				// assign variables
				assignArray($user_info, 'user_info');
				$view_mode = 1;
			} else {
				// fouls counter
				userSetFouls(DB_PREFIX, $db_link, $auth_id);
				$auth_id = 0;
				// user is not accepted
				$error_msg = $SYS_WARN_MSG['wrong_psw'];
            		}
		} else {
			$auth_id = 0;
			// user is not accepted
			$error_msg = $SYS_WARN_MSG['user_locked'];
        	}
	} else {
		$auth_id = 0;
		// user is not accepted
		$error_msg = $SYS_WARN_MSG['wrong_nick'];
    	}
} else {
	// user is not accepted, control to login modul
	$view_mode = 2;
	$warning_msg = $SYS_WARN_MSG['your_login'];
}

if ($error_msg)
	$view_mode = 2;

// view
if ($view_mode > 1) {
	$auth_id = 0;
	$smarty->assign('error_msg', $error_msg);
	$smarty->assign('warning_msg', $warning_msg);
	$smarty->assign('nick', $nick);
	$smarty->assign('site_url', $site_url);
	$smarty->assign('site_title', $site_title);
	$smarty->assign('cms_ver', $cms_ver);
	$smarty->assign('cms_theme', $cms_theme);
	$smarty->display('core_login.tpl'); 
}
?>
