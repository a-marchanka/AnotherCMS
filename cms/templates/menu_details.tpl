<!-- COPYRIGHTS Another CMS      -->
{literal}
<script>
function genName() {
	var elemFrom = document.getElementById('title');
	var elemTo = document.getElementById('name');
	var str = elemFrom.value.toLowerCase();
	elemTo.value = str.split(' ').join('_').split('-').join('_');
}
function changeSourceType(src_type) {
	if (src_type == 'module' || src_type == 'url') {
		toggle('content_htm', 0);
		toggle('content_txt', 1);
		toggle('content_fol', 0);
		toggle('content_tab', 1);
	} else if (src_type == 'static') {
		toggle('content_htm', 1);
		toggle('content_txt', 0);
		toggle('content_fol', 0);
		toggle('content_tab', 1);
	} else {
		toggle('content_htm', 0);
		toggle('content_txt', 0);
		toggle('content_fol', 1);
		toggle('content_tab', 0);
	}
}
function loading() {
	toggle('form_details', 0);
	toggle('upload_bar', 1);
}
function saveAndClose() {
	loading();
	document.forms['form_details'].elements['subaction'].value = 'save_close_menu';
	document.forms['form_details'].submit();
}
</script>
{/literal}

{strip}
<form id="form_details" name="form_details" method="post" action="#" onsubmit="loading()" style="display:block;">

<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id|default:0 > 0)}
<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
</div>

<h3>{#LB_details#}</h3>
<div class="w3-half">
<label>{#LB_title#} <span class="w3-text-red">*</span>:</label>
<input name="title" id="title" type="text" value="{$details.title}" size="45" maxlength="128" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label><a href="javascript:javascript:genName()" title="{#LB_refresh#}"><span class="i20s_refr1"></span></a> {#LB_name#}<span class="w3-text-red">*</span>:</label>
<input name="name" id="name" type="text" value="{$details.name}" size="45" maxlength="32" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_webPage#}:</label><br>
	<select name="parent_id" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
	<option value="0">- High level -</option>
	{section name=custom loop=$search_list}
	<option value="{$search_list[custom].id}"{if ($details.parent_id|default:0 == $search_list[custom].id) or (!$details.id and ($search_list[custom].name eq $details_default.mnu_home))} selected="selected"{/if}{if $search_list[custom].content_type eq 'folder'} style="font-weight:bold"{/if}{if $search_list[custom].id eq $details.id} disabled{/if}>{'&nbsp;'|indent:$search_list[custom].level:'- '} {$search_list[custom].title}</option>
	{/section}
	</select>
</div>
<div class="w3-half">
<label>{#LB_description#}:</label>
<input name="description" id="description" type="text" value="{$details.description|default:''}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_keywords#}:</label>
<input name="keywords" id="keywords" type="text" value="{$details.keywords|default:''}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_priority#}:</label>
<input name="priority" id="priority" type="text" value="{$details.priority|default:1}" size="4" maxlength="4" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half w3-margin-bottom-8">
<div class="w3-left w3-margin-right">
	<label>
	<span class="i20s_folder"></span><br>
	<input value="folder"{if $details.content_type eq 'folder'} checked="checked"{/if} type="radio" name="content_type" id="folder" onclick="javascript:changeSourceType('folder')" class="w3-radio">
	&nbsp;{#LB_folder#}</label>
</div>
<div class="w3-left w3-margin-right">
	<label>
	<span class="i20s_static"></span><br>
	<input value="static"{if $details.content_type eq 'static'} checked="checked"{/if} type="radio" name="content_type" id="static" onclick="javascript:changeSourceType('static')" class="w3-radio">
	&nbsp;{#LB_file#}</label>
</div>
<div class="w3-left w3-margin-right">
	<label>
	<span class="i20s_url"></span><br>
	<input value="url"{if $details.content_type eq 'url'} checked="checked"{/if} type="radio" name="content_type" id="url" onclick="javascript:changeSourceType('url')" class="w3-radio">
	&nbsp;{#LB_url#}</label>
</div>
<div class="w3-left w3-margin-right">
	<label>
	<span class="i20s_module"></span><br>
	<input value="module"{if $details.content_type eq 'module'} checked="checked"{/if} type="radio" name="content_type" id="module" onclick="javascript:changeSourceType('module')" class="w3-radio">
	&nbsp;{#LB_module#}</label>
</div>
</div>
<div id="content_tab"{if $details.content_type eq 'folder'} style="display:none;"{else} style="display:block;"{/if} class="w3-clear">
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_content#} <span class="w3-text-red">*</span>:</label>
	<select name="content_htm" id="content_htm"{if $details.content_type eq 'static'} style="max-width:430px;display:block;"{else} style="max-width:430px;display:none;"{/if} class="w3-select w3-border w3-round w3-margin-bottom-8">
	<option value="">--</option>
	{section name=custom loop=$html_list}
	<option value="{$html_list[custom].nameext}"{if ($html_list[custom].nameext eq $details.content_htm)} selected="selected"{/if}>
	{$html_list[custom].nameext}</option>
	{/section}
	</select>
	<input name="content_txt" id="content_txt" type="text" value="{$details.content_txt}" size="45" maxlength="255"{if $details.content_type eq 'url' or $details.content_type eq 'module'} style="display:block;max-width:430px;"{else} style="display:none;max-width:430px;"{/if} class="w3-input w3-border w3-round w3-margin-bottom-8">
	<input name="content_fol" id="content_fol" type="text" value="--" size="45" maxlength="255" disabled{if $details.content_type eq 'folder'} style="display:block;max-width:430px;"{else} style="display:none;max-width:430px;"{/if} class="w3-input w3-border w3-round w3-margin-bottom-8">
<label>{#LB_pattern#} <span class="w3-text-red">*</span>:</label><br>
	<select name="pattern_0" id="pattern_0" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
	<option value="">--</option>
	{section name=custom loop=$tpl_list}
	{if ($tpl_list[custom].name|substr:0:4) eq 'site'}
	<option value="{$tpl_list[custom].nameext}"{if ($tpl_list[custom].nameext eq $details.pattern_0|default:'') or (!$details.id and ($tpl_list[custom].nameext eq $details_default.mnu_pattern_0))} selected="selected"{/if}>{$tpl_list[custom].nameext}</option>
	{/if}
	{/section}
	</select><br>
<label>{#LB_pattern4#} (pattern_content):</label><br>
	<select name="pattern_4" id="pattern_4" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
	<option value="">--</option>
	{section name=custom loop=$tpl_list}
	{if ($tpl_list[custom].nameext|substr:0:7) eq 'content'}
	<option value="{$tpl_list[custom].nameext}"{if ($tpl_list[custom].nameext eq $details.pattern_4|default:'') or (!$details.id and ($tpl_list[custom].nameext eq $details_default.mnu_pattern_4))} selected="selected"{/if}>{$tpl_list[custom].nameext}</option>
	{/if}
	{/section}
	</select><br>
<label>{#LB_pattern5#} (pattern_content_add):</label><br>
	<select name="pattern_5" id="pattern_5" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
	<option value="">--</option>
	{section name=custom loop=$tpl_list}
	{if ($tpl_list[custom].nameext|substr:0:7) eq 'content'}
	<option value="{$tpl_list[custom].nameext}"{if ($tpl_list[custom].nameext eq $details.pattern_5|default:'') or (!$details.id and ($tpl_list[custom].nameext eq $details_default.mnu_pattern_5))} selected="selected"{/if}>{$tpl_list[custom].nameext}</option>
	{/if}
	{/section}
	</select>
</div>
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_pattern1#} (pattern_menu_top):</label><br>
	<select name="pattern_1" id="pattern_1" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
	<option value="">--</option>
	{section name=custom loop=$tpl_list}
	{if ($tpl_list[custom].nameext|substr:0:4) eq 'menu'}
	<option value="{$tpl_list[custom].nameext}"{if ($tpl_list[custom].nameext eq $details.pattern_1|default:'') or (!$details.id and ($tpl_list[custom].nameext eq $details_default.mnu_pattern_1))} selected="selected"{/if}>{$tpl_list[custom].nameext}</option>
	{/if}
	{/section}
	</select><br>
<label>{#LB_pattern2#} (pattern_menu_main):</label><br>
	<select name="pattern_2" id="pattern_2" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
	<option value="">--</option>
	{section name=custom loop=$tpl_list}
	{if ($tpl_list[custom].nameext|substr:0:4) eq 'menu'}
	<option value="{$tpl_list[custom].nameext}"{if ($tpl_list[custom].nameext eq $details.pattern_2|default:'') or (!$details.id and ($tpl_list[custom].nameext eq $details_default.mnu_pattern_2))} selected="selected"{/if}>{$tpl_list[custom].nameext}</option>
	{/if}
	{/section}
	</select><br>
<label>{#LB_pattern3#} (pattern_menu_sub):</label><br>
	<select name="pattern_3" id="pattern_3" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
	<option value="">--</option>
	{section name=custom loop=$tpl_list}
	{if ($tpl_list[custom].nameext|substr:0:4) eq 'menu'}
	<option value="{$tpl_list[custom].nameext}"{if ($tpl_list[custom].nameext eq $details.pattern_3|default:'') or (!$details.id and ($tpl_list[custom].nameext eq $details_default.mnu_pattern_3))} selected="selected"{/if}>{$tpl_list[custom].nameext}</option>
	{/if}
	{/section}
	</select><br>
<label>{#LB_variables#}:</label><br>
	<input name="variables" id="variables" type="text" value="{$details.variables|default:$details_default.mnu_variables}" size="45" maxlength="128" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
</div>
<div class="w3-half">
	<label>{#LB_role#}:</label><br>
	{section name=custom loop=$roles_list}
	<label><input name="role_ids_arr[]" type="checkbox" value="{$roles_list[custom].id}"{section name=arri loop=$details.role_ids_arr}{if $roles_list[custom].id==$details.role_ids_arr[arri]} checked="checked"{/if}{/section} class="w3-check">&nbsp; {$roles_list[custom].role}</label><br>
	{/section}
</div>
</div>
<div class="w3-margin-top w3-clear">
<label><input name="active" id="active" type="checkbox" value="1"{if $details.active|default:0} checked="checked"{/if} class="w3-check"> &nbsp;{#LB_active#}</label>
<div>
<p>
{#LB_modified#}: {$details.modifytime|date_format:"%d.%m.%Y %H:%M"|default:'--'}<br>
{#LB_user#}: {$details.createnick|default:$user_info.nick}
</p>
<input name="action" id="action" type="hidden" value="{if $details.id|default:0}edit{else}create{/if}">
<input name="subaction" id="subaction" type="hidden" value="menu">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="details_id" id="details_id" type="hidden" value="{$details.id|default:0}">
<input name="modifytime" id="modifytime" type="hidden" value="{$details.modifytime|default:0}">
<input name="createnick" id="createnick" type="hidden" value="{if $details.id|default:0}{$details.createnick}{else}{$user_info.nick}{/if}">

<!-- buttons -->
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id|default:0 > 0)}
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
<!-- buttons -->

</form>
{/strip}

<div id="upload_bar" style="display:none;">
<img src="../images/loading.gif" width="32" height="32" alt="{#LB_loading#}" style="padding:20px;">
</div>

<hr class="w3-light-grey">

<script>
toggle('upload_bar', 0);
</script>

