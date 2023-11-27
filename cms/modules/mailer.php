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

function mailerSendSimple($mx = '', $to = '', $reply ='', $from = '', $cc = '', $bcc = '', $subj = '', $html_content = '', $style = '', $msg_var = array(), $msg_syn = array()) {
	$header = '';
	$mime_boundary = 'Multipart_Boundary_x'.md5(mt_rand()).'x';
	foreach($msg_var as $var => $param) {
		if ($param) if (isset($msg_syn[$var])) $html_content .= $msg_syn[$var].': '.$param.'<br />';
	}
	if ($from) $header .= "From: ".$from."\n";
	if ($reply) $header .= "Reply-To: ".$reply."\n";
	if ($cc) $header .= "Cc: ".$cc."\n";
	if ($bcc) $header .= "Bcc: ".$bcc."\n";
	
	$header .= "X-Mailer: PHP 7\n";
	$header .= "Message-ID: <".md5(uniqid(time()))."@".($mx?$mx:getenv("SERVER_NAME")).">\n";
	$header .= "Return-Path: <".$from.">\n";
	$header .= "MIME-Version: 1.0\n";
	$header .= "Content-Type: multipart/mixed; boundary=\"".$mime_boundary."\"\n\n";
	$html_content = "This is a multi-part message in MIME format.\n\n".
	"--{$mime_boundary}\n".
	"Content-Type: text/html; charset=\"utf-8\"\n".
	"Content-Transfer-Encoding: 7bit\n\n".
	"<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">".(($style)?'<link rel="stylesheet" type="text/css" href="'.$style.'">':'')."</head>".
	"<body>".$html_content."</body></html>\n\n";
	$html_content = $html_content."--{$mime_boundary}--\n";

	//print $to.' '.$subj.' '.$html_content.' '.$header; return true;
	return (mail($to, $subj, $html_content, $header));
}
//-------------------------------------
function mailerSendAttach($mx = '', $to = '', $reply ='', $from = '', $cc = '', $bcc = '', $subj = '', $style = '', $html_content = '', $file_name = '', $file_type = '', $file_content = '') {
	$header = '';
	$mime_boundary = 'Multipart_Boundary_x'.md5(mt_rand()).'x';

	if ($from) $header .= "From: ".$from."\n";
	if ($reply) $header .= "Reply-To: ".$reply."\n";
	if ($cc) $header .= "Cc: ".$cc."\n";
	if ($bcc) $header .= "Bcc: ".$bcc."\n";
	
	$header .= "X-Mailer: PHP7\n";
	$header .= "Message-ID: <".md5(uniqid(time()))."@".($mx?$mx:getenv("SERVER_NAME")).">\n";
	$header .= "Return-Path: <".$from.">\n";
	$header .= "MIME-Version: 1.0\n";
	$header .= "Content-Type: multipart/mixed; boundary=".$mime_boundary."\n\n";
	$html_content = "This is a multi-part message in MIME format.\n\n".
	"--{$mime_boundary}\n".
	"Content-Type: text/html; charset=\"utf-8\"\n".
	"Content-Transfer-Encoding: 7bit\n\n".
	"<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">".(($style)?'<link rel="stylesheet" type="text/css" href="'.$style.'">':'')."</head>".
	"<body>".$html_content."</body></html>\n\n";

	// build attachment
	if ($file_content) {
		$file_content = "--{$mime_boundary}\n".
				"Content-Type: {".$file_type."};\n".
				" name=\"".$file_name."\"\n".
				"Content-Disposition: attachment;\n".
				" filename=\"".$file_name."\"\n".
				"Content-Transfer-Encoding: base64\n\n".chunk_split(base64_encode($file_content))."\n\n";
		$html_content .= $file_content;
	}
	$html_content = $html_content."--{$mime_boundary}--\n";

	//print $to.' '.$subj.' '.$html_content.' '.$header; return true;
	return (mail($to, $subj, $html_content, $header));
}
?>
