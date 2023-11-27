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

function userGetInfo($db_prefix, $db_link, $auth_id) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT u.id, u.active, u.nick, u.pass, u.lastvisit, ro.role, ro.id AS role_id, u.descr, u.sig, u.agent
		FROM '.$db_prefix.'role ro INNER JOIN '.$db_prefix.'user u ON u.role_id=ro.id WHERE u.id='.$auth_id;
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
function userGetByNick($db_prefix, $db_link, $auth_nick) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT u.id, u.active, u.nick, u.pass, u.lastvisit, u.fouls, ro.role, ro.id AS role_id, ro.descr, u.sig, u.agent
		FROM '.$db_prefix.'role ro INNER JOIN '.$db_prefix.'user u ON u.role_id=ro.id WHERE LOWER(u.nick)=\''.strtolower($auth_nick).'\'';
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
function userSetLastVisit($db_prefix, $db_link, $auth_id) {
	$sql = 'UPDATE '.$db_prefix.'user SET lastvisit=\''.time().'\', fouls=0 WHERE id='.$auth_id;
	//echo $sql;
	$db_link->exec($sql) or 0;
	return (true);
}
//------------------------------------------------------------
function userSetFouls($db_prefix, $db_link, $auth_id) {
	$sql = 'UPDATE '.$db_prefix.'user SET lastvisit=\''.time().'\', fouls=1 WHERE id='.$auth_id;
	//echo $sql;
	$db_link->exec($sql) or 0;
	return (true);
}
//------------------------------------------------------------
function userGetAll($db_prefix, $db_link, $search_var, $page_var) {
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
	$sql_order = 'u.'.substr($search_var['sort'],3).((substr($search_var['sort'],0,2) == 'up') ? ' ASC, ' : ' DESC, ');
	// filter
	if (isset($search_var['filter']))
	if ($search_var['filter'])
	$sql_filter .= ' AND (u.nick LIKE \'%'.$search_var['filter'].'%\' OR ro.role LIKE \'%'.$search_var['filter'].'%\' OR ro.descr LIKE \'%'.$search_var['filter'].'%\')';
	// limit
	$sql_limit = 'LIMIT '.$page_var['start'].','.$page_var['limit'];

	if ($sql_order) $sql_order = 'ORDER BY '.$sql_order.' u.id DESC';
	else		$sql_order = 'ORDER BY role_id, nick';

	$sql = 'SELECT u.id, u.active, u.nick, u.pass, u.descr as title, u.lastvisit, ro.role, ro.id AS role_id, ro.descr
		FROM '.$db_prefix.'role ro INNER JOIN '.$db_prefix.'user u ON u.role_id=ro.id '.$sql_filter.' '.$sql_order.' '.$sql_limit;
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
function userGetNick($db_prefix, $db_link, $filter = '') {
	$sql_info = array();
	$count = 0;
	$sql_filter = 'WHERE 1=1';

	// search criteria
	if (isset($filter)) if ($filter)
		$sql_filter .= ' AND (nick LIKE \'%'.$filter.'%\' OR descr LIKE \'%'.$filter.'%\')';

	$sql = 'SELECT nick, descr as title FROM '.$db_prefix.'user '.$sql_filter;
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
function userGetCount($db_prefix, $db_link, $search_var) {
	$sql_filter = 'WHERE 1=1';
	// search criteria
	// filter
	if (isset($search_var['filter']))
	if ($search_var['filter'])
	$sql_filter .= ' AND (u.nick LIKE \'%'.$search_var['filter'].'%\' OR ro.role LIKE \'%'.$search_var['filter'].'%\' OR ro.descr LIKE \'%'.$search_var['filter'].'%\')';

	$sql = 'SELECT COUNT(u.id) AS count FROM '.$db_prefix.'user u INNER JOIN '.$db_prefix.'role ro ON u.role_id=ro.id '.$sql_filter;
	//print $query;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	return ($row['count']);
}
//------------------------------------------------------------
function userCleanUp($db_prefix, $db_link, $role = 'Viewer') {
	$list = '';
	// delete default accounts
	$sql = 'SELECT u.id FROM '.$db_prefix.'user u INNER JOIN '.$db_prefix.'role ro ON u.role_id=ro.id WHERE ro.role=\''.$role.'\' AND u.lastvisit<'.(time()-236520000); // 1825*129600 - 3 years
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC))
			$list .= $row['id'].', ';
		$list = substr($list, 0, -2);
		$result->finalize();
	}
	if ($list) {
		$sql = 'DELETE FROM '.$db_prefix.'user WHERE id IN ('.$list.')';
		//echo $sql;
		$result = $db_link->exec($sql) or 0;
	}
	return ($list);
}
//------------------------------------------------------------
function userUpdate($db_prefix, $db_link, $auth_id = 0, $array_db) {
	$sql = 'UPDATE '.$db_prefix.'user SET ';
	foreach ($array_db as $var => $param) {
		$sql .= $var.'='.$param.', ';
	}
	$sql = substr($sql, 0, -2).' WHERE id='.$auth_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function userInsert($db_prefix, $db_link, $array_db) {
	$sql_insert = 'INSERT INTO '.$db_prefix.'user (';
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
function userDelete($db_prefix, $db_link, $auth_id = 0) {
	$sql = 'DELETE FROM '.$db_prefix.'user WHERE id='.$auth_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
?>
