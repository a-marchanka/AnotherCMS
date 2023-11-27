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
	opener.document.getElementById(field_name).value = field_value;
	window.close();
}
function selectPage(targetId,action){
	target_obj=document.getElementById(targetId);
	page_obj=document.getElementById('page');
	var ind=0;
	switch(action){
	case 'first':ind=0;break;
	case 'prev':ind=page_obj.selectedIndex-1;break;
	case 'next':ind=page_obj.selectedIndex+1;break;
	case 'last':ind=page_obj.length-1;break;
	default:ind=page_obj.selectedIndex;break};
	page_obj.selectedIndex=ind;
	target_obj.submit();
}
</script>
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
<form id="form_search_header" method="post" action="#">
<!-- filter -->
<div class="w3-row w3-margin-top-8 w3-margin-bottom-8">
	<div class="w3-margin-right w3-left">
	<label>{#LB_webPage#}:</label><select name="menu_id" onchange="this.form.submit()" class="w3-select w3-border w3-round w3-margin-bottom-8">
	<option value="0">---</option>
	{section name=custom loop=$search_list}
	<option value="{$search_list[custom].id}"{if $details_search.menu_id|default:0 eq $search_list[custom].id} selected="selected"{/if}{if $search_list[custom].content_type eq 'folder'} style="font-weight:bold"{/if}>
	{'&nbsp;'|indent:$search_list[custom].level:'- '} {$search_list[custom].title}</option>
	{/section}
	</select>
	</div>
	<div class="w3-margin-right w3-left">
	<label>{#LB_sort#}:</label><select name="sort" onchange="this.form.submit()" class="w3-select w3-border w3-round w3-margin-bottom-8">
	<option value="0">---</option>
	{section name=custom loop=$sort_list}
	<option value="{$sort_list[custom].id}"{if $details_search.sort|default:'' eq $sort_list[custom].id} selected{/if}>{$sort_list[custom].title}</option>
	{/section}
	</select>
	</div>
	<div class="w3-left">
	<label>{#LB_search#}:</label>
	<input name="filter" type="text" id="filter" value="{$details_search.filter|default:''}" size="15" maxlength="128" class="w3-input w3-border w3-round w3-margin-bottom-8">
	</div>
	<div class="w3-margin-right w3-left">&nbsp;<br>
	<input class="w3-button w3-theme" type="submit" value="{#LB_go#}">
	</div>
</div>
<!-- filter -->
</form>
{strip}
<!-- list -->
{section name=customer loop=$galery_list}
{if $galery_list[customer].filepath eq 'content/images/'}
	<div class="w3-left w3-margin-right w3-margin-bottom">
	<a href="javascript:selectFile('{$details.field_name}','{$galery_list[customer].filename}')">
	<img src="../{$galery_list[customer].filepath}thumbs/{$galery_list[customer].filename}" alt="{$galery_list[customer].filename}" title="{$galery_list[customer].filename}" width="95" height="95" class="w3-card-2"></a>
	</div>
{/if}
{/section}
<!-- list -->
{/strip}
{if $pager_list.pages > 1}
<!-- pager -->
<form name="form_pager_header" id="form_pager_header" method="post" action="#" class="w3-clear">
<div class="w3-row w3-margin-top w3-margin-bottom">
	{if $pager_list.page ne 1}
		<a href="javascript:pagerGo('form_pager_header','first','browser_src');" class="w3-border w3-light-grey w3-round w3-padding-small w3-margin-right-8" style="text-decoration:none">{#LB_first#}</a>
	{else}
		<span class="w3-border w3-text-grey w3-round w3-padding-small w3-margin-right-8">{#LB_first#}</span>
	{/if}
	{if $pager_list.page ne 1}
		<a href="javascript:pagerGo('form_pager_header','prev','browser_src');" class="w3-border w3-light-grey w3-round w3-padding-small w3-margin-right-8" style="text-decoration:none">{#LB_prev#}</a>
	{else}
		<span class="w3-border w3-text-grey w3-round w3-padding-small w3-margin-right-8">{#LB_prev#}</span>
	{/if}
	<span style="padding-left:10px;">{#LB_page#}:&nbsp;</span>
	<select name="page" id="page" onchange="pagerGo('form_pager_header','search','browser_src');" class="w3-select w3-border w3-round w3-padding-small" style="width:auto;">
	{section name=custom loop=$pager_list.pages}
		<option value="{$smarty.section.custom.iteration}"{if $pager_list.page eq $smarty.section.custom.iteration} selected{/if}>
		{$smarty.section.custom.iteration}
		</option>
	{/section}
	</select> : {$pager_list.pages} &nbsp;
	<input name="sort" type="hidden" value="{$details_search.sort}">
	<input name="menu_id" type="hidden" value="{$details_search.menu_id|default:0}">
	<input name="filter" type="hidden" value="{$details_search.filter|default:''}">
	<input name="action" type="hidden" value="list">
	<input name="subaction" type="hidden" value="browser_src">
	<input name="field_name" type="hidden" value="{$details.field_name}">
	<input name="src_type" type="hidden" value="{$details.src_type}">
	{if $pager_list.page ne $pager_list.pages}
		<a href="javascript:pagerGo('form_pager_header','next','browser_src');" class="w3-border w3-light-grey w3-round w3-padding-small w3-margin-right-8" style="text-decoration:none">{#LB_next#}</a>
	{else}
		<span class="w3-border w3-text-grey w3-round w3-padding-small w3-margin-right-8">{#LB_next#}</span>
	{/if}
	{if $pager_list.page ne $pager_list.pages}
		<a href="javascript:pagerGo('form_pager_header','last','browser_src');" class="w3-border w3-light-grey w3-round w3-padding-small w3-margin-right-8" style="text-decoration:none">{#LB_last#}</a>
	{else}
		<span class="w3-border w3-text-grey w3-round w3-padding-small w3-margin-right-8">{#LB_last#}</span>
	{/if}
</div>
</form>
<!-- pager -->
{/if}
</div>
</body>
</html>
