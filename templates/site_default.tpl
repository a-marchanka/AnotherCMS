<!DOCTYPE html>
{config_load file="core_$ui_lang.conf" scope="global"}
<html lang="{$ui_lang}">
<head>
<title>{$site_title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
<meta name="keywords" content="{$site_keywords}" />
<meta name="description" content="{$site_description}" />
<meta name="robots" content="index, follow" />
<link rel="author" href="humans.txt">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<link rel="icon" type="image/x-icon" href="images/favicon.ico" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
<link rel="apple-touch-icon" href="images/apple-touch-icon-precomposed.png" sizes="57x57" />
<link rel="apple-touch-icon" href="images/apple-touch-icon-57x57.png" sizes="57x57" />
<link rel="apple-touch-icon" href="images/apple-touch-icon-60x60.png" sizes="60x60" />
<link rel="apple-touch-icon" href="images/apple-touch-icon-72x72.png" sizes="72x72" />
<link rel="apple-touch-icon" href="images/apple-touch-icon-76x76.png" sizes="76x76" />
<link rel="apple-touch-icon" href="images/apple-touch-icon-114x114.png" sizes="114x114" />
<link rel="apple-touch-icon" href="images/apple-touch-icon-120x120.png" sizes="120x120" />
<link rel="apple-touch-icon" href="images/apple-touch-icon-128x128.png" sizes="128x128" />
<link rel="apple-touch-icon" href="images/apple-touch-icon-144x144.png" sizes="144x144" />
<link rel="apple-touch-icon" href="images/apple-touch-icon-152x152.png" sizes="152x152" />
<link rel="apple-touch-icon" href="images/apple-touch-icon-180x180.png" sizes="180x180" />
<link rel="apple-touch-icon" href="images/apple-touch-icon-196x196.png" sizes="196x196" />
<link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16" />
<link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="images/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/png" href="images/favicon-160x160.png" sizes="160x160" />
<link rel="icon" type="image/png" href="images/favicon-192x192.png" sizes="192x192" />
<link rel="icon" type="image/png" href="images/favicon-196x196.png" sizes="196x196" />

<link rel="stylesheet" href="images/w3.css" />
<link rel="stylesheet" href="libs/lytebox/lytebox_core.css" type="text/css" media="screen" />
{literal}
<script src="libs/lytebox/lytebox.js"></script>
<style>
.galBl {padding:10px 15px 10px 0px; display:inherit; float:left;}
.galBl img {box-shadow:0 1px 3px #888; border-radius:0px;}
.w3-third img {width:100%; border:0px;}
#ado_policy {display:block; text-align:center; margin:0; background-color:#ededed; font-size:12px;}
.ado_policy_wrap {max-width:500px; display:block; margin:0 auto; position:relative;}
</style>
{/literal}
</head>

<body onload="rMsg();" class="w3-light-grey">

<!-- Sidebar -->
<nav class="w3-sidebar w3-black w3-animate-top w3-large" style="display:none;padding-top:50px" id="mySidebar">
  <a href="#" class="w3-button w3-black w3-large w3-padding w3-display-topleft" onclick="w3_close()" title="close menu">&times;</a>
  <div class="w3-bar-block w3-center">
    {include file=$pattern_menu_main|default:"menu_empty.tpl"}
  </div>
</nav>

<!-- !PAGE CONTENT! -->
<div class="w3-content" style="max-width:1500px">

<!-- Header -->
<div class="w3-opacity">
<button class="w3-button w3-large w3-left w3-black" onclick="w3_open();">Menu</button>
<div class="w3-clear"></div>
</div>

<!-- Photo Grid -->
<div class="w3-row-padding" id="myGrid" style="margin-bottom:30px">

	<div id="text">
	{if $error_msg}
		<div class="w3-container w3-orange"><h5>
		{$error_msg}
		</h5></div>
	{/if}
	{if $warning_msg}
		<div class="w3-container w3-green"><h5>
		{$warning_msg}
		</h5></div>
	{/if}
	</div>
	{include file=$pattern_content|default:"content_empty.tpl"}
	{include file=$pattern_content_add|default:"content_empty.tpl"}

</div>

<!-- End Page Content -->
</div>

<!-- Footer -->
<footer class="w3-container w3-padding-16 w3-center w3-opacity w3-medium w3-white"> 
  <a href="home{if $sid}?sid={$sid}{/if}">Home</a>
  &nbsp; &nbsp;
  <a href="contact{if $sid}?sid={$sid}{/if}">Contact</a>
  &nbsp; &nbsp;<a href="privacy_policy{if $sid}?sid={$sid}{/if}">Privacy Policy</a>
  {if $sid}
    &nbsp; &nbsp;<a href="?sid={$sid}&action=logout">&rsaquo; {#LB_logout#}</a>
  {/if}
</footer>

{literal}
<!-- Script for Sidebar, Tabs, Accordions, Progress bars and slideshows -->
<script>
/* <![CDATA[ */
function rScr(request) {
	acceptYes();
	this.location.href = this.location.href + '/../' + request;
}
function rMsg() {
	/* clear warning message after 5 sec */
	var elemErr = document.getElementById('errMsg');
	var elemWrn = document.getElementById('warnMsg');
	var cls_f = 0;
	if (elemErr) {
		if (elemErr.innerHTML) cls_f = 1;
	}
	if (elemWrn) {
		if (elemWrn.innerHTML) cls_f = 1;
	}
	if (cls_f == 1) setTimeout(clrMsg, 5000); // once in 5 sec
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
		if (state == 1 && visibility == "none")
			visibility = "block";
		if (state == 0 && visibility == "block")
			visibility = "none";
		if (state == -1)
			visibility = (visibility == "none") ? ("block") : ("none");
		elem.style.display = visibility;
	}
}
/* [Cookie] Sets value in a cookie */
function setCookie(cookieName, cookieValue, expires, path, domain, secure) {
	document.cookie =
		escape(cookieName) + '=' + escape(cookieValue)
		+ (expires ? '; expires=' + expires.toUTCString() : '')
		+ (path ? '; path=' + path : '')
		+ (domain ? '; domain=' + domain : '')
		+ (secure ? '; secure' : '');
}
/* [Cookie] Gets a value from a cookie */
function getCookie(cookieName, cookieDefault) {
	var cookieValue = '';
	var posName = document.cookie.indexOf(escape(cookieName) + '=');
	if (posName != -1) {
		var posValue = posName + (escape(cookieName) + '=').length;
		var endPos = document.cookie.indexOf(';', posValue);
		if (endPos != -1) cookieValue = unescape(document.cookie.substring(posValue, endPos));
		else cookieValue = unescape(document.cookie.substring(posValue));
	} else cookieValue = cookieDefault;
	return (cookieValue);
}
/* Check policy */
function acceptPolicy() {
	var isAccepted = getCookie('use_cookie', 0);
	if (isAccepted > 0) // hide the note
		toggle('ado_policy', 0);
	else
		toggle('ado_policy', 1);
	return true;
}
function acceptYes() {
        var now = new Date();
	var expires = new Date(now.getTime() + 1000 * 60 * 60 * 24 * 90); /* for 90 days */
	setCookie('use_cookie', '1', expires);
	toggle('ado_policy', 0);
}
function acceptNo() {
        var now = new Date();
	var expires = new Date(now.getTime() + 1000 * 60 * 60 * 24 * 90); /* for 90 days */
	setCookie('use_cookie', '2', expires);
	toggle('ado_policy', 0);
}
function acceptReset() {
        var now = new Date();
	var expires = new Date(now.getTime() + 1000 * 60 * 60 * 24 * 90); /* for 90 days */
	setCookie('use_cookie', '0', expires);
	toggle('ado_policy', 1);
}
// Side navigation
function w3_open() {
    var x = document.getElementById("mySidebar");
    x.style.width = "100%";
    //x.style.fontSize = "30px";
    //x.style.paddingTop = "2%";
    x.style.display = "block";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
/* ]]> */
</script>
{/literal}
</body>
</html>
