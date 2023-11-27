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

function jobGetInfo($db_prefix, $db_link, $filter_id = 0) {
	$sql_info = array();
	$result = 0;
	$sql = 'SELECT id, menu_id, news_id, createnick FROM '.$db_prefix.'news_job WHERE 1=1 AND id='.$filter_id.' ORDER BY 1';
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
function jobGetAll($db_prefix, $db_link, $search_var, $page_var) {
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
	$sql_filter .= ' AND (LOWER(email) LIKE \'%'.strtolower($search_var['reference']).'%\' OR LOWER(createnick) LIKE \'%'.strtolower($search_var['filter']).'%\')';
	// menu
	if (isset($search_var['menu_id']))
	if ($search_var['menu_id'])
	$sql_filter .= ' AND menu_id='.$search_var['menu_id'];
	// limit
	$sql_limit = 'LIMIT '.$page_var['start'].','.$page_var['limit'];
	// combine
	if ($sql_order) $sql_order = 'ORDER BY '.$sql_order.' modifytime DESC';
	else		$sql_order = 'ORDER BY menu_id, news_id DESC, modifytime DESC';

	$sql = 'WITH jb AS (SELECT MIN(id) AS id, menu_id, news_id, COUNT(email) AS email_cnt, SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS status1_cnt, SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) AS status2_cnt, MAX(modifytime) AS modifytime
		FROM '.$db_prefix.'news_job '.$sql_filter.' GROUP BY menu_id, news_id '.$sql_order.') SELECT jb.id, jb.menu_id, jb.news_id, nw.title, jb.email_cnt, jb.status1_cnt, jb.status2_cnt, jb.modifytime
		FROM jb LEFT JOIN '.$db_prefix.'news nw ON jb.news_id=nw.id '.$sql_limit;
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
function jobGetCount($db_prefix, $db_link, $search_var) {
	$cnt = 0;
	$sql_filter = 'WHERE 1=1';
	// search criteria
	// filter
	if (isset($search_var['filter']))
	if ($search_var['filter'])
	$sql_filter .= ' AND (LOWER(email) LIKE \'%'.strtolower($search_var['reference']).'%\' OR LOWER(createnick) LIKE \'%'.strtolower($search_var['filter']).'%\')';
	// menu
	if (isset($search_var['menu_id']))
	if ($search_var['menu_id'])
	$sql_filter .= ' AND menu_id='.$search_var['menu_id'];

	$sql = 'SELECT SUM(1) AS cnt FROM '.$db_prefix.'news_job '.$sql_filter.' GROUP BY menu_id, news_id';
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
function jobGetMenuList($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT mn.id, mn.title, mn.content_type, SUM(1) as cnt FROM '.$db_prefix.'news_email nw, '.$db_prefix.'menu mn WHERE nw.menu_id=mn.id AND nw.enabled=1 AND nw.validetime>STRFTIME(\'%s\') GROUP BY mn.id, mn.title, mn.content_type ORDER BY mn.parent_id, mn.priority, mn.title LIMIT 100';
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
function jobGetNewsList($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT DISTINCT ne.id, ne.menu_id, ne.title, ne.status, ne.ui_lang, ne.validetime FROM '.$db_prefix.'news_email nw, '.$db_prefix.'menu mn, '.$db_prefix.'news ne WHERE nw.menu_id=mn.id AND ne.menu_id=mn.id AND nw.enabled=1 AND nw.validetime>STRFTIME(\'%s\') AND ne.status>1 AND ne.status<4 AND ne.validetime>STRFTIME(\'%s\') ORDER BY mn.id, ne.validetime DESC LIMIT 100';
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
function jobMenuCleanUp($db_prefix, $db_link) {
	$list = '';
	$sql = 'SELECT nw.id FROM '.$db_prefix.'news_job nw LEFT JOIN '.$db_prefix.'menu mn ON nw.menu_id=mn.id WHERE nw.menu_id!=0 AND mn.id IS NULL';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC))
			$list .= $row['id'].', ';
		$list = substr($list, 0, -2);
		$result->finalize();
	}
	if ($list) {
		$sql = 'UPDATE '.$db_prefix.'news_job SET menu_id=0 WHERE id IN ('.$list.')';
		//echo $sql;
		$result = $db_link->exec($sql) or 0;
	}
	return (($list)?($result):(0));
}
//------------------------------------------------------------
function jobNewsCleanUp($db_prefix, $db_link) {
	$list = '';
	$sql = 'SELECT nw.id FROM '.$db_prefix.'news_job nw LEFT JOIN '.$db_prefix.'news mn ON nw.news_id=mn.id WHERE nw.news_id!=0 AND mn.id IS NULL';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC))
			$list .= $row['id'].', ';
		$list = substr($list, 0, -2);
		$result->finalize();
	}
	if ($list) {
		$sql = 'UPDATE '.$db_prefix.'news_job SET news_id=0 WHERE id IN ('.$list.')';
		//echo $sql;
		$result = $db_link->exec($sql) or 0;
	}
	return (($list)?($result):(0));
}
//------------------------------------------------------------
function jobEmailSource($db_prefix, $db_link, $filter_id = 0, $ref_list = array()) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT DISTINCT email, name, surname, title, firm FROM '.$db_prefix.'news_email WHERE 1=1'.($filter_id>0?' AND menu_id='.$filter_id:'').' AND enabled=1 AND validetime>STRFTIME(\'%s\') ORDER BY priority, email';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$row['reference'] = buildReference($ref_list, $row['name'], $row['surname'], $row['title']);
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function jobEmails($db_prefix, $db_link, $menu_id = 0, $news_id = 0) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT id, email, reference, status FROM '.$db_prefix.'news_job WHERE menu_id='.$menu_id.' AND news_id='.$news_id.' ORDER BY status DESC, email';
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
function jobSendEmails($db_prefix, $db_link, $menu_id = 0, $news_id = 0) {
	$sql_info = array();
	$count = 0;
	// limit is count of emails send at once
	$sql = 'SELECT id, email, reference, status FROM '.$db_prefix.'news_job WHERE status<2 AND menu_id='.$menu_id.' AND news_id='.$news_id.' LIMIT 10';
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
function jobUpdate($db_prefix, $db_link, $filter_id = 0, $array_db) {
	$sql = 'UPDATE '.$db_prefix.'news_job SET ';
	foreach ($array_db as $var => $param) {
		$sql .= $var.'='.$param.', ';
	}
	$sql = substr($sql, 0, -2).' WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function jobInsert($db_prefix, $db_link, $array_db) {
	$sql_insert = 'INSERT INTO '.$db_prefix.'news_job (';
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
function jobDelete($db_prefix, $db_link, $menu_id = 0, $news_id = 0) {
	$sql = 'DELETE FROM '.$db_prefix.'news_job WHERE menu_id='.$menu_id.' AND news_id='.$news_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function jobValideTime($db_prefix, $db_link) {
	$sql = 'UPDATE '.$db_prefix.'news_job SET enabled=0 WHERE enabled>0 AND validetime<'.(time()-86400); // 1 day over
	//echo $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}

?>
