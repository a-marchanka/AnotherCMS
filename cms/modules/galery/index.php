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

$in_var = array('id' => '', 'priority' => '', 'menu_id' => '', 'status' => '', 'filepath' => '', 'filename' => '', 'alttext' => '',
		'width' => '', 'height' => '', 'rotation' => '', 'crop' => '', 'meta_who' => '', 'meta_where' => '', 'shoottime' => '', 'modifytime' => '', 'createnick' => '',
		'field_name' => '', 'field_url' => '', 'src_type' => '' // for js browser
		);
$in_var = trimRequestValues($in_var);

$search_var = array('sort' => '', 'menu_id' => '', 'filter' => '', 'viewer' => '', 'page' => '');

$sort_list = array(
	'0' => array('id' => 'up_menu_id', 'title' => $SYS_WARN_MSG['webpage'].' &uarr;'),
	'1' => array('id' => 'dw_menu_id', 'title' => $SYS_WARN_MSG['webpage'].' &darr;'),
	'2' => array('id' => 'up_status', 'title' => $SYS_WARN_MSG['status'].' &uarr;'),
	'3' => array('id' => 'dw_status', 'title' => $SYS_WARN_MSG['status'].' &darr;'),
	'4' => array('id' => 'up_shoottime', 'title' => $SYS_WARN_MSG['date'].' &uarr;'),
	'5' => array('id' => 'dw_shoottime', 'title' => $SYS_WARN_MSG['date'].' &darr;')
	);
assignArray($sort_list, 'sort_list');

$success = 0;
$in_db_var = array();
$out_var = array();
// image
$path_img_user  = $site_dir.$usr_img;
$path_img_orig = $path_img_user.'originals/';
$path_img_thmb = $path_img_user.'thumbs/';
// audio
$path_usr_aud  = $site_dir.$usr_aud;
// video
$path_usr_vid  = $site_dir.$usr_vid;
// assign module variables
$smarty->assign('user_img', $usr_img);
$smarty->assign('user_aud', $usr_aud);
$smarty->assign('user_vid', $usr_vid);

// GET CONFIG DATA
$img_items = (!empty($img_items)&&is_numeric($img_items)) ? ($img_items) : (100);
$img_quality = (!empty($img_quality)&&is_numeric($img_quality)) ? ($img_quality) : (86);

// img_status - status_list
$tmp = explode(';', htmlDecode($img_status));
for ($i=0; $i<sizeof($tmp); $i++) {
	$tmp_var = explode('=', $tmp[$i]);
	$img_status_array[$i] = array('id' => trim($tmp_var[0]), 'title' => trim($tmp_var[1]));
}
assignArray($img_status_array, 'status_list');

// img_prop - prop_list
$tmp = explode(';', htmlDecode($img_prop));
for ($i=0; $i<sizeof($tmp); $i++) {
	$tmp_var = explode('=', $tmp[$i]);
	$img_prop_array[$i] = array('id' => trim($tmp_var[0]), 'title' => trim($tmp_var[1]));
}
assignArray($img_prop_array, 'prop_list');

include 'modules/menu/func_menu.php';
assignArray(menuGetAll(DB_PREFIX, $db_link), 'search_list');

// db functions
include 'modules/galery/func_galery.php';

// fm functions
include 'modules/fm/func_fm.php';

switch ($action) {
case 'delete':
	if ($details_id) {
		$details = galeryGetInfo(DB_PREFIX, $db_link, $details_id);
		// delete files
		if ($details['filepath'] == $usr_img) {
			fmDeleteFile($site_dir.$details['filepath'].$details['filename']);
			fmDeleteFile($site_dir.$details['filepath'].'originals/'.$details['filename']);
			fmDeleteFile($site_dir.$details['filepath'].'thumbs/'.$details['filename']);
		}
		if ($details['filepath'] == $usr_vid || $details['filepath'] == $usr_aud) {
			fmDeleteFile($site_dir.$details['filepath'].$details['filename']);
		}
		// delete from db
		if (galeryDelete(DB_PREFIX, $db_link, $details_id))
			$warning_msg .= $SYS_WARN_MSG['f_deleted'].': '.$details['filename'];
		else
			$error_msg .= $SYS_WARN_MSG['f_notdeleted'].': '.$details['filename'];
	}
	$action = 'list';
//------------------------------------------------------------
case 'list':
	if ($subaction == 'browser_src') {
		include 'inc_galery_list.php';
		// assign
		assignArray($in_var, 'details');
		$smarty->assign('site_url', $site_url);
		$smarty->assign('site_title', $site_title);
		$smarty->assign('entry_id', $entry_id);
		$smarty->assign('sid', $sid);
		$tpl = 'galery_browser_src.tpl';
		$view_mode = 2;
	} elseif ($subaction == 'browser') {
		include 'inc_galery_list.php';
		// assign
		assignArray($in_var, 'details');
		$smarty->assign('cms_theme', $cms_theme);
		$smarty->assign('site_url', $site_url);
		$smarty->assign('site_title', $site_title);
		$smarty->assign('entry_id', $entry_id);
		$smarty->assign('sid', $sid);
		$tpl = 'galery_browser_mceedit.tpl';
		$view_mode = 2;
	} elseif ($subaction == 'list_js_img') {
		$list_js = '';
		//take a list
		$out_var = galeryGetImagesList(DB_PREFIX, $db_link);
		if ($out_var) {
			foreach ($out_var as $file_info) {
			$list_js .= '{"title":"'.$file_info['id'].': '.$file_info['filename'].'",';
			$list_js .= '"value":"'.$site_url.'/'.$file_info['filepath'].$file_info['filename'].'"},';
			}
			$list_js = '['.substr($list_js, 0, -1).']';
		} else
			$list_js = '[{"title":"Error 404", "value":"'.$site_url.'/cms/images/404.png"}]';
		// assign
		header('Content-type: text/javascript');
		header('pragma: no-cache');
		echo $list_js;
		unset($list_js);
		$tpl = 'core_empty.tpl';
		$view_mode = 2;
	} else {
		// clean-up deleted menu
		if (galeryCleanUp(DB_PREFIX, $db_link)) $warning_msg .= $SYS_WARN_MSG['cleanup'];
		// list
		include 'inc_galery_list.php';
		$view_mode = 1;
	}
break;
//------------------------------------------------------------
case 'details':
	// DISPLAY UPLOAD FORM
	if ($subaction == 'upload') {
		$search_s = $cfg_profile['img_sort'];
		$search_var = explodeRequestValues($search_s);
		$details['menu_id'] = (isset($search_var['menu_id']))?($search_var['menu_id']):(0);
		$details['status'] = 2;
		// ASSIGN
		assignArray($details, 'details');
		$tpl = 'galery_details_upload.tpl';
		$view_mode = 1;
		$action = 'list';
	}
	// DISPLAY MEDIA INFO
	if ($subaction == 'media') {
		$details = galeryGetInfo(DB_PREFIX, $db_link, $details_id);
		// ASSIGN
		assignArray($details, 'details');
		unset($details);
		$tpl = 'galery_details.tpl';
		$view_mode = 1;
		$action = 'list';
	}
	// DISPLAY PREVIEW
	if ($subaction == 'preview') {
		$file_name = $in_var['filename'];
		$ext = galeryGetNameExt($file_name);
		// show preview
		include 'inc_details_preview.php';
		$tpl = 'core_log.tpl';
		$view_mode = 2;
	}
break;
//------------------------------------------------------------
case 'create':
	$name_ok = 0;
	$u_attr = array();
	$u_in_name = '';
	$u_ext = '';
	$u_name = '';
	$img_rotation = 0;
	$rotation_matrix = array(1=>0, 2=>0, 3=>180, 4=>180, 5=>270, 6=>270, 7=>90, 8=>90);
	// UPLOAD
	if ($subaction == 'upload' || $subaction == 'upload_close') {
		$cnt = sizeof($_FILES['file']['error']);
		if ($cnt) {
		// loop files
		for ($i = 0; $i < $cnt; $i++) {
			if ($_FILES['file']['error'][$i] == 0) {
				// validate file
				$u_in_name = strtolower(htmlDecode(trim($_FILES['file']['name'][$i])));
				// media type
				$u_attr = fmGetNameExt($u_in_name);
				$u_name = $u_attr['name'];
				$u_ext = $u_attr['ext'];
				// verify name
				if ($u_name && strlen($u_name) > 2) {
					$name_ok = 1;
					$u_name = preg_replace("/[^a-zA-Z0-9]/", '_', $u_name).'.'.$u_ext;
				} else
					$error_msg .= $SYS_WARN_MSG['not_all_mandatory'];
				// extensions
				if ($u_ext != 'png' && $u_ext != 'jpg' && $u_ext != 'gif' && $u_ext != 'jpeg' &&
				    $u_ext != 'webm' && $u_ext != 'mp4' && $u_ext != 'mpg' && $u_ext != 'mov' && $u_ext != 'ogg' && $u_ext != 'mp3' && $u_ext != 'm4a') {
					$name_ok = 0;
					$error_msg .= $SYS_WARN_MSG['f_name_ext'];
				}
				// image
				if ($name_ok && ($u_ext == 'png' || $u_ext == 'jpg' || $u_ext == 'gif' || $u_ext == 'jpeg')) {
				// iphone hack
				if ($u_name == 'image.jpg') $u_name = date('Ymdhms',time()).'.jpg';
				// upload original
				if (fmUploadFile($_FILES['file']['tmp_name'][$i], $path_img_orig.$u_name)) {
					if ($warning_msg) $warning_msg .= '<br />';
					$warning_msg .= $u_name.': '.$SYS_WARN_MSG['f_uploaded'];
					$thumb_attr = array();
					$image_attr = array();
					// get exif
					$exif = ($u_ext == 'jpg' || $u_ext == 'jpeg') ?
						(exif_read_data($path_img_orig.$u_name, 'FILE,IFD0,COMMENT,EXIF', true)) : (false);
					// complete attributes
					$in_var['createnick'] = $user_info['nick'];
					$in_var['filename'] = $u_name;
					$in_var['filepath'] = $usr_img;
					// exif attributes
					$in_var['shoottime'] = ($exif===false) ? (time()) : ( isset($exif['EXIF']['DateTimeOriginal'])?(strtotime($exif['EXIF']['DateTimeOriginal'])):time() );
					// autorotation
					$exif_orientation = ($exif===false) ? (1) : ( isset($exif['IFD0']['Orientation'])?($exif['IFD0']['Orientation']):1 );
					$img_rotation = $rotation_matrix[$exif_orientation];
					$in_var['rotation'] = $img_rotation;
					// create thumb and image
					$thumb_attr = galeryCreateThumb($path_img_orig.$u_name, $path_img_thmb.$u_name, $u_ext, $img_quality, $img_rotation);
					$image_attr = galeryCreateImage($path_img_orig.$u_name, $path_img_user.$u_name, $u_ext, $in_var['width'], $img_watermark, $img_quality, $img_rotation, $in_var['crop']);
					// complete attributes
					$in_var['width'] = $image_attr['width'];
					$in_var['height'] = $image_attr['height'];
					// finish
					$validate_array = galeryValidateUpload($action);
					if ($validate_array['valid']) {
						// add info
						$details_id = galeryInsert(DB_PREFIX, $db_link, $in_db_var);
						if ($details_id) {
							if ($warning_msg) $warning_msg .= '<br />';
							$warning_msg .= $SYS_WARN_MSG['created'];
							$success = ($subaction == 'upload_close')?(2):(1);
						} else {
							if ($error_msg) $error_msg .= '<br />';
							$error_msg .= $u_name.': '.$SYS_WARN_MSG['notcreated'];
						}
					} else {
						if ($error_msg) $error_msg .= '<br />';
						$error_msg .= $u_name.': '.$validate_array['error_msg'];
					}
				} else {
					if ($error_msg) $error_msg .= '<br />';
					$error_msg .= $u_name.': '.$SYS_WARN_MSG['f_notuploaded'];
				}
				} // end of image

				// video
				if ($name_ok && ($u_ext == 'webm' || $u_ext == 'mp4' || $u_ext == 'mov' || $u_ext == 'mpg')) {
				if (fmUploadFile($_FILES['file']['tmp_name'][$i], $path_usr_vid.$u_name)) {
					if ($warning_msg) $warning_msg .= '<br />';
					$warning_msg .= $u_name.': '.$SYS_WARN_MSG['f_uploaded'];
					// complete attributes
					$in_var['filename'] = $u_name;
					$in_var['filepath'] = $usr_vid; // video
					$in_var['width'] = 1;
					$in_var['height'] = 1;
					$in_var['shoottime'] = time();
					// finish
					$validate_array = galeryValidateUpload($action);
					if ($validate_array['valid']) {
						// add info
						$details_id = galeryInsert(DB_PREFIX, $db_link, $in_db_var);
						if ($details_id) {
							if ($warning_msg) $warning_msg .= '<br />';
							$warning_msg .= $SYS_WARN_MSG['created'];
							$success = ($subaction == 'upload_close')?(2):(1);
						} else {
							if ($error_msg) $error_msg .= '<br />';
							$error_msg .= $u_name.': '.$SYS_WARN_MSG['notcreated'];
						}
					} else {
						if ($error_msg) $error_msg .= '<br />';
						$error_msg .= $u_name.': '.$validate_array['error_msg'];
					}
				}
				} // end of video

				// audio
				if ($name_ok && ($u_ext == 'wav' || $u_ext == 'ogg' || $u_ext == 'mp3' || $u_ext == 'm4a')) {
				if (fmUploadFile($_FILES['file']['tmp_name'][$i], $path_usr_aud.$u_name)) {
					if ($warning_msg) $warning_msg .= '<br />';
					$warning_msg .= $u_name.': '.$SYS_WARN_MSG['f_uploaded'];
					// complete attributes
					$in_var['filename'] = $u_name;
					$in_var['filepath'] = $usr_aud; // audio
					$in_var['width'] = 1;
					$in_var['height'] = 1;
					$in_var['shoottime'] = time();
					// finish
					$validate_array = galeryValidateUpload($action);
					if ($validate_array['valid']) {
						// add info
						$details_id = galeryInsert(DB_PREFIX, $db_link, $in_db_var);
						if ($details_id) {
							if ($warning_msg) $warning_msg .= '<br />';
							$warning_msg .= $SYS_WARN_MSG['created'];
							$success = ($subaction == 'upload_close')?(2):(1);
						} else {
							if ($error_msg) $error_msg .= '<br />';
							$error_msg .= $u_name.': '.$SYS_WARN_MSG['notcreated'];
						}
					} else {
						if ($error_msg) $error_msg .= '<br />';
						$error_msg .= $u_name.': '.$validate_array['error_msg'];
					}
				}
				} // end of audio
			} else {
				if ($_FILES['file']['error'][$i] == 1) $tmp_m = 'UPLOAD_ERR_INI_SIZE';
				if ($_FILES['file']['error'][$i] == 2) $tmp_m = 'UPLOAD_ERR_FORM_SIZE';
				if ($_FILES['file']['error'][$i] == 3) $tmp_m = 'UPLOAD_ERR_PARTIAL';
				if ($_FILES['file']['error'][$i] == 4) $tmp_m = 'UPLOAD_ERR_NO_FILE';
				if ($_FILES['file']['error'][$i] == 6) $tmp_m = 'UPLOAD_ERR_NO_TMP_DIR';
				if ($_FILES['file']['error'][$i] == 7) $tmp_m = 'UPLOAD_ERR_CANT_WRITE';
				if ($_FILES['file']['error'][$i] == 8) $tmp_m = 'UPLOAD_ERR_EXTENSION';
				if ($error_msg) $error_msg .= '<br />';
				$error_msg .= $u_name.': '.$SYS_WARN_MSG['f_notuploaded'].' '.$tmp_m.' ';
				unset($tmp_m);
			}
		}
		}
		if ($subaction == 'upload_close' && $success > 0)
			include 'inc_galery_list.php';
		else {
			$in_var['alttext'] = '';
			$in_var['meta_who'] = '';
			$in_var['meta_where'] = '';
			assignArray($in_var, 'details');
			$tpl = 'galery_details_upload.tpl';
		}
	}
	$view_mode = 1;
	$action = 'list';
break;
//------------------------------------------------------------
case 'edit':
	$u_attr = array();
	$u_ext = '';
	$u_name = '';
	// MODIFY
	if ($subaction == 'media' || $subaction == 'save_close') {
		$u_name = $in_var['filename'];
		$u_attr = fmGetNameExt($u_name);
		$u_ext = $u_attr['ext'];
		// image update
		if ($in_var['filepath'] == $usr_img) {
			// create thumb and image
			$thumb_attr = galeryCreateThumb($path_img_orig.$u_name, $path_img_thmb.$u_name, $u_ext, $img_quality, $in_var['rotation']);
			$image_attr = galeryCreateImage($path_img_orig.$u_name, $path_img_user.$u_name, $u_ext, $in_var['width'], $img_watermark, $img_quality, $in_var['rotation'], $in_var['crop']);
			// complete attributes
			$in_var['width'] = $image_attr['width'];
			$in_var['height'] = $image_attr['height'];
			// finish
			$validate_array = galeryValidateDetails();
			if ($validate_array['valid']) {
				if (galeryUpdate(DB_PREFIX, $db_link, $details_id, $in_db_var)) {
					$warning_msg .= $SYS_WARN_MSG['f_updated'].': '.$in_var['filename'];
					$success = ($subaction == 'save_close')?(2):(1);
				} else
					$error_msg .= $SYS_WARN_MSG['notupdated'].': '.$in_var['filename'];
			} else
				$error_msg .= $validate_array['error_msg'];
		}
		// video audio update
		if ($in_var['filepath'] == $usr_vid || $in_var['filepath'] == $usr_aud) {
			$in_var['width'] = 1;
			$in_var['height'] = 1;
			// finish
			$validate_array = galeryValidateDetails();
			if ($validate_array['valid']) {
				if (galeryUpdate(DB_PREFIX, $db_link, $details_id, $in_db_var)) {
					$warning_msg .= $SYS_WARN_MSG['f_updated'].': '.$in_var['filename'];
					$success = ($subaction == 'save_close')?(2):(1);
				} else
					$error_msg .= $SYS_WARN_MSG['notupdated'].': '.$in_var['filename'];
			} else
				$error_msg .= $validate_array['error_msg'];
		}
		if ($subaction == 'save_close' && $success > 0)
			include 'inc_galery_list.php';
		else {
			assignArray($in_var, 'details');
			$tpl = 'galery_details.tpl';
		}
	}
	$view_mode = 1;
	$action = 'list';
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
	$smarty->display((($tpl) ? ($tpl) : ('galery_details.tpl')));
} else {
	$right_frame = ($tpl) ? ($tpl) : ('galery_list.tpl');
}

// unset variables
unset($in_var);
unset($out_var);

?>
