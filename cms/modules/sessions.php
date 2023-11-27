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
function sessExists($id) {
	$sess_file = SESS_DIR.'sess_'.$id;
	return(file_exists($sess_file));
}
//------------------------------------------------------------
function sessRead($id) {
	$sess_file = SESS_DIR.'sess_'.$id;
	if ($fp = fopen($sess_file, 'r')) return(fread($fp, filesize($sess_file)));
	else return ('');
}
//------------------------------------------------------------
function sessWrite($id, $sess_data) {
	$sess_file = SESS_DIR.'sess_'.$id;
	if ($fp = fopen($sess_file, 'w')) return(fwrite($fp, $sess_data));
	else return (false);
}
//------------------------------------------------------------
function sessDestroy($id) {
	$sess_file = SESS_DIR.'sess_'.$id;
	return (unlink($sess_file));
}
//------------------------------------------------------------
function sessUpdate($sid, $auth_id) {
	$auth_time = time();
	$auth_info = $auth_id.'#'.$auth_time;
	//print 'id='.$auth_id;
	sessWrite($sid, $auth_info);
}
//------------------------------------------------------------
// Insert session ID to url
function appendSid($sid, $url, $non_html_amp = false) {
	if ( !empty($sid) && !preg_match('#sid=#', $url) ) {
		$url .= ( ( strpos($url, '?') != false ) ?  ( ( $non_html_amp ) ? '&' : '&amp;' ) : '?' ) .'sid='.$sid;
	}
	return $url;
}
?>
