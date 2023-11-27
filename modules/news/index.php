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

$search_var = array('page'=>'', 'filter'=>'');

// include NEWS
include 'modules/news/func_news.php';

$list_items = 100;
$success = 0;
$items_list = array();
$tpl = 'content_empty.tpl';

switch ($action) {
case 'login':
case 'logout':
	$view_mode = 1;
break;
case 'list':
	// show list
	$tpl = 'news_list_city.tpl';
	// assign search options
	$search_var = trimRequestValues($search_var);
	assignArray($search_var, 'details_search');
	// filter
	assignArray(newsGetCity(DB_PREFIX, $db_link, $menu_info['id'], $ui_lang), 'filter_list');
	// count rows
	$list_total = newsGetCount(DB_PREFIX, $db_link, $menu_info['id'], $ui_lang, $search_var['filter']);
	// page input parameter
	if (!isset($search_var['page'])) $list_page = 1;
	else $list_page = is_numeric($search_var['page'])?($search_var['page']):(1);
	// pager
	$pager_var = pagerGetInfo($list_page, $list_total, $list_items);
	assignArray($pager_var, 'pager_list');
	// news list
	assignArray(newsGetAll(DB_PREFIX, $db_link, $menu_info['id'], $ui_lang, $search_var['filter'], $pager_var), 'items_list');

	$view_mode = 1;
break;
//------------------------------------------------------------
default:
	$error_msg = $SYS_WARN_MSG['action_wrong'];
	$action = 'list';
	$view_mode = 1;
}

// unset variables
unset($pager_var);
unset($list_total);

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
