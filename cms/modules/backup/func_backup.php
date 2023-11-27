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

function backupGetTables($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = '';

	$sql = 'SELECT name, tbl_name, sql FROM sqlite_master WHERE type=\'table\'';
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
function backupListValues($db_prefix, $db_link, $table_name, $row_from, $row_count) {
	$sql = '';
	$out = '';
	$out_buffer = '';
	$tmp_var = '';
	$tmp_param = '';
	
	if ($table_name != 'sqlite_sequence') $sql = 'SELECT * FROM '.$table_name.' LIMIT '.$row_from.','.$row_count;
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			$out .= "INSERT INTO $table_name VALUES(";
			foreach ($row as $tmp_var => $tmp_param)
				$out_buffer .= '\''.(str_replace('&#039;','\&#039;',$tmp_param)).'\', '; // sql quote
			$out .= substr($out_buffer,0,-2) . ");;\n";
			$out_buffer = '';
		}
		$result->finalize();
	}
	//print_r($out);
	return ($out);
}

?>
