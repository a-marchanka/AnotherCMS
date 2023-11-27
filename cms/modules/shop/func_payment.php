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

//------------------------------------------------------------
function paymentGetInfo($db_prefix, $db_link, $filter_id = 0) {
	$sql_info = array();
	$result = 0;
	$sql = 'SELECT id, code, title, country_code, price, price_type, currency, tax, enabled, modifytime
		FROM '.$db_prefix.'shop_payment WHERE 1=1 AND id='.$filter_id.' ORDER BY 1';
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
function paymentGetAll($db_prefix, $db_link, $search_var, $page_var, $f_decimal = '.', $f_thousand = ',') {
	$sql_info = array();
	$count = 0;
	$result = 0;
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
	$sql_filter .= ' AND (LOWER(code) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(title) LIKE \'%'.strtolower($search_var['filter']).'%\')';
	// limit
	$sql_limit = 'LIMIT '.$page_var['start'].','.$page_var['limit'];

	// combine
	if ($sql_order) $sql_order = 'ORDER BY '.$sql_order.' modifytime DESC';
	else		$sql_order = 'ORDER BY modifytime';

	$sql = 'SELECT id, code, title, country_code, price, price_type, currency, tax, enabled, modifytime
		FROM '.$db_prefix.'shop_payment '.$sql_filter.' '.$sql_order.' '.$sql_limit;
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$row['price_str'] = number_format($row['price'], 2, $f_decimal, $f_thousand);
			$row['tax_str'] = number_format($row['tax'], 2, $f_decimal, $f_thousand);
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function paymentGetCount($db_prefix, $db_link, $search_var) {
	$result = 0;
	$cnt = 0;
	$sql_filter = 'WHERE 1=1';
	// search criteria
	// filter
	if (isset($search_var['filter']))
	if ($search_var['filter'])
	$sql_filter .= ' AND (LOWER(code) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(title) LIKE \'%'.strtolower($search_var['filter']).'%\')';

	$sql = 'SELECT COUNT(id) AS cnt FROM '.$db_prefix.'shop_payment '.$sql_filter;
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
function paymentUpdate($db_prefix, $db_link, $filter_id = 0, $array_db) {
	$result = 0;
	$sql = 'UPDATE '.$db_prefix.'shop_payment SET ';
	foreach ($array_db as $var => $param) {
		$sql .= $var.'='.$param.', ';
	}
	$sql = substr($sql, 0, -2).' WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function paymentInsert($db_prefix, $db_link, $array_db) {
	$result = 0;
	$sql_insert = 'INSERT INTO '.$db_prefix.'shop_payment (';
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
function paymentDelete($db_prefix, $db_link, $filter_id = 0) {
	$result = 0;
	$sql = 'DELETE FROM '.$db_prefix.'shop_payment WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}

?>
