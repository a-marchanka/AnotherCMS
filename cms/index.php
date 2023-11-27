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
include 'modules/constants.php';
include 'modules/functions.php';
include 'modules/sessions.php';
//------------------------------------------------------------
// Smarty
require(WWW_DIR.'libs/smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->setTemplateDir(CMS_DIR.'templates');
$smarty->setCompileDir(CMS_DIR.'templates_c');
$smarty->setConfigDir(CMS_DIR.'templates');
$smarty->setCacheDir(CMS_DIR.'templates');
//------------------------------------------------------------
// data base
$db_file = CMS_DIR.'data/cms-db.sqlite';
// open
if (strpos($db_file, '.sqlite') !== false && file_exists($db_file)) {
	$db_link = new SQLite3($db_file);
	$db_link->busyTimeout(8000);
} else {
	die('Unable to open database '.$db_file);
}
//------------------------------------------------------------
// init
$site_dir = WWW_DIR;
$entry_id = 0;
$action = '';
$subaction = '';
$error_msg = '';
$warning_msg = '';
$tpl = '';

if (!empty($_POST['entry_id']) || !empty($_GET['entry_id']))
$entry_id = (!empty($_POST['entry_id'])) ? $_POST['entry_id'] : $_GET['entry_id'];
if (!is_numeric($entry_id) || !$entry_id) $entry_id = 1;

if (!empty($_POST['action']) || !empty($_GET['action']))
$action = (!empty($_POST['action'])) ? $_POST['action'] : $_GET['action'];
if (!$action) $action = 'list';

if (!empty($_POST['subaction']) || !empty($_GET['subaction']))
$subaction = (!empty($_POST['subaction'])) ? $_POST['subaction'] : $_GET['subaction'];

$left_frame = 'core_dtree.tpl';
$right_frame = 'core_search.tpl';
$display_frame = 'core_default.tpl';

//------------------------------------------------------------
// Session Checking
$sid = '';
$SID = '';
$auth_id = 0;
$auth_time = 0;
if (!empty($_POST['sid']) || !empty($_GET['sid'])) {
	$sid = (!empty($_POST['sid'])) ? $_POST['sid'] : $_GET['sid'];
	if(sessExists($sid)) {
		$auth_info = sessRead($sid);
		list($auth_id, $auth_time) = preg_split('/#/', $auth_info);
		//print $auth_info.' '.$auth_id.' '.$auth_time;
		if ($auth_time < time()-18000) { // 18000 - 5 hours
			sessDestroy($sid);
			$sid = '';
			$auth_id = 0;
		} else sessUpdate($sid, $auth_id);
	} else
		$sid = '';
}

//------------------------------------------------------------
// CONFIG modul
include 'modules/config/func_config.php';
$cfg_global = configGetInfo(DB_PREFIX, $db_link);
// global variables
foreach ($cfg_global as $tmp_var => $tmp_param)
	$$tmp_var = $tmp_param;

if ($entry_id > 1) {
	$cfg_local = configGetInfo(DB_PREFIX, $db_link, $entry_id);
	// local variables
	foreach ($cfg_local as $tmp_var => $tmp_param)
		$$tmp_var = $tmp_param;
}

//------------------------------------------------------------
// SYSTEM WARNINGS library
$ui_lang = $cfg_global['msg_lang'];
if ($ui_lang) {
	include 'modules/warnings_'.$ui_lang.'.php';
	$smarty->assign('ui_lang', $ui_lang);
}

//------------------------------------------------------------
// USER module
if ($auth_id) {
	include 'modules/user/func_user.php';
	$user_info = userGetInfo(DB_PREFIX, $db_link, $auth_id);
	//print_r($user_info);
	// assign variables
	assignArray($user_info, 'user_info');
} else {
	include 'modules/user/inc_login.php';
	// open help by DEFAULT
	$entry_id = ($entry_id_default) ? ($entry_id_default) : (1);
	$action = 'list';
}

if ($sid) $SID = 'sid='.$sid;

//------------------------------------------------------------
// PROFILE module
// include user's profile
if ($auth_id) {
	include 'modules/user/func_profile.php';
	$cfg_profile = profileGetInfo(DB_PREFIX, $db_link, $auth_id);
}

//------------------------------------------------------------
// DTREE module
if ($auth_id) {
	include 'modules/dtree.php';
	// get entry details
	$entry_info = dtreeGetInfo(DB_PREFIX, $db_link, $auth_id, $entry_id);
	//print_r($entry_info);
	if ($entry_info) {
		assignArray(dtreeGetChilds(DB_PREFIX, $db_link, $auth_id, $entry_id), 'modules_list');
		$module_path = 'modules/'.$entry_info['entry_path'];
		// assign variables
		assignArray($entry_info, 'entry_info');
		// view_mode: 0 - module file is not found, 1 - core, 2 - modul cares for displaying of .tpl
		$view_mode = (file_exists($module_path)) ? (1) : (0);
	} else
		$view_mode = 0;
	//print_r($entry_info);
	//------------------------------------------------------------
	// SECURITY verification
	$action_attr_array = array(
		'list' => 1,
		'details' => 1,
		'edit' => 2,
		'create' => 3,
		'delete' => 3);
	if (isset($entry_info['entry_attr'])) {
		if ($action_attr_array[$action] > $entry_info['entry_attr'])
			$action = 'error';
	} else $action = 'error';
	//------------------------------------------------------------
	// Include custom module
	if ($view_mode) include $module_path;
	//------------------------------------------------------------
	// Display Dtree
	if ($action == 'list')
		$dtree_list = dtreeGetTop(DB_PREFIX, $db_link, $auth_id, $entry_id);
}
// Close DB
$db_link->close();
unset($db_link);
//------------------------------------------------------------
// SMARTY modul
if ($view_mode < 2) {
	if (!$view_mode) {
		$right_frame = 'core_empty.tpl';
		$error_msg .= $SYS_WARN_MSG['modul_notfound'];
	}
	$smarty->assign('error_msg', $error_msg);
	$smarty->assign('warning_msg', $warning_msg);
	$smarty->assign('site_url', $site_url);
	$smarty->assign('site_title', $site_title);
	$smarty->assign('cms_ver', $cms_ver);
	$smarty->assign('cms_theme', $cms_theme);
	$smarty->assign('left_frame', $left_frame);
	$smarty->assign('right_frame', $right_frame);
	$smarty->assign('entry_id', $entry_id);
	$smarty->assign('entry_id_default', $entry_id_default);
	$smarty->assign('sid', $sid);
	$smarty->assign('SID', $SID);
	if (isset($dtree_list)) $smarty->assign('dtree_list', $dtree_list);
	$smarty->display($display_frame);
}

// unset variables
unset($smarty);
unset($entry_id);
unset($action);
unset($subaction);
unset($error_msg);
unset($warning_msg);
unset($SID);
unset($sid);
unset($tpl);
?>
