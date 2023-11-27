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
function getCountryList($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT DISTINCT country_code, country FROM '.$db_prefix.'shop_delivery WHERE 1=1 AND enabled=1 ORDER BY country';
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
function getDeliveryList($db_prefix, $db_link, $country = 'DE', $weight = 0, $length = 0, $f_decimal = '.', $f_thousand = ',') {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT code AS delivery_code, title AS delivery_title, country_code, country, currency,
		ROUND( (CASE WHEN weight_kg1>'.$weight.' THEN price_kg1 WHEN weight_kg2>'.$weight.' THEN price_kg2 WHEN weight_kg3>'.$weight.' THEN price_kg3 ELSE price_kg4 END),2 ) AS price_kg,
		ROUND( (CASE WHEN weight_kg1>'.$weight.' THEN price_kg1 WHEN weight_kg2>'.$weight.' THEN price_kg2 WHEN weight_kg3>'.$weight.' THEN price_kg3 ELSE price_kg4 END)*100/(100+tax),3 ) AS price_kg_nett,
		ROUND( (CASE WHEN length_cm1>'.$length.' THEN price_cm1 WHEN length_cm2>'.$length.' THEN price_cm2 WHEN length_cm3>'.$length.' THEN price_cm3 ELSE price_cm4 END),2 ) AS price_cm,
		ROUND( (CASE WHEN length_cm1>'.$length.' THEN price_cm1 WHEN length_cm2>'.$length.' THEN price_cm2 WHEN length_cm3>'.$length.' THEN price_cm3 ELSE price_cm4 END)*100/(100+tax),3 ) AS price_cm_nett
		FROM '.$db_prefix.'shop_delivery WHERE 1=1 AND enabled=1 AND (country_code=\''.$country.'\' OR country_code=\'--\') ORDER BY country';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$row['price'] = ($row['price_cm'] > $row['price_kg'])?($row['price_cm']):($row['price_kg']);
			$row['price_nett'] = ($row['price_cm_nett'] > $row['price_kg_nett'])?($row['price_cm_nett']):($row['price_kg_nett']);
			$row['price_str'] = number_format($row['price'], 2, $f_decimal, $f_thousand);
			$row['price_nett_str'] = number_format($row['price_nett'], 3, $f_decimal, $f_thousand);
			$row['weight_str'] = number_format($weight, 1, $f_decimal, $f_thousand);
			$row['length_str'] = number_format($length, 1, $f_decimal, $f_thousand);
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	unset($result);
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function getPaymentList($db_prefix, $db_link, $country = 'DE', $price = 0, $f_decimal = '.', $f_thousand = ',') {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT code AS payment_code, title AS payment_title, country_code, currency, 
		ROUND( (CASE WHEN price_type=\'fix\' THEN price ELSE '.$price.'*price/100 END), 2) AS price,
		ROUND( (CASE WHEN price_type=\'fix\' THEN price ELSE '.$price.'*price/100 END)*100/(100+tax),3 ) AS price_nett
		FROM '.$db_prefix.'shop_payment WHERE 1=1 AND enabled=1 AND (country_code=\''.$country.'\' OR country_code=\'--\') ORDER BY country_code';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$row['price_str'] = number_format($row['price'], 2, $f_decimal, $f_thousand);
			$row['price_nett_str'] = number_format($row['price_nett'], 3, $f_decimal, $f_thousand);
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	unset($result);
	return ($sql_info);
}
//------------------------------------------------------------
function orderGetInfo($db_prefix, $db_link, $sid = '', $f_decimal = '.', $f_thousand = ',') {
	$sql_info = array();
	$sql = 'SELECT id, sid, cust_name, cust_surname, cust_title, cust_reference, cust_firm, bill_firm_vat_nr, bill_email, bill_tel, cust_street, cust_postcode, cust_city, cust_country_code, bill_birth_year, 
		bill_name, bill_surname, bill_title, bill_reference, bill_firm, bill_street, bill_postcode, bill_city, bill_country_code, bill_nr, bill_total_gross, bill_total_nett, bill_receipt, delivery_receipt,
		delivery_code, delivery_gross, delivery_nett, weight_kg_sum, length_cm_max, tracking_nr, payment_code, payment_gross, payment_nett, txn_nr, discount_code, discount_price, terms_flag, last_step, notes, status, agent, createtime, modifytime, closetime, paytime, createnick
		FROM '.$db_prefix.'shop_order WHERE 1=1 AND status=0 AND sid=\''.$sid.'\'';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$sql_info = $result->fetchArray(SQLITE3_ASSOC);
		if ($sql_info) {
		$sql_info['bill_total_gross_str'] = number_format($sql_info['bill_total_gross'], 2, $f_decimal, $f_thousand);
		$sql_info['bill_total_nett_str'] = number_format($sql_info['bill_total_nett'], 3, $f_decimal, $f_thousand);
		$sql_info['delivery_gross_str'] = number_format($sql_info['delivery_gross'], 2, $f_decimal, $f_thousand);
		$sql_info['delivery_nett_str'] = number_format($sql_info['delivery_nett'], 3, $f_decimal, $f_thousand);
		$sql_info['payment_gross_str'] = number_format($sql_info['payment_gross'], 2, $f_decimal, $f_thousand);
		$sql_info['payment_nett_str'] = number_format($sql_info['payment_nett'], 3, $f_decimal, $f_thousand);
		$sql_info['discount_price_str'] = number_format($sql_info['discount_price'], 2, $f_decimal, $f_thousand);
		}
		$result->finalize();
	}
	unset($result);
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function orderFinish($db_prefix, $db_link, $sid = '', $filter_id = 0) {
	$sql = 'UPDATE '.$db_prefix.'shop_order SET status=1 WHERE 1=1 AND status=0 AND sid=\''.$sid.'\' AND id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function orderUpdate($db_prefix, $db_link, $sid = '', $filter_id = 0, $array_db) {
	$sql = 'UPDATE '.$db_prefix.'shop_order SET ';
	foreach ($array_db as $var => $param) {
		$sql .= $var.'='.$param.', ';
	}
	$sql = substr($sql, 0, -2).' WHERE 1=1 AND status=0 AND sid=\''.$sid.'\' AND id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function orderInsert($db_prefix, $db_link, $sid = '', $array_db) {
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
function orderLines($db_prefix, $db_link, $sid = '') {
	$row = array();
	$result = 0;
	$cnt = 0;
	$sql = 'SELECT COUNT(id) AS cnt FROM '.$db_prefix.'shop_order WHERE 1=1 AND status=0 AND sid=\''.$sid.'\'';
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	unset($result);
	$cnt = ($row['cnt']===null || $row['cnt']==='')?(0):($row['cnt']);
	return ($cnt);
}
//------------------------------------------------------------
function orderUpdateTxn($db_prefix, $db_link, $sid = '', $txn_nr = '') {
	$sql = 'UPDATE '.$db_prefix.'shop_order SET txn_nr=\''.$txn_nr.'\' WHERE 1=1 AND status=0 AND sid=\''.$sid.'\'';
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function orderGetTxn($db_prefix, $db_link, $sid = '') {
	$row = array();
	$result = 0;
	$txn_nr = '';
	$sql = 'SELECT txn_nr FROM '.$db_prefix.'shop_order WHERE 1=1 AND sid=\''.$sid.'\'';
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	unset($result);
	$txn_nr = ($row['txn_nr']===null || $row['txn_nr']==='')?('na'):($row['txn_nr']);
	return ($txn_nr);
}
//------------------------------------------------------------
function orderUpdatePaytime($db_prefix, $db_link, $sid = '') {
	$sql = 'UPDATE '.$db_prefix.'shop_order SET paytime='.time().' WHERE 1=1 AND sid=\''.$sid.'\'';
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
?>
