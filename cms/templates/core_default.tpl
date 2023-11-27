<!DOCTYPE html>{config_load file="../../cms/templates/core_$ui_lang.conf" scope="global"}
<html lang="{$ui_lang}">
<head>
<title>{$site_title}: {$entry_info.entry_title|default:'cms'}</title>
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
<link href="../images/cms_core.css" rel="stylesheet" type="text/css">
<link href="../images/cms_w3.css" rel="stylesheet" type="text/css">
<link href="../images/{$cms_theme|default:'w3-theme-blue-grey.css'}" rel="stylesheet" type="text/css">
<style>
{literal}
html,body,h1,h2,h3,h4,h5 {font-family:Arial,Helvetica,sans-serif}
body{margin:0;}
{/literal}
</style>
{literal}
<script src="../images/cms_core.js"></script>
<script>
var var_sid='{/literal}{$SID}{literal}';
var var_entry_id='{/literal}{$entry_id}{literal}';
</script>
{/literal}
</head>
<body onload="rMsg();" class="w3-medium">
{include file=$left_frame|default:'core_empty.tpl'}
<div class="w3-main" style="margin-left:230px;">

<div id="topFrame" class="w3-container" style="background-image:linear-gradient(to bottom, #fdfdfd, #f1f1f1);">
{if $error_msg or $warning_msg}
<div id="warnMsg" class="w3-top w3-margin-top-8" style="position:fixed;width:auto;display:block;">
{if $error_msg}<div class="w3-padding w3-round w3-orange">{$error_msg}</div>{/if}
{if $warning_msg}<div class="w3-padding w3-round w3-light-green">{$warning_msg}</div>{/if}
</div>
{/if}
<div class="w3-margin-top w3-large" style="margin-bottom:14px;">{$site_title}</div>
</div>

<div id="headerFrame" class="w3-card w3-light-grey w3-margin-bottom">
{section name=custom loop=$modules_list}
  {if $modules_list[custom].in_path eq '1'}
    <a href="?entry_id={$modules_list[custom].entry_id}&amp;{$SID}" class="w3-bar-item w3-button w3-padding-small w3-hover-white">&rsaquo;&nbsp;{$modules_list[custom].entry_title}</a>
  {/if}
{/section}
    <a class="w3-bar-item w3-button w3-hide-large w3-right w3-padding-small w3-hover-white" href="javascript:void(0);" onclick="dtreeSidebar()" title="{#LB_menu#}">≡ {#LB_menu#}&nbsp;</a>
</div>

<div id="middleFrame" class="w3-container">
{include file=$right_frame|default:'core_empty.tpl'}
</div>
</div>
</body>
</html>
