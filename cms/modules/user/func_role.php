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

function roleGetInfo($db_prefix, $db_link, $role_id) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT ro.role, ro.id, ro.descr FROM '.$db_prefix.'role ro WHERE id='.$role_id;
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
function roleGetAll($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT id, role, descr FROM '.$db_prefix.'role';
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
function roleGetDtreeAll($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = '';
	$sql = 'SELECT id AS entry_id, parent_id, priority, icon AS entry_icon, title AS entry_title, path AS entry_path
		FROM '.$db_prefix.'dtree WHERE active=1';
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
function roleGetDtree($db_prefix, $db_link, $role_id) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT dt.id AS entry_id, dt.priority, dt.parent_id, dt.title AS entry_title, dt.path AS entry_path, dt.icon AS entry_icon,
		 dro.id AS dtree_role_id, dro.attr AS entry_attr, length(dt.id) AS entry_level
		FROM '.$db_prefix.'dtree dt, '.$db_prefix.'dtree_role dro
		WHERE dt.id=dro.dtree_id AND dt.prefix!=\'lgn\' AND dro.role_id='.$role_id.' ORDER BY 3, 2, 1';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	$sql_info_sort = array();
	$sql_info_sort = roleGetDtreeRecursive($sql_info, $sql_info_sort, 0);
	unset($sql_info);
	//print_r($sql_info);
	return ($sql_info_sort);
}
//------------------------------------------------------------
function roleGetDtreeRecursive($in_arr, $in_arr_sort, $parent = 0) {
	$size = sizeof($in_arr);
	for ($i = 0; $i < $size; $i ++) {
		if ($in_arr[$i]['parent_id'] == $parent) {
			$in_arr_sort = array_pad($in_arr_sort, sizeof($in_arr_sort)+1, $in_arr[$i]);
			$in_arr_sort = roleGetDtreeRecursive($in_arr, $in_arr_sort, $in_arr[$i]['entry_id']);

		}
	}
	return $in_arr_sort;
}
//------------------------------------------------------------
function roleGetEmpty($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT ro.id, ro.role, ro.descr FROM '.$db_prefix.'role ro LEFT OUTER JOIN '.$db_prefix.'user us ON ro.id=us.role_id WHERE us.id IS NULL';
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
function roleUpdate($db_prefix, $db_link, $role_id = 0, $array_db) {
	$sql = 'UPDATE '.$db_prefix.'role SET ';
	foreach ($array_db as $var => $param) {
		$sql .= $var.'='.$param.', ';
	}
	$sql = substr($sql, 0, -2).' WHERE id='.$role_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function roleDtreeUpdate($db_prefix, $db_link, $role_id = 0, $attr) {
	$sql = 'UPDATE '.$db_prefix.'dtree_role SET attr='.$attr.' WHERE id='.$role_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function roleInsert($db_prefix, $db_link, $array_db) {
	$sql_insert = 'INSERT INTO '.$db_prefix.'role (';
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
function roleDtreeInsert($db_prefix, $db_link, $dtree_id, $role_id) {
	$sql_insert = 'INSERT INTO '.$db_prefix.'dtree_role (dtree_id, role_id, attr) VALUES ('.$dtree_id.', '.$role_id.', 0)';
	//print $sql_insert;
	$result = $db_link->exec($sql_insert) or 0;
	return (($result)?($db_link->lastInsertRowID()):(0));
}
//------------------------------------------------------------
function roleDtreeDelete($db_prefix, $db_link, $role_id = 0) {
	$sql = 'DELETE FROM '.$db_prefix.'dtree_role WHERE role_id='.$role_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function roleDelete($db_prefix, $db_link, $role_id = 0) {
	$sql = 'DELETE FROM '.$db_prefix.'role WHERE id='.$role_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
// validation
function roleValidateDetails($action = 'create') {
	global $in_var, $in_db_var, $details_id, $SYS_WARN_MSG;
	$valid = 0;
	$warning_msg = '';
	$error_msg = '';
	$in_var = trimRequestValues($in_var);
	//print_r($in_var);
	if (!$in_var['role'])
		$error_msg .= $SYS_WARN_MSG['not_all_mandatory'];
	else {
		if ($action == 'edit' && !$details_id)
			$error_msg .= $SYS_WARN_MSG['action_wrong'];
		else {
			// PREPARING TO UPDATE
			$in_db_var['role'] = '\''.$in_var['role'].'\'';
			$in_db_var['descr'] = '\''.$in_var['descr'].'\'';
			$valid = 1;
		}
	}
	return (array('valid' => $valid, 'warning_msg' => $warning_msg, 'error_msg' => $error_msg));
}
?>
