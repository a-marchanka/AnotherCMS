<!DOCTYPE html>{config_load file="../cms/templates/core_$ui_lang.conf" scope="global"}
<html lang="{$ui_lang}">
<head>
<title>{$site_title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="keywords" content="{$site_keywords}">
<meta name="description" content="{$site_description}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{$site_url}/{$entry_name}">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<link rel="icon" type="image/x-icon" href="images/favicon.ico">
<link rel="icon" type="image/png" href="images/favicon.png">
<link rel="apple-touch-icon" href="images/favicon.png">
<link rel="apple-touch-icon" href="images/favicon-152x152.png" sizes="152x152">
<link rel="apple-touch-icon" href="images/favicon-180x180.png" sizes="180x180">
<link rel="apple-touch-icon" href="images/favicon-196x196.png" sizes="196x196">
<link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="images/favicon-96x96.png" sizes="96x96">
<link rel="stylesheet" href="images/w3.css">
<link rel="stylesheet" href="images/w3-font-roboto.css">
<link rel="stylesheet" href="libs/lytebox/lytebox_core.css" type="text/css" media="screen">
{literal}
<script src="libs/lytebox/lytebox.js"></script>
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
</style>
<!-- Script for Sidebar, Tabs, Accordions, Progress bars and slideshows -->
<script>
function rMsg() {
	/* clear warning message after n sec */
	var elemErr = document.getElementById('errMsg');
	var elemWrn = document.getElementById('warnMsg');
	var cls_f = 0;
	if (elemErr) if (elemErr.innerHTML) cls_f = 1;
	if (elemWrn) if (elemWrn.innerHTML) cls_f = 1;
	if (cls_f == 1) setTimeout(clrMsg, 6000); // once in n sec
}
function clrMsg() {
	var elemErr = document.getElementById('errMsg');
	var elemWrn = document.getElementById('warnMsg');
	if (elemErr) elemErr.style.display="none";
	if (elemWrn) elemWrn.style.display="none";
	clearTimeout(clrMsg);
}
function toggle(elementId, state) {
	/* state: 0 - disable, 1 - enable, -1 - change */
	var elem = document.getElementById(elementId);
	if (elem) {
		var visibility = elem.style.display;
		if (state == 1 && visibility == "none")	visibility = "block";
		if (state == 0 && visibility == "block") visibility = "none";
		if (state == -1) visibility = (visibility == "none") ? ("block") : ("none");
		elem.style.display = visibility;
	}
}
// Side navigation
function w3Nav() {
	var x = document.getElementById("myNav");
	if (x.className.indexOf("w3-show") == -1) x.className += " w3-show";
	else x.className = x.className.replace(" w3-show", "");
}
// Automatic slideShow - change image every x seconds
var slides_i = 0;
function slideShow() {
    var i;
    var slides = document.getElementsByClassName("slideList");
    if (slides && slides.length > 0) {
        for (i = 0; i < slides.length; i++) slides[i].style.display = "none";  
        slides_i ++;
        if (slides_i > slides.length) slides_i = 1;
        slides[slides_i-1].style.display = "block";
        setTimeout(slideShow, 4000);
    }
}
</script>
{/literal}
</head>
<body onload="rMsg();slideShow();" class="w3-light-grey" style="margin:auto;">
{include file=$pattern_menu_main|default:"menu_empty.tpl"}
<!-- !PAGE CONTENT! -->
<div class="w3-content w3-padding" style="max-width:1100px;min-width:360px;">
{if $error_msg or $warning_msg}
<div id="warnMsg" class="w3-top w3-margin-top" style="width:auto;display:block;">
{if $error_msg}<div style="height:30px;">&nbsp;</div><h5 class="w3-padding w3-card w3-orange">{$error_msg}</h5>{/if}
{if $warning_msg}<div style="height:30px;">&nbsp;</div><h5 class="w3-padding w3-card w3-green">{$warning_msg}</h5>{/if}
</div>
{/if}
  <div style="height:50px;">&nbsp;</div>
  {include file=$pattern_content|default:'content_empty.tpl'}
  {include file=$pattern_content_add|default:'content_empty.tpl'}
  {include file=$pattern_menu_sub|default:'menu_empty.tpl'}
</div>
</body>
</html>
