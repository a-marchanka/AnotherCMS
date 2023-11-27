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
function galeryGetByMenu($db_prefix, $db_link, $filter_id) {
	$sql_info = array();
	$count = 0;
	$sql = '';
	$sql_filter = 'WHERE 1=1 AND status>1';
	$sql_order = 'ORDER BY priority, shoottime, id';

	if ($filter_id) $sql_filter .= ' AND menu_id='.$filter_id; // by menu id
	$sql = 'SELECT id, priority, menu_id, status, filepath, filename, alttext, width, height, rotation, meta_who, meta_where, shoottime, modifytime
		FROM '.$db_prefix.'galery '.$sql_filter.' '.$sql_order;
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
function galeryGetRefList($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;

	$sql = 'SELECT g.id, g.priority, g.menu_id, g.status, g.filepath, g.filename, g.alttext, g.width, g.height, g.meta_who, g.meta_where, g.shoottime, g.modifytime
		FROM '.$db_prefix.'galery g, (SELECT menu_id, min(id) AS id FROM '.$db_prefix.'galery WHERE status>1 GROUP BY menu_id) gr
		WHERE g.id=gr.id';
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
function galeryGetMetaYear($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;

	$sql = 'SELECT strftime(\'%Y\', date(shoottime,\'unixepoch\')) as meta_year
		FROM '.$db_prefix.'galery GROUP BY strftime(\'%Y\', date(shoottime,\'unixepoch\')) ORDER BY 1';
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
function galeryGetMetaWho($db_prefix, $db_link, $year, $where) {
	$sql_info = array();
	$count = 0;

	$sql = 'SELECT meta_who
		FROM '.$db_prefix.'galery WHERE 1=1 '.($year?' AND strftime(\'%Y\', date(shoottime,\'unixepoch\'))=\''.$year.'\'':'').($where?' AND meta_where LIKE \'%'.$meta_where.'%\'':'').'
		GROUP BY meta_who ORDER BY 1';
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
function galeryGetMetaWhere($db_prefix, $db_link, $year, $who) {
	$sql_info = array();
	$count = 0;

	$sql = 'SELECT meta_where
		FROM '.$db_prefix.'galery WHERE 1=1 '.($year?' AND strftime(\'%Y\', date(shoottime,\'unixepoch\'))=\''.$year.'\'':'').($who?' AND meta_who LIKE \'%'.$who.'%\'':'').'
		GROUP BY meta_where ORDER BY 1';
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
function galeryGetAll($db_prefix, $db_link, $search_var) {
	$sql_info = array();
	$count = 0;
	$sql = '';
	$sql_filter = 'WHERE 1=1 AND menu_id=28';
	$sql_limit = '';
	$sql_order = '';

	// search criteria
	// filter
	if ($search_var['meta_year'])
		$sql_filter .= ' AND strftime(\'%Y\', date(shoottime,\'unixepoch\'))=\''.$search_var['meta_year'].'\'';
	if ($search_var['meta_who'])
		$sql_filter .= ' AND meta_who LIKE \'%'.$search_var['meta_who'].'%\'';
	if ($search_var['meta_where'])
		$sql_filter .= ' AND meta_where LIKE \'%'.$search_var['meta_where'].'%\'';
	// custom code
	if ($search_var['meta_album']) {
		switch ($search_var['meta_album']) {
		case 'album_jv':
		$sql_filter .= ' AND (meta_who LIKE \'Ян\' OR meta_who LIKE \'Витя\' OR meta_who LIKE \'Ян%Витя\' OR meta_who LIKE \'Витя%Ян\') ';
		break;
		case 'album_ma':
		$sql_filter .= ' AND (meta_who LIKE \'Маша\' OR meta_who LIKE \'Андрей\' OR meta_who LIKE \'%Маша%Андрей%\' OR meta_who LIKE \'%Андрей%Маша%\') ';
		break;
		case 'album_tv':
		$sql_filter .= ' AND (meta_who LIKE \'Баб Таня\' OR meta_who LIKE \'Дед Валера\' OR meta_who LIKE \'%Баб Таня%Дед Валера%\' OR meta_who LIKE \'%Валера%Баб Таня%\') ';
		break;
		case 'album_vk':
		$sql_filter .= ' AND (meta_who LIKE \'Баб Валя\' OR meta_who LIKE \'Дед Коля\' OR meta_who LIKE \'%Баб Валя%Дед Коля%\' OR meta_who LIKE \'%Дед Коля%Баб Валя%\') ';
		break;
		default:
		//
		}
	}
	// limit
	$sql_limit = 'LIMIT 500';

	// combine
	$sql_order = 'ORDER BY priority, shoottime DESC';

	$sql = 'SELECT id, priority, status, filepath, filename, alttext,
		strftime(\'%Y\', date(shoottime,\'unixepoch\')) as meta_year, 
		strftime(\'%m\', date(shoottime,\'unixepoch\')) as meta_month, 
		width, height, rotation, meta_who, meta_where, shoottime, modifytime
		FROM '.$db_prefix.'galery '.$sql_filter.' '.$sql_order.' '.$sql_limit;
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


?>
