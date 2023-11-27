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

function dtreeGetInfo($db_prefix, $db_link, $auth_id, $entry_id) {
	$sql_info = array();
	$count = 0;
	$sql = '';
	$sql_filter = '';
	$sql_order = 'ORDER BY 2, 1';

	if ($auth_id) $sql_filter = ' AND us.id='.$auth_id;
	if ($entry_id) $sql_filter .= ' AND dt.id='.$entry_id;
	$sql = 'SELECT dt.id AS entry_id, dt.priority, dt.parent_id, dt.title AS entry_title,
		 dt.prefix AS entry_prefix, dt.active AS entry_active, dt.path AS entry_path,
		 dt.icon AS entry_icon, dtro.attr AS entry_attr, us.nick AS user_nick
		FROM '.$db_prefix.'dtree dt, '.$db_prefix.'dtree_role dtro, '.$db_prefix.'user us
		WHERE dtro.dtree_id=dt.id AND dtro.role_id=us.role_id AND us.active>0 AND dtro.attr>0'.$sql_filter.' '.$sql_order;
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
function dtreeGetChilds($db_prefix, $db_link, $auth_id, $entry_id) {
	$sql_info = array();
	$count = 0;
	$sql = '';
	$sql_filter = '';
	$sql_order = 'ORDER BY 2, 1';
	$path_id = $entry_id;

	if ($auth_id) $sql_filter = ' AND us.id='.$auth_id;
	$sql = 'SELECT dt.id AS entry_id, dt.priority, dt.parent_id, dt.title AS entry_title, dt.prefix AS entry_prefix, 0 AS in_path, 0 AS is_child
		FROM '.$db_prefix.'dtree dt, '.$db_prefix.'dtree_role dtro, '.$db_prefix.'user us
		WHERE dtro.dtree_id=dt.id AND dtro.role_id=us.role_id AND us.active>0 AND dt.active>0 AND dtro.attr>0 '.$sql_filter.' '.$sql_order;
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	$count = sizeof($sql_info);
	for ($i = 1; $i < $count; $i ++) {
		for ($j = 0; $j < $count; $j ++) {
			// look for path
			if ($path_id == $sql_info[$j]['entry_id']) {
				$sql_info[$j]['in_path'] = 1;
				$path_id = $sql_info[$j]['parent_id'];
			}
			// look for child
			if ($entry_id == $sql_info[$j]['parent_id']) {
				$sql_info[$j]['is_child'] = 1;
			}
		}
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function dtreeGetTop($db_prefix, $db_link, $auth_id, $entry_id) {
	$sql_info = array();
	$out_data = '';
	$tmp_url = '';
	$tmp_active = '';
	$count = 0;
	$sql = '';
	$sql_filter = '';
	$sql_order = 'ORDER BY 1, 2, 3';

	if ($auth_id) $sql_filter = ' AND us.id='.$auth_id;
	$sql = 'SELECT dt.parent_id, dt.priority, dt.id AS entry_id, dt.title AS entry_title, dt.icon AS entry_icon
		FROM '.$db_prefix.'dtree dt, '.$db_prefix.'dtree_role dtro, '.$db_prefix.'user us
		WHERE dtro.dtree_id=dt.id AND dtro.role_id=us.role_id AND us.active>0 AND dtro.attr>0 AND dt.parent_id<=1 '.$sql_filter.' '.$sql_order;
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
?>
