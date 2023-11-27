<?php
/* ==================================================== ##
##             COPYRIGHTS © Another CMS PHP TEAM        ##
## ==================================================== ##
## PRODUCT : CMS(CONTENT MANAGEMENT SYSTEM)             ##
## LICENSE : GNU(General Public License v.3)            ##
## TECHNOLOGIES : PHP & Sqlite                          ##
## WWW : www.zapms.de | www.marchenko.de                ##
## E-MAIL : andrey@marchenko.de                         ##
## ==================================================== */

//error_reporting(E_ALL);
//error_reporting(E_ALL ^ E_NOTICE);
//print_r($_COOKIE);
//print_r($_SERVER);
ini_set('default_charset','utf-8');

include 'cms/modules/constants.php';
include 'cms/modules/functions.php';
include 'cms/modules/sessions.php';
include 'cms/modules/mailer.php';

//------------------------------------------------------------
// Smarty
require(WWW_DIR.'libs/smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->setTemplateDir(WWW_DIR.'templates');
$smarty->setCompileDir(WWW_DIR.'templates_c');
$smarty->setConfigDir(WWW_DIR.'templates');
$smarty->setCacheDir(WWW_DIR.'templates');

//------------------------------------------------------------
// data base
$db_file = CMS_DIR.'data/cms-db.sqlite';
// open
if (strpos($db_file, '.sqlite') !== false && file_exists($db_file)) {
	$db_link = new SQLite3($db_file);
	$db_link->busyTimeout(8000);
} else die('Unable to open database '.$db_file);

//------------------------------------------------------------
// init
$site_dir = WWW_DIR;
$entry_name = '';
$entry_id = 0;
$action = '';
$subaction = '';
$error_msg = '';
$warning_msg = '';
$sid = '';
$SID = '';
$nick = '';
$pwd = '';
$eml = '';
$auth_role_id = 0;
$auth_id = 0;
$auth_time = 0;
$view_mode = 0;
$user_info = array();
$menu_path_array = array();
$menu_tree = array();

// get input path
if (!empty($_POST['m']) || !empty($_GET['m']))
$entry_name = (!empty($_POST['m'])) ? htmlEncode($_POST['m']) : htmlEncode($_GET['m']);
$menu_path_array = explode('/',$entry_name);
//print_r($menu_path_array);

if (!empty($_POST['action']) || !empty($_GET['action']))
$action = (!empty($_POST['action'])) ? $_POST['action'] : $_GET['action'];
if (!$action) $action = 'list';

if (!empty($_POST['subaction']) || !empty($_GET['subaction']))
$subaction = (!empty($_POST['subaction'])) ? $_POST['subaction'] : $_GET['subaction'];

//print $action.' '.$subaction;
// set defaults
$display_frame = 'site_default.tpl';

//------------------------------------------------------------
// Session Checking
if (!empty($_POST['sid']) || !empty($_GET['sid'])) {
	$sid = (!empty($_POST['sid'])) ? $_POST['sid'] : $_GET['sid'];
	if (sessExists($sid)) {
		$auth_info = sessRead($sid);
		list($auth_id, $auth_time) = preg_split('/#/', $auth_info);
		//print $auth_info.' '.$auth_id.' '.$auth_time;
		if ($auth_time < time()-18000) { // 18000 - 5 hours
			sessDestroy($sid);
			$sid = '';
			$auth_id = 0;
		} else sessUpdate($sid, $auth_id);
	} else $sid = '';
}
//------------------------------------------------------------
// CONFIG module
include 'modules/config/func_config.php';
$cfg_global = configGetInfo(DB_PREFIX, $db_link);
// global variables
foreach ($cfg_global as $tmp_var => $tmp_param)	$$tmp_var = $tmp_param;

//------------------------------------------------------------
// MENU module, currently selected page
include 'modules/menu/func_menu.php';

// parsing of the url path
$entry_name = '';
$menu_info = array();
// verify page exists
$last_m = sizeof($menu_path_array);
if ($last_m > 0) {
	$entry_name = $menu_path_array[$last_m-1];
	if (!empty($entry_name)) $menu_info = menuGetPage(DB_PREFIX, $db_link, $entry_name);
}
//print_r($menu_info);
// in case nothing is found
if (!$menu_info) {
	// try default start page
	if (!$entry_name) {
		$cfg_local = configGetInfo(DB_PREFIX, $db_link, 0, 'mnu_home');
		$entry_name = $cfg_local['mnu_home'];
		$menu_info = menuGetPage(DB_PREFIX, $db_link, $entry_name);
	}
	if (!$menu_info) {
		$menu_info['id'] = 0;
		$menu_info['parent_id'] = 0;
		$menu_info['content_type'] = 'dynamic';
		$menu_info['content'] = '<!DOCTYPE html><head><title>404 Error</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="robots" content="noindex, nofollow"></head><body><h2>Error 404. Page <b>'.$entry_name.'</b> is not found<br><img src="/images/404.png" alt="404 Error" title="404 Error" width="200" height="200"></h2><a href="/">Go Back</a></body></html>';
		$menu_info['variables'] = 'language=en';
		$menu_info['pattern_0'] = 'content_default.tpl';
		$menu_info['pattern_1'] = '';
		$menu_info['pattern_2'] = '';
		$menu_info['pattern_3'] = '';
		$menu_info['pattern_4'] = '';
		$menu_info['pattern_5'] = '';
		$menu_info['title'] = $site_title;
		$menu_info['description'] = $site_description;
		$menu_info['keywords'] = $site_keywords;
		$menu_info['modifytime'] = 0;
		$menu_info['role_ids'] = '';
	}
}
// PAGE VARIABLES
$url_variables = explodeVariables($menu_info['variables']);
// PAGE LANGUAGE
$ui_lang = (isset($url_variables['language']))?($url_variables['language']):($msg_lang);

//------------------------------------------------------------
// SYSTEM WARNINGS library
if ($ui_lang) include 'modules/warnings_'.$ui_lang.'.php';

//------------------------------------------------------------
// USER module
include 'modules/user/func_user.php';
// LOGOUT
if ($action == 'logout') {
	if ($auth_id) {
		sessDestroy($sid);
		$sid = '';
		$auth_id = 0;
		$warning_msg = $SYS_WARN_MSG['exit_auth'];
	} else
		$error_msg = $SYS_WARN_MSG['not_auth'];
	// set action
	$action = 'list';
}
//------------------------------------------------------------
// LOGIN
/*
login account - login
login request - create inactive user, send email
*/
if (!$auth_id && $action == 'login' && ($subaction == 'account' || $subaction == 'request')) {
	// get parameters POST
	$nick = htmlEncode((!empty($_POST['nick'])) ? $_POST['nick'] : '');
	$pwd = htmlEncode((!empty($_POST['pwd'])) ? $_POST['pwd'] : '');
	$sig = htmlEncode((!empty($_POST['sig'])) ? $_POST['sig'] : 'empty');
	$referer = $_SERVER['HTTP_HOST'];
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$url = parse_url($site_url);
	$ali = parse_url($site_alias);
	// verify nick for special chars	
	preg_match('/[\w\@\-\.\/\ ]*/', $nick, $nick_valide);
	//print_r($nick_valide);
	if ($nick_valide[0] != $nick) {
		$error_msg = $SYS_WARN_MSG['valide_nick'];
		$nick = '';
	}
	// verify
	if ( strlen($nick) >= 3 && strlen($nick) <= 50 && strlen($pwd) >= 3 && strlen($pwd) <= 30 && $sig != 'empty' &&
	    (preg_match("#^".$url['host']."#i", $referer) || preg_match("#^".$ali['host']."#i", $referer)) ) {
		// login of existing user
		if ($subaction == 'account' && $menu_info['role_ids']) {
			// find user id
			$user_info = userGetByNick(DB_PREFIX, $db_link, $nick);
			$auth_id = (!empty($user_info['id']))?($user_info['id']):(0);
			if ($auth_id) {
				if ($user_info['active'] > 0) {
					if ($user_info['fouls'] == 0 || ($user_info['fouls'] > 0 && time()-$user_info['lastvisit'] > 20)) {
						if ($user_info['pass'] == md5($pwd)) {
							$sid = md5(uniqid(rand(),1));
							sessUpdate($sid, $auth_id);
							// user is accepted
							userSetLastVisit(DB_PREFIX, $db_link, $auth_id);
							$warning_msg = $SYS_WARN_MSG['ok_auth'];
						} else {
							// fouls counter
							userSetFouls(DB_PREFIX, $db_link, $auth_id);
							$auth_id = 0;
							$error_msg = $SYS_WARN_MSG['wrong_psw'];
				    		}
					} else {
						$auth_id = 0;
						$error_msg = $SYS_WARN_MSG['user_locked'];
					}
				} else {
					$auth_id = 0;
					$error_msg = $SYS_WARN_MSG['wrong_auth'];
				}
			} else {
				$auth_id = 0;
				$error_msg = $SYS_WARN_MSG['wrong_nick'];
		    	}
		}
		// request new user
		if ($subaction == 'request') {
			if (userGetCount(DB_PREFIX, $db_link, (time()-$spam_expire), $sig, $agent) == 0) {
				$role_info = array();
				$in_db_var = array();
				$role_id = 0;
				$tmp_id = 0;
				// get default role
				$role_info = roleGetByName(DB_PREFIX, $db_link, $usr_def_role);
				$role_id = (!empty($role_info['id']))?($role_info['id']):(0);
				if ($role_id) {
					// create user, admin must activate
					$in_db_var['lastvisit'] = time();
					$in_db_var['agent'] = '\''.$agent.'\'';
					$in_db_var['sig'] = '\''.$sig.'\'';
					$in_db_var['active'] = 0;
					$in_db_var['nick'] = '\''.strtolower($nick).'\'';
					$in_db_var['pass'] = '\''.md5($pwd).'\'';
					$in_db_var['role_id'] = $role_id;
					$tmp_id = userInsert(DB_PREFIX, $db_link, $in_db_var);
					if ($tmp_id) {
						// add profile info for module prefixes
						profileInsertValues(DB_PREFIX, $db_link, $tmp_id);
						// send email
						if ( mailerSendSimple($sys_mx, $sys_email, $sys_email, $sys_email, '', '', 'New Account '.$site_url, $SYS_WARN_MSG['u_created'].'<hr />', $email_style, array('nick'=>$nick), array('nick'=>'User')) )
							$warning_msg .= $SYS_WARN_MSG['email_sent'].'<br />';
						else
							$error_msg .= $SYS_WARN_MSG['email_invalid'];
						// user is accepted
						$warning_msg .= $SYS_WARN_MSG['ok_user'];
					} else $error_msg .= $SYS_WARN_MSG['wrong_nick'];
				} else $error_msg = $SYS_WARN_MSG['notcreated'];
			} else $error_msg = $SYS_WARN_MSG['try_later'];
		}
	} else $warning_msg = $SYS_WARN_MSG['your_login'];
	// set action
	$action = 'list';
}
//------------------------------------------------------------
// VERIFY ROLE
if ($auth_id) { // user info
	if (!$user_info) $user_info = userGetInfo(DB_PREFIX, $db_link, $auth_id);
	$auth_role_id = $user_info['role_id'];
}
if ($menu_info['role_ids']) { // verify access to menu
	$do_login = 1;
	$menu_info['role_ids_arr'] = (!empty($menu_info['role_ids']))?explode(',', $menu_info['role_ids']):array();
	// authorized
	if ($auth_id && $user_info) {
		for ($i = 0; $i < sizeof($menu_info['role_ids_arr']); $i ++)
			if ($menu_info['role_ids_arr'][$i] == $user_info['role_id']) $do_login = 0;
	}
	// not autorized
	if ($do_login == 1) {
		// display your login page
		$menu_info['content_type'] = 'static';
		$menu_info['pattern_4'] = 'content_default.tpl';
		$menu_info['content'] = 'content_login_'.$ui_lang.'.html';
	}
	// not permited
	if ($auth_id && $do_login) $warning_msg = $SYS_WARN_MSG['wrong_auth'];
}
if ($sid) $SID = 'sid='.$sid;
assignArray($user_info, 'user_info');
//------------------------------------------------------------
// MENU tree and path
$menu_tree = menuGetAll(DB_PREFIX, $db_link, $menu_info['id'], $auth_role_id);
assignArray($menu_tree, 'menu_tree');
//print_r($menu_tree);

//------------------------------------------------------------
// ASSIGN PAGE PROPERTIES
if ($menu_info['pattern_0'])
	$display_frame = $menu_info['pattern_0'];
if ($menu_info['pattern_1'])
	$smarty->assign('pattern_menu_top', $site_dir.$design_dir.$menu_info['pattern_1']);
if ($menu_info['pattern_2'])
	$smarty->assign('pattern_menu_main', $site_dir.$design_dir.$menu_info['pattern_2']);
if ($menu_info['pattern_3'])
	$smarty->assign('pattern_menu_sub', $site_dir.$design_dir.$menu_info['pattern_3']);
if ($menu_info['pattern_4'])
	$smarty->assign('pattern_content', $site_dir.$design_dir.$menu_info['pattern_4']);
if ($menu_info['pattern_5'])
	$smarty->assign('pattern_content_add', $site_dir.$design_dir.$menu_info['pattern_5']);

// Assign html meta tags
$smarty->assign('site_url', $site_url);
$smarty->assign('site_title', $menu_info['title'].'. '.$site_title);
$smarty->assign('site_description', ($menu_info['description'])?($menu_info['description']):($site_description));
$smarty->assign('site_keywords', ($menu_info['keywords'])?($menu_info['keywords']):($site_keywords));
$smarty->assign('site_modifytime', ($menu_info['modifytime'])?($menu_info['modifytime']):(0));
$smarty->assign('ui_lang', $ui_lang);
$smarty->assign('sys_img', $sys_img);
$smarty->assign('usr_img', $usr_img);
$smarty->assign('entry_name', $entry_name);
$smarty->assign('entry_title', $menu_info['title']);
$smarty->assign('entry_id', $menu_info['id']);
$smarty->assign('entry_parent_id', $menu_info['parent_id']);

//------------------------------------------------------------
// READ PAGE CONTENT
switch ($menu_info['content_type']) {
	case 'url':
		$smarty->caching = 0;
		$tmp_var = ($menu_info['variables']) ? ('?'.implodeRequestValues(explodeVariables($menu_info['variables']))) : ('');
		// if content already url
		$tmp_url = (strpos($menu_info['content'], '://') ? ($menu_info['content']) : ($site_url.'/'.$menu_info['content']));
		header('Location: '.appendSid($sid, $tmp_url, true));
		//print 'Location: '.appendSid($sid, $tmp_url);
		$view_mode = 2;
	break;
	case 'static':
		$smarty->caching = 0;
		$smarty->assign('page_content', ($menu_info['content'])?(getContentFromPath($site_dir.$files_dir.$menu_info['content'], $sid)):(''));
		//print $site_dir.$files_dir.$menu_info['content'];
		// ----- Menu Last Changes -----
		assignArray(menuGetLast(DB_PREFIX, $db_link), 'menu_last');
		// ----- Guestbook include -----
		include 'modules/guestbook/func_guestbook.php';
		// ----- Galery include -----
		include 'modules/galery/func_galery.php';
		assignArray(galeryGetByMenu(DB_PREFIX, $db_link, $menu_info['id']), 'galery_list');
		// ----- News include -----
		include 'modules/news/func_news.php';
		assignArray(newsGetHits(DB_PREFIX, $db_link, $ui_lang, $menu_info['id']), 'news_list');
		// ----- Contact -----
		if ($subaction == 'contact') include 'modules/contact/inc_contact.php';
		// ----- Newsletter -----
		if ($subaction == 'newsletter') include 'modules/news/inc_news_email.php';
		// ----------------------
		$view_mode = 1;
	break;
	case 'dynamic':
		$smarty->caching = 0;
		$smarty->assign('page_content', $menu_info['content']);
		$url_variables = explodeVariables($menu_info['variables']);
		$view_mode = 1;
	break;
	case 'module':
		// ----- Guestbook include -----
		include 'modules/guestbook/func_guestbook.php';
		// ----- Contact -----
		if ($subaction == 'contact') include 'modules/contact/inc_contact.php';
		// ----- Newsletter -----
		if ($subaction == 'newsletter') include 'modules/news/inc_news_email.php';
		// ----------------------
		$smarty->caching = 0;
		$module_path = 'modules/'.$menu_info['content'];
		if (file_exists($module_path) && $menu_info['content']) include $module_path;
	break;
}
// Close DB
$db_link->close();
unset($db_link);
//------------------------------------------------------------
// SMARTY modul
if ($view_mode < 2) {
	if (!$view_mode) {
		$right_frame = 'site_error.tpl';
		$error_msg .= $SYS_WARN_MSG['module_notfound'];
	}
	$smarty->assign('error_msg', $error_msg);
	$smarty->assign('warning_msg', $warning_msg);
	$smarty->assign('sid', $sid);
	$smarty->assign('SID', $SID);
	$smarty->display($display_frame, $entry_name);
}

// unset variables
unset($smarty);
unset($menu_info);
unset($menu_tree);
unset($entry_id);
unset($entry_name);
unset($action);
unset($subaction);
unset($error_msg);
unset($warning_msg);
unset($SID);
unset($sid);
?>
