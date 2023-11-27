<!DOCTYPE html>
<html lang="{$ui_lang}">
<head>
<title>{$entry_info.entry_title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="author" content="{#LB_copyRight#}">
<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
<link rel="icon" type="image/x-icon" href="../images/favicon.ico">
<link rel="icon" type="image/gif" href="../images/favicon.gif">
<link rel="icon" type="image/png" href="../images/favicon.png">
<link rel="apple-touch-icon" href="../images/apple-touch-icon.png">
<link href="../images/cms_core.css" rel="stylesheet" type="text/css">
<link href="../images/cms_w3.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="middleFrame" class="w3-container">
{if $error_msg or $warning_msg}
<div id="warnMsg" class="w3-top w3-margin-top-8" style="position:fixed;width:auto;display:block;">
{if $error_msg}<div class="w3-padding w3-round w3-orange">{$error_msg}</div>{/if}
{if $warning_msg}<div class="w3-padding w3-round w3-light-green">{$warning_msg}</div>{/if}
</div>
{/if}
{$log}
</div>
</body>
</html>
