<!-- COPYRIGHTS Another CMS      -->
{literal}
<!-- TinyMCE -->
<script src="../libs/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
	selector:'textarea#message',
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
function loading() {
	toggle('mceEditor', 0);
	toggle('upload_bar', 1);
}
function saveAndClose() {
	loading();
	document.forms['mceEditor'].elements['subaction'].value = 'save_close';
	document.forms['mceEditor'].submit();
}
</script>
<!-- /TinyMCE -->
{/literal}
<!-- CALENDAR -->
<link href="../libs/calendar/{$cms_theme|default:'core'}.css" rel="stylesheet" type="text/css">
<script src="../libs/calendar/calendar.js"></script>
<script src="../libs/calendar/lang/calendar-{$ui_lang|default:'en'}.js"></script>
<script src="../libs/calendar/calendar-setup.js"></script>

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
<input name="title" id="title" type="text" value="{$details.title}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_webPage#}:</label><br>
<select name="menu_id" id="menu_id" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<option value="0">---</option>
{section name=custom loop=$search_list}
	<option value="{$search_list[custom].id}"{if $details.menu_id eq $search_list[custom].id} selected="selected"{/if}>
	{'&nbsp;'|indent:$search_list[custom].level:'- '} {$search_list[custom].title}
	</option>
{/section}
</select>
</div>
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_validTo#}:</label>
<input name="validetime" id="validetime" type="text" value="{$details.validetime|date_format:"%d.%m.%Y"|default:"--"}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<input name="trigger" id="trigger" type="button" value="{#LB_calendar#}" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme">
	<!-- CALENDAR -->
	{literal}
	<script>
	  Calendar.setup( {
		inputField:"validetime",
		ifFormat:"%d.%m.%Y",
		button:"trigger"
		} );
	</script>
	{/literal}
</div>
<div class="w3-clear w3-margin-top-8 w3-margin-bottom-8">
<textarea id="message" name="message" cols="80" rows="25" class="w3-input w3-border w3-round" style="width:98%;height:350px;background-color:#F9F9F9;">{$details.message}</textarea>
</div>
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_priority#}:</label>
<input name="priority" id="priority" type="text" value="{$details.priority|default:1}" size="4" maxlength="4" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_lang#}:</label>
<input name="ui_lang" id="ui_lang" type="text" value="{$details.ui_lang|default:$ui_lang}" size="4" maxlength="4" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-margin-top w3-clear">
<label>{#LB_status#}: </label> &nbsp; 
{section name=status_counter loop=$status_list}
	<label{if $details.status == $status_list[status_counter].id}{if $details.status<2} style="background-color:#FFDFDF"{elseif $details.status==2} style="background-color:#FFFF00"{else} style="background-color:#DFFFDF"{/if}{/if}><input value="{$status_list[status_counter].id}"{if $details.status == $status_list[status_counter].id} checked="checked"{/if} type="radio" name="status" class="w3-radio">
	&nbsp;{$status_list[status_counter].title}</label>&nbsp; &nbsp;
{/section}
<p>
{#LB_modified#}: {$details.modifytime|date_format:"%d.%m.%Y %H:%M"|default:"--"}<br>
{#LB_user#}: {$details.createnick|default:$user_info.nick}</p>
</div>
<input name="old_status" id="old_status" type="hidden" value="{$details.status}">
<input name="action" id="action" type="hidden" value="{if $details.id|default:0}edit{else}create{/if}">
<input name="subaction" id="subaction" type="hidden" value="news">
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

<script>
toggle('upload_bar', 0);
</script>
