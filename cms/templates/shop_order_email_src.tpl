<!DOCTYPE html>
<html lang="{$ui_lang}">
{config_load file="core_$ui_lang.conf" scope="global"}
<head>
<title>{#LB_search#}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="author" content="{#LB_copyRight#}">
<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
<link rel="icon" type="image/x-icon" href="../images/favicon.ico">
<link rel="icon" type="image/gif" href="../images/favicon.gif">
<link rel="icon" type="image/png" href="../images/favicon.png">
<link href="../images/cms_core.css" rel="stylesheet" type="text/css">
<link href="../images/cms_w3.css" rel="stylesheet" type="text/css">
<link href="../images/{$cms_theme|default:'w3-theme-blue-grey.css'}" rel="stylesheet" type="text/css">
{literal}
<style>
html,body,h1,h2,h3,h4,h5 {font-family:Arial,Helvetica,sans-serif}
body{margin:0;}
</style>
<script src="../images/cms_core.js"></script>
{/literal}
</head>
<body onload="rMsg();" class="w3-medium">
<div id="middleFrame" class="w3-padding-small">
{if $error_msg or $warning_msg}
<div id="warnMsg" class="w3-top w3-margin-top-8" style="position:fixed;width:auto;display:block;">
{if $error_msg}<div class="w3-padding w3-round w3-orange">{$error_msg}</div>{/if}
{if $warning_msg}<div class="w3-padding w3-round w3-light-green">{$warning_msg}</div>{/if}
</div>
{/if}
{if $subaction eq 'bill' or $subaction eq 'delivery' or $subaction eq 'dunning'}
<form id="form_details" name="form_details" method="post" action="#">
<div class="w3-right w3-margin-top-8 w3-margin-bottom-8">
<input id="newObj" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_email#}">
</div>
<input name="action" id="action" type="hidden" value="details">
<input name="subaction" id="subaction" type="hidden" value="{$subaction|default:'bill'}_email">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
</form>
{/if}
{$log|default:''}
</div>
</body>
</html>
