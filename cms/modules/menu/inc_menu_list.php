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
	profileUpdate(DB_PREFIX, $db_link, $auth_id, 'mnu_sort', $search_s);
} else {
	if (isset($cfg_profile['mnu_sort'])) $search_s = $cfg_profile['mnu_sort'];
	$search_var = explodeRequestValues($search_s);
}
// assign search options
assignArray($search_var, 'details_search');

// assign menu search list
$out_var = menuGetAll(DB_PREFIX, $db_link, array('menu_id' => '0'));
assignArray($out_var, 'search_list');

// set search options
if (!empty($search_var['menu_id'])) {
	// search
	$parent = $search_var['menu_id'];
	$out_var_search = array();
	$out_var_search = menuGetAllRecursive($out_var, $out_var_search, -1, $parent);
	//print_r($out_var_search);
	assignArray($out_var_search, 'menu_list');
	unset($out_var_search);
} else
	assignArray($out_var, 'menu_list');
?>

