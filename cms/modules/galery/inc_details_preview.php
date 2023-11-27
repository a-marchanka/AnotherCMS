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

switch (strtolower($ext)) {

case 'gif':
case 'jpeg':
case 'jpg':
case 'png':
$smarty->assign('log', '<img src="'.$site_url.'/'.$usr_img.$file_name.'" alt="" title="'.$file_name.'" style="position:absolute; width:100%;" />');
break;

case 'mp3':
$smarty->assign('log', '<audio style="position:absolute; width:95%;" controls><source src="'.$site_url.'/'.$usr_aud.$file_name.'" type="audio/mpeg" />Media element is not supported.</audio>');
break;
case 'wav':
$smarty->assign('log', '<audio style="position:absolute; width:95%;" controls><source src="'.$site_url.'/'.$usr_aud.$file_name.'" type="audio/wav" />Media element is not supported.</audio>');
break;

case 'mp4':
case 'mpg':
case 'mov':
$smarty->assign('log', '<video style="position:absolute; width:95%;" controls><source src="'.$site_url.'/'.$usr_vid.$file_name.'" type="video/mp4" />Media element is not supported.</video>');
break;
case 'webm':
$smarty->assign('log', '<video style="position:absolute; width:95%;" controls><source src="'.$site_url.'/'.$usr_vid.$file_name.'" type="video/webm" />Media element is not supported.</video>');
break;

default:
$smarty->assign('log', '<a href="'.$site_url.'/'.$usr_img.$file_name.'">'.$file_name.'</a>');
}

?>
