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

$in_var = array('id'=>'', 'pr_number'=>'', 'menu_main_id'=>'', 'product_type'=>'', 'priority'=>'', 'title'=>'', 'descr'=>'', 'image'=>'', 'amount_total'=>'', 'amount'=>'',
		'amount_1'=>'', 'amount_2'=>'', 'amount_3'=>'', 'price'=>'', 'price_1'=>'', 'price_2'=>'', 'price_3'=>'', 'currency'=>'', 'tax'=>'', 'weight_kg'=>'',
		'length_cm'=>'', 'family_ids'=>'', 'family_ids_old'=>'', 'status'=>'', 'modifytime'=>'', 'createnick'=>'');

$search_var = array('sort' => '', 'menu_id' => '', 'filter' => '', 'page' => '');

$sort_list = array(
	'0' => array('id' => 'up_menu_main_id', 'title' => $SYS_WARN_MSG['webpage'].' &uarr;'),
	'1' => array('id' => 'dw_menu_main_id', 'title' => $SYS_WARN_MSG['webpage'].' &darr;'),
	'2' => array('id' => 'up_title', 'title' => $SYS_WARN_MSG['title'].' &uarr;'),
	'3' => array('id' => 'dw_title', 'title' => $SYS_WARN_MSG['title'].' &darr;'),
	'4' => array('id' => 'up_status', 'title' => $SYS_WARN_MSG['status'].' &uarr;'),
	'5' => array('id' => 'dw_status', 'title' => $SYS_WARN_MSG['status'].' &darr;'),
	'6' => array('id' => 'up_modifytime', 'title' => $SYS_WARN_MSG['date'].' &uarr;'),
	'7' => array('id' => 'dw_modifytime', 'title' => $SYS_WARN_MSG['date'].' &darr;'),
	'8' => array('id' => 'up_id', 'title' => 'ID &uarr;'),
	'9' => array('id' => 'dw_id', 'title' => 'ID &darr;')
	);
assignArray($sort_list, 'sort_list');

$success = 0;
$in_db_var = array();
$out_var = array();
// assign module variables
$smarty->assign('tinymce_css', $tinymce_css);

// GET CONFIG DATA
$cfg_local = configGetInfo(DB_PREFIX, $db_link, 115); // shop module
foreach ($cfg_local as $tmp_var=>$tmp_param)
	$$tmp_var = $tmp_param;
$smarty->assign('currency', $shp_currency);

// prd_status - status_list
$tmp = explode(';', htmlDecode($prd_status));
for ($i=0; $i<sizeof($tmp); $i++) {
	$tmp_var = explode('=', $tmp[$i]);
	$status_array[$i] = array('id' => trim($tmp_var[0]), 'title' => trim($tmp_var[1]));
}
assignArray($status_array, 'status_list');

include 'modules/menu/func_menu.php';
assignArray(menuGetAll(DB_PREFIX, $db_link), 'search_list');

// db functions
include 'modules/shop/func_product.php';

switch ($action) {
case 'delete':
	if ($details_id) {
		if (productDelete(DB_PREFIX, $db_link, $details_id))
			$warning_msg .= $SYS_WARN_MSG['deleted'];
		else
			$error_msg .= $SYS_WARN_MSG['notdeleted'];
	}
	$action = 'list';
//------------------------------------------------------------
case 'list':
	// clean-up deleted menu
	if (productCleanUp(DB_PREFIX, $db_link)) $warning_msg .= $SYS_WARN_MSG['cleanup'];
	// list
	include 'inc_product_list.php';
	if ($subaction == 'prices') $tpl = 'shop_product_prices.tpl';
	$view_mode = 1;
break;
//------------------------------------------------------------
case 'details':
	if ($subaction == 'product') {
		if ($details_id) {
			// assign details
			$details = productGetInfo(DB_PREFIX, $db_link, $details_id);
			if (isset($details['descr'])) $details['descr'] = htmlEncode($details['descr']);
		} else {
			$search_s = $cfg_profile['prd_sort'];
			$search_var = explodeRequestValues($search_s);
			$details['pr_number'] = '';
			$details['menu_main_id'] = (isset($search_var['menu_id']))?($search_var['menu_id']):(0);
			$details['product_type'] = 'product';
			$details['priority'] = 0;
			$details['title'] = '';
			$details['descr'] = '';
			$details['image'] = '';
			$details['amount_total'] = 0;
			$details['amount'] = 1;
			$details['amount_1'] = 0;
			$details['amount_2'] = 0;
			$details['amount_3'] = 0;
			$details['price'] = 0.0;
			$details['price_1'] = 0.0;
			$details['price_2'] = 0.0;
			$details['price_3'] = 0.0;
			$details['tax'] = 0.0;
			$details['currency'] = $shp_currency;
			$details['weight_kg'] = 0.0;
			$details['length_cm'] = 0.0;
			$details['family_ids'] = '';
			$details['status'] = 0;
			$details['modifytime'] = 0;
			$details['createnick'] = '';
		}
		assignArray($details, 'details');
		unset($details);
		$tpl = 'shop_product_details.tpl';
		$view_mode = 1;
		$action = 'list';
	}
	if ($subaction == 'options') {
		if ($details_id) {
			// assign details
			$details = productShortInfo(DB_PREFIX, $db_link, $details_id);
			// assign family products
			$details_items = productFamilyInfo(DB_PREFIX, $db_link, $details['family_ids']);
			// assign all products
			$details_all = productShortAll(DB_PREFIX, $db_link);
			assignArray($details, 'details');
			assignArray($details_items, 'details_items');
			assignArray($details_all, 'details_all');
			unset($details);
			unset($details_items);
			unset($details_all);
		}
		$tpl = 'shop_product_options.tpl';
		$view_mode = 1;
		$action = 'list';
	}
break;
//------------------------------------------------------------
case 'edit':
case 'create':
	if ($action == 'create') $details_id = 0; // empty for new
	if ($subaction == 'product') $tpl = 'shop_product_details.tpl';
	if ($subaction == 'product_prices') $tpl = 'shop_product_prices.tpl';
	if ($subaction == 'product_options') $tpl = 'shop_product_options.tpl';
	// edit product
	if ($subaction == 'product' || $subaction == 'save_close') include 'inc_product_edit.php';
	// edit prices
	if ($subaction == 'product_prices' || $subaction == 'save_close_prices') include 'inc_product_prices_edit.php';
	// edit options
	if ($subaction == 'product_options' || $subaction == 'save_close_options') include 'inc_product_options_edit.php';

	if ($subaction == 'save_close') {
		if ($success > 0) include 'inc_product_list.php';
		else $tpl = 'shop_product_details.tpl';
	}
	if ($subaction == 'save_close_prices') {
		if ($success > 0) include 'inc_product_list.php';
		else $tpl = 'shop_product_prices.tpl';
	}
	if ($subaction == 'save_close_options') {
		if ($success > 0) include 'inc_product_list.php';
		else $tpl = 'shop_product_options.tpl';
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
if ($view_mode > 1) {
	$smarty->assign('error_msg', $error_msg);
	$smarty->assign('warning_msg', $warning_msg);
	$smarty->assign('success', $success);
	$smarty->assign('SID', $SID);
	$smarty->display((($tpl) ? ($tpl) : ('shop_product_details.tpl')));
} else {
	$right_frame = ($tpl) ? ($tpl) : ('shop_product_list.tpl');
}

// unset variables
unset($in_var);
unset($out_var);

?>
