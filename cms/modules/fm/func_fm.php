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

function fmGetPathArray($path = '') {
	$path_items = array();
	$path_array = array();
	if ($path) $path_items = explode('/', substr($path, 0, -1));
	$sum = sizeof($path_items);
	for ($i = 0; $i < $sum; $i ++) {
		$path_tmp = '';
		for ($j = 0; $j <= $i; $j ++) {
			$path_tmp .= $path_items[$j].'/';
		}
		$path_array = array_pad($path_array, ($i + 1), array('name' => $path_items[$i], 'path' => $path_tmp));
	}
	return ($path_array);
}
//------------------------------------------------------------
function fmGetNameExt($f_name) {
	$dot_pos = strrpos($f_name, '.', -2);
	$name = ($dot_pos) ? (substr($f_name, 0, $dot_pos)) : ($f_name);
	$ext = ($dot_pos) ? (substr($f_name, $dot_pos + 1)) : ('');
       	return (array('name' => $name, 'ext' => $ext));
}
//------------------------------------------------------------
function fmGetAttribute($f_path) {
	$attr = '0755';
	if (file_exists($f_path))
		$attr = substr(sprintf('%o', fileperms($f_path)), -4);
	//print $f_path;
	return ($attr);
}
//------------------------------------------------------------
function fmGetContent($f_path) {
	$content = '';
	if (file_exists($f_path)) {
		$fd = fopen($f_path, 'r');
		while (!feof($fd)) $content .= fgets($fd, 8192);
		fclose($fd);
		return $content;
	}
	return (0);
}
//------------------------------------------------------------
function fmGetFileList($path = '', $type_filter = '*', $ext_filter = '*') {
	$arr_name = array();
	$arr_type = array();
	$arr_ext = array();
	$arr_size = array();
	$arr_mtime = array();
	$arr_attr = array();
	$keys = array();
	$files_array = array();

	if ($handle = opendir($path)) {
		$count = 0;
		while (false !== ($f_name = readdir($handle))) {
			if ($f_name == "." || $f_name == "..") continue;
			$f_path = $path.$f_name;
			//print $f_path;
			$type = filetype($f_path);
			$is_found = false;
			if ($type == 'file' && ($type_filter == '*' || $type_filter == 'file')) {
				$name_ext = fmGetNameExt($f_name);
				$name = $name_ext['name'];
				$ext = $name_ext['ext'];
				if (!($ext_filter == '*' || ($ext_filter != '*' && $ext_filter == $ext))) continue;
				$size = filesize($f_path);
				if ($size < 0)
					$size = '>2 GB';
				else if ($size > 1000000)
					$size = number_format(($size/1000000), 1, ',', ' ').' MB';
				else if ($size > 1000)
					$size = number_format(($size/1000), 1, ',', ' ').' KB';
				else
					$size = number_format($size, 0, ',', ' ').' B';
				$is_found = true;
			}
			if ($type == 'dir' && ($type_filter == '*' || $type_filter == 'dir')) {
				$name = $f_name;
				$ext = '';
				if (!($ext_filter == '*' || ($ext_filter != '*' && strpos($name, $ext_filter) !== false))) continue;
				$size = '&lt;DIR&gt;';
				$is_found = true;
			}
			if ($is_found) {
				$count ++;
				$mtime = filemtime($f_path);
				$attr = substr(sprintf('%o', fileperms($f_path)), -4);
				$arr_name = array_pad($arr_name, $count, $name);
				$arr_ext = array_pad($arr_ext, $count, $ext);
				$arr_type = array_pad($arr_type, $count, $type);
				$arr_size = array_pad($arr_size, $count, $size);
				$arr_mtime = array_pad($arr_mtime, $count, $mtime);
				$arr_attr = array_pad($arr_attr, $count, $attr);
			}
		}
		/*
		print_r($arr_name);
		print_r($arr_ext);
		print_r($arr_type);
		print_r($arr_size);
		print_r($arr_mtime);
		print_r($arr_attr);
		*/
		closedir($handle);
		$tmp_array = array();
		if ($count) {
			array_multisort($arr_ext, SORT_STRING, $arr_name, SORT_STRING, $arr_mtime, SORT_DESC, SORT_STRING, $arr_type, SORT_STRING, $arr_size, $arr_attr);
			$sum = count($arr_name);
			for ($i = 0; $i < $sum; $i ++) {
				$tmp_array = array_pad($tmp_array, ($i + 1), array(
						'name' => $arr_name[$i],
						'ext' => $arr_ext[$i],
						'nameext' => $arr_name[$i].(($arr_ext[$i])?('.'.$arr_ext[$i]):('')),
						'type' => $arr_type[$i],
						'size' => $arr_size[$i],
						'mtime' => $arr_mtime[$i],
						'attr' => $arr_attr[$i] )
						);
			}
			//print_r($files_array);
		}
		$files_array = $tmp_array;
		unset($tmp_array);
	}
	return ($files_array);
}
//------------------------------------------------------------
function fmMakeDir($dir_name = '') {
	if (!is_dir($dir_name))
		$result = mkdir($dir_name, 0775);
	else $result = false;

       	return ($result);
}
//------------------------------------------------------------
function fmSaveContent($f_path, $f_content) {
	if ($fd = fopen($f_path, 'w')) {
		//print $f_path;
		if (fwrite($fd, $f_content) === FALSE) {
			fclose($fd);
			return false;
		}
		fclose($fd);
		return true;
	} else
		return false;
}
//------------------------------------------------------------
function fmCopyFile($old_path, $new_path) {
	if (!file_exists($new_path))
		return (copy($old_path, $new_path));
	else
		return false;
}
//------------------------------------------------------------
function fmRenameDirFile($old_path, $new_path, $attr = '') {
	// rename
	if (!file_exists($new_path) && $old_path != $new_path)
		return (rename($old_path, $new_path));
	elseif (is_writable($new_path)) {
		// try to change attributes
		if (!$attr) (is_dir($new_path)) ? ('0775') : ('0664');
		return (chmod($new_path, octdec($attr)));
	} else
		return false;
}
//------------------------------------------------------------
function fmDeleteDir($f_path) {
	if (file_exists($f_path)) {
		$result = rmdir($f_path);
		return ($result);
	} else 
		return false; 
}
//------------------------------------------------------------
function fmDeleteFile($f_path) {
	if (file_exists($f_path)) {
		$result = unlink($f_path);
		return ($result);
	} else 
		return false; 
}
//------------------------------------------------------------
function fmUploadFile($tmp_path, $f_path, $replace = 0) {
	if ((file_exists($f_path) && is_file($f_path) && $replace == 1) || !file_exists($f_path))
		if (is_uploaded_file($tmp_path))
			if (move_uploaded_file($tmp_path, $f_path)) return (chmod($f_path, octdec('0664')));
	return false;
}
//------------------------------------------------------------
function fmGetTypeByExt($ext) {
	$types_array = array(
	'bin' => 'application/octet-stream',
	'class' => 'application/octet-stream',
	'doc' => 'application/msword',
	'pdf' => 'application/pdf',
	'xls' => 'application/vnd.ms-excel',
	'xlsx' => 'application/vnd.openxmlformats-officedocument', 
	'ppt' => 'application/vnd.ms-powerpoint',
	'js' => 'application/x-javascript',
	'xml' => 'application/xml',
	'xsl' => 'application/xsl',
	'zip' => 'application/zip',
	'rar' => 'application/rar',
	'au' => 'audio/basic',
	'mp3' => 'audio/mpeg',
	'm3u' => 'audio/x-mpegurl',
	'ram' => 'audio/x-pn-realaudio',
	'rm' => 'application/vnd.rn-realmedia',
	'm3u' => 'audio/x-mpegurl',
	'wav' => 'audio/x-wav',
	'ogg' => 'audio/ogg',
	'avi' => 'video/x-msvideo',
	'mp4' => 'video/mp4',
	'webm' => 'video/webm',
	'mpeg' => 'video/mpeg',
	'bmp' => 'image/bmp',
	'gif' => 'image/gif',
	'jpeg' => 'image/jpeg',
	'jpg' => 'image/jpeg',
	'jpe' => 'image/jpeg',
	'png' => 'image/png',
	'tiff' => 'image/tiff',
	'tif' => 'image/tiff',
	'css' => 'text/css',
	'html' => 'text/html',
	'htm' => 'text/html',
	'php' => 'text/html',
	'php4' => 'text/html',
	'phtml' => 'text/html',
	'tpl' => 'text/html',
	'txt' => 'text/plain',
	'log' => 'text/plain'
	);
	$type = $types_array[$ext];
	if (empty($type)) $type = 'application/octet-stream';
	return ($type);
}
//------------------------------------------------------------
function fmGetExtByType($type) {
	$ext_array = array(
	'application/octet-stream' => 'bin',
	'application/msword' => 'doc',
	'application/pdf' => 'pdf',
	'application/vnd.ms-excel' => 'xls',
	'application/vnd.ms-powerpoint' => 'ppt',
	'application/x-javascript' => 'js',
	'application/xml' => 'xml',
	'application/xsl' => 'xsl',
	'application/zip' => 'zip',
	'application/rar' => 'rar',
	'audio/basic' => 'au',
	'audio/mpeg' => 'mp3',
	'audio/x-mpegurl' => 'm3u',
	'audio/x-pn-realaudio' => 'ram',
	'application/vnd.rn-realmedia' => 'rm',
	'audio/x-mpegurl' => 'm3u',
	'audio/x-wav' => 'wav',
	'audio/ogg' => 'ogg',
	'video/x-msvideo' => 'avi',
	'video/mp4' => 'mp4',
	'video/webm' => 'webm',
	'video/mpeg' => 'mpeg',
	'image/bmp' => 'bmp',
	'image/gif' => 'gif',
	'image/jpeg' => 'jpg',
	'image/png' => 'png',
	'image/tiff' => 'tif',
	'text/css' => 'css',
	'text/html' => 'html',
	'text/plain' => 'txt'
	);
	$ext = $ext_array[$type];
	if (empty($ext)) $ext = 'bin';
	return ($ext);
}
//------------------------------------------------------------
// validation of FILE DIR
function fmValidateNameAttr($action = 'create', $in_var) {
	global $SYS_WARN_MSG, $SYS_WARN_MSG;
	$valid = 0;
	$error_msg = '';
	$warning_msg= '';
	if (!$in_var['name_new'] || !$in_var['attr']) {
		$error_msg .= $SYS_WARN_MSG['not_all_mandatory'];
	} else {
		preg_match('/[\w\-\.\/\ ]*/', $in_var['name_new'], $name_validate);
		//print_r($name_validate);
		if ($name_validate[0] != $in_var['name_new'])
			$error_msg .= $SYS_WARN_MSG['f_name_accept'];
		if (!preg_match('/0[0-7]{3}/', $in_var['attr']))
			$error_msg .= $SYS_WARN_MSG['a_wrong'];
		if ($action == 'edit' && !$in_var['name_new'])
			$error_msg .= $SYS_WARN_MSG['f_name_empty'];
		if (!$error_msg)
			$valid = 1;
	}
	return (array('valid' => $valid, 'warning_msg' => $warning_msg, 'error_msg' => $error_msg));
}
?>
