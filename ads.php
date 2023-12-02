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

ini_set('default_charset','utf-8');

$content_str = "#Ads.txt - no marketing"."\n";

header('Content-Type: text/plain');
header('Content-Disposition: inline; filename="ads.txt"');
header('Content-Length: '.strlen($content_str));
echo $content_str;
unset($content_str);
?>
