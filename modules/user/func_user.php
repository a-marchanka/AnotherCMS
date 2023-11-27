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

function userGetInfo($db_prefix, $db_link, $auth_id) {
	$sql_info = array();
	$sql = 'SELECT id, active, nick, pass, lastvisit, role_id, descr FROM '.$db_prefix.'user WHERE id='.$auth_id;
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
	$sql = 'SELECT id, active, nick, pass, lastvisit, role_id, descr, fouls FROM '.$db_prefix.'user WHERE LOWER(nick)=\''.strtolower($auth_nick).'\'';
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
function userGetCount($db_prefix, $db_link, $time_s, $sig, $agent) {
	$row = array('count' => 0);
	$sql = 'SELECT COUNT(id) AS count FROM '.$db_prefix.'user WHERE sig=\''.$sig.'\' AND agent=\''.$agent.'\' AND lastvisit>'.$time_s;
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	return ($row['count']);
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
function userSetActive($db_prefix, $db_link, $auth_id) {
	$sql = 'UPDATE '.$db_prefix.'user SET lastvisit=\''.time().'\', active=1 WHERE id='.$auth_id;
	//echo $sql;
	$db_link->exec($sql) or 0;
	return (true);
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
function roleGetByName($db_prefix, $db_link, $auth_role) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT ro.role, ro.id, ro.descr FROM '.$db_prefix.'role ro WHERE ro.role=\''.$auth_role.'\'';
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
function profileInsertValues($db_prefix, $db_link, $auth_id) {
	$sql_insert = 'INSERT INTO '.$db_prefix.'user_profile (user_id, param, value) ';
	$sql_insert .= 'SELECT '.$auth_id.' as user_id, prefix || \'_sort\' as param, \'\' as value FROM '.$db_prefix.'dtree';
	//print $sql_insert;
	$result = $db_link->exec($sql_insert) or 0;
	return ($result);
}

?>
