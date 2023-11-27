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

// info
$valide = 0;
$news_item = array();

// verify
$in_var = trimRequestValues($in_var);
//print_r($in_var);

if ($action == 'create')
if (!$in_var['news_id']) {
	$error_msg .= $SYS_WARN_MSG['not_all_mandatory'];
} else {
	// reference
	$ref_list = array('mr_id'=>$SYS_WARN_MSG['mr_id'],'mr_ref'=>$SYS_WARN_MSG['mr_ref'],'ms_id'=>$SYS_WARN_MSG['ms_id'],'ms_ref'=>$SYS_WARN_MSG['ms_ref']);
	$out_var = jobEmailSource(DB_PREFIX, $db_link, $in_var['menu_id'], $ref_list);
	$ok_cnt = 0;
	$out_cnt = sizeof($out_var);
	if ($out_var) {
		for ($i = 0; $i < $out_cnt; $i++) {
			// db var
			$in_db_var['menu_id'] = $in_var['menu_id'];
			$in_db_var['news_id'] = $in_var['news_id'];
			$in_db_var['modifytime'] = time();
			$in_db_var['status'] = 0;
			$in_db_var['email'] = '\''.$out_var[$i]['email'].'\'';
			$in_db_var['reference'] = '\''.$out_var[$i]['reference'].'\'';
			$in_db_var['createnick'] = '\''.$in_var['createnick'].'\'';
			// add info
			$details_id = jobInsert(DB_PREFIX, $db_link, $in_db_var);
			if ($details_id) {
				$ok_cnt ++;
				$in_db_var = array();
				$out_log .= '0 - '.$out_var[$i]['email'].' '.$out_var[$i]['reference']."\n";
			}
		}
		$warning_msg .= $SYS_WARN_MSG['created'].': '.$ok_cnt;
		$success = ($subaction == 'save_close')?(2):(1);
	} else
		$error_msg .= $SYS_WARN_MSG['notcreated'];
}

if ($action == 'edit')
if (!$details_id)
	$error_msg .=  $SYS_WARN_MSG['action_wrong'];
else {
	$out_var = jobSendEmails(DB_PREFIX, $db_link, $in_var['menu_id'], $in_var['news_id']);
	$out_cnt = sizeof($out_var);
	if ($out_var) {
		// get news details
		include 'modules/news/func_news.php';
		include 'modules/mailer.php';
		$news_item = newsGetInfo(DB_PREFIX, $db_link, $in_var['news_id']);
		for ($i = 0; $i < $out_cnt; $i++) {
			$tmp_descr = '';
			// send email
			if (mailerSendSimple($sys_mx, $out_var[$i]['email'], $nwl_email, $nwl_email, '', '', $news_item['title'], $news_item['message'], $site_url.'/images/w3.css')) {
				$tmp_descr = $SYS_WARN_MSG['email_sent'].' '.$out_var[$i]['email'];
				$warning_msg .= ($warning_msg?'<br>':'').$tmp_descr;
				$success = 1;
			} else {
				$tmp_descr = $SYS_WARN_MSG['email_notsend'].' '.$out_var[$i]['email'];
				$error_msg .= ($error_msg?'<br>':'').$tmp_descr;
			}
			// PREPARING TO UPDATE
			$in_var['modifytime'] = time();
			// db var
			$in_db_var['status'] = 2;
			$in_db_var['modifytime'] = $in_var['modifytime'];
			$in_db_var['descr'] = '\''.$tmp_descr.'\'';
			if (jobUpdate(DB_PREFIX, $db_link, $out_var[$i]['id'], $in_db_var)) {
				$success = 1;
				$out_log .= '2 - '.$out_var[$i]['email'].' '.$out_var[$i]['reference']."\n";
			}
		}
		$warning_msg = 'Job ON';
	} else {
		$out_var = jobEmails(DB_PREFIX, $db_link, $in_var['menu_id'], $in_var['news_id']);
		$out_cnt = sizeof($out_var);
		for ($i = 0; $i < $out_cnt; $i++) $out_log .= $out_var[$i]['status'].' - '.$out_var[$i]['email'].' '.$out_var[$i]['reference']."\n";
		$warning_msg = 'Job OFF';
	}
}

if ($details_id) {
	$in_var['id'] = $details_id;
	$in_var['out_log'] = $out_log;
}

//print_r($in_var);
assignArray($in_var, 'details');

?>
