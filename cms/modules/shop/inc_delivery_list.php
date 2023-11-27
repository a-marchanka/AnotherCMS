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

$search_s = '';
if ($subaction == 'search') {
	// save search options into db
	$search_var = trimRequestValues($search_var);
	$search_s = '\''.implodeRequestValues($search_var).'\'';
	profileUpdate(DB_PREFIX, $db_link, $auth_id, 'dlv_sort', $search_s);
} else {
	if (isset($cfg_profile['dlv_sort'])) $search_s = $cfg_profile['dlv_sort'];
	$search_var = explodeRequestValues($search_s);
}
// assign search options
assignArray($search_var, 'details_search');
//print_r($search_var);

// count rows
$items_total = deliveryGetCount(DB_PREFIX, $db_link, $search_var);
if (!$items_total) $warning_msg .= $SYS_WARN_MSG['no_results'];

// page input parameter
if (!isset($search_var['page'])) $item_page = 1;
else $item_page = is_numeric($search_var['page'])?($search_var['page']):(1);

$pager_var = pagerGetInfo($item_page, $items_total, $shp_items);
assignArray($pager_var, 'pager_list');

// set search options
$out_var = deliveryGetAll(DB_PREFIX, $db_link, $search_var, $pager_var, $format_dec_point, $format_ths_sep);
//print_r($out_var);

assignArray($out_var, 'items_list');

?>
