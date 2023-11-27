<!-- COPYRIGHTS Another CMS      -->
{literal}
<!-- TinyMCE -->
<script src="../libs/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
	selector:'textarea#editor_content',
	theme:'modern',
	resize:true,
	plugins:['advlist autolink link image lists charmap hr anchor pagebreak searchreplace visualblocks visualchars',
		 'code fullscreen media nonbreaking table directionality template paste textcolor'],
	menubar:false,
	visual:true,
	toolbar1:'newdocument fullscreen | bold italic underline strikethrough | blockquote subscript superscript | alignleft aligncenter alignright alignjustify | styleselect formatselect',
	toolbar2:'undo redo | bullist numlist table | template link image media | hr anchor charmap nonbreaking | forecolor backcolor removeformat code',
	extended_valid_elements:'img[class|style|src|alt|title|width|height|onmouseover|onmouseout|name],hr[class|style],script[src|type]',
	link_list:'?entry_id=111&action=list&subaction=list_js_url&{/literal}{$SID}{literal}',
	image_list:'?entry_id=112&action=list&subaction=list_js_img&{/literal}{$SID}{literal}',
	templates:'?entry_id=121&action=list&subaction=list_js_tpl&{/literal}{$SID}{literal}',
	file_browser_callback:fileBrowserCallBack,
	language:'{/literal}{$ui_lang}{literal}',
	document_base_url:'{/literal}{$site_url}{literal}/',
	convert_urls:true,
	relative_urls:false,
	remove_script_host:true,
	content_css : '{/literal}{$tinymce_css}{literal}',
	style_formats: [
        {title:'Bold text', inline:'b'},
        {title:'Red text', inline:'span', styles: {color:'#ff0000'}},
        {title:'Red header', block:'h1', styles: {color:'#ff0000'}},
        {title:'Example 1', inline:'span', classes:'example1'},
        {title:'Example 2', inline:'span', classes:'example2'},
        {title:'Table styles'},
        {title:'Table row 1', selector:'tr', classes:'tablerow1'}
    ]
});
function fileBrowserCallBack(field_name, field_url, src_type, win) {
	if (window.innerWidth < 600) var win_width = 380;
	else var win_width = 800;
	var win_height = Math.round(0.9*window.innerHeight);
	tiny_win = win;
	if (src_type == 'image')
		var browser_request = "?entry_id=112&action=list&subaction=browser&src_type="+src_type+"&field_name="+field_name+"&field_url="+field_url+"&"+var_sid;
	else
		var browser_request = "?entry_id=121&action=list&subaction=browser&src_type="+src_type+"&field_name="+field_name+"&field_url="+field_url+"&"+var_sid;
	tinyMCE.activeEditor.windowManager.open(
	{
	file: browser_request,
	title: 'File Browser',
	width: win_width,
	height: win_height,
	resizable: 'yes',
	inline: 'yes',
	close_previous: 'no' },
	{
	window: win, input: field_name }
	);
	return false;
}
function genName() {
	var elemFrom = document.getElementById('title');
	var elemTo = document.getElementById('name');
	var elemFile = document.getElementById('content_htm');
	var str = elemFrom.value.toLowerCase();
	elemTo.value = str.split(' ').join('_').split('-').join('_');
	elemFile.value = str.split(' ').join('_').split('-').join('_') + '.html';
}
function loading() {
	toggle('mceEditor', 0);
	toggle('upload_bar', 1);
}
function saveAndClose() {
	loading();
	document.forms['mceEditor'].elements['subaction'].value = 'save_close_mceedit';
	document.forms['mceEditor'].submit();
}
</script>
<!-- /TinyMCE -->
{/literal}
<form id="mceEditor" name="mceEditor" method="post" action="#" onsubmit="loading()" style="display:block;">

<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id|default:0 > 0)}
<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
</div>

<h3>{#LB_details#}</h3>

<div class="w3-half w3-margin-bottom-8">
<label>{#LB_title#} <span class="w3-text-red">*</span>:</label>
<input name="title" id="title" type="text" value="{$details.title}" size="45" maxlength="128" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
</div>
<div class="w3-half w3-margin-bottom-8">
<label><a href="javascript:javascript:genName()">{#LB_name#}</a> <span class="w3-text-red">*</span>:</label>
<input name="name" id="name" type="text" value="{$details.name}" size="45" maxlength="32" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
</div>
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_file#}:</label>
<input name="content_htm" id="content_htm" type="text" value="{$details.content_htm}" size="32" maxlength="128" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
</div>
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_webPage#}:</label><br>
	<select name="parent_id" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
	<option value="0">- High level -</option>
	{section name=custom loop=$search_list}
	<option value="{$search_list[custom].id}"{if ($details.parent_id|default:0 eq $search_list[custom].id) or (!$details.id and ($search_list[custom].name eq $details_default.mnu_home))} selected="selected"{/if}{if $search_list[custom].content_type eq 'folder'} style="font-weight:bold"{/if}{if $search_list[custom].id eq $details.id} disabled{/if}>{'&nbsp;'|indent:$search_list[custom].level:'- '} {$search_list[custom].title}</option>
	{/section}
	</select>
</div>
<div class="w3-clear w3-margin-top-8 w3-margin-bottom-8">
<textarea id="editor_content" name="editor_content" cols="80" rows="25" class="w3-input w3-border w3-round" style="width:98%;height:350px;background-color:#F9F9F9;">{$editor_content}</textarea>
</div>
<div class="w3-margin-bottom-8">
<label>{#LB_priority#}:</label>
<input name="priority" id="priority" type="text" value="{$details.priority|default:1}" size="4" maxlength="4" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<label><input name="active" id="active" type="checkbox" value="1"{if $details.active|default:0} checked="checked"{/if} class="w3-check"> &nbsp;{#LB_active#}</label>
</div>
<p>
{#LB_modified#}: {$details.modifytime|date_format:"%d.%m.%Y %H:%M"|default:'--'}<br>
{#LB_user#}: {$details.createnick|default:$user_info.nick}
</p>
<input name="description" id="description" type="hidden" value="{$details.description|default:''}">
<input name="keywords" id="keywords" type="hidden" value="{$details.keywords|default:''}">
<input name="content_type" id="content_type" type="hidden" value="static">
<input name="variables" id="variables" type="hidden" value="{$details.variables|default:''}">
<input name="pattern_0" id="pattern_0" type="hidden" value="{if $details.id|default:0}{$details.pattern_0}{else}{$details_default.mnu_pattern_0}{/if}">
<input name="pattern_1" id="pattern_1" type="hidden" value="{if $details.id|default:0}{$details.pattern_1}{else}{$details_default.mnu_pattern_1}{/if}">
<input name="pattern_2" id="pattern_2" type="hidden" value="{if $details.id|default:0}{$details.pattern_2}{else}{$details_default.mnu_pattern_2}{/if}">
<input name="pattern_3" id="pattern_3" type="hidden" value="{if $details.id|default:0}{$details.pattern_3}{else}{$details_default.mnu_pattern_3}{/if}">
<input name="pattern_4" id="pattern_4" type="hidden" value="{if $details.id|default:0}{$details.pattern_4}{else}{$details_default.mnu_pattern_4}{/if}">
<input name="pattern_5" id="pattern_5" type="hidden" value="{if $details.id|default:0}{$details.pattern_5}{else}{$details_default.mnu_pattern_5}{/if}">
<input name="role_ids" id="role_ids" type="hidden" value="{$details.role_ids|default:''}">
<input name="action" id="action" type="hidden" value="{if $details.id|default:0}edit{else}create{/if}">
<input name="subaction" id="subaction" type="hidden" value="mceedit">
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

<div id="upload_bar" style="display:none;">
<img src="../images/loading.gif" width="32" height="32" alt="{#LB_loading#}" style="padding:20px;">
</div>

<hr class="w3-light-grey">

<script>toggle('upload_bar', 0);</script>

