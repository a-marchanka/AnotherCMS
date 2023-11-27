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

function profileGetInfo($db_prefix, $db_link, $auth_id) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT up.param, up.value FROM '.$db_prefix.'user_profile up WHERE up.user_id='.$auth_id;
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$key = $row['param'];
			$sql_info[$key] = $row['value'];
		}
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
//------------------------------------------------------------
function profileUpdate($db_prefix, $db_link, $auth_id, $param_s, $value_s) {
	$sql = 'UPDATE '.$db_prefix.'user_profile SET value='.$value_s.' WHERE user_id='.$auth_id.' AND param=\''.$param_s.'\'';
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function profileDeleteValues($db_prefix, $db_link, $auth_id) {
	$sql = 'DELETE FROM '.$db_prefix.'user_profile WHERE user_id='.$auth_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
?>
