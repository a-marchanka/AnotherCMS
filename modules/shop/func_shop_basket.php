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

function discountInOrder($db_prefix, $db_link, $filter = '--') {
	$row = array();
	$result = 0;
	$sql = 'SELECT COUNT(id) AS cnt FROM '.$db_prefix.'shop_order WHERE 1=1 AND status IN (1,2,3) AND discount_code=\''.$filter.'\'';
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	unset($result);
	return ($row['cnt']);
}
//------------------------------------------------------------
function discountInfo($db_prefix, $db_link, $filter = '--', $f_decimal = '.', $f_thousand = ',') {
	$sql_info = array();
	$result = 0;
	$sql = 'SELECT code AS discount_code, price, price_type, reusable FROM '.$db_prefix.'shop_discount WHERE 1=1 AND enabled=1 AND active_from<='.time().' AND active_to>='.time().' AND code=\''.$filter.'\'';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$sql_info = $result->fetchArray(SQLITE3_ASSOC);
		if ($sql_info)
			$sql_info['price_str'] = number_format($sql_info['price'], 2, $f_decimal, $f_thousand);
		$result->finalize();
	}
	unset($result);
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function discountClear($db_prefix, $db_link, $sid = '0') {
	$sql = 'UPDATE '.$db_prefix.'shop_basket SET discount=0, discount_type=\'fix\', discount_code=\'\' WHERE 1=1 AND status=0 AND sid=\''.$sid.'\'';
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function discountUpdate($db_prefix, $db_link, $sid = '0', $type = 'fix', $discount = 0, $code = '') {
	$sql = 'UPDATE '.$db_prefix.'shop_basket SET discount='.$discount.', discount_type=\''.$type.'\', discount_code=\''.$code.'\' WHERE 1=1 AND amount>0 AND status=0 AND sid=\''.$sid.'\'';
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function discountInBasket($db_prefix, $db_link, $sid = '0') {
	$row = array();
	$result = 0;
	$sql = 'SELECT MAX(discount_code) AS discount_code FROM '.$db_prefix.'shop_basket WHERE 1=1 AND amount>0 AND status=0 AND sid=\''.$sid.'\'';
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	unset($result);
	return ($row['discount_code']);
}
//------------------------------------------------------------
function productMinus($db_prefix, $db_link, $filter_id = 0, $cnt = 0) {
	$sql = 'UPDATE '.$db_prefix.'shop_product SET amount_total='.$cnt.' WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function basketInsert($db_prefix, $db_link, $sid = '0', $pid = 0, $cnt = 0) {
	$sql_insert = 'INSERT INTO '.$db_prefix.'shop_basket (sid, product_id, amount, status, modifytime) VALUES (\''.$sid.'\', '.$pid.', '.$cnt.', 0, '.time().')';
	//echo $sql_insert;
	$result = $db_link->exec($sql_insert) or 0;
	return (($result)?($db_link->lastInsertRowID()):(0));
}
//------------------------------------------------------------
function basketUpdate($db_prefix, $db_link, $sid = '0', $pid = 0, $cnt = 0) {
	$sql = 'UPDATE '.$db_prefix.'shop_basket SET amount='.$cnt.', discount=0, discount_type=\'fix\' WHERE 1=1 AND status=0 AND sid=\''.$sid.'\' AND product_id='.$pid;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function basketFinish($db_prefix, $db_link, $sid = '') {
	$sql = 'UPDATE '.$db_prefix.'shop_basket SET status=1 WHERE 1=1 AND status=0 AND sid=\''.$sid.'\'';
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function basketProduct($db_prefix, $db_link, $sid = '0', $pid = 0) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT id, sid, product_id, amount, status FROM '.$db_prefix.'shop_basket WHERE 1=1 AND status=0 AND sid=\''.$sid.'\' AND product_id='.$pid;
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$sql_info = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	unset($result);
	return ($sql_info);
}
//------------------------------------------------------------
function basketList($db_prefix, $db_link, $sid, $f_decimal = '.', $f_thousand = ',') {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT pr.id, pr.pr_number, pr.menu_main_id, pr.product_type, CASE WHEN pr.product_type=\'service\' THEN pr.descr ELSE \'\' END AS descr, pr.currency, pr.tax, pr.status, pr.image, pr.amount_total, pr.weight_kg*bs.amount AS weight_kg, pr.length_cm, bs.amount, bs.discount, bs.discount_type, bs.discount_code,
		TRIM(CASE WHEN INSTR(pr.title,\'#\')>0 THEN SUBSTR(pr.title,1,INSTR(pr.title,\'#\')-1) ELSE pr.title END) AS title_1, TRIM(CASE WHEN INSTR(pr.title,\'#\')>0 THEN SUBSTR(pr.title,INSTR(pr.title,\'#\')+1) ELSE \'\' END) AS title_2,
		ROUND( (CASE WHEN bs.amount>=pr.amount_3 THEN pr.price_3 WHEN bs.amount>=pr.amount_2 THEN pr.price_2 WHEN bs.amount>=pr.amount_1 THEN pr.price_1 ELSE pr.price END),2 ) AS single_price,
		ROUND( (CASE WHEN bs.amount>=pr.amount_3 THEN pr.price_3 WHEN bs.amount>=pr.amount_2 THEN pr.price_2 WHEN bs.amount>=pr.amount_1 THEN pr.price_1 ELSE pr.price END)*100/(100+pr.tax),3 ) AS single_price_nett,
		ROUND( (CASE WHEN bs.amount>=pr.amount_3 THEN pr.price_3*bs.amount WHEN bs.amount>=pr.amount_2 THEN pr.price_2*bs.amount WHEN bs.amount>=pr.amount_1 THEN pr.price_1*bs.amount ELSE pr.price*bs.amount END),2 ) AS subtotal_price,
		ROUND( (CASE WHEN bs.amount>=pr.amount_3 THEN pr.price_3*bs.amount+(CASE WHEN bs.discount_type=\'pct\' THEN pr.price_3*bs.amount*bs.discount/100 ELSE bs.discount END) WHEN bs.amount>=pr.amount_2 THEN pr.price_2*bs.amount+(CASE WHEN bs.discount_type=\'pct\' THEN pr.price_2*bs.amount*bs.discount/100 ELSE bs.discount END) WHEN bs.amount>=pr.amount_1 THEN pr.price_1*bs.amount+(CASE WHEN bs.discount_type=\'pct\' THEN pr.price_1*bs.amount*bs.discount/100 ELSE bs.discount END) ELSE pr.price*bs.amount+(CASE WHEN bs.discount_type=\'pct\' THEN pr.price*bs.amount*bs.discount/100 ELSE bs.discount END) END),2 ) AS total_price,
		ROUND( (CASE WHEN bs.amount>=pr.amount_3 THEN pr.price_3*bs.amount WHEN bs.amount>=pr.amount_2 THEN pr.price_2*bs.amount WHEN bs.amount>=pr.amount_1 THEN pr.price_1*bs.amount ELSE pr.price*bs.amount END)*100/(100+pr.tax),3 ) AS subtotal_price_nett,
		ROUND( (CASE WHEN bs.amount>=pr.amount_3 THEN pr.price_3*bs.amount+(CASE WHEN bs.discount_type=\'pct\' THEN pr.price_3*bs.amount*bs.discount/100 ELSE bs.discount END) WHEN bs.amount>=pr.amount_2 THEN pr.price_2*bs.amount+(CASE WHEN bs.discount_type=\'pct\' THEN pr.price_2*bs.amount*bs.discount/100 ELSE bs.discount END) WHEN bs.amount>=pr.amount_1 THEN pr.price_1*bs.amount+(CASE WHEN bs.discount_type=\'pct\' THEN pr.price_1*bs.amount*bs.discount/100 ELSE bs.discount END) ELSE pr.price*bs.amount+(CASE WHEN bs.discount_type=\'pct\' THEN pr.price*bs.amount*bs.discount/100 ELSE bs.discount END) END)*100/(100+pr.tax),3 ) AS total_price_nett
		FROM '.$db_prefix.'shop_product pr, '.$db_prefix.'shop_basket bs WHERE 1=1 AND pr.amount_total>0 AND pr.id=bs.product_id AND pr.amount>0 AND pr.amount_1>0 AND pr.amount_2>0 AND pr.amount_3>0 AND bs.amount>0 AND bs.status=0 AND bs.sid=\''.$sid.'\' ORDER BY bs.modifytime DESC';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$row['single_price_str'] = number_format($row['single_price'], 2, $f_decimal, $f_thousand);
			$row['single_price_nett_str'] = number_format($row['single_price_nett'], 3, $f_decimal, $f_thousand);
			$row['subtotal_price_str'] = number_format($row['subtotal_price'], 2, $f_decimal, $f_thousand);
			$row['subtotal_price_nett_str'] = number_format($row['subtotal_price_nett'], 3, $f_decimal, $f_thousand);
			$row['total_price_str'] = number_format($row['total_price'], 2, $f_decimal, $f_thousand);
			$row['total_price_nett_str'] = number_format($row['total_price_nett'], 3, $f_decimal, $f_thousand);
			$row['tax_str'] = number_format($row['tax'], 1, $f_decimal, $f_thousand);
			$row['weight_kg_str'] = number_format($row['weight_kg'], 1, $f_decimal, $f_thousand);
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	unset($result);
	return ($sql_info);
}
//------------------------------------------------------------
function basketCount($db_prefix, $db_link, $sid = '0') {
	$row = array();
	$result = 0;
	$sql = 'SELECT SUM(amount) AS cnt FROM '.$db_prefix.'shop_basket WHERE 1=1 AND amount>0 AND status=0 AND sid=\''.$sid.'\'';
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	unset($result);
	return ($row['cnt']);
}
//------------------------------------------------------------
function basketLines($db_prefix, $db_link, $sid = '0') {
	$row = array();
	$result = 0;
	$sql = 'SELECT COUNT(id) AS cnt FROM '.$db_prefix.'shop_basket WHERE 1=1 AND amount>0 AND status=0 AND sid=\''.$sid.'\'';
	//print $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		$row = $result->fetchArray(SQLITE3_ASSOC);
		$result->finalize();
	}
	unset($result);
	return ($row['cnt']);
}
?>
