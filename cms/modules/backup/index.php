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

$details_id = 0;

if (!empty($_POST['details_id']) || !empty($_GET['details_id']))
$details_id = (!empty($_POST['details_id'])) ? $_POST['details_id'] : $_GET['details_id'];
if (!is_numeric($details_id)) $details_id = 0;

$in_var = array('table' => '', 'drop' => '', 'structure' => '', 'start' => '', 'count' => '', 'compress' => '', 'csv' => '');

$success = 0;
$editor_content = '';
$table_list = array();
$table_name = '';

// INCLUDE DB
include 'modules/backup/func_backup.php';
$table_list = backupGetTables(DB_PREFIX, $db_link);
assignArray($table_list, 'table_list');

switch ($action) {
case 'list':
if ($subaction == 'search') {
	$in_var = trimRequestValues($in_var);
	if(!is_numeric($in_var['start'])) $in_var['start'] = 0;
	if(!is_numeric($in_var['count'])) $in_var['count'] = 99;

	if (!$in_var['table']) {
		// dump all tables
		for ($i = 0; $i < sizeof($table_list); $i++) {
			$table_name = $table_list[$i]['name']; //get table name
			// structure
			if ($in_var['structure'])
			$editor_content .= "\nDROP TABLE IF EXISTS ".$table_list[$i]['name'].";;\n".$table_list[$i]['sql'].";;\n";
			// data
			$editor_content .= backupListValues(DB_PREFIX, $db_link, $table_list[$i]['name'], $in_var['start'], $in_var['count']);
		}
	} else {
		// structure
		if ($in_var['structure']) {
			for ($i = 0; $i < sizeof($table_list); $i++)
				if ($table_list[$i]['name'] == $in_var['table'])
					$editor_content .= "\nDROP TABLE IF EXISTS ".$table_list[$i]['name'].";;\n".$table_list[$i]['sql'].";;\n";
		}
		// data
		$editor_content .= backupListValues(DB_PREFIX, $db_link, $in_var['table'], $in_var['start'], $in_var['count']);
	}
	//echo $editor_content;
	if (!$editor_content) $editor_content = '-- empty';

	if ($in_var['compress'] && function_exists('gzcompress')) {
		$file_name = date("d_m_Y", time()).'-'.($in_var['table'] ? $in_var['table'] : DB_PREFIX.'_all').'.sql';
		// INCLUDE zip
		include 'modules/archive_zip.php';
		// set the header
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename="'.$file_name.'.zip"');
		header('Content-Transfer-Encoding: binary');
		// Output
		echo zipAddFile(htmlDecode($editor_content), $file_name, time());
		$tpl = 'core_empty.tpl';
		$view_mode = 2;
	} else {
		$warning_msg .= $SYS_WARN_MSG['dump_created'];
		$tpl = 'backup_list.tpl';
		// ASSIGN
		assignArray($in_var, 'details');
		assignArray($editor_content, 'editor_content');
		$view_mode = 1;
	}
	unset($in_var);
	unset($editor_content);
}
$success = 1;
break;
//------------------------------------------------------------
case 'details':
break;
//------------------------------------------------------------
case 'create':
if ($subaction == 'dump') {
	$editor_content = htmlDecode($_POST['editor_content']); // without strips
	$editor_content = str_replace("\'",'&#039;',$editor_content); // sql quote
	$in_var = trimRequestValues($in_var,0,2);

	if ($editor_content) {
		// search for queries
		$sql_array = explode(';;', $editor_content);
		$sql_error = '';
		foreach ($sql_array as $sql) {
			// execude sql
			if ($sql) {
			$result = $db_link->query($sql) or 0;
			//echo $sql;
			if ($result === FALSE) {
				$sql_error .= '<strong>-- Invalid query: </strong> '.$db_link->lastErrorMsg().'<br>';
			} else if ($result !== TRUE) {
				// if select table
				$warning_msg .= '<blockquote>'.htmlEncode($sql).'</blockquote><table class="w3-table w3-striped w3-border w3-small w3-margin-bottom">';
				$header = 0;
				while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
					if (!$header) {
						$h_array = array_keys($row);
						$warning_msg .= '<tr>';
						foreach ($h_array as $h_value) {
							$warning_msg .= '<td><strong>'.$h_value.'</strong></td>';
						}
						$warning_msg .= '</tr>';
						$header = 1;
						unset($h_array);
					}
					$warning_msg .= '<tr>';
					foreach ($row as $col_value) {
						$warning_msg .= '<td>'.$col_value.'</td>';
					}
					$warning_msg .= '</tr>';
				}
				$warning_msg .= '</table>';
				$result->finalize();
			}
			}
			unset($sql);
		}
		if ($sql_error)
			$error_msg .= $SYS_WARN_MSG['dump_updated_with'].'<br /> <br />'.$sql_error;
		else
			$warning_msg .= $SYS_WARN_MSG['sql_ok'];
		$success = 1;
	} else
		$warning_msg .= $SYS_WARN_MSG['dump_nocontent'];

	// ASSIGN
	$smarty->assign('log', $warning_msg.'<br />'.$error_msg);
	$warning_msg = '';
	$tpl = 'core_log.tpl';
	$view_mode = 2;
}
break;
//------------------------------------------------------------
case 'edit':
break;
//------------------------------------------------------------
default:
	$error_msg = $SYS_WARN_MSG['action_wrong'];
	$tpl = 'core_error.tpl';
	$action = 'list';
	$view_mode = 1;
}
//------------------------------------------------------------
// VIEW
if ($view_mode > 1) {
	$smarty->assign('error_msg', $error_msg);
	$smarty->assign('warning_msg', $warning_msg);
	$smarty->assign('success', $success);
	$smarty->assign('SID', $SID);
	$smarty->display((($tpl) ? ($tpl) : ('core_log.tpl')));
} else
	$right_frame = ($tpl) ? ($tpl) : ('backup_list.tpl');

// unset variables
unset($in_var);

?>
