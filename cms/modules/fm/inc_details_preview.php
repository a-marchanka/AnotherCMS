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
case 'htm':
case 'html':
case 'tpl':
$smarty->assign('log', getContentFromPath($site_dir.$fm_dir.$dir.$file_name));
break;

case 'bmp':
case 'gif':
case 'jpeg':
case 'jpg':
case 'jpe':
case 'png':
case 'tiff':
case 'tif':
$smarty->assign('log', '<img src="'.$site_url.'/'.$fm_dir.$dir.$file_name.'" alt="" title="'.$file_name.'" style="position:absolute;height:100%;" />');
break;

case 'mp3':
$smarty->assign('log', '<audio style="position:absolute;width:95%;" controls><source src="'.$site_url.'/'.$fm_dir.$dir.$file_name.'" type="audio/mpeg" />Media element is not supported.</audio>');
break;
case 'm4a':
$smarty->assign('log', '<audio style="position:absolute;width:95%;" controls><source src="'.$site_url.'/'.$fm_dir.$dir.$file_name.'" type="audio/mp4" />Media element is not supported.</audio>');
break;
case 'wav':
$smarty->assign('log', '<audio style="position:absolute;width:95%;" controls><source src="'.$site_url.'/'.$fm_dir.$dir.$file_name.'" type="audio/wav" />Media element is not supported.</audio>');
break;
case 'ogg':
$smarty->assign('log', '<audio style="position:absolute;width:95%;" controls><source src="'.$site_url.'/'.$fm_dir.$dir.$file_name.'" type="audio/ogg" />Media element is not supported.</audio>');
break;

case 'mp4':
case 'mpg':
case 'mov':
$smarty->assign('log', '<video style="position:absolute;width:95%;" controls><source src="'.$site_url.'/'.$fm_dir.$dir.$file_name.'" type="video/mp4" />Media element is not supported.</video>');
break;
case 'webm':
$smarty->assign('log', '<video style="position:absolute;width:95%;" controls><source src="'.$site_url.'/'.$fm_dir.$dir.$file_name.'" type="video/webm" />Media element is not supported.</video>');
break;

case 'php':
case 'php4':
case 'phtml':
$smarty->assign('log', getHighlighter($site_dir.$fm_dir.$dir.$file_name, 'php'));
break;

case 'xml':
$smarty->assign('log', getHighlighter($site_dir.$fm_dir.$dir.$file_name, 'xml'));
break;

case 'bat':
$smarty->assign('log', getHighlighter($site_dir.$fm_dir.$dir.$file_name, 'dos'));
break;

case 'css':
$smarty->assign('log', getHighlighter($site_dir.$fm_dir.$dir.$file_name, 'css'));
break;

case 'js':
$smarty->assign('log', getHighlighter($site_dir.$fm_dir.$dir.$file_name, 'javascript'));
break;

case 'txt':
case 'csv':
case 'log':
case 'conf':
$smarty->assign('log', getHighlighter($site_dir.$fm_dir.$dir.$file_name, 'ini'));
break;

case 'sql':
$smarty->assign('log', getHighlighter($site_dir.$fm_dir.$dir.$file_name, 'sql'));
break;

default:
$smarty->assign('log', '<a href="'.$site_url.'/'.$fm_dir.$dir.$file_name.'">'.$file_name.'</a>');
}

//-------------------------------------------------
function getHighlighter($path, $ext) {
	return '<link href="../../libs/highlight/highlight.css" rel="stylesheet" type="text/css" />'.
		'<pre><code class="'.$ext.'">'.htmlEncode(getContentFromPath($path)).'</code></pre>'.
		'<script type="text/javascript" src="../../libs/highlight/highlight.js"></script>'.
		'<script type="text/javascript">hljs.tabReplace="    ";hljs.initHighlightingOnLoad();</script>';
}

?>
