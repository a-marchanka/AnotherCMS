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

function menuGetInfo($db_prefix, $db_link, $filter_id = 0) {
	$sql_info = array();
	$result = 0;
	$sql = 'SELECT id, parent_id, priority, title, name, content_type,
		CASE WHEN content_type=\'static\' THEN content ELSE \'\' END AS content_htm,
		CASE WHEN content_type=\'url\' OR content_type=\'module\' THEN content ELSE \'\' END AS content_txt,
		description, keywords, variables, role_ids, pattern_0, pattern_1, pattern_2, pattern_3, pattern_4, pattern_5, active, modifytime, createnick
		FROM '.$db_prefix.'menu WHERE 1=1 AND id='.$filter_id.' ORDER BY 1';
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
function menuGetPage($db_prefix, $db_link, $filter) {
	$sql_info = array();
	$sql = '';

	$sql = 'SELECT id, parent_id, priority, title, name, content_type, content, description, keywords, variables, role_ids,
		pattern_0, pattern_1, pattern_2, pattern_3, pattern_4, pattern_5, modifytime, createnick
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
function menuGetAll($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = '';
	$sql_filter = 'WHERE 1=1';
	$sql_order = 'ORDER BY m.parent_id, m.priority, m.title';

	$sql = 'SELECT m.id, m.parent_id, m.priority, m.name, m.title, m.content_type, m.content as content_htm, m.content as content_txt, m.variables,
		 m.pattern_0, m.pattern_1, m.pattern_2, m.pattern_3, m.pattern_4, m.pattern_5, m.active, m.description, m.keywords, m.role_ids, m.modifytime, m.createnick
		FROM '.$db_prefix.'menu m '.$sql_filter.' '.$sql_order;
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$row['role_ids_array'] = (!empty($row['role_ids']))?explode(',', $row['role_ids']):array();
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	$sql_info_sort = array();
	$sql_info_sort = menuGetAllRecursive($sql_info, $sql_info_sort, -1, 0);
	unset($sql_info);
	//print_r($sql_info);
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
function menuGetUrlList($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = '';

	$sql = 'SELECT id, parent_id, priority, title, name, content_type FROM '.$db_prefix.'menu
		WHERE active=1 AND (content_type=\'static\' OR content_type=\'module\') ORDER BY parent_id, priority, title';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function menuUpdate($db_prefix, $db_link, $filter_id = 0, $array_db) {
	$sql = 'UPDATE '.$db_prefix.'menu SET ';
	foreach ($array_db as $var => $param) {
		$sql .= $var.'='.$param.', ';
	}
	$sql = substr($sql, 0, -2).' WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function menuInsert($db_prefix, $db_link, $array_db) {
	$sql_insert = 'INSERT INTO '.$db_prefix.'menu (';
	$sql_values = ' VALUES (';
	foreach ($array_db as $var => $param) {
		$sql_insert .= $var.', ';
		$sql_values .= $param.', ';
	}
	$sql_insert = substr($sql_insert, 0, -2).')'.substr($sql_values, 0, -2).')';
	//print $sql_insert;
	$result = $db_link->exec($sql_insert) or 0;
	return (($result)?($db_link->lastInsertRowID()):(0));
}
//------------------------------------------------------------
function menuDelete($db_prefix, $db_link, $filter_id = 0) {
	$sql = 'DELETE FROM '.$db_prefix.'menu WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function menuGetCountChild($db_prefix, $db_link, $filter_id = 0) {
	$sql = 'SELECT COUNT(id) AS count FROM '.$db_prefix.'menu WHERE parent_id='.$filter_id;
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	return ($row['count']);
}
//------------------------------------------------------------
// validation
function menuValidateDetails($subaction = 'create') {
	global $in_var, $in_db_var, $details_id, $SYS_WARN_MSG;
	$valid = 0;
	$error_msg = '';
	$warning_msg = '';
	$role_ids = '';
	$role_ids_arr = array();
	$in_var = trimRequestValues($in_var);
	// verify
	if ( !$in_var['name'] || !$in_var['title'] || !$in_var['content_type'] || !$in_var['pattern_0'] || 
	     ($subaction == 'mceedit' && !$in_var['content_htm']) || ($subaction == 'save_close_mceedit' && !$in_var['content_htm']) )
		$error_msg .= $SYS_WARN_MSG['not_all_mandatory'];
	else {
		preg_match('/[\w\-\.\ ]*/', $in_var['name'], $name_validate);
		if ($name_validate[0] != $in_var['name']) {
			$error_msg .= $SYS_WARN_MSG['f_name_accept'];
		} else {
			// PREPARING TO UPDATE
			$in_var['modifytime'] = time();
			if (!$in_var['active']) $in_var['active'] = 0;
			if (!$in_var['parent_id']) $in_var['parent_id'] = 0;
			if (!$in_var['priority']) $in_var['priority'] = 1;

			$in_db_var['parent_id'] = $in_var['parent_id'];
			$in_db_var['priority'] = $in_var['priority'];
			$in_db_var['active'] = $in_var['active'];
			$in_db_var['modifytime'] = $in_var['modifytime'];
			$in_db_var['createnick'] = '\''.$in_var['createnick'].'\'';
			$in_db_var['name'] = '\''.$in_var['name'].'\'';
			$in_db_var['title'] = '\''.$in_var['title'].'\'';
			$in_db_var['content_type'] = '\''.$in_var['content_type'].'\'';
			$in_db_var['variables'] = '\''.$in_var['variables'].'\'';
			$in_db_var['pattern_0'] = '\''.$in_var['pattern_0'].'\'';
			$in_db_var['pattern_1'] = '\''.$in_var['pattern_1'].'\'';
			$in_db_var['pattern_2'] = '\''.$in_var['pattern_2'].'\'';
			$in_db_var['pattern_3'] = '\''.$in_var['pattern_3'].'\'';
			$in_db_var['pattern_4'] = '\''.$in_var['pattern_4'].'\'';
			$in_db_var['pattern_5'] = '\''.$in_var['pattern_5'].'\'';
			$in_db_var['description'] = '\''.$in_var['description'].'\'';
			$in_db_var['keywords'] = '\''.$in_var['keywords'].'\'';
			// conditions
			if ($subaction == 'mceedit' || $subaction == 'save_close_mceedit') {
			// mce form
				$in_db_var['content'] = ($in_var['content_htm'])?('\''.$in_var['content_htm'].'\''):('\''.$in_var['name'].'.html\'');
			} else {
			// details form
				if (isset($_POST['role_ids_arr']))
					$in_var['role_ids'] = ( (is_array($_POST['role_ids_arr']))?(implode(',', $_POST['role_ids_arr'])):'' );
				$in_db_var['role_ids'] = '\''.$in_var['role_ids'].'\'';
				
				if ($in_var['content_type'] == 'static')
					$in_db_var['content'] = ($in_var['content_htm'])?('\''.$in_var['content_htm'].'\''):('\''.$in_var['name'].'.html\'');
				else
					$in_db_var['content'] = '\''.$in_var['content_txt'].'\'';
			}
			$valid = 1;
		}
	}
	//print_r($in_var);
	//print_r($in_db_var);
	return (array('valid' => $valid, 'warning_msg' => $warning_msg, 'error_msg' => $error_msg));
}

?>
