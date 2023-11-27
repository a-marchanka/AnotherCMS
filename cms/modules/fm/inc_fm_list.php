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

$files_list = fmGetFileList($path_full);
//print_r($files_list);
// ASSIGN
assignArray($files_list, 'files_list');
if (sizeof($files_list) == 0) $warning_msg .= $SYS_WARN_MSG['d_empty'];

unset($files_list);

?>
