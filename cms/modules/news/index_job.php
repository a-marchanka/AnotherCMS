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

$in_var = array('id' => '', 'menu_id' => '', 'news_id' => '', 'createnick' => '');
$search_var = array('sort' => '', 'menu_id' => '', 'filter' => '', 'page' => '');

$sort_list = array(
	'0' => array('id' => 'up_menu_id', 'title' => $SYS_WARN_MSG['webpage'].' &uarr;'),
	'1' => array('id' => 'dw_menu_id', 'title' => $SYS_WARN_MSG['webpage'].' &darr;'),
	'2' => array('id' => 'up_status', 'title' => $SYS_WARN_MSG['status'].' &uarr;'),
	'3' => array('id' => 'dw_status', 'title' => $SYS_WARN_MSG['status'].' &darr;'),
	'4' => array('id' => 'up_modifytime', 'title' => $SYS_WARN_MSG['date'].' &uarr;'),
	'5' => array('id' => 'dw_modifytime', 'title' => $SYS_WARN_MSG['date'].' &darr;')
	);
assignArray($sort_list, 'sort_list');

$success = 0;
$in_db_var = array();
$out_var = array();
$nwj_status_array = array();
$out_log = '';

// GET CONFIG DATA
$cfg_local = configGetInfo(DB_PREFIX, $db_link, 113); // news module
foreach ($cfg_local as $tmp_var=>$tmp_param)
	$$tmp_var = $tmp_param;

// nwj_status - status_list
$tmp = explode(';', htmlDecode($nwj_status));
for ($i=0; $i<sizeof($tmp); $i++) {
	$tmp_var = explode('=', $tmp[$i]);
	$nwj_status_array[$i] = array('id' => trim($tmp_var[0]), 'title' => trim($tmp_var[1]));
}
assignArray($nwj_status_array, 'status_list');

// db functions
include 'modules/news/func_job.php';
assignArray(jobGetMenuList(DB_PREFIX, $db_link), 'menu_list');
assignArray(jobGetNewsList(DB_PREFIX, $db_link), 'news_list');

switch ($action) {
case 'delete':
	if ($details_id) {
		$details = jobGetInfo(DB_PREFIX, $db_link, $details_id);
		if (jobDelete(DB_PREFIX, $db_link, $details['menu_id'], $details['news_id'])) $warning_msg .= $SYS_WARN_MSG['deleted'];
		else $error_msg .= $SYS_WARN_MSG['notdeleted'];
	}
	$action = 'list';
//------------------------------------------------------------
case 'list':
	// clean-up deleted menu and news  // clean-up status
	if (jobNewsCleanUp(DB_PREFIX, $db_link) && jobMenuCleanUp(DB_PREFIX, $db_link)) $warning_msg .= $SYS_WARN_MSG['cleanup'];
	// list
	include 'inc_job_list.php';
	$view_mode = 1;
break;
//------------------------------------------------------------
case 'details':
	// DISPLAY DOCUMENT
	if ($subaction == 'item') {
		if ($details_id) {
			// assign news details
			$details = jobGetInfo(DB_PREFIX, $db_link, $details_id);
			$out_var = jobEmails(DB_PREFIX, $db_link, $details['menu_id'], $details['news_id']);
			$out_cnt = sizeof($out_var);
			for ($i = 0; $i < $out_cnt; $i++) {
				$out_log .= $out_var[$i]['status'].' - '.$out_var[$i]['email'].' '.$out_var[$i]['reference']."\n";
				// job can be runned
				if ($out_var[$i]['status'] < 2) $success ++;
			}
			$details['out_log'] = $out_log;
		} else {
			$search_s = $cfg_profile['nwj_sort'];
			$search_var = explodeRequestValues($search_s);
			$details['menu_id'] = (isset($search_var['menu_id']))?($search_var['menu_id']):(0);
			$details['news_id'] = 0;
		}
		assignArray($details, 'details');
		unset($details);
		$tpl = 'news_job_details.tpl';
		$view_mode = 1;
		$action = 'list';
	}
break;
//------------------------------------------------------------
case 'edit':
case 'create':
	if ($action == 'create') $details_id = 0; // empty for new

	if ($subaction == 'item') $tpl = 'news_job_details.tpl';
	// edit
	include 'inc_job_edit.php';

	if ($subaction == 'save_close') {
		if ($success > 0) include 'inc_job_list.php';
		else $tpl = 'news_job_details.tpl';
	}
	$view_mode = 1;
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
$smarty->assign('success', $success);
if ($view_mode > 1) {
	$smarty->assign('error_msg', $error_msg);
	$smarty->assign('warning_msg', $warning_msg);
	$smarty->assign('SID', $SID);
	$smarty->display((($tpl) ? ($tpl) : ('news_job_details.tpl')));
} else {
	$right_frame = ($tpl) ? ($tpl) : ('news_job_list.tpl');
}

// unset variables
unset($in_var);
unset($out_var);

?>
