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

//------------------------------------------------------------
function emailGetInfo($db_prefix, $db_link, $filter_id=0) {
	$sql_info = array();
	$result = 0;
	$sql = 'SELECT id, priority, menu_id, email, name, surname, title, firm, enabled, validetime, modifytime, createnick
		FROM '.$db_prefix.'news_email WHERE 1=1 AND id='.$filter_id.' ORDER BY 1';
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
function emailInsert($db_prefix, $db_link, $array_db) {
	$sql_insert = 'INSERT INTO '.$db_prefix.'news_email (';
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
function emailUpdate($db_prefix, $db_link, $filter_id=0, $array_db) {
	$sql = 'UPDATE '.$db_prefix.'news_email SET ';
	foreach ($array_db as $var => $param) {
		$sql .= $var.'='.$param.', ';
	}
	$sql = substr($sql, 0, -2).' WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function emailDelete($db_prefix, $db_link, $filter_id=0, $menu_id=0) {
	$sql = 'DELETE FROM '.$db_prefix.'news_email WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function emailGetId($db_prefix, $db_link, $email='', $menu_id=0) {
	$cnt = 0;
	$sql_filter = 'WHERE 1=1';
	// filter
	if (isset($email)) if ($email) $sql_filter .= ' AND email=\''.strtolower($email).'\'';
	if (isset($menu_id)) if ($menu_id) $sql_filter .= ' AND menu_id='.$menu_id;
	$sql = 'SELECT MAX(id) AS id FROM '.$db_prefix.'news_email '.$sql_filter;
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	if ($row) $cnt = ($row['id']===null || $row['id']==='')?(0):($row['id']);
	return ($cnt);
}
?>
