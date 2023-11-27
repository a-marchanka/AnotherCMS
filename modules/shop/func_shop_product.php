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
function productAggFamily($db_prefix, $db_link, $filter_str, $id_ref = 0, $f_decimal = '.', $f_thousand = ',') {
	$sql_info = array();
	$count = 0;
	$sql = '';
	$sql_filter = 'WHERE 1=1 AND status>1';
	$sql_order = 'ORDER BY priority';
	if ($filter_str) $sql_filter .= ' AND id IN ('.$filter_str.')';
	// sql
	$sql = 'SELECT id, pr_number, menu_main_id, priority, currency, status, image, amount_total, amount, price,
		TRIM(CASE WHEN INSTR(title,\'#\')>0 THEN SUBSTR(title,1,INSTR(title,\'#\')-1) ELSE title END) AS title_1, TRIM(CASE WHEN INSTR(title,\'#\')>0 THEN SUBSTR(title,INSTR(title,\'#\')+1) ELSE \'\' END) AS title_2
		FROM '.$db_prefix.'shop_product '.$sql_filter.' '.$sql_order;
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$row['id_ref'] = $id_ref;
			$row['price_str'] = number_format($row['price'], 2, $f_decimal, $f_thousand);
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function productAggInfo($db_prefix, $db_link, $filter_id, $f_decimal = '.', $f_thousand = ',') {
	$sql_info = array();
	$count = 0;
	$sql = '';
	$sql_filter = 'WHERE 1=1 AND status>1';
	$sql_order = 'ORDER BY pr.priority';
	if ($filter_id) $sql_filter .= ' AND id='.$filter_id;
	// sql
	$sql = 'SELECT pr.id AS id, pr.pr_number AS pr_number, pr.menu_main_id AS menu_main_id, pr.priority AS priority, pr.currency AS currency, pr.tax AS tax, pr.status AS status, pr.descr AS descr, pr.family_ids AS family_ids,
		TRIM(CASE WHEN INSTR(pr.title,\'#\')>0 THEN SUBSTR(pr.title,1,INSTR(pr.title,\'#\')-1) ELSE pr.title END) AS title_1, TRIM(CASE WHEN INSTR(pr.title,\'#\')>0 THEN SUBSTR(pr.title,INSTR(pr.title,\'#\')+1) ELSE \'\' END) AS title_2,
		pr.image AS image, pr.amount_total AS amount_total, pr.amount AS amount, pr.amount_1 AS amount_1, pr.amount_2 AS amount_2, pr.amount_3 AS amount_3, pr.price AS price, pr.price_1 AS price_1, pr.price_2 AS price_2, pr.price_3 AS price_3, ROUND(pr.price*100/(100+pr.tax),3) AS price_nett, ROUND(pr.price_1*100/(100+pr.tax),3) AS price_1_nett, ROUND(pr.price_2*100/(100+pr.tax),3) AS price_2_nett, ROUND(pr.price_3*100/(100+pr.tax),3) AS price_3_nett
		FROM '.$db_prefix.'shop_product pr, '.'( SELECT TRIM(CASE WHEN INSTR(title,\'#\')>0 THEN SUBSTR(title,1,INSTR(title,\'#\')-1) ELSE title END) AS title FROM '.$db_prefix.'shop_product '.$sql_filter.' ) tit WHERE tit.title=TRIM(CASE WHEN INSTR(pr.title,\'#\')>0 THEN SUBSTR(pr.title,1,INSTR(pr.title,\'#\')-1) ELSE pr.title END) '.' '.$sql_order;
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$row['price_str'] = number_format($row['price'], 2, $f_decimal, $f_thousand);
			$row['price_1_str'] = number_format($row['price_1'], 2, $f_decimal, $f_thousand);
			$row['price_2_str'] = number_format($row['price_2'], 2, $f_decimal, $f_thousand);
			$row['price_3_str'] = number_format($row['price_3'], 2, $f_decimal, $f_thousand);
			$row['price_nett_str'] = number_format($row['price_nett'], 3, $f_decimal, $f_thousand);
			$row['price_1_nett_str'] = number_format($row['price_1_nett'], 3, $f_decimal, $f_thousand);
			$row['price_2_nett_str'] = number_format($row['price_2_nett'], 3, $f_decimal, $f_thousand);
			$row['price_3_nett_str'] = number_format($row['price_3_nett'], 3, $f_decimal, $f_thousand);
			$row['tax_str'] = number_format($row['tax'], 1, $f_decimal, $f_thousand);
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function productAggList($db_prefix, $db_link, $menu_id = 0, $page_var, $f_decimal = '.', $f_thousand = ',') {
	$sql_info = array();
	$count = 0;
	$sql = '';
	$sql_filter = 'WHERE 1=1 AND status>1';
	$sql_limit = '';
	$sql_order = 'ORDER BY pr.menu_main_id, pr.status DESC, pr.priority';

	// search criteria
	// filter
	if (isset($menu_id)) if ($menu_id) $sql_filter .= ' AND menu_main_id='.$menu_id;
	// limit
	$sql_limit = 'LIMIT '.$page_var['start'].','.$page_var['limit'];
	// sql
	$sql = 'SELECT pr.id AS id, pr.menu_main_id AS menu_main_id, pr.currency AS currency, pr.tax AS tax, pr.image AS image, pr.price AS price, ids.status AS status, ids.cnt AS cnt, ids.price_min AS price_min, ids.price_max AS price_max,
		TRIM(CASE WHEN INSTR(pr.title,\'#\')>0 THEN SUBSTR(pr.title,1,INSTR(pr.title,\'#\')-1) ELSE pr.title END) AS title
		FROM '.$db_prefix.'shop_product pr, '.'( SELECT MIN(id) as id, MAX(status) as status, MIN(price) as price_min, MAX(price) as price_max, SUM(1) as cnt FROM '.$db_prefix.'shop_product '.$sql_filter.' GROUP BY TRIM(CASE WHEN INSTR(title,\'#\')>0 THEN SUBSTR(title,1,INSTR(title,\'#\')-1) ELSE title END) ) ids WHERE pr.id=ids.id '.' '.$sql_order.' '.$sql_limit;
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$row['price_str'] = number_format($row['price'], 2, $f_decimal, $f_thousand);
			$row['price_min_str'] = number_format($row['price_min'], 2, $f_decimal, $f_thousand);
			$row['price_max_str'] = number_format($row['price_max'], 2, $f_decimal, $f_thousand);
			$row['tax_str'] = number_format($row['tax'], 1, $f_decimal, $f_thousand);
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function productAggCount($db_prefix, $db_link, $menu_id = 0) {
	$sql_filter = 'WHERE 1=1 AND status>1';
	// menu
	if (isset($menu_id)) if ($menu_id) $sql_filter .= ' AND menu_main_id='.$menu_id;
	// sql
	$sql = 'SELECT SUM(1) as cnt FROM ( SELECT MIN(id) as id FROM '.$db_prefix.'shop_product '.$sql_filter.' GROUP BY TRIM(CASE WHEN INSTR(title,\'#\')>0 THEN SUBSTR(title,1,INSTR(title,\'#\')-1) ELSE title END) )';
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
function productGetPrices($db_prefix, $db_link, $menu_id = 0, $page_var, $f_decimal = '.', $f_thousand = ',') {
	$sql_info = array();
	$count = 0;
	$sql = '';
	$sql_filter = 'WHERE 1=1 AND status>1';
	$sql_limit = '';
	$sql_order = 'ORDER BY menu_main_id, priority, status DESC';

	// search criteria
	// filter
	if (isset($menu_id)) if ($menu_id) $sql_filter .= ' AND menu_main_id='.$menu_id.')';
	// limit
	$sql_limit = 'LIMIT '.$page_var['start'].','.$page_var['limit'];
	// sql
	$sql = 'SELECT id, pr_number, menu_main_id, product_type, priority, title, currency, tax, status, modifytime,
		TRIM(CASE WHEN INSTR(title,\'#\')>0 THEN SUBSTR(title,1,INSTR(title,\'#\')-1) ELSE title END) AS title_1,
		TRIM(CASE WHEN INSTR(title,\'#\')>0 THEN SUBSTR(title,INSTR(title,\'#\')+1) ELSE \'\' END) AS title_2,
		image, amount_total, amount, amount_1, amount_2, amount_3, price, price_1, price_2, price_3, ROUND(price*100/(100+tax),3) AS price_nett, ROUND(price_1*100/(100+tax),3) AS price_1_nett, ROUND(price_2*100/(100+tax),3) AS price_2_nett, ROUND(price_3*100/(100+tax),3) AS price_3_nett
		FROM '.$db_prefix.'shop_product '.$sql_filter.' '.$sql_order.' '.$sql_limit;
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$count ++;
			$row['price_str'] = number_format($row['price'], 2, $f_decimal, $f_thousand);
			$row['price_1_str'] = number_format($row['price_1'], 2, $f_decimal, $f_thousand);
			$row['price_2_str'] = number_format($row['price_2'], 2, $f_decimal, $f_thousand);
			$row['price_3_str'] = number_format($row['price_3'], 2, $f_decimal, $f_thousand);
			$row['price_nett_str'] = number_format($row['price_nett'], 3, $f_decimal, $f_thousand);
			$row['price_1_nett_str'] = number_format($row['price_1_nett'], 3, $f_decimal, $f_thousand);
			$row['price_2_nett_str'] = number_format($row['price_2_nett'], 3, $f_decimal, $f_thousand);
			$row['price_3_nett_str'] = number_format($row['price_3_nett'], 3, $f_decimal, $f_thousand);
			$row['tax_str'] = number_format($row['tax'], 1, $f_decimal, $f_thousand);
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function productGetCount($db_prefix, $db_link, $menu_id = 0) {
	$row = array();
	$sql_filter = 'WHERE 1=1 AND status>1';
	// menu
	if (isset($menu_id)) if ($menu_id) $sql_filter .= ' AND menu_main_id='.$menu_id;
	// sql
	$sql = 'SELECT SUM(1) AS cnt FROM '.$db_prefix.'shop_product '.$sql_filter;
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
