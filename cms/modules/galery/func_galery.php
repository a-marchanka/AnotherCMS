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

function galeryGetInfo($db_prefix, $db_link, $filter_id = 0) {
	$sql_info = array();
	$result = 0;
	$sql = 'SELECT id, priority, menu_id, status, filepath, filename, alttext, width, height, rotation, crop, meta_who, meta_where, shoottime, modifytime, createnick
		FROM '.$db_prefix.'galery WHERE 1=1 AND id='.$filter_id.' ORDER BY 1';
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
function galeryGetByMenu($db_prefix, $db_link, $filter_id) {
	$sql_info = array();
	$count = 0;
	$sql_filter = 'WHERE 1=1';
	$sql_order = 'ORDER BY 1';
	if ($filter_id) $sql_filter .= ' AND menu_id='.$filter_id; // by menu id
	$sql = 'SELECT id, priority, menu_id, status, filepath, filename, alttext, width, height, rotation, crop, meta_who, meta_where, shoottime, modifytime, createnick
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
function galeryGetAll($db_prefix, $db_link, $search_var, $page_var) {
	$sql_info = array();
	$count = 0;
	$sql_filter = 'WHERE 1=1';
	$sql_limit = '';
	$sql_order = '';
	// search criteria
	// order
	if (isset($search_var['sort']))
	if ($search_var['sort'])
	$sql_order = ''.substr($search_var['sort'],3).((substr($search_var['sort'],0,2) == 'up') ? ' ASC, ' : ' DESC, ');
	// filter
	if (isset($search_var['filter']))
	if ($search_var['filter']) {
	$sql_filter .= ' AND (filename LIKE \'%'.$search_var['filter'].'%\' OR alttext LIKE \'%'.$search_var['filter'].'%\'';
	$sql_filter .= ' OR meta_who LIKE \'%'.$search_var['filter'].'%\' OR meta_where LIKE \'%'.$search_var['filter'].'%\' OR LOWER(createnick) LIKE \'%'.strtolower($search_var['filter']).'%\')'; }
	// menu
	if (isset($search_var['menu_id']))
	if ($search_var['menu_id'])
	$sql_filter .= ' AND menu_id='.$search_var['menu_id'];
	// limit
	if (isset($page_var['start']))
	$sql_limit = 'LIMIT '.$page_var['start'].','.$page_var['limit'];

	// combine
	if ($sql_order) $sql_order = 'ORDER BY '.$sql_order.' priority DESC';
	else		$sql_order = 'ORDER BY menu_id, priority';

	$sql = 'SELECT id, priority, menu_id, status, filepath, filename, alttext, width, height, rotation, crop, meta_who, meta_where, shoottime, modifytime, createnick
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
//------------------------------------------------------------
function galeryGetImagesList($db_prefix, $db_link) {
	$sql_info = array();
	$count = 0;
	$sql = 'SELECT id, priority, menu_id, filepath, filename, alttext, width, height, shoottime FROM '.$db_prefix.'galery
		WHERE status>0 AND (lower(filename) LIKE \'%.jp%\' OR lower(filename) LIKE \'%.png%\' OR lower(filename) LIKE \'%.gif%\') ORDER BY 1 DESC';
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
function galeryGetCount($db_prefix, $db_link, $search_var) {
	$result = 0;
	$cnt = 0;
	$sql_filter = 'WHERE 1=1';
	// search criteria
	// filter
	if (isset($search_var['filter']))
	if ($search_var['filter']) {
	$sql_filter .= ' AND (filename LIKE \'%'.$search_var['filter'].'%\' OR alttext LIKE \'%'.$search_var['filter'].'%\'';
	$sql_filter .= ' OR meta_who LIKE \'%'.$search_var['filter'].'%\' OR meta_where LIKE \'%'.$search_var['filter'].'%\' OR LOWER(createnick) LIKE \'%'.strtolower($search_var['filter']).'%\')'; }
	// menu
	if (isset($search_var['menu_id']))
	if ($search_var['menu_id'])
	$sql_filter .= ' AND menu_id='.$search_var['menu_id'];

	$sql = 'SELECT COUNT(id) AS cnt FROM '.$db_prefix.'galery '.$sql_filter;
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
function galeryCleanUp($db_prefix, $db_link) {
	$list = '';
	$sql = 'SELECT ga.id FROM '.$db_prefix.'galery ga LEFT JOIN '.$db_prefix.'menu mn ON ga.menu_id=mn.id WHERE ga.menu_id!=0 AND mn.id IS NULL';
	//echo $sql;
	$result = $db_link->query($sql) or 0;
	if ($result) {
		while ($row = $result->fetchArray(SQLITE3_ASSOC))
			$list .= $row['id'].', ';
		$list = substr($list, 0, -2);
		$result->finalize();
	}
	if ($list) {
		$sql = 'UPDATE '.$db_prefix.'galery SET menu_id=0 WHERE id IN ('.$list.')';
		//echo $sql;
		$result = $db_link->exec($sql) or 0;
	}
	return ($list);
}
//------------------------------------------------------------
function galeryUpdate($db_prefix, $db_link, $filter_id = 0, $array_db) {
	$sql = 'UPDATE '.$db_prefix.'galery SET ';
	foreach ($array_db as $var => $param) {
		$sql .= $var.'='.$param.', ';
	}
	$sql = substr($sql, 0, -2).' WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
function galeryInsert($db_prefix, $db_link, $array_db) {
	$sql_insert = 'INSERT INTO '.$db_prefix.'galery (';
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
function galeryDelete($db_prefix, $db_link, $filter_id = 0) {
	$sql = 'DELETE FROM '.$db_prefix.'galery WHERE id='.$filter_id;
	//print $sql;
	$result = $db_link->exec($sql) or 0;
	return ($result);
}
//------------------------------------------------------------
// validation of UPLOADED FILE
function galeryValidateUpload($action = 'create') {
	global $in_var, $in_db_var, $details_id, $SYS_WARN_MSG;
	$valid = 0;
	$error_msg = '';
	$warning_msg = '';

	if ($action == 'edit' && !$details_id)
		$error_msg .=  $SYS_WARN_MSG['action_wrong'];
	else {
		// PREPARING TO UPDATE
		$in_var['modifytime'] = time();
		if (!$in_var['status']) $in_var['status'] = 0;
		if (!$in_var['menu_id']) $in_var['menu_id'] = 0;
		if (!$in_var['rotation']) $in_var['rotation'] = 0;
		if (!$in_var['crop']) $in_var['crop'] = 0;
		$in_db_var['priority'] = $in_var['priority'];
		$in_db_var['filename'] = '\''.$in_var['filename'].'\'';
		$in_db_var['filepath'] = '\''.$in_var['filepath'].'\'';
		$in_db_var['alttext'] = '\''.$in_var['alttext'].'\'';
		$in_db_var['meta_who'] = '\''.$in_var['meta_who'].'\'';
		$in_db_var['meta_where'] = '\''.$in_var['meta_where'].'\'';
		$in_db_var['width'] = $in_var['width'];
		$in_db_var['height'] = $in_var['height'];
		$in_db_var['rotation'] = $in_var['rotation'];
		$in_db_var['crop'] = $in_var['crop'];
		$in_db_var['status'] = $in_var['status'];
		$in_db_var['menu_id'] = $in_var['menu_id'];
		$in_db_var['shoottime'] = $in_var['shoottime'];
		$in_db_var['modifytime'] = $in_var['modifytime'];
		$in_db_var['createnick'] = '\''.$in_var['createnick'].'\'';
		$valid = 1;
	}
	//print_r($in_var);
	//print_r($in_db_var);
	return (array('valid' => $valid, 'warning_msg' => $warning_msg, 'error_msg' => $error_msg));
}
//------------------------------------------------------------
// validation of DETAILS
function galeryValidateDetails($action = 'create') {
	global $in_var, $in_db_var, $details_id, $SYS_WARN_MSG;
	$valid = 0;
	$error_msg = '';
	$warning_msg= '';
	// verify
	if ($action == 'edit' && !$details_id)
		$error_msg .=  $SYS_WARN_MSG['action_wrong'];
	else {
		$in_var['modifytime'] = time();
		if (!$in_var['status']) $in_var['status'] = 0;
		if (!$in_var['menu_id']) $in_var['menu_id'] = 0;
		if (!$in_var['rotation']) $in_var['rotation'] = 0;
		if (!$in_var['crop']) $in_var['crop'] = 0;
		// convert time
		$tmp_date = $in_var['shoottime'];
		$tmp_day = substr($tmp_date,0,2);
		$tmp_month = substr($tmp_date,3,2);
		$tmp_year = substr($tmp_date,6,4);
		$tmp_time = mktime(0, 0, 0, $tmp_month, $tmp_day, $tmp_year);
		$in_var['shoottime'] = $tmp_time;
		$in_db_var['priority'] = $in_var['priority'];
		$in_db_var['filename'] = '\''.$in_var['filename'].'\'';
		$in_db_var['filepath'] = '\''.$in_var['filepath'].'\'';
		$in_db_var['alttext'] = '\''.$in_var['alttext'].'\'';
		$in_db_var['meta_who'] = '\''.$in_var['meta_who'].'\'';
		$in_db_var['meta_where'] = '\''.$in_var['meta_where'].'\'';
		$in_db_var['width'] = $in_var['width'];
		$in_db_var['height'] = $in_var['height'];
		$in_db_var['rotation'] = $in_var['rotation'];
		$in_db_var['crop'] = $in_var['crop'];
		$in_db_var['status'] = $in_var['status'];
		$in_db_var['menu_id'] = $in_var['menu_id'];
		$in_db_var['shoottime'] = $in_var['shoottime'];
		$in_db_var['modifytime'] = $in_var['modifytime'];
		$in_db_var['createnick'] = '\''.$in_var['createnick'].'\'';
		$valid = 1;
	}
	//print_r($in_var);
	//print_r($in_db_var);
	return (array('valid' => $valid, 'warning_msg' => $warning_msg, 'error_msg' => $error_msg));
}
//------------------------------------------------------------
function galeryCreateThumb($img_src_path, $thumb_path, $ext, $img_quality = 90, $rotation = 0) {
	$width_trg = 95; // maximum x aperture  in pixels
	$height_trg = 95; // maximum y aperture in pixels
	$ratio = 0;
	// get properties
	$size_src = getimagesize($img_src_path);
	// create image
	if ($size_src[1] < $size_src[0]) {
		$ratio = $height_trg/$size_src[1];
		$semi_x = floor($size_src[0]*$ratio);
		$semi_y = $height_trg;
	} else {
		$ratio = $width_trg/$size_src[0];
		$semi_x = $width_trg;
		$semi_y = floor($size_src[1]*$ratio);
	}
	if ($ext == 'jpg' || $ext == 'jpeg')
		$img_src = imagecreatefromjpeg($img_src_path);
	else if ($ext == 'gif')
		$img_src = imagecreatefromgif($img_src_path);
	else if ($ext == 'png')
		$img_src = imagecreatefrompng($img_src_path);
	else $img_src = null;
	// create thumb
	$thumb = imagecreatetruecolor($width_trg, $height_trg);
	imagecopyresampled($thumb, $img_src, -($semi_x/2) + ($width_trg/2), -($semi_y/2) + ($height_trg/2), 0, 0, ($semi_x), ($semi_y), $size_src[0], $size_src[1]);
	// rotate
	if ($rotation > 0)
		$thumb = imagerotate($thumb, $rotation, 0);
	// save
	if ($ext == 'jpg' || $ext == 'jpeg') {
		imagejpeg($thumb, $thumb_path, $img_quality);
	} else if ($ext == 'gif') {
		imagegif($thumb, $thumb_path);
	} else if ($ext == 'png') {
		imagepng($thumb, $thumb_path);
	}
	imagedestroy($img_src);
	imagedestroy($thumb);
	return (array('width'=>$width_trg, 'height'=>$height_trg));
}
//------------------------------------------------------------
function galeryCreateImage($img_src_path, $img_dst_path, $ext, $size, $watermark = '', $img_quality = 90, $rotation = 0, $crop = 0) {
	// default value
	$height_src = 500;
        $width_src = 500;
	$height_trg = 500;
        $width_trg = 500;
	$x_src = 0;
	$y_src = 0;
	$x_trg = 0;
	$y_trg = 0;
	// get properties
	if (!is_numeric($size) || !$size) $size = 500;
	$size_src = getimagesize($img_src_path);
	$width_src = $size_src[0];
	$height_src = $size_src[1];
	$width_trg = ($size == 1)?($width_src):($size);
	$height_trg = ($size == 1)?($height_src):($size);
	// type
	if ($ext == 'jpg' || $ext == 'jpeg')
		$img_src = imagecreatefromjpeg($img_src_path);
	else if ($ext == 'gif')
		$img_src = imagecreatefromgif($img_src_path);
	else if ($ext == 'png')
		$img_src = imagecreatefrompng($img_src_path);
	else $img_src = null;
	// create image
	if ( ($height_src > $width_src && ($rotation == 0 || $rotation == 180)) || ($height_src < $width_src && ($rotation == 90 || $rotation == 270)) ) {
		if ($height_src/$width_src > $crop && $crop > 0) {
			$height_trg = floor($width_trg*$crop);
			$y_src = floor(($height_src - $height_src*$crop)/2);
			//$height_src = floor($height_src*$crop);
			$height_src = floor($height_src*$crop);
		} else
			$height_trg = floor($width_trg*$height_src/$width_src);
	} else {
		if ($width_src/$height_src > $crop && $crop > 0) {
			$width_trg = floor($height_trg*$crop);
			$x_src = floor(($width_src - $width_src*$crop)/2);
			$width_src = floor($width_src*$crop);
		} else
			$width_trg = floor($height_trg*$width_src/$height_src);
	}
	// create image
	$img_trg = imagecreatetruecolor($width_trg, $height_trg);
	// crop
	imagecopyresampled($img_trg, $img_src, $x_trg, $y_trg, $x_src, $y_src, $width_trg, $height_trg, $width_src, $height_src);	
	// rotate
	if ($rotation > 0)
		$img_trg = imagerotate($img_trg, $rotation, 0);
	// write text
	if ($watermark) {
		$text_color = imagecolorallocate ($img_trg, 200, 200, 200);
		imagestring($img_trg, 2, 10, $height_trg-20, $watermark, $text_color);
	}
	// save
	if ($ext == 'jpg' || $ext == 'jpeg')
		imagejpeg($img_trg, $img_dst_path, $img_quality);
	else if ($ext == 'gif')
		imagegif($img_trg, $img_dst_path);
	else if ($ext == 'png')
		imagepng($img_trg, $img_dst_path);
	// clear
	imagedestroy($img_src);
	imagedestroy($img_trg);
	return (array('width'=>$width_trg, 'height'=>$height_trg));
}
//------------------------------------------------------------
function galeryGetNameExt($f_name) {
	$dot_pos = strrpos($f_name, '.');
	$ext = ($dot_pos) ? (substr($f_name, $dot_pos + 1)) : ('');
       	return $ext;
}

?>
