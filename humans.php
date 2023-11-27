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

$content_str = '';
$content_str .= "/* TEAM */ \n";
$content_str .= "Developer: Andrey Marchenko \n";
$content_str .= "Site: www.marchenko.de \n";
$content_str .= "Location: Germany \n";
$content_str .= "/* THANKS */ \n";
$content_str .= "Name: ZAPware IT-Service eG \n";
$content_str .= "/* SITE */ \n";
$content_str .= "Standards: HTML5, CSS3, PHP, Sqlite3 \n";
$content_str .= "Components: w3schools, smarty, TinyMCE, lytebox, highlight.js \n";

header('Content-Type: text/plain');
header('Content-Disposition: inline; filename="humans.txt"');
header('Content-Length: '.strlen($content_str));
echo $content_str;

// unset variables
unset($content_str);

?>
