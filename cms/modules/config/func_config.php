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

function configGetInfo($db_prefix, $db_link, $dtree_id = 1, $param = '') {
	$cfg_info = array();
	$count = 0;
	$sql_filter = 'WHERE 1=1';
	$sql_order = 'ORDER BY 1';
	if ($dtree_id && !$param) $sql_filter .= ' AND conf.dtree_id='.$dtree_id;
	else                      $sql_filter .= ' AND conf.param=\''.$param.'\'';
	$sql = 'SELECT conf.param, conf.value FROM '.$db_prefix.'config conf '.$sql_filter.' '.$sql_order;
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ( $row = $result->fetchArray(SQLITE3_ASSOC) ) {
			$count ++;
			$key = $row['param'];
			$cfg_info[$key] = $row['value'];
		}
		$result->finalize();
	}
	//print_r($cfg_info);
	return ($cfg_info);
}
//------------------------------------------------------------
function configGetAll($db_prefix, $db_link, $filter_id) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT DISTINCT
		 dt.parent_id, dt.priority, co.id AS id, co.dtree_id AS dtree_id,
		 co.param, co.value, dt.title, co.description, co.tip
		 FROM '.$db_prefix.'dtree dt, '.$db_prefix.'config co, '.$db_prefix.'dtree_role dtro, '.$db_prefix.'user us
		 WHERE dt.id = co.dtree_id
		   AND dt.id = dtro.dtree_id
		   AND dtro.role_id = us.role_id
		   AND us.active > 0
		   AND dtro.attr > 0 AND us.id='.$filter_id.' ORDER BY 1, 2';
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
function configUpdate($db_prefix, $db_link, $cfg_id = 0, $cfg_val) {
	$sql = 'UPDATE '.$db_prefix.'config SET value='.$cfg_val.' WHERE id='.$cfg_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}

?>
