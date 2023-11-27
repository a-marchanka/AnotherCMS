<?php
/* ==================================================== ##
##             COPYRIGHTS © Another CMS                 ##
## ==================================================== ##
## PRODUCT : CMS(CONTENT MANAGEMENT SYSTEM)             ##
## LICENSE : GNU(General Public License v.3)            ##
## TECHNOLOGIES : PHP & Sqlite                          ##
## WWW : www.zapms.de | www.marchenko.de                ##
## E-MAIL : andrey@marchenko.de                         ##
## ==================================================== */

if (!$subaction) $subaction = 'products';
$def_id = 5; // default user id like none or anonymous

$in_var = array('pid'=>'', 'ip'=>'', 'cnt'=>'');
$sort_list = array('up_price', 'dw_price', 'up_title', 'dw_title');
$search_var = array('page' => '', 'title' => '');
$search_var = trimRequestValues($search_var);

$in_db_var = array();
$items_list = array();
$subi_list = array();
$item = array();
$bs_prod = array();
$pid = 0;
$cnt = 0;
$basket_amount = 0;
$bs_id = 0;
$pg_items = 48;
$pg_total = 0;
$pager_var = array();
$tpl = 'content_default.tpl';

// GET CONFIG DATA
$cfg_local = configGetInfo(DB_PREFIX, $db_link, 115); // shop module
foreach ($cfg_local as $tmp_var=>$tmp_param)
	$$tmp_var = $tmp_param;

// include
include 'modules/shop/func_shop_product.php';
include 'modules/shop/func_shop_basket.php';

switch ($action) {
case 'list':
	// search page
	if (!isset($search_var['page'])) $pg_page = 1;
	else $pg_page = is_numeric($search_var['page'])?($search_var['page']):(1);
	// lists
	if ($subaction == 'products') {
		$tpl = 'content_shop_product_list.tpl';
		$menu_id = $menu_info['id'];
		if ($entry_name == 'shop') $menu_id = 0;
		// count rows
		$pg_total = productAggCount(DB_PREFIX, $db_link, $menu_id);
		// pager
		$pager_var = pagerGetInfo($pg_page, $pg_total, $pg_items);
		assignArray($pager_var, 'pager_list');
		// list
		assignArray(productAggList(DB_PREFIX, $db_link, $menu_id, $pager_var, $format_dec_point, $format_ths_sep), 'items_list');
	}
	if ($subaction == 'prices') {
		$tpl = 'content_shop_product_prices.tpl';
		// count rows
		$pg_total = productGetCount(DB_PREFIX, $db_link, 0);
		// pager
		$pager_var = pagerGetInfo($pg_page, $pg_total, $pg_items);
		assignArray($pager_var, 'pager_list');
		// list
		assignArray(productGetPrices(DB_PREFIX, $db_link, 0, $pager_var, $format_dec_point, $format_ths_sep), 'items_list');
	}
	$view_mode = 1;
break;
//------------------------------------------------------------
case 'details':
	$tpl = 'content_shop_product_details.tpl';
	$in_var = trimRequestValues($in_var);
	if (!is_numeric($in_var['pid'])) $pid = 0; else $pid = $in_var['pid'];
	if (!is_numeric($in_var['cnt'])) $cnt = 0; else $cnt = $in_var['cnt'];
	if ($pid > 0 && ($subaction == 'product' || $subaction == 'add') ) {
		// product info
		$items_list = productAggInfo(DB_PREFIX, $db_link, $pid, $format_dec_point, $format_ths_sep);
		assignArray($items_list, 'items_list');
		// family info
		$subitems_list = array();
		$subitems_temp = array();
		foreach ($items_list as $item) {
			if ($item['family_ids']) {
				$subitems_temp = productAggFamily(DB_PREFIX, $db_link, $item['family_ids'], $item['id'], $format_dec_point, $format_ths_sep);
				$subitems_list = array_merge($subitems_list, $subitems_temp);
				$subitems_temp = array();
			}
		}
		//print_r($subitems_list);
		if ($subitems_list)
			assignArray($subitems_list, 'subitems_list');
		// add to basket
		if ($subaction == 'add' && $in_var['ip'] && $in_var['ip']!='empty') {
			// create blank session
			if (!$sid) {
				$sid = md5(uniqid(rand(),1));
				$SID = 'sid='.$sid;
				sessUpdate($sid, $def_id); // none user id
			}
			// clear discount
			discountClear(DB_PREFIX, $db_link, $sid);
			// find in basket
			$bs_prod = basketProduct(DB_PREFIX, $db_link, $sid, $pid);
			if ($bs_prod) if ($bs_prod['amount']) $cnt = $cnt + $bs_prod['amount'];
			// update basket
			if (!$bs_prod) {
				// insert new
				$bs_id = basketInsert(DB_PREFIX, $db_link, $sid, $pid, $cnt);
				if ($bs_id) $warning_msg = $SYS_WARN_MSG['basket_added'];
				else $error_msg = $SYS_WARN_MSG['notcreated'];
			} else if ($bs_prod['id']) { 
				if (basketUpdate(DB_PREFIX, $db_link, $sid, $pid, $cnt)) $warning_msg = $SYS_WARN_MSG['basket_added'];
				else $error_msg = $SYS_WARN_MSG['notupdated'];
			}
		}
		unset($subitems_list);
		unset($items_list);
		unset($item);
	}
	$view_mode = 1;
break;
//------------------------------------------------------------
case 'edit':
case 'create':
	$view_mode = 1;
	$action = 'list';
break;
//------------------------------------------------------------
default:
	$error_msg = $SYS_WARN_MSG['action_wrong'];
	$action = 'list';
	$view_mode = 1;
}
// short info
if (!$basket_amount && $sid) $basket_amount = basketCount(DB_PREFIX, $db_link, $sid);
$smarty->assign('basket_amount', $basket_amount);
$smarty->assign('pid', $pid);

//------------------------------------------------------------
// VIEW
if ($view_mode > 1) {
	$smarty->assign('error_msg', $error_msg);
	$smarty->assign('warning_msg', $warning_msg);
	$smarty->assign('SID', $SID);
	$smarty->display($tpl);
} else
	$smarty->assign('pattern_content', $tpl);

?>
