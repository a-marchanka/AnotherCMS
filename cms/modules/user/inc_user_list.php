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
	profileUpdate(DB_PREFIX, $db_link, $auth_id, 'acc_sort', $search_s);
} else {
	if (isset($cfg_profile['acc_sort'])) $search_s = $cfg_profile['acc_sort'];
	$search_var = explodeRequestValues($search_s);
}
// assign search options
assignArray($search_var, 'details_search');

// count rows
$acc_total = userGetCount(DB_PREFIX, $db_link, $search_var);
if (!$acc_total) $warning_msg .= $SYS_WARN_MSG['no_results'];

// page input parameter
if (!isset($search_var['page'])) $acc_page = 1;
else $acc_page = is_numeric($search_var['page'])?($search_var['page']):(1);

$pager_var = pagerGetInfo($acc_page, $acc_total, $acc_items);
assignArray($pager_var, 'pager_list');

// set search options
$out_var = userGetAll(DB_PREFIX, $db_link, $search_var, $pager_var);

assignArray($out_var, 'users_list');

?>
