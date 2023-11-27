<?php
/* ==================================================== ##
##             COPYRIGHTS © Another CMS              ##
## ==================================================== ##
## PRODUCT : CMS(CONTENT MANAGEMENT SYSTEM)             ##
## LICENSE : GNU(General Public License v.3)            ##
## TECHNOLOGIES : PHP & Sqlite                          ##
## WWW : www.zapms.de | www.marchenko.de                ##
## E-MAIL : andrey@marchenko.de                         ##
## ==================================================== */

//------------------------------------------------------------
// Front End DB functions
//------------------------------------------------------------
function menuGetPage($db_prefix, $db_link, $filter) {
	$sql_info = array();
	$sql = '';

	$sql = 'SELECT id, parent_id, priority, title, name, content_type, content, description, keywords, variables, role_ids,
		pattern_0, pattern_1, pattern_2, pattern_3, pattern_4, pattern_5, modifytime
		FROM '.$db_prefix.'menu WHERE (content_type=\'static\' OR content_type=\'url\' OR content_type=\'module\') AND active=1 AND name=\''.$filter.'\'';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$sql_info = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function menuGetLast($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;

	$sql = 'SELECT id, name, title, modifytime FROM '.$db_prefix.'menu WHERE active=1 and role_ids=\'\' ORDER BY modifytime DESC LIMIT 8';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			// extend aray
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function menuGetAll($db_prefix, $db_link, $menu_id = 0, $role_id = 0) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT id, parent_id, priority, name, title, description, content_type, content, active, role_ids, modifytime
		FROM '.$db_prefix.'menu WHERE active=1 ORDER BY parent_id, priority, title';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			// user defined attributes
			$row['role_ids_array'] = (!empty($row['role_ids']))?explode(',', $row['role_ids']):array();
			// status: disabled, enabled, selected
			if ($row['role_ids_array']) {
				// disabled
				$row['status'] = 'disabled';
				// enabled
				if ($role_id > 0) for ($i = 0; $i < sizeof($row['role_ids_array']); $i ++) {
					if ($row['role_ids_array'][$i] == $role_id) $row['status'] = 'enabled';
				}
			} else
				$row['status'] = 'enabled';
			// clicked
			if ($row['id'] == $menu_id)
				$row['status'] = 'selected';

			// extend aray
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	$sql_info_sort = array();
	$sql_info_sort = menuGetAllRecursive($sql_info, $sql_info_sort, -1, 0);
	unset($sql_info);
	//print_r($sql_info_sort);
	return ($sql_info_sort);
}
//------------------------------------------------------------
function menuGetAllRecursive($in_arr, $in_arr_sort, $level = 0, $parent = 0) {
	$level ++;
	$size = sizeof($in_arr);
	for ($i = 0; $i < $size; $i ++) {
		if ($in_arr[$i]['parent_id'] == $parent) {
			$in_arr[$i]['level'] = $level;
			$in_arr_sort = array_pad($in_arr_sort, sizeof($in_arr_sort)+1, $in_arr[$i]);
			$in_arr_sort = menuGetAllRecursive($in_arr, $in_arr_sort, $level, $in_arr[$i]['id']);
		}
	}
	return $in_arr_sort;
}
//------------------------------------------------------------

?>
