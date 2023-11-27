<!-- COPYRIGHTS Another CMS      -->
{literal}
<script>
function oDel(ft, fn, ext) {
	oFmCnfr('delete',ft,'{/literal}{$path_current}{literal}',fn,ext,'{/literal}{#LB_delete#}{literal} '+fn+(ext?('.'+ext):'')+'?');
}
</script>
{/literal}
{strip}
<!-- filter -->
<form id="form_search_header" method="post" action="#">
<div class="w3-row">
	<input class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-light-grey" onclick="javascript:rFmScr('list','','','','')" value="&nbsp;./&nbsp;" type="button">
	{section name=path_item loop=$path_array}
	<input class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-light-grey" onclick="javascript:rFmScr('list','','{$path_array[path_item].path}','','')" value="{$path_array[path_item].name}/" type="button">
	{/section}
	<!-- buttons -->
	<div class="w3-right w3-hide-small w3-hide-medium">
	{if $entry_info.entry_attr > 2}
	<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oFmDir('{$entry_id}','details','mceedit','{$path_current}')" value="{#LB_newHtml#}">
	<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oFmDir('{$entry_id}','details','txtedit','{$path_current}')" value="{#LB_newTxt#}">
	<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oFmDir('{$entry_id}','details','dir','{$path_current}')" value="{#LB_newFolder#}">
	<input id="TnewObj4" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details&amp;dir={$path_current}','upload')" value="{#LB_upload#}">
	<input id="TnewObj5" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oFmDir('{$entry_id}','details','utils','{$path_current}')" value="{#LB_utils#}">
	{/if}
	</div>
</div>
</form>
<!-- list -->
<table class="w3-table w3-bordered w3-striped">
<tr>
<th>{#LB_name#}</th>
<th>{#LB_edit#}</th>
<th class="w3-hide-small">{#LB_options#}</th>
<th class="w3-hide-small">{#LB_size#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_attributes#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_date#}</th>
<th class="w3-center">{#LB_delete#}</th>
</tr>
{section name=item loop=$files_list}
	<tr>
	<td>
	{if $files_list[item].type eq 'dir'}
		<a href="javascript:rFmScr('list','','{$path_current}{$files_list[item].name}/','','');" style="text-decoration:none">
		<span class="i20s_folder"></span>
		{$files_list[item].name}</a>
	{else}
		{if $entry_info.entry_attr > 0}
			{if $files_list[item].ext eq 'html' or $files_list[item].ext eq 'htm' or $files_list[item].ext eq 'tpl'}
			<a href="javascript:rFmScr('details','mceedit','{$path_current}','{$files_list[item].name}','{$files_list[item].ext}');" style="text-decoration:none">
			<span class="i20s_{$files_list[item].ext|lower}"></span>
			{$files_list[item].name}{if $files_list[item].ext}.{$files_list[item].ext}{/if}</a>
			{else}
			{if $files_list[item].ext eq 'php' or $files_list[item].ext eq 'js' or $files_list[item].ext eq 'txt' or $files_list[item].ext eq 'css' or $files_list[item].ext eq 'sql'}
			<a href="javascript:rFmScr('details','txtedit','{$path_current}','{$files_list[item].name}','{$files_list[item].ext}');" style="text-decoration:none">
			<span class="i20s_{$files_list[item].ext|lower}"></span>
			{$files_list[item].name}{if $files_list[item].ext}.{$files_list[item].ext}{/if}</a>
			{else}
			<span class="i20s_{$files_list[item].ext|lower}"></span>
			{$files_list[item].name}{if $files_list[item].ext}.{$files_list[item].ext}{/if}
			{/if}
			{/if}
		{else}
        		<span class="i20s_file"></span>
			{$files_list[item].name}{if $files_list[item].ext}.{$files_list[item].ext}{/if}
		{/if}
	{/if}
	</td>
	<td>
	{if $entry_info.entry_attr > 2}
		<a href="javascript:rScr('details&amp;dir={$path_current}&amp;name={$files_list[item].name}&amp;ext={$files_list[item].ext}','{$files_list[item].type}');" class="i20s_ch" title="{#LB_change#}"></a>
	{/if}
	{if $files_list[item].type eq 'file'}
		{if ($entry_info.entry_attr > 0) and ($files_list[item].name eq '.htaccess' or $files_list[item].name eq '.htpasswd' or $files_list[item].ext eq 'tpl' or $files_list[item].ext eq 'xml' or $files_list[item].ext eq 'txt' or $files_list[item].ext eq 'csv' or $files_list[item].ext eq 'css' or $files_list[item].ext eq 'sql' or $files_list[item].ext eq 'js' or $files_list[item].ext eq 'php' or $files_list[item].ext eq 'html' or $files_list[item].ext eq 'htm' or $files_list[item].ext eq 'conf' or $files_list[item].ext eq 'm3u')}
			<a href="javascript:rFmScr('details','txtedit','{$path_current}','{$files_list[item].name}','{$files_list[item].ext}');" class="i20s_md" title="{#LB_textEdit#}"></a>
		{/if}
	{/if}
	{if $files_list[item].type eq 'file'}
		{if ($entry_info.entry_attr > 0) and ($files_list[item].ext eq 'html' or $files_list[item].ext eq 'htm' or $files_list[item].ext eq 'tpl')}
			<a href="javascript:rFmScr('details','mceedit','{$path_current}','{$files_list[item].name}','{$files_list[item].ext}');" class="i20s_ed" title="{#LB_htmlEdit#}"></a>
		{/if}
	{/if}
    	</td>
	<td class="w3-hide-small">
   	{if $files_list[item].type eq 'file'}
		{if $entry_info.entry_attr > 2}
			<a href="javascript:rScr('details&amp;dir={$path_current}&amp;name={$files_list[item].name}&amp;ext={$files_list[item].ext}','copy');" class="i20s_copy" title="{#LB_copy#}"></a>
		{/if}
	{/if}
   	{if $files_list[item].type eq 'file'}
	{if ($entry_info.entry_attr > 0) and ($files_list[item].ext eq 'mov' or $files_list[item].ext eq 'mpg' or $files_list[item].ext eq 'webm' or $files_list[item].ext eq 'mp4' or $files_list[item].ext eq 'mp3' or $files_list[item].ext eq 'm4a')}
		<a class="lytebox" data-lyte-options="group:gal" title="{#LB_preview#}" href="/{$path_current}{$files_list[item].name}.{$files_list[item].ext}"><div class="i20s_pre"></div></a>
	{else}
		<a class="lytebox" data-lyte-options="group:gal" title="{#LB_preview#}" href="?{$SID}&amp;entry_id={$entry_id}&amp;action=details&amp;subaction=preview&amp;dir={$path_current}&amp;name={$files_list[item].name}&amp;ext={$files_list[item].ext}"><div class="i20s_pre"></div></a>
	{/if}
	<a href="javascript:oFmDtl('download','{$path_current}','{$files_list[item].name}','{$files_list[item].ext}');" class="i20s_down" title="{#LB_download#}"></a>
	{/if}
	</td>
	<td class="w3-hide-small">{$files_list[item].size}</td>
	<td class="w3-hide-small w3-hide-medium">{$files_list[item].attr}</td>
	<td class="w3-hide-small w3-hide-medium">{$files_list[item].mtime|date_format:"%d.%m.%Y %H:%M"}</td>
	<td style="text-align:center; text-align:-webkit-center; text-align:-moz-center;">
	{if $entry_info.entry_attr > 2}
		<a href="javascript:oDel('{$files_list[item].type}','{$files_list[item].name}','{$files_list[item].ext}');" class="i20s_del" title="{#LB_delete#}"></a>
	{else}
		<span class="i20s_del0"></span>
	{/if}
	</td>
	</tr>
{/section}
</table>
<!-- list -->

<!-- buttons -->
<div class="w3-row">
{if $entry_info.entry_attr > 2} &nbsp;<br>
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oFmDir('{$entry_id}','details','mceedit','{$path_current}')" value="{#LB_newHtml#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oFmDir('{$entry_id}','details','txtedit','{$path_current}')" value="{#LB_newTxt#}">
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oFmDir('{$entry_id}','details','dir','{$path_current}')" value="{#LB_newFolder#}">
<input id="newObj4" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details&amp;dir={$path_current}','upload')" value="{#LB_upload#}">
<input id="newObj5" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oFmDir('{$entry_id}','details','utils','{$path_current}')" value="{#LB_utils#}">
{/if}
</div>
<hr class="w3-light-grey">
{/strip}
