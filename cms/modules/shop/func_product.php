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
function productGetInfo($db_prefix, $db_link, $filter_id = 0) {
	$sql_info = array();
	$result = 0;
	$sql = 'SELECT id, pr_number, menu_main_id, product_type, priority, title, descr, image, amount_total, amount, amount_1, amount_2, amount_3, price, price_1, price_2, price_3, currency, tax, weight_kg, length_cm, family_ids, status, modifytime, createnick
		FROM '.$db_prefix.'shop_product WHERE 1=1 AND id='.$filter_id.' ORDER BY 1';
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
function productShortInfo($db_prefix, $db_link, $filter_id) {
	$sql_info = array();
	$count = 0;
	$sql = '';
	$sql_filter = 'WHERE 1=1';
	$sql_order = 'ORDER BY 1';
	if ($filter_id) $sql_filter .= ' AND id='.$filter_id;
	$sql = 'SELECT id, pr_number, title, image, family_ids, status, modifytime, createnick FROM '.$db_prefix.'shop_product '.$sql_filter.' '.$sql_order;
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
function productFamilyInfo($db_prefix, $db_link, $filter_id) {
	$sql_info = array();
	$count = 0;
	$sql = '';
	$sql_filter = 'WHERE 1=1';
	$sql_order = 'ORDER BY 1';
	if ($filter_id) {
		$sql_filter .= ' AND id IN ('.$filter_id.')';
		$sql = 'SELECT id, pr_number, title, image, status FROM '.$db_prefix.'shop_product '.$sql_filter.' '.$sql_order;
		//echo $sql;
		$result = $db_link->query($sql) or 0;
		if ($result) {
			while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
				$count ++;
				$sql_info = array_pad($sql_info, $count, $row);
			}
			$result->finalize();
		}
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function productGetAll($db_prefix, $db_link, $search_var, $page_var, $f_decimal = '.', $f_thousand = ',') {
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
	$sql_filter .= ' AND (LOWER(title) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(pr_number) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(descr) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(image) LIKE \'%'.strtolower($search_var['filter']).'%\')';
	// menu
	if (isset($search_var['menu_id']))
	if ($search_var['menu_id'])
	$sql_filter .= ' AND menu_main_id='.$search_var['menu_id'];
	// limit
	$sql_limit = 'LIMIT '.$page_var['start'].','.$page_var['limit'];
	// combine
	if ($sql_order) $sql_order = 'ORDER BY '.$sql_order.' priority DESC';
	else		$sql_order = 'ORDER BY priority';

	$sql = 'SELECT id, pr_number, menu_main_id, product_type, priority, title, image, amount_total, amount, amount_1, amount_2, amount_3, price, price_1, price_2, price_3, currency, tax, weight_kg, length_cm, family_ids, status, modifytime, createnick
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
			$row['tax_str'] = number_format($row['tax'], 2, $f_decimal, $f_thousand);
			$row['weight_kg_str'] = number_format($row['weight_kg'], 3, $f_decimal, $f_thousand);
			// take family products
			if ($row['family_ids']) {
				$sql1 = 'SELECT group_concat(id||\'. \'||pr_number||\' - \'||substr(title,1,35), \'<br>\') AS family_products FROM '.$db_prefix.'shop_product WHERE id IN ('.$row['family_ids'].') AND status>0 ORDER BY menu_main_id, id';
				//echo $sql1;
				$result1 = $db_link->query($sql1) or 0;
				if ($result1) {
					$sql1_info = $result1->fetchArray(SQLITE3_ASSOC);
					$result1->finalize();
					$row['family_products'] = $sql1_info['family_products'];
				}
			}
			$sql_info = array_pad($sql_info, $count, $row);
		}
		$result->finalize();
	}
	//print_r($sql_info);
	return ($sql_info);
}
//------------------------------------------------------------
function productShortAll($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT id, pr_number, priority, title, image, status FROM '.$db_prefix.'shop_product WHERE 1=1 AND status>0 ORDER BY priority LIMIT 1000';
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
function productGetCount($db_prefix, $db_link, $search_var) {
	$result = 0;
	$cnt = 0;
	$sql_filter = 'WHERE 1=1';
	// search criteria
	// filter
	if (isset($search_var['filter']))
	if ($search_var['filter'])
	$sql_filter .= ' AND (LOWER(title) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(pr_number) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(descr) LIKE \'%'.strtolower($search_var['filter']).'%\' OR LOWER(descr) LIKE \'%'.strtolower($search_var['filter']).'%\')';
	// menu
	if (isset($search_var['menu_id']))
	if ($search_var['menu_id'])
	$sql_filter .= ' AND menu_main_id='.$search_var['menu_id'];

	$sql = 'SELECT COUNT(id) AS cnt FROM '.$db_prefix.'shop_product '.$sql_filter;
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
function productCleanUp($db_prefix, $db_link) {
	$list = '';
	$sql = 'SELECT pr.id FROM '.$db_prefix.'shop_product pr LEFT JOIN '.$db_prefix.'menu mn ON pr.menu_main_id=mn.id WHERE pr.menu_main_id!=0 AND mn.id IS NULL';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC))
			$list .= $row['id'].', ';
		$list = substr($list, 0, -2);
		$result->finalize();
	}
	if ($list) {
		$sql = 'UPDATE '.$db_prefix.'shop_product SET menu_main_id=0 WHERE id IN ('.$list.')';
		//echo $sql;
		$result = $db_link->exec($sql) or 0;
	}
	return (($list)?($result):(0));
}
//------------------------------------------------------------
function productUpdate($db_prefix, $db_link, $filter_id = 0, $array_db) {
	$sql = 'UPDATE '.$db_prefix.'shop_product SET ';
	foreach ($array_db as $var => $param) {
		$sql .= $var.'='.$param.', ';
	}
	$sql = substr($sql, 0, -2).' WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function productInsert($db_prefix, $db_link, $array_db) {
	$sql_insert = 'INSERT INTO '.$db_prefix.'shop_product (';
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
function productDelete($db_prefix, $db_link, $filter_id = 0) {
	$sql = 'DELETE FROM '.$db_prefix.'shop_product WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}

?>
