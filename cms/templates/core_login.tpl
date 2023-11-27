<!DOCTYPE html>
<html lang="{$ui_lang}">
{config_load file="core_$ui_lang.conf" scope="global"}
<head>
<title>Login: {$site_title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="author" content="{#LB_copyRight#}">
<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
<link rel="icon" type="image/x-icon" href="../images/favicon.ico">
<link rel="icon" type="image/png" href="../images/favicon.png">
<link rel="apple-touch-icon" href="../images/favicon.png">
<link rel="apple-touch-icon" href="../images/favicon-152x152.png" sizes="152x152">
<link rel="apple-touch-icon" href="../images/favicon-180x180.png" sizes="180x180">
<link rel="apple-touch-icon" href="../images/favicon-196x196.png" sizes="196x196">
<link rel="icon" type="image/png" href="../images/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="../images/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="../images/favicon-96x96.png" sizes="96x96">
<link href="../images/cms_w3.css" rel="stylesheet" type="text/css">
<link href="../images/{$cms_theme|default:'w3-theme-blue-grey.css'}" rel="stylesheet" type="text/css">
<style>
{literal}
html,body,h1,h2,h3,h4,h5 {font-family:Arial,Helvetica,sans-serif}
body{margin:0;}
{/literal}
</style>
<script src="../images/cms_core.js"></script>
</head>
<body class="w3-light-grey" onload="rMsg();">
<div style="margin:auto; max-width:600px; min-width:320px;">
{if $error_msg or $warning_msg}
<div id="warnMsg" class="w3-top w3-margin-top-8" style="position:fixed;width:auto;display:block;">
{if $error_msg}<div class="w3-padding w3-round w3-orange">{$error_msg}</div>{/if}
{if $warning_msg}<div class="w3-padding w3-round w3-light-green">{$warning_msg}</div>{/if}
</div>
{/if}
<form action="{$site_url|default:''}/cms/index.php" method="post" id="auth" class="w3-container" style="margin-top:30px;">
<h2 class="w3-text-theme">{$site_title}</h2>
<p><label>{#LB_user#}</label>
<input name="nick" id="nick" class="w3-input w3-border w3-round" type="text" style="max-width:300px;" required></p>
<p><label>{#LB_password#}</label>
<input name="pwd" id="pwd" class="w3-input w3-border w3-round" type="password" style="max-width:300px;" required></p>
<p>
<input name="sig" value="empty" type="hidden">
<button type="submit" class="w3-button w3-theme">{#LB_login#}</button></p>
</form>
</div>
<script>document.forms['auth'].elements['sig'].value = screen.width+'#'+screen.height+'#'+screen.colorDepth+'#'+navigator.language;</script>
</body>
</html>
