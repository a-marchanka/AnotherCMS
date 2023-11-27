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
<script>
var var_sid='{/literal}{$SID}{literal}';
var var_entry_id='{/literal}{$entry_id}{literal}';
function selectFile(field_name, field_value) {
	parent.document.getElementById(field_name).value = field_value;
	top.tinyMCE.activeEditor.windowManager.close();
}
</script>
{/literal}
</head>
<body onload="rMsg();" class="w3-medium">
<div id="middleFrame">
{if $error_msg or $warning_msg}
<div id="warnMsg" class="w3-top w3-margin-top-8" style="position:fixed;width:auto;display:block;">
{if $error_msg}<div class="w3-padding w3-round w3-orange">{$error_msg}</div>{/if}
{if $warning_msg}<div class="w3-padding w3-round w3-light-green">{$warning_msg}</div>{/if}
</div>
{/if}
<form id="form_search_header" method="post" action="#">
<!-- filter -->
<div class="w3-row">
	<input class="w3-button w3-margin-8 w3-light-grey" type="button" onclick="javascript:rFmScr('list','browser&amp;field_name={$details.field_name}&amp;src_type={$details.src_type}','','','')" value="&nbsp;./&nbsp;">
	{section name=path_item loop=$path_array}
	<input class="w3-button w3-margin-top-8 w3-margin-right-8 w3-margin-bottom-8 w3-light-grey" type="button" onclick="javascript:rFmScr('list','browser&amp;field_name={$details.field_name}&amp;src_type={$details.src_type}','{$path_array[path_item].path}','','')" value="{$path_array[path_item].name}/">
	{/section}
</div>
<!-- filter -->
</form>
{strip}
<!-- list -->
<table class="w3-table w3-bordered w3-striped w3-border-top">
{section name=customer loop=$files_list}
	<tr>
	<td>
	{if $files_list[customer].type eq 'dir'}
		<a href="javascript:rFmScr('list','browser&amp;field_name={$details.field_name}&amp;src_type={$details.src_type}','{$path_current}{$files_list[customer].name}/','','');">
		<span class="i20s_fl" title="{$files_list[customer].name}"></span>{$files_list[customer].name}</a>
	{else}
        	<span class="i20s_non" title="{$files_list[customer].name}"></span>{$files_list[customer].name|truncate:30}{if $files_list[customer].ext}.{$files_list[customer].ext}{/if}
	{/if}
	</td>
	<td>{$files_list[customer].size}</td>
	<td class="w3-center">
	{if $files_list[customer].type ne 'dir'}
	{if ($details.src_type eq 'file' and $files_list[customer].ext) or
	    ($details.src_type eq 'image' and
		($files_list[customer].ext|lower eq 'bmp' or
		 $files_list[customer].ext|lower eq 'gif' or
		 $files_list[customer].ext|lower eq 'png' or
		 $files_list[customer].ext|lower eq 'jpg' or
		 $files_list[customer].ext|lower eq 'jpeg')) or
	    ($details.src_type eq 'media' and
		($files_list[customer].ext|lower eq 'mp3' or
		 $files_list[customer].ext|lower eq 'webm' or
		 $files_list[customer].ext|lower eq 'mp4' or
		 $files_list[customer].ext|lower eq 'mov' or
		 $files_list[customer].ext|lower eq 'mpg'))}
	<input class="w3-button w3-theme" type="button" onclick="javascript:selectFile('{$details.field_name}','{$fm_dir}{$path_current}{$files_list[customer].name}.{$files_list[customer].ext}');" value="{#LB_select#}"></a>
	{/if}
	{/if}
	</td>
	</tr>
{/section}
</table>
<!-- list -->
{/strip}
</div>
</body>
</html>
