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

$search_var = array('meta_year' => '', 'meta_who' => '', 'meta_where' => '', 'meta_album' => '', 'filename' => '');
$search_var = trimRequestValues($search_var);
//print_r($search_var);

// include Galery
include 'modules/galery/func_galery.php';

// Template
$tpl = 'content_galery.tpl';

$success = 1;
$meta_raw = array();
$meta_year = array();
$meta_who = array();
$meta_where = array();
// custom code
$meta_album = array( array('key'=>'album_jv','value'=>'Ян Витя'), array('key'=>'album_ma','value'=>'Маша Андрей'),
                     array('key'=>'album_tv','value'=>'Баб Таня Дед Валера'), array('key'=>'album_vk','value'=>'Баб Валя Дед Коля') );

switch ($action) {
case 'list':
	// take metadata
	$tmp_1 = 0; $tmp_1b = 0;
	$tmp_2 = 0; $tmp_2b = 0;
	$tmp_3 = 0; $tmp_3b = 0;

	$meta_raw = galeryGetMetaYear(DB_PREFIX, $db_link);
	$tmp_array = array();
	for ($i = 0; $i < sizeof($meta_raw); $i ++) {
		if ($meta_raw[$i]['meta_year']) {
			$tmp_array = explode(',', $meta_raw[$i]['meta_year']);
			if ($tmp_array)
			for ($j = 0; $j < sizeof($tmp_array); $j ++) {
				$tmp_1 ++;
				$meta_year = array_pad($meta_year, $tmp_1, trim($tmp_array[$j]));
				// reset flag
				if (trim($tmp_array[$j]) == $search_var['meta_year']) $tmp_1b = 1;
			}
		}
	}
	if ($tmp_1b == 0 || !$search_var['meta_year']) $search_var['meta_year'] = date('Y');

	// get the list
	$meta_raw = galeryGetMetaWho(DB_PREFIX, $db_link, $search_var['meta_year'], $search_var['meta_where']);
	$tmp_array = array();
	for ($i = 0; $i < sizeof($meta_raw); $i ++) {
		if ($meta_raw[$i]['meta_who']) {
			$tmp_array = explode(',', $meta_raw[$i]['meta_who']);
			if ($tmp_array)
			for ($j = 0; $j < sizeof($tmp_array); $j ++) {
				$tmp_2 ++;
				$meta_who = array_pad($meta_who, $tmp_2, trim($tmp_array[$j]));
				// reset flag
				if (trim($tmp_array[$j]) == $search_var['meta_who']) $tmp_2b = 1;
			}
		}
	}
	if ($tmp_2b == 0 || !$search_var['meta_who']) $search_var['meta_who'] = '';

	// get the list
	$meta_raw = galeryGetMetaWhere(DB_PREFIX, $db_link, $search_var['meta_year'], $search_var['meta_who']);
	$tmp_array = array();
	for ($i = 0; $i < sizeof($meta_raw); $i ++) {
		if ($meta_raw[$i]['meta_where']) {
			$tmp_array = explode(',', $meta_raw[$i]['meta_where']);
			if ($tmp_array)
			for ($j = 0; $j < sizeof($tmp_array); $j ++) {
				$tmp_3 ++;
				$meta_where = array_pad($meta_where, $tmp_3, trim($tmp_array[$j]));
				// reset flag
				if (trim($tmp_array[$j]) == $search_var['meta_where']) $tmp_3b = 1;
			}
		}
	}
	if ($tmp_3b == 0 || !$search_var['meta_where']) $search_var['meta_where'] = '';

	// assign metadata
	assignArray(array_keys(array_flip(array_unique($meta_year))), 'meta_year');
	assignArray(array_keys(array_flip(array_unique($meta_who))), 'meta_who');
	assignArray(array_keys(array_flip(array_unique($meta_where))), 'meta_where');
	assignArray($meta_album, 'meta_album');
	assignArray($search_var, 'search_var');

	assignArray(galeryGetAll(DB_PREFIX, $db_link, $search_var), 'galery_list');

	$view_mode = 1;
break;
//------------------------------------------------------------
default:
	$error_msg = $SYS_WARN_MSG['action_wrong'];
	$action = 'list';
	$view_mode = 1;
}

// unset variables
unset($meta_year);
unset($meta_who);
unset($meta_where);

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
