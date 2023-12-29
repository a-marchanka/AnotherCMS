<?php
/* ==================================================== ##
##             COPYRIGHTS © Another CMS PHP TEAM        ##
## ==================================================== ##
## PRODUCT : CMS(CONTENT MANAGEMENT SYSTEM)             ##
## LICENSE : GNU(General Public License v.3)            ##
## TECHNOLOGIES : PHP & Sqlite                          ##
## WWW : www.zapms.de | www.marchenko.de                ##
## E-MAIL : andrey@marchenko.de                         ##
## ==================================================== */

//------------------------------------------------------------
// Additional functions
function assignArray($array_var, $array_name = 'array_list', $strip_slash = 1, $success = 0) {
	global $smarty;
	if (isset($request_var)) {
	if ($strip_slash) {
		while (list($vari, $parami) = each($array_var)) {
			if (is_array($parami)) {
			while (list($varj, $paramj) = each($parami)) {
				$array_var[$vari][$varj] = stripslashes($array_var[$vari][$varj]);
			} }
		}
	} }
	//print_r($array_var);
	$smarty->assign($array_name, $array_var);
	$smarty->assign('success', $success);
}
//------------------------------------------------------------
// html replace
function htmlEncode($str) {
	$search = array('&', '<', '>', "\'", "'", '\"', '"', 'Ä', 'ä', 'Ö', 'ö', 'Ü', 'ü', 'ß');
	$replace = array('&amp;', '&lt;', '&gt;', '\&#039;', '&#039;', '\&quot;', '&quot;', '&Auml;', '&auml;', '&Ouml;', '&ouml;', '&Uuml;', '&uuml;', '&szlig;');
	return (str_replace($search, $replace, $str));
}
//------------------------------------------------------------
// html decode
function htmlDecode($str) {
	$search = array(' /&gt;', '&amp;', '&lt;', '&gt;', '&#039;', '&acute;', '&quot;', '&Auml;', '&auml;', '&Ouml;', '&ouml;', '&Uuml;', '&uuml;', '&szlig;');
	$replace = array( ' >', '&', '<', '>', "&#039;", "&#039;", '"', 'Ä', 'ä', 'Ö', 'ö', 'Ü', 'ü', 'ß');
	return (str_replace($search, $replace, $str));
}
//------------------------------------------------------------
// code replace
function codeEncode($str) {
	$search = array('<', '>', "'", '"');
	$replace = array('&lt;', '&gt;', '&#039;', '&quot;');
	return (str_replace($search, $replace, $str));
}
//------------------------------------------------------------
// code decode used in fm
function codeDecode($str) {
	$search = array('&lt;', '&gt;', '&#039;', '&quot;');
	$replace = array('<', '>', "'", '"');
	return (str_replace($search, $replace, $str));
}
//------------------------------------------------------------
function trimRequestValues($request_var, $replace = 1, $method = 1) {
	// 1-keine/2-POST/0-GET
	global $_POST, $_GET;
	if (isset($request_var)) {
	foreach ($request_var as $var => $param) {
		if(isset($_GET[$var]) && $method==0)
			$request_var[$var] = stripslashes(($replace) ? (htmlEncode(trim($_GET[$var]))) : (trim($_GET[$var])));
		else if(isset($_POST[$var]) && $method==2)
			$request_var[$var] = stripslashes(($replace) ? (htmlEncode(trim($_POST[$var]))) : (trim($_POST[$var])));
		else {
			$request_var[$var] = stripslashes(
			($replace) ? 
			(htmlEncode
			(trim( (isset($_POST[$var]) && !is_array($_POST[$var]) ) ? ($_POST[$var]) : ( (isset($_GET[$var]) && !is_array($_GET[$var]) ) ? ($_GET[$var]) : (''))
			))) :
			(trim( (isset($_POST[$var]) && !is_array($_POST[$var]) ) ? ($_POST[$var]) : ( (isset($_GET[$var]) && !is_array($_GET[$var]) ) ? ($_GET[$var]) : (''))
			)));
		}
	} }
	return $request_var;
} 
//------------------------------------------------------------
function implodeRequestValues($request_var) {
	$result = '';
	foreach ($request_var as $key => $val)
		if ($val) $result .= $key.'='.$val.'&';
	return (substr($result, 0, -1));
}
//------------------------------------------------------------
function explodeRequestValues($request_s, $separator='&') {
	$result = array();
	$request_array = explode($separator, $request_s);
	$i = 0;
	while ($i < count($request_array)) {
		$pair = preg_split('/=/', $request_array[$i]);
		if ($pair[0]) {
			$key = trim($pair[0]);
			$result[$key] = trim($pair[1]);
		}
		$i++;
	}
	return ($result);
}
//------------------------------------------------------------
function explodeVariables($request_s) {
	$result = array();
	if ($request_s) {
		$request_array = explode(';', $request_s);
		$i = 0;
		while ($i < count($request_array)) {
			if ($request_array[$i]) {
			$pair = preg_split('/=/', trim($request_array[$i]));
			$key = $pair[0];
			$result[$key] = $pair[1];
			}
			$i++;
		}
	}
	return ($result);
}
//------------------------------------------------------------
function isValidEmail($sender_mail) {
	return (preg_match('/^([a-z0-9]+([-_\.]?[a-z0-9])+)@[a-z0-9äöü]+([-_\.]?[a-z0-9äöü])+\.[a-z]{2,4}$/i', $sender_mail))?(1):(0);
}
//------------------------------------------------------------
function emailToUnicode($content) {
	$mail_pattern = '/mailto:[^\"]*/';
	preg_match_all($mail_pattern, $content, $found);
	$patterns = $found[0];
	$replacements = $found[0];
	for ($i = 0; $i < sizeof($patterns); $i++) {
		$str_unicode = '';
		for ($j = 0; $j < strlen($patterns[$i]); $j++)
			$str_unicode .= '&#'.ord($patterns[$i][$j]).';';
		$replacements[$i] = $str_unicode;
		//print ($replacements[$i].'<br>');
	}
	return (str_replace($patterns, $replacements, $content));
}
//------------------------------------------------------------
function linkToLytebox($content, $title='') {
	$img_pattern = '/<img src=(\'|")(.*?)content\/images\/thumbs\/(.*?).(bmp|gif|jpeg|jpg|png)(\'|")(.*?) \/>/i';
	$replacement = '<a class="lytebox" data-lyte-options="group:gal" data-title="'.($title?$title:'$3').'" href="$2content/images/$3.$4"><img class="" src="$2content/images/thumbs/$3.$4" $6 ></a>';
	return (preg_replace($img_pattern, $replacement, $content));
}
//------------------------------------------------------------
function getContentFromPath($content_path) {
	$content = 'file not found';
	if (file_exists($content_path)) {
		$content = '';
		$fd = fopen($content_path, 'r');
		while (!feof($fd)) $content .= fgets($fd, 4096);
		fclose($fd);
	}
	return ($content);
}
//------------------------------------------------------------
function putContentToPath($content_path, $content) {
	if (file_exists($content_path)) {
		$fd = fopen($content_path, 'w');
		if (fwrite($fd, $content) === FALSE) {
			fclose($fd);
			return false;
		}
		fclose($fd);
		return (true);
	} else
		return (false);
}
//------------------------------------------------------------
function replaceContentWithValues($content, $vars_array) {
	$search = array();
	$replace = array();
	$count = 0;
	foreach ($vars_array as $k => $v) {
		$count ++;
		$search = array_pad($search, $count, '{$'.$k.'}');
		if (strpos($k, 'time') !== false)
			$v = date("d.m.Y", (int)$v);
		$replace = array_pad($replace, $count, $v);
	}
	return (str_replace($search, $replace, $content));
}
//------------------------------------------------------------
function buildReference($vars_array, $name='', $surname='', $title='', $reference='') {
	$success = 0;
	if ($reference != '---' && $reference) {
		if ($reference == $vars_array['mr_id'] && $surname) $reference = $vars_array['mr_ref'].' '.$title.' '.$surname;
		if ($reference == $vars_array['ms_id'] && $surname) $reference = $vars_array['ms_ref'].' '.$title.' '.$surname;
	} else if ($name && $surname)
		$reference = $name.' '.$surname;
	else
		$reference = '';
	return ($reference);
}
//------------------------------------------------------------
function convertDateToTime($date) {
	return (($date) ? (mktime(substr($date,11,2), substr($date,14,2), 0, substr($date,3,2), substr($date,0,2), substr($date,6,4))) : (0));
}
//------------------------------------------------------------
function exportCSV($data, $filename = 'export', $chr_set = 'UTF-8', $csv_separator = ';') {
	$csv_separator = ($csv_separator)?(trim($csv_separator)):(';');
	header('Content-type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.$filename.'.csv"');
	header('Content-Transfer-Encoding: binary');
	foreach ($data[0] as $k => $v) {
		echo iconv('UTF-8', $chr_set, '"'.$k.'"'.$csv_separator);
	}
	echo "\n";
	foreach ($data as $k => $v) {
		foreach ($v as $ki => $vi) {
			if (is_array($vi)) echo iconv('UTF-8', $chr_set, '"--"'.$csv_separator);
			else echo iconv('UTF-8', $chr_set, '"'.str_replace('"','',htmlDecode($vi)).'"'.$csv_separator);
		}
		echo "\n";
	}
	return (1);
}
//------------------------------------------------------------
function genPin($plength = 6) {
	$keylist = 'aAbBcCdDeEfFgGhHijJkKLmMnNoOpPqQrRsStTuUvVwWxXyYzZ_-!|123456789_-!|';
	$pass = '';
	for ($i = 1; $i <= $plength; $i++)
		$pass .= substr($keylist, rand(0,strlen($keylist)-1), 1);
	return ($pass);
}
//------------------------------------------------------------
function pagerGetInfo($page = 1, $total = 1, $limit = 1) {
	$pager_info = array();
	if (!$page || $page <= 0) $page = 1;
	if (!$total || $total <= 0) $total = 1;
	if ($page > $total) $page = $total;
	$pages = ($limit) ? (ceil($total/$limit)) : (1);
	$start = ($page - 1) * $limit;
	// collect
	$pager_info['page'] = $page;
	$pager_info['pages'] = $pages;
	$pager_info['total'] = $total;
	$pager_info['start'] = $start;
	$pager_info['limit'] = $limit;
	return ($pager_info);
}
?>
