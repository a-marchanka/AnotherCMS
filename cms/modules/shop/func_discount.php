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

function discountGetInfo($db_prefix, $db_link, $filter_id = 0, $f_decimal = '.', $f_thousand = ',') {
	$sql_info = array();
	$result = 0;
	$sql = 'SELECT id, code, title, price, price_type, pattern, active_from, active_to, reusable, enabled, modifytime, createnick
		FROM '.$db_prefix.'shop_discount WHERE 1=1 AND id='.$filter_id.' ORDER BY 1';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$sql_info = $result->fetchArray(SQLITE3_ASSOC);
		$sql_info['price_str'] = number_format($sql_info['price'], 2, $f_decimal, $f_thousand);
		$sql_info['price_type_str'] = ($sql_info['price_type']=='fix')?('fix'):('%');
		$sql_info['active_from_str'] = date('d.m.Y', $sql_info['active_from']);
		$sql_info['active_to_str'] = date('d.m.Y', $sql_info['active_to']);
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function discountGetAll($db_prefix, $db_link, $search_var, $page_var, $f_decimal = '.', $f_thousand = ',') {
	$sql_info = array();
	$count = 0;
	$result = 0;
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
	$sql_filter .= ' AND (LOWER(title) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(code) LIKE \'%'.strtolower($search_var['filter']).'%\')';
	// limit
	$sql_limit = 'LIMIT '.$page_var['start'].','.$page_var['limit'];

	// combine
	if ($sql_order) $sql_order = 'ORDER BY '.$sql_order.' modifytime DESC';
	else		$sql_order = 'ORDER BY modifytime';

	$sql = 'SELECT id, code, title, price, price_type, pattern, active_from, active_to, reusable, enabled, modifytime, createnick FROM '.$db_prefix.'shop_discount '.$sql_filter.' '.$sql_order.' '.$sql_limit;
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$row['price_str'] = number_format($row['price'], 2, $f_decimal, $f_thousand);
			$row['price_type_str'] = ($row['price_type']=='fix')?('fix'):('%');
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function discountGetCount($db_prefix, $db_link, $search_var) {
	$result = 0;
	$cnt = 0;
	$sql_filter = 'WHERE 1=1';
	// search criteria
	// filter
	if (isset($search_var['filter']))
	if ($search_var['filter'])
	$sql_filter .= ' AND (LOWER(code) LIKE \'%'.$search_var['filter'].'%\' OR LOWER(title) LIKE \'%'.$search_var['filter'].'%\')';

	$sql = 'SELECT COUNT(id) AS cnt FROM '.$db_prefix.'shop_discount '.$sql_filter;
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	$cnt = ($row['cnt']===null || $row['cnt']==='')?(0):($row['cnt']);
	return ($cnt);
}
//------------------------------------------------------------
function discountUpdate($db_prefix, $db_link, $filter_id = 0, $array_db) {
	$result = 0;
	$sql = 'UPDATE '.$db_prefix.'shop_discount SET ';
	foreach ($array_db as $var => $param) {
		$sql .= $var.'='.$param.', ';
	}
	$sql = substr($sql, 0, -2).' WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function discountInsert($db_prefix, $db_link, $array_db) {
	$result = 0;
	$sql_insert = 'INSERT INTO '.$db_prefix.'shop_discount (';
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
function discountDelete($db_prefix, $db_link, $filter_id = 0) {
	$result = 0;
	$sql = 'DELETE FROM '.$db_prefix.'shop_discount WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function discountInactivate($db_prefix, $db_link) {
	$result = 0;
	$sql = 'SELECT COUNT(id) AS cnt FROM '.$db_prefix.'shop_discount WHERE enabled>0 AND active_to<'.(time()-3600);
	//echo $sql;
	$obj = $db_link->query($sql) or 0;
	if ($obj) {
		$row = $obj->fetchArray(SQLITE3_ASSOC);
		if ($row['cnt']) {
			$sql = 'UPDATE '.$db_prefix.'shop_discount SET enabled=0 WHERE enabled>0 AND active_to<'.(time()-3600); // 1 hour over
			//echo $sql;
			$result = $db_link->exec($sql) or 0;
		}
	}
	return ($result);
}

?>
