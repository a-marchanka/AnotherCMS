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

$details_id = 1;

$in_var = array('dir' => '', 'dir_new' => '', 'name' => '', 'name_new' => '', 'ext' => '', 'attr' => '', 'replace' => '',
		'field_name' => '', 'field_url' => '', 'src_type' => '');
$in_var = trimRequestValues($in_var);

// INCLUDE FILE MANAGER
include 'modules/fm/func_fm.php';
$path_init = $site_dir.$fm_dir;
$path_curr = $in_var['dir'];
$path_new = $in_var['dir_new'];
$path_full = $path_init.$path_curr;
$path_full_new = $path_init.$path_new;
$path_array = array();
$files_list = array();

// Directory Verifying
preg_match('/[^\w\-\/\.\ ]|\.\./', $in_var['dir'], $dir_validate);
if (isset($dir_validate[0]) || !file_exists($path_full)) {
	$path_full = $path_init;
	$path_full_new = $path_init;
	$error_msg .= 'Wrong directory. ';
} else
	$path_array = fmGetPathArray($path_curr);

$success = 0;

$ext = $in_var['ext'];
$name = $in_var['name'];
$name_new = $in_var['name_new'];
$dir = $in_var['dir'];
$dir_new = $in_var['dir_new'];
$file_name = $name.(($ext) ? ('.'.$ext) : (''));
$file_name_new = $name_new.(($ext) ? ('.'.$ext) : (''));
$attr = $in_var['attr'];
$editor_content = '';

// ASSIGN
assignArray($path_array, 'path_array');
$smarty->assign('path_current', $path_curr);
// assign module variables
$smarty->assign('tinymce_css', $tinymce_css);

switch ($action) {
case 'delete':
	// DELETE DEIRECTORY
	if ($subaction == 'dir') {
		if (fmDeleteDir($path_full.$file_name)) {
			$warning_msg .= $SYS_WARN_MSG['d_deleted'];
			$success = 1;
		} else
			$error_msg .= $SYS_WARN_MSG['d_notempty'];
	}
	// DELETE FILE
	if ($subaction == 'file') {
		if (fmDeleteFile($path_full.$file_name)) {
			$warning_msg .= $SYS_WARN_MSG['f_deleted'];
			$success = 1;
		} else
			$error_msg .= $SYS_WARN_MSG['f_notdeleted'];
	}
	$action = 'list';
//------------------------------------------------------------
case 'list':
	if ($subaction == 'browser') {
		include 'inc_fm_list.php';
		// assign
		assignArray($in_var, 'details');
		$smarty->assign('cms_theme', $cms_theme);
		$smarty->assign('site_url', $site_url);
		$smarty->assign('site_title', $site_title);
		$smarty->assign('entry_id', $entry_id);
		$smarty->assign('fm_dir', $fm_dir);
		$smarty->assign('sid', $sid);
		$tpl = 'fm_browser_mceedit.tpl';
		$view_mode = 2;
	} elseif ($subaction == 'list_js_tpl') {
		$list_js = '';
		//take a list
		$files_list = fmGetFileList($site_dir.$usr_tpl, 'file', 'tpl');
		if ($files_list) {
			foreach ($files_list as $file_info) {
			$list_js .= '{"title":"'.$file_info['name'].'",';
			$list_js .= '"description":"'.$file_info['name'].'",';
			$list_js .= '"url":"'.$site_url.'/'.$usr_tpl.$file_info['name'].'.'.$file_info['ext'].'"},';
			}
			$list_js = '['.substr($list_js, 0, -1).']';
		}
		// assign
		header('Content-type: text/javascript');
		header('pragma: no-cache');
		echo $list_js;
		unset($list_js);
		$tpl = 'core_empty.tpl';
		$view_mode = 2;
	} else {
		include 'inc_fm_list.php';
		$view_mode = 1;
	}
break;
//------------------------------------------------------------
case 'details':
	// FILE / DIR / DETAILS
	if ($subaction == 'dir' || $subaction == 'file') {
		$in_var['attr'] = fmGetAttribute($path_full.$file_name);
		$in_var['name_new'] = $name;
		// ASSIGN
		assignArray($in_var, 'details');
		$tpl = ($subaction == 'dir') ? ('fm_details_dir.tpl') : ('fm_details_file.tpl');
		$view_mode = 1;
		$action = 'list';
	}
	// FILE COPY
	if ($subaction == 'copy') {
		$in_var['attr'] = fmGetAttribute($path_full.$file_name);
		$in_var['name_new'] = $name.'_copy';
		$in_var['dir_new'] = $dir;
		// ASSIGN
		assignArray($in_var, 'details');
		$tpl = 'fm_details_copy.tpl';
		$view_mode = 1;
		$action = 'list';
	}
	// UPLOAD
	if ($subaction == 'upload') {
		// ASSIGN
		assignArray($in_var, 'details');
		$tpl = 'fm_details_upload.tpl';
		$view_mode = 1;
		$action = 'list';
	}
	// DOWNLOAD DOCUMENT
	if ($subaction == 'download') {
		$file_type = fmGetTypeByExt($ext);
		$file_content = fmGetContent($path_full.$file_name);
		if ($file_content) {
			header('Content-type: '.$file_type);
			header('Content-Disposition: attachment; filename="'.$file_name.'"');
			echo $file_content;
			// ASSIGN
			$success = 1;
			$tpl = 'core_empty.tpl';
			$view_mode = 2;
		} else $error_msg .= $SYS_WARN_MSG['f_notdownloaded'];
	}
	// DISPLAY PREVIEW
	if ($subaction == 'preview') {
		// show preview
		include 'inc_details_preview.php';
		$tpl = 'core_log.tpl';
		$view_mode = 2;
	}
	// DISPLAY DOCUMENT
	if ($subaction == 'mceedit' || $subaction == 'txtedit') {
		if ($name) {
			$in_var['name_new'] = $name;
			$editor_content = fmGetContent($path_full.$file_name);
			if ($in_var['ext'] == 'php' || $in_var['ext'] == 'js') // could be a problem with saving
				if (strpos($editor_content,'&#')) $error_msg .= $SYS_WARN_MSG['f_special_warn'];
		}
		// ASSIGN
		assignArray($in_var, 'details');
		$smarty->assign('editor_content', htmlEncode($editor_content)); // show and replace all htmls
		unset($editor_content);
		$tpl = ($subaction == 'mceedit') ? ('fm_details_mceedit.tpl') : ('fm_details_txtedit.tpl');
		$view_mode = 1;
		$action = 'list';
	}
	// UTILITIES
	if ($subaction == 'utils') {
		// ASSIGN
		assignArray($_SERVER, 'webclient');
		assignArray($in_var, 'details');
		$tpl = 'fm_details_utils.tpl';
		$view_mode = 1;
		$action = 'list';
	}
break;
//------------------------------------------------------------
case 'create':
	// DIRECTORY
	if ($subaction == 'dir' || $subaction == 'dir_close') {
		$validate_array = fmValidateNameAttr($action, $in_var);
		if ($validate_array['valid']) {
			if (fmMakeDir($path_full.$name_new)) {
				$warning_msg .= $SYS_WARN_MSG['d_created'];
				$success = ($subaction == 'dir_close')?(2):(1);
			} else
				$error_msg .= $SYS_WARN_MSG['d_notcreated'];
		} else
			$error_msg .= $validate_array['error_msg'];

		if ($success == 2)
			include 'inc_fm_list.php';
		else {
			assignArray($in_var, 'details');
			$tpl = 'fm_details_dir.tpl';
		}
	}
	// UPLOAD
	if ($subaction == 'upload' || $subaction == 'upload_close') {
		$success == 2;
		$cnt = sizeof($_FILES['file']['error']);
		if ($cnt) {
			// loop files
			for ($i = 0; $i < $cnt; $i++) {
				if ($_FILES['file']['error'][$i] == 0) {
					// validate
					$u_name = htmlDecode(trim($_FILES['file']['name'][$i]));
					preg_match('/[\w\-\.\/\ ]*/', $u_name, $name_validate);
					if ($name_validate[0] != $u_name) $error_msg .= $SYS_WARN_MSG['f_name_accept'];
					else if (!$u_name) $error_msg .= $SYS_WARN_MSG['not_all_mandatory'];
					// iphone hack
					if ($u_name == 'image.jpg') $u_name = date('Ymdhms',time()).'.jpg';
					// upload
					if (fmUploadFile($_FILES['file']['tmp_name'][$i], $path_full.$u_name, $in_var['replace'])) {
						if ($warning_msg) $warning_msg .= '<br />';
						$warning_msg .= $u_name.': '.$SYS_WARN_MSG['f_uploaded'];
						$success = ($subaction == 'upload_close')?(2):(1);
					} else {
						if ($error_msg) $error_msg .= '<br />';
						$error_msg .= $u_name.': '.$SYS_WARN_MSG['f_notuploaded'];
					}
				} else {
					if ($_FILES['file']['error'][$i] == 1) $tmp_m = 'UPLOAD_ERR_INI_SIZE';
					if ($_FILES['file']['error'][$i] == 2) $tmp_m = 'UPLOAD_ERR_FORM_SIZE';
					if ($_FILES['file']['error'][$i] == 3) $tmp_m = 'UPLOAD_ERR_PARTIAL';
					if ($_FILES['file']['error'][$i] == 4) $tmp_m = 'UPLOAD_ERR_NO_FILE';
					if ($_FILES['file']['error'][$i] == 6) $tmp_m = 'UPLOAD_ERR_NO_TMP_DIR';
					if ($_FILES['file']['error'][$i] == 7) $tmp_m = 'UPLOAD_ERR_CANT_WRITE';
					if ($_FILES['file']['error'][$i] == 8) $tmp_m = 'UPLOAD_ERR_EXTENSION';
					$error_msg .= $SYS_WARN_MSG['f_notuploaded'].' '.$tmp_m.' ';
					unset($tmp_m);
				}
			}
		}
		if ($subaction == 'upload_close' && $success == 2)
			include 'inc_fm_list.php';
		else {
			assignArray($in_var, 'details');
			$tpl = 'fm_details_upload.tpl';
		}
	}
	// SAVE DOCUMENT
	if ($subaction == 'mcecontent' || $subaction == 'txtcontent') {
		$editor_content = emailToUnicode(stripslashes($_POST['editor_content']));
		//$editor_content = stripslashes($_POST['editor_content']);
		if ($subaction == 'txtcontent')
			$editor_content = htmlDecode($editor_content);

		$validate_array = fmValidateNameAttr($action, $in_var);
		if ($validate_array['valid']) {
			if (fmSaveContent($path_full.$file_name_new, $editor_content)) { // save and replace only code
				$in_var['name'] = $name_new;
				$warning_msg .= $SYS_WARN_MSG['f_created'];
				$success = 1;
			} else
				$error_msg .= $SYS_WARN_MSG['f_notcreated'];
		} else
			$error_msg .= $validate_array['error_msg'];
		// ASSIGN
		assignArray($in_var, 'details');
		$smarty->assign('editor_content', htmlEncode($editor_content)); // show and replace htmls
		unset($editor_content);
		$tpl = ($subaction == 'mcecontent') ? ('fm_details_mceedit.tpl') : ('fm_details_txtedit.tpl');
	}
	// UTILITIES
	if ($subaction == 'emailjs') {
		$tmp = "document.write(\"<a href='mailto:".$in_var['name']."'>".$in_var['name']."</a>\");";
		$tmp_out = '';
		for ($x = 0; $x < strlen($tmp); $x ++) $tmp_out .= '%' . bin2hex($tmp[$x]);
		$in_var['name'] =  "<script>eval(unescape(\"$tmp_out\"));</script>";
		// ASSIGN
		assignArray($_SERVER, 'webclient');
		assignArray($in_var, 'details');
		$tpl = 'fm_details_utils.tpl';
	}
	// UTILITIES
	if ($subaction == 'pincode') {
		$in_var['attr'] =  genPin($in_var['ext']);
		// ASSIGN
		assignArray($_SERVER, 'webclient');
		assignArray($in_var, 'details');
		$tpl = 'fm_details_utils.tpl';
	}
	$view_mode = 1;
	$action = 'list';
break;
//------------------------------------------------------------
case 'edit':
	// SAVE DIR/FILE
	if ($subaction == 'dir' || $subaction == 'file' || $subaction == 'dir_close' || $subaction == 'file_close') {
		$validate_array = fmValidateNameAttr($action, $in_var);
		if ($validate_array['valid']) {
			if (fmRenameDirFile($path_full.$file_name, $path_full.$file_name_new, $in_var['attr'])) {
				$in_var['name'] = $name_new;
				$warning_msg .= $SYS_WARN_MSG['a_updated'];
				$success = ($subaction == 'dir_close' || $subaction == 'file_close')?(2):(1);
			} else
				$error_msg .= $SYS_WARN_MSG['f_exist'];
		} else
			$error_msg .= $validate_array['error_msg'];

		if (($subaction == 'dir_close' || $subaction == 'file_close') && $success == 2)
			include 'inc_fm_list.php';
		else {
			assignArray($in_var, 'details');
			$tpl = ($subaction == 'dir') ? ('fm_details_dir.tpl') : ('fm_details_file.tpl');
		}
	}
	// COPY FILE
	if ($subaction == 'copy' || $subaction == 'copy_close') {
		$validate_array = fmValidateNameAttr($action, $in_var);
		if ($validate_array['valid']) {
			if (fmCopyFile($path_full.$file_name, $path_full_new.$file_name_new)) {
				$in_var['name'] = $name_new;
				$warning_msg .= $SYS_WARN_MSG['f_copied'];
				$success = ($subaction == 'copy_close')?(2):(1);
			} else
				$error_msg .= $SYS_WARN_MSG['f_notcopied'];
		} else
			$error_msg .= $validate_array['error_msg'];

		if ($subaction == 'copy_close' && $success == 2)
			include 'inc_fm_list.php';
		else {
			assignArray($in_var, 'details');
			$tpl = 'fm_details_copy.tpl';
		}
	}
	// UPDATE DOCUMENT
	if ($subaction == 'mcecontent' || $subaction == 'txtcontent' || $subaction == 'mcecontent_close' || $subaction == 'txtcontent_close') {
		$editor_content = $_POST['editor_content']; // without strips
		$editor_content = linkToLytebox(emailToUnicode($editor_content));
		//$editor_content = emailToUnicode($editor_content);
		if ($subaction == 'txtcontent' || $subaction == 'txtcontent_close')
			$editor_content = htmlDecode($editor_content);
			
		$validate_array = fmValidateNameAttr($action, $in_var);
		if ($validate_array['valid']) {
			if (fmSaveContent($path_full.$file_name_new, $editor_content)) { // save and replace only code
				$in_var['name'] = $name_new;
				$warning_msg .= $SYS_WARN_MSG['f_updated'];
				$success = ($subaction == 'mcecontent_close' || $subaction == 'txtcontent_close')?(2):(1);
			} else
				$error_msg .= $SYS_WARN_MSG['f_notupdated'];
		} else
			$error_msg .= $validate_array['error_msg'];

		if (($subaction == 'mcecontent_close' || $subaction == 'txtcontent_close') && $success == 2)
			include 'inc_fm_list.php';
		else {
			assignArray($in_var, 'details');
			$smarty->assign('editor_content', htmlEncode($editor_content)); // show and replace all htmls
			unset($editor_content);
			$tpl = ($subaction == 'mcecontent') ? ('fm_details_mceedit.tpl') : ('fm_details_txtedit.tpl');
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
	$smarty->display((($tpl) ? ($tpl) : ('fm_details_dir.tpl')));
} else {
	$right_frame = ($tpl) ? ($tpl) : ('fm_list.tpl');
}

// unset variables
unset($in_var);

?>
