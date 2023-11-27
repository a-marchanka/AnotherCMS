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

function newsGetCity($db_prefix, $db_link, $menu_id, $lang) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT DISTINCT SUBSTR(title, INSTR(title,\', \')+2, (CASE WHEN INSTR(title,\' #\')=0 THEN LENGTH(title)-INSTR(title,\', \')-1 ELSE TRIM(INSTR(title,\' #\')-INSTR(title,\', \')-2) END) ) AS city
		FROM '.$db_prefix.'news WHERE 1=1 AND INSTR(title,\', \')>0 AND status>1'.($menu_id?' AND menu_id='.$menu_id:' AND menu_id>0').($lang?' AND ui_lang=\''.$lang.'\'':'').' ORDER BY 1';
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
function newsGetHits($db_prefix, $db_link, $menu_lang, $menu_id) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT id, menu_id, status, title, SUBSTR(title, 1, (CASE WHEN INSTR(title,\', \')=0 THEN LENGTH(title) ELSE TRIM(INSTR(title,\', \')-1) END)) as title_short,
		message, ui_lang, strftime(\'%Y\', date(validetime,\'unixepoch\')) as time_year, strftime(\'%m\', date(validetime,\'unixepoch\')) as time_month, validetime, modifytime, createnick
		FROM '.$db_prefix.'news WHERE status>1 AND status<4 AND validetime>STRFTIME(\'%s\')'.($menu_id?' AND menu_id='.$menu_id:' AND menu_id>0').($menu_lang?' AND ui_lang=\''.$menu_lang.'\'':'').' ORDER BY validetime, priority LIMIT 16';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$row['message'] = str_replace('<div style="text-align: left; display: block;">', '<div id="descr'.$row['id'].'" style="text-align: left; display: none;">', $row['message']);
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function newsGetAll($db_prefix, $db_link, $menu_id, $menu_lang, $search = '', $page_var) {
	$sql_info = array();
	$count = 0;
	$sql_filter = 'WHERE 1=1';
	// filter
	if ($search) $sql_filter .= ' AND (LOWER(title) LIKE \'%'.strtolower($search).'%\' OR LOWER(message) LIKE \'%'.strtolower($search).'%\') ';
	$sql = 'SELECT id, menu_id, status, SUBSTR(title, 1, (CASE WHEN INSTR(title,\', \')=0 THEN LENGTH(title) ELSE TRIM(INSTR(title,\', \')-1) END)) as title_short, SUBSTR(title, 1, (CASE WHEN INSTR(title,\' #\')=0 THEN LENGTH(title) ELSE TRIM(INSTR(title,\' #\')) END)) as title, message, ui_lang, validetime, modifytime, createnick
		FROM '.$db_prefix.'news '.$sql_filter.' AND status>1 AND status<4 AND validetime>STRFTIME(\'%s\')'.($menu_id?' AND menu_id='.$menu_id:' AND menu_id>0').($menu_lang?' AND ui_lang=\''.$menu_lang.'\'':'').' ORDER BY title, priority LIMIT '.$page_var['start'].','.$page_var['limit'];
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
function newsInsert($db_prefix, $db_link, $array_db) {
	$sql_insert = 'INSERT INTO '.$db_prefix.'news (';
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
function newsGetCount($db_prefix, $db_link, $menu_id, $menu_lang, $search = '') {
	$sql_filter = 'WHERE 1=1';
	// filter
	if ($search) $sql_filter .= ' AND (LOWER(title) LIKE \'%'.strtolower($search).'%\' OR LOWER(message) LIKE \'%'.strtolower($search).'%\') ';
	$sql = 'SELECT COUNT(id) AS count FROM '.$db_prefix.'news '.$sql_filter.' AND status>1 AND status<4 AND validetime>STRFTIME(\'%s\')'.($menu_id?' AND menu_id='.$menu_id:' AND menu_id>0').($menu_lang?' AND ui_lang=\''.$menu_lang.'\'':'');
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	return ($row['count']);
}

?>
