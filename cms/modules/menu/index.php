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
if (!is_numeric($details_id) || !$details_id) $details_id = 0;

$in_var = array(
	'id' => '', 'parent_id' => '', 'priority' => '', 'name' => '', 'title' => '', 'content_type' => '', 'content_htm' => '', 'content_txt' => '',
	'variables' => '', 'pattern_0' => '', 'pattern_1' => '', 'pattern_2' => '', 'pattern_3' => '', 'pattern_4' => '', 'pattern_5' => '',
	'active' => '', 'description' => '', 'keywords' => '', 'modifytime' => '', 'createnick' => '', 'role_ids' => '', 'role_ids_arr' => '' );

$search_var = array('menu_id' => '');

$success = 0;
$in_db_var = array();
$out_var = array();
$editor_content = '';

// include MENU
include 'modules/menu/func_menu.php';
// assign menu search list
assignArray(menuGetAll(DB_PREFIX, $db_link), 'search_list');

// include ROLES LIST
include 'modules/user/func_role.php';
assignArray(roleGetAll(DB_PREFIX, $db_link), 'roles_list');

// fm functions
include 'modules/fm/func_fm.php';

// default parameters
assignArray($cfg_local, 'details_default');
// assign module variables
$smarty->assign('tinymce_css', $tinymce_css);

switch ($action) {
case 'delete':
	// details_id = menu ID
	if ($subaction == 'menu') {
		if (menuGetCountChild(DB_PREFIX, $db_link, $details_id))
			$error_msg .= $SYS_WARN_MSG['notsingle'];
		else if (menuDelete(DB_PREFIX, $db_link, $details_id))
			$warning_msg .= $SYS_WARN_MSG['deleted'];
		else
			$error_msg .= $SYS_WARN_MSG['notdeleted'];
	}
	$action = 'list';
//------------------------------------------------------------
case 'list':
	if ($subaction == 'list_js_url') {
		$list_js = '';
		//take a list
		$out_var = menuGetUrlList(DB_PREFIX, $db_link);
		if ($out_var) {
			foreach ($out_var as $file_info) {
			$list_js .= '{"title":"'.htmlDecode($file_info['title']).' ('.$file_info['name'].')",';
			$list_js .= '"value":"'.$site_url.'/'.$file_info['name'].'"},';
			}
			$list_js = '['.substr($list_js, 0, -1).']';
		}
		// assign
		header('Content-type: text/javascript');
		header('pragma: no-cache');
		echo $list_js;
		unset($list_js);
		$tpl = 'core_empty.tpl';
		$view_mode = 2;
	} else if ($subaction == 'csv') {
		// create CSV
		exportCSV(menuGetAll(DB_PREFIX, $db_link, array('menu_id' => '0')), 'cms_menu', $chr_set, $csv_separator);
		$tpl = 'core_empty.tpl';
		$view_mode = 2;
	} else {
		// list
		include 'inc_menu_list.php';
		$view_mode = 1;
	}
break;
//------------------------------------------------------------
case 'details':
	// subaction IN menu, copy, static, dynamic, modul, url, folder, mceedit
	// assign lists
	assignArray(fmGetFileList($site_dir.$files_dir, 'file', 'html'), 'html_list');
	assignArray(fmGetFileList($site_dir.$design_dir, 'file', 'tpl'), 'tpl_list');
	// details
	if ($details_id) {
		$details = menuGetInfo(DB_PREFIX, $db_link, $details_id);
		if ($subaction == 'copy') {
			$details['id'] = '';
			$details['content_htm'] = '';
			$details['title'] .= ' Copy';
			$details['name'] .= '_copy';
		}
		if ($subaction == 'mceedit' && $details['content_type'] == 'static') {
			if ($details['content_htm']) {
				$editor_content = fmGetContent($site_dir.$files_dir.$details['content_htm']);
				if (!$editor_content) $editor_content = $SYS_WARN_MSG['content_default'];
				//print $editor_content;
				$smarty->assign('editor_content', htmlEncode($editor_content)); // show and replace all specials
			}
		}
	} else {
		if (isset($cfg_profile['mnu_sort'])) $search_s = $cfg_profile['mnu_sort'];
		$search_var = explodeRequestValues($search_s);
		$details['parent_id'] = (isset($search_var['menu_id']))?($search_var['menu_id']):(0);
		$details['title'] = 'New Page';
		$details['name'] = 'new_page';
		$details['content_type'] = 'static';
		$details['content_htm'] = '';
		$details['content_txt'] = '';
		$details['pattern_0'] = 'site_default.tpl';
		$details['id'] = 0;
		$details['priority'] = 1;
		$smarty->assign('editor_content', $SYS_WARN_MSG['content_default']);
	}
	if (isset($details['role_ids'])) $details['role_ids_arr'] = explode(',', $details['role_ids']);
	assignArray($details, 'details');
	unset($details);
	//print_r($details);
	$tpl = ($subaction=='mceedit')?('menu_details_mceedit.tpl'):('menu_details.tpl');
	$view_mode = 1;
	$action = 'list';
break;
//------------------------------------------------------------
case 'edit':
case 'create':
	if ($action == 'create') $details_id = 0; // empty for new

	if ($subaction == 'mceedit' || $subaction == 'save_close_mceedit') {
		$editor_content = $_POST['editor_content']; // without strips
		$editor_content = linkToLytebox(emailToUnicode($editor_content));
		$smarty->assign('editor_content', htmlEncode($editor_content)); // show and replace all htmls
	}
	// edit
	include 'inc_menu_edit.php';

	if (($subaction == 'save_close_mceedit' || $subaction == 'save_close_menu') && $success == 2)
		include 'inc_menu_list.php';
	else {
		// assign lists
		assignArray(fmGetFileList($site_dir.$files_dir, 'file', 'html'), 'html_list');
		assignArray(fmGetFileList($site_dir.$design_dir, 'file', 'tpl'), 'tpl_list');
	}
	if (($subaction == 'save_close_mceedit' && $success == 0) || $subaction == 'mceedit') $tpl = 'menu_details_mceedit.tpl';
	if (($subaction == 'save_close_menu' && $success == 0) || $subaction == 'menu') $tpl = 'menu_details.tpl';

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
if ($view_mode > 1) {
	$smarty->assign('error_msg', $error_msg);
	$smarty->assign('warning_msg', $warning_msg);
	$smarty->assign('success', $success);
	$smarty->assign('SID', $SID);
	$smarty->display((($tpl) ? ($tpl) : ('menu_details.tpl')));
} else
	$right_frame = ($tpl) ? ($tpl) : ('menu_list.tpl');

// unset variables
unset($in_var);
unset($out_var);
unset($search_var);
unset($editor_content);

?>
