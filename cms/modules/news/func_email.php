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

function emailGetInfo($db_prefix, $db_link, $filter_id = 0) {
	$sql_info = array();
	$result = 0;
	$sql = 'SELECT id, priority, menu_id, email, name, surname, title, firm, enabled, validetime, modifytime, createnick
		FROM '.$db_prefix.'news_email  WHERE 1=1 AND id='.$filter_id.' ORDER BY 1';
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
function emailGetAll($db_prefix, $db_link, $search_var, $page_var) {
	$sql_info = array();
	$count = 0;
	$sql = '';
	$sql_filter = 'WHERE 1=1';
	$sql_limit = '';
	$sql_order = '';
	// search criteria
	// order
	if (isset($search_var['sort']))
	if ($search_var['sort'])
	$sql_order = substr($search_var['sort'],3).((substr($search_var['sort'],0,2) == 'up') ? ' ASC, ' : ' DESC, ');
	// filter
	if (isset($search_var['filter']))
	if ($search_var['filter'])
	$sql_filter .= ' AND (LOWER(name) LIKE \'%'.strtolower($search_var['surname']).'%\' OR LOWER(firm) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(createnick) LIKE \'%'.strtolower($search_var['filter']).'%\')';
	// menu
	if (isset($search_var['menu_id']))
	if ($search_var['menu_id'])
	$sql_filter .= ' AND menu_id='.$search_var['menu_id'];
	// limit
	$sql_limit = 'LIMIT '.$page_var['start'].','.$page_var['limit'];
	// combine
	if ($sql_order) $sql_order = 'ORDER BY '.$sql_order.' priority DESC';
	else		$sql_order = 'ORDER BY menu_id, priority';

	$sql = 'SELECT id, priority, menu_id, email, name, surname, title, firm, enabled, validetime, modifytime, createnick FROM '.$db_prefix.'news_email  '.$sql_filter.' '.$sql_order.' '.$sql_limit;
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
function emailGetCount($db_prefix, $db_link, $search_var) {
	$cnt = 0;
	$sql_filter = 'WHERE 1=1';
	// search criteria
	// filter
	if (isset($search_var['filter']))
	if ($search_var['filter'])
	$sql_filter .= ' AND (LOWER(name) LIKE \'%'.strtolower($search_var['surname']).'%\' OR LOWER(firm) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(createnick) LIKE \'%'.strtolower($search_var['filter']).'%\')';
	// menu
	if (isset($search_var['menu_id']))
	if ($search_var['menu_id'])
	$sql_filter .= ' AND menu_id='.$search_var['menu_id'];

	$sql = 'SELECT COUNT(id) AS cnt FROM '.$db_prefix.'news_email  '.$sql_filter;
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	if ($row) $cnt = ($row['cnt']===null || $row['cnt']==='')?(0):($row['cnt']);
	return ($cnt);
}
//------------------------------------------------------------
function emailCleanUp($db_prefix, $db_link) {
	$list = '';
	$sql = 'SELECT nw.id AS id FROM '.$db_prefix.'news_email nw LEFT JOIN '.$db_prefix.'menu mn ON nw.menu_id=mn.id WHERE nw.menu_id!=0 AND mn.id IS NULL';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC))
			$list .= $row['id'].', ';
		$list = substr($list, 0, -2);
		$result->finalize();
	}
	if ($list) {
		$sql = 'UPDATE '.$db_prefix.'news_email SET menu_id=0 WHERE id IN ('.$list.')';
		//echo $sql;
		$result = $db_link->exec($sql) or 0;
	}
	return (($list)?($result):(0));
}
//------------------------------------------------------------
function emailProlong($db_prefix, $db_link) {
	$sql = 'UPDATE '.$db_prefix.'news_email SET enabled=1, validetime='.mktime(0, 0, 0, 1, 1, date("Y")+2).' WHERE enabled=0 AND validetime<'.time();
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function emailUpdate($db_prefix, $db_link, $filter_id = 0, $array_db) {
	$sql = 'UPDATE '.$db_prefix.'news_email  SET ';
	foreach ($array_db as $var => $param) {
		$sql .= $var.'='.$param.', ';
	}
	$sql = substr($sql, 0, -2).' WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function emailInsert($db_prefix, $db_link, $array_db) {
	$sql_insert = 'INSERT INTO '.$db_prefix.'news_email  (';
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
function emailDelete($db_prefix, $db_link, $filter_id = 0) {
	$sql = 'DELETE FROM '.$db_prefix.'news_email  WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function emailValideTime($db_prefix, $db_link) {
	$sql = 'UPDATE '.$db_prefix.'news_email  SET enabled=0 WHERE enabled>0 AND validetime<'.(time()-86400); // 1 day over
	//echo $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}

?>
