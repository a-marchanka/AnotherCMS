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
function orderGetInfo($db_prefix, $db_link, $filter_id = 0, $f_decimal = '.', $f_thousand = ',') {
	$sql_info = array();
	$result = 0;
	$sql = 'SELECT id, sid, cust_name, cust_surname, cust_title, cust_reference, cust_firm, bill_firm_vat_nr, bill_email, bill_tel, cust_street, cust_postcode, cust_city, cust_country_code, bill_birth_year, 
		bill_name, bill_surname, bill_title, bill_reference, bill_firm, bill_street, bill_postcode, bill_city, bill_country_code, bill_nr, bill_total_gross, bill_total_nett, bill_receipt, delivery_receipt,
		delivery_code, delivery_gross, delivery_nett, weight_kg_sum, length_cm_max, tracking_nr, payment_code, payment_gross, payment_nett, txn_nr, discount_code, discount_price, terms_flag, last_step, notes, status, agent, createtime, modifytime, closetime, paytime, createnick
		FROM '.$db_prefix.'shop_order WHERE 1=1 AND id='.$filter_id.' ORDER BY 1';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$sql_info = $result->fetchArray(SQLITE3_ASSOC);
		$sql_info['bill_total_gross_str'] = number_format($sql_info['bill_total_gross'], 2, $f_decimal, $f_thousand);
		$sql_info['bill_total_nett_str'] = number_format($sql_info['bill_total_nett'], 2, $f_decimal, $f_thousand);
		$sql_info['delivery_gross_str'] = number_format($sql_info['delivery_gross'], 2, $f_decimal, $f_thousand);
		$sql_info['delivery_nett_str'] = number_format($sql_info['delivery_nett'], 2, $f_decimal, $f_thousand);
		$sql_info['payment_gross_str'] = number_format($sql_info['payment_gross'], 2, $f_decimal, $f_thousand);
		$sql_info['payment_nett_str'] = number_format($sql_info['payment_nett'], 2, $f_decimal, $f_thousand);
		$sql_info['discount_price_str'] = number_format($sql_info['discount_price'], 2, $f_decimal, $f_thousand);
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function orderGetSid($db_prefix, $db_link, $filter_id = 0) {
	$result = 0;
	$sql = 'SELECT sid FROM '.$db_prefix.'shop_order WHERE 1=1 AND id='.$filter_id;
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	$cnt = ($row['sid']===null || $row['sid']==='')?(0):($row['sid']);
	return ($cnt);
}
//------------------------------------------------------------
function orderGetList($db_prefix, $db_link, $search_var, $page_var) {
	$sql_info = array();
	$count = 0;
	$sql_filter = 'WHERE 1=1';
	$sql_order = '';

	// search criteria
	// order
	if (isset($search_var['sort']))	if ($search_var['sort'])
		$sql_order = substr($search_var['sort'],3).((substr($search_var['sort'],0,2) == 'up') ? ' ASC, ' : ' DESC, ');
	// filter
	if (isset($search_var['filter'])) if ($search_var['filter'])
		$sql_filter .= ' AND (LOWER(bill_name) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(bill_surname) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(bill_receipt) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(bill_nr) LIKE \'%'.strtolower($search_var['filter']).'%\')';
	// limit
	$sql_limit = 'LIMIT '.$page_var['start'].','.$page_var['limit'];

	// combine
	if ($sql_order) $sql_order = 'ORDER BY '.$sql_order.' id DESC';
	else		$sql_order = 'ORDER BY id DESC';

	$sql = 'SELECT id, sid, bill_name, bill_surname, bill_email, bill_tel, cust_country_code, delivery_code, tracking_nr, payment_code, txn_nr, bill_country_code, bill_nr, discount_code, bill_total_gross, bill_receipt, delivery_receipt, notes, status, createtime, modifytime, closetime, paytime, createnick
		FROM '.$db_prefix.'shop_order '.$sql_filter.' '.$sql_order.' '.$sql_limit;
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
function getPaymentList($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT DISTINCT title, code, currency, payment_days, enabled FROM '.$db_prefix.'shop_payment ORDER BY title';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$row['dunning_time'] = time()-$row['payment_days']*86400;
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function getDeliveryList($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT title, code, MAX(enabled) AS enabled FROM '.$db_prefix.'shop_delivery GROUP BY title, code ORDER BY priority, title';
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
function getCountryList($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT country_code, country, MAX(enabled) AS enabled FROM '.$db_prefix.'shop_delivery GROUP BY country_code, country ORDER BY priority, country_code';
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
function orderGetCount($db_prefix, $db_link, $search_var) {
	$result = 0;
	$cnt = 0;
	$sql_filter = 'WHERE 1=1';
	// search criteria
	// filter
	if (isset($search_var['filter']))
	if ($search_var['filter'])
		$sql_filter .= ' AND (LOWER(bill_name) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(bill_surname) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(bill_receipt) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(bill_nr) LIKE \'%'.strtolower($search_var['filter']).'%\')';

	$sql = 'SELECT COUNT(id) AS cnt FROM '.$db_prefix.'shop_order '.$sql_filter;
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
function orderGetNextBill($db_prefix, $db_link) {
	$sql = 'SELECT MAX(bill_nr)+1 AS bill_nr_next FROM '.$db_prefix.'shop_order ';
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	return ($row['bill_nr_next']);
}
//------------------------------------------------------------
function orderUpdate($db_prefix, $db_link, $filter_id = 0, $array_db) {
	$sql = 'UPDATE '.$db_prefix.'shop_order SET ';
	foreach ($array_db as $var => $param) {
		$sql .= $var.'='.$param.', ';
	}
	$sql = substr($sql, 0, -2).' WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function orderInsert($db_prefix, $db_link, $array_db) {
	$sql_insert = 'INSERT INTO '.$db_prefix.'shop_order (';
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
function orderDelete($db_prefix, $db_link, $filter_id = 0) {
	$sql = 'DELETE FROM '.$db_prefix.'shop_order WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function basketList($db_prefix, $db_link, $sid) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT pr.id, pr.status, pr.amount_total, bs.amount FROM '.$db_prefix.'shop_product pr, '.$db_prefix.'shop_basket bs WHERE 1=1 AND pr.id=bs.product_id AND pr.status>1 AND bs.amount>0 AND bs.status=1 AND bs.sid=\''.$sid.'\'';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	unset($result);
	return ($sql_info);
}
//------------------------------------------------------------
function basketCleanup($db_prefix, $db_link) {
	$sql = 'DELETE FROM '.$db_prefix.'shop_basket WHERE 1=1 AND status=0 AND modifytime<'.(time()-2592000); // 30 days
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}

?>
