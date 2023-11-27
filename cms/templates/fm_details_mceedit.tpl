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
function loading() {
	toggle('mceEditor', 0);
	toggle('upload_bar', 1);
}
function saveAndClose() {
	loading();
	document.forms['mceEditor'].elements['subaction'].value = 'mcecontent_close';
	document.forms['mceEditor'].submit();
}
</script>
<!-- /TinyMCE -->
{/literal}

<form id="mceEditor" name="mceEditor" method="post" action="#" onsubmit="loading()" style="display:block;">
<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id > 0)}
<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
{if $details.name}
<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
{/if}
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="rScr('list&amp;dir={$details.dir}','')" value="{#LB_close#}">
</div>

<h3>{#LB_details#}</h3>

<div class="w3-margin-bottom-8">
<label>{#LB_path#} <span class="w3-text-red">*</span>:</label> <b>/{$details.dir}</b>
</div>
<div class="w3-margin-bottom-8">
<label>{#LB_file#}:</label>
{if $details.name}
	<b>{$details.name_new}.{$details.ext|default:'html'}</b>
	<input name="name_new" id="name_new" type="hidden" value="{$details.name_new}">
{else}
	<b>.html</b>
	<input name="name_new" id="name_new" type="text" value="{$details.name_new}" size="35" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required >
{/if}
<input name="ext" id="ext" type="hidden" value="{$details.ext|default:'html'}">
{if $details.name}
	<a class="lytebox" title="{#LB_preview#}" href="?{$SID}&amp;entry_id={$entry_id}&amp;action=details&amp;subaction=preview&amp;dir={$details.dir}&amp;name={$details.name}&amp;ext={$details.ext}"><span style="display:inline-block;background-color:#eaeaea;border:1px solid #ccc;color:#000;cursor:pointer;font-size:13px;margin:1px;outline-style:none;outline-width:0;padding:5px;border-radius:3px;">{#LB_preview#}</span></a>
{/if}
</div>
<div class="w3-margin-top-8 w3-margin-bottom">
<textarea id="editor_content" name="editor_content" cols="80" rows="25" class="w3-input w3-border w3-round" style="width:98%;height:350px;background-color:#F9F9F9;">{$editor_content}</textarea>
</div>
<input name="action" id="action" type="hidden" value="{if $details.name}edit{else}create{/if}">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="attr" id="attr" type="hidden" value="{$details.attr|default:'0644'}">
<input name="dir" id="dir" type="hidden" value="{$details.dir}">
<input name="subaction" id="subaction" type="hidden" value="mcecontent">
<input name="name" id="name" type="hidden" value="{$details.name}">

<!-- buttons -->
{if $entry_info.entry_attr > 1}
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
{if $details.name}
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
{/if}
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="rScr('list&amp;dir={$details.dir}','')" value="{#LB_close#}">
<!-- buttons -->

</form>

<div id="upload_bar" style="display:none;">
<img src="../images/loading.gif" width="32" height="32" alt="{#LB_loading#}" style="padding:20px;">
</div>

<hr class="w3-light-grey">

<script>toggle('upload_bar', 0);</script>

