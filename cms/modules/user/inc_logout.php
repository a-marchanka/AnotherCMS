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

$view_mode = 2;

if ($auth_id) {
	sessDestroy($sid);
	$auth_id = 0;
	$warning_msg = $SYS_WARN_MSG['your_login'];
} else {
	$error_msg = $SYS_WARN_MSG['not_auth'];
}
$nick = 'none';
$smarty->assign('error_msg', $error_msg);
$smarty->assign('warning_msg', $warning_msg);
$smarty->assign('nick', $nick);
$smarty->assign('site_url', $site_url);
$smarty->assign('site_title', $site_title);
$smarty->assign('cms_ver', $cms_ver);
$smarty->assign('cms_theme', $cms_theme);
$smarty->display('core_login.tpl'); 
?>
