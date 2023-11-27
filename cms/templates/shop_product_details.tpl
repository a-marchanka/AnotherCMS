<!-- COPYRIGHTS Another CMS      -->
{literal}
<!-- TinyMCE -->
<script src="../libs/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
	selector:'textarea#descr',
	theme:'modern',
	resize:true,
	plugins:['advlist autolink image lists hr pagebreak searchreplace visualblocks visualchars',
		 'code fullscreen media table template paste textcolor'],
	menubar:false,
	visual:true,
	toolbar1:'newdocument fullscreen undo redo | bold italic | styleselect formatselect | bullist table image media hr forecolor backcolor removeformat code',
	toolbar2:false,
	extended_valid_elements:'img[class|style|src|alt|title|width|height|onmouseover|onmouseout|name],hr[class|style],script[src|type]',
	link_list:'?entry_id=111&action=list&subaction=list_js_url&{/literal}{$SID}{literal}',
	image_list:'?entry_id=112&action=list&subaction=list_js_img&{/literal}{$SID}{literal}',
	templates:'?entry_id=121&action=list&subaction=list_js_tpl&{/literal}{$SID}{literal}',
	file_browser_callback:fileBrowserCallBack,
	language:'{/literal}{$ui_lang}{literal}',
	document_base_url:'{/literal}{$site_url}{literal}/',
	convert_urls:false,
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
	if (window.innerWidth < 600) var win_width = 400;
	else var win_width = 600;
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
function oBrowser(field_source) {
	if (window.innerWidth < 600) {
		var bw = 380; var bl = 10; var bt = 10;
	} else {
		var bw = 800; var bl = 100; var bt = 50;
	}
	var bh = Math.round(0.9*window.innerHeight);
	//browser_url = this.location.pathname + browser_url;
	browser_request = "?entry_id=112&action=list&subaction=browser_src&src_type=image&field_name=" + field_source + "&" + var_sid;
	fileBrowserPopup = open(browser_request, "imageBrowser", "modal, width=" + bw + ", height=" + bh + ", status=yes, toolbar=no, menubar=no, scrollbars=yes, resizable=yes, left=" + bl + ", top=" + bt);
}
function loading() {
	toggle('form_details', 0);
	toggle('upload_bar', 1);
}
function saveAndClose() {
	loading();
	document.forms['form_details'].elements['subaction'].value = 'save_close';
	document.forms['form_details'].submit();
}
</script>
{/literal}

<form id="form_details" name="form_details" method="post" action="#" onsubmit="loading()" style="display:block;">
<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id|default:0 > 0)}
<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
{if $details.id|default:0}<input id="TnewObj4" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','options&amp;details_id={$details.id}')" value="{#LB_options#}">{/if}
</div>

<h3>{#LB_details#}</h3>

<div class="w3-half w3-margin-bottom-8">
<label>{#LB_title#} <span class="w3-text-red">*</span>:</label>
<input name="title" id="title" type="text" value="{$details.title}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_webPage#}:</label><br>
<select name="menu_main_id" id="menu_main_id" class="w3-select w3-border w3-round w3-margin-bottom-8 w3-margin-right" style="max-width:430px;">
<option value="0">---</option>
{section name=item loop=$search_list}
	<option value="{$search_list[item].id}"{if $details.menu_main_id eq $search_list[item].id} selected="selected"{/if}>
	{'&nbsp;'|indent:$search_list[item].level:'- '} {$search_list[item].title}
	</option>
{/section}
</select><br>
{if $details.id|default:0 and $details.image}
<a onmouseover="toggle('opt_{$details.id}',-1)" onmouseout="toggle('opt_{$details.id}',-1)"><span class="i20s_jpg"></span></a>
<img src="../content/images/thumbs/{$details.image}" alt="{$details.image}" title="{$details.image}" width="75" height="75" id="opt_{$details.id}" style="display:none;position:absolute;clear:both;margin-top:22px;padding:4px;background-color:white;border-radius:3px;box-shadow:0 0 3px #888;z-index:3;"></a>
{/if}
<label class="w3-block">{#LB_image#}:</label>
<input name="image" id="image" type="text" value="{$details.image|default:''}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8 w3-left w3-margin-right" style="max-width:340px;">
<input name="trigger" id="trigger" type="button" onclick="oBrowser('image')" value="{#LB_search#}" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme">
</div>
<div class="w3-half w3-margin-bottom-8">
<div class="w3-half">
<label>{#LB_productNumber#}:</label>
<input name="pr_number" id="pr_number" type="text" value="{$details.pr_number|default:'--'}" size="5" maxlength="30" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<label>{#LB_count#} {#LB_total#}:</label>
<input name="amount_total" id="amount_total" type="text" value="{$details.amount_total|default:0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<p><label>{#LB_type#}:</label><br>
<input value="product"{if $details.product_type eq 'product'} checked="checked"{/if} type="radio" name="product_type" class="w3-radio">
<label>&nbsp;{#LB_product#}</label>&nbsp; &nbsp;<input value="service"{if $details.product_type eq 'service'} checked="checked"{/if} type="radio" name="product_type" class="w3-radio">
<label>&nbsp;{#LB_service#}</label></p>
</div>
<div class="w3-half">
<label>{#LB_priority#}:</label>
<input name="priority" id="priority" type="text" value="{$details.priority|default:10}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<label>{#LB_weight#}:</label>
<input name="weight_kg" id="weight_kg" type="text" value="{$details.weight_kg|default:0.1}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<label>{#LB_length#}:</label>
<input name="length_cm" id="length_cm" type="text" value="{$details.length_cm|default:0.1}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
</div>
<div class="w3-clear w3-margin-top-8 w3-margin-bottom-8">
<textarea id="descr" name="descr" cols="80" rows="25" class="w3-input w3-border w3-round" style="width:97%;height:300px;background-color:#F9F9F9;">{$details.descr}</textarea>
</div>
<div class="w3-half">
<div class="w3-half">
	<label>1. {#LB_piece#}:</label>
	<input name="amount" id="amount" type="text" value="{$details.amount|default:'0'}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
	<label>1. {#LB_price#}:</label>
	<input name="price" id="price" type="text" value="{$details.price|default:'0'}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
	<label>2. {#LB_piece#}:</label>
	<input name="amount_1" id="amount_1" type="text" value="{$details.amount_1|default:'0'}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
	<label>2. {#LB_price#}:</label>
	<input name="price_1" id="price_1" type="text" value="{$details.price_1|default:'0'}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
	<label>3. {#LB_piece#}:</label>
	<input name="amount_2" id="amount_2" type="text" value="{$details.amount_2|default:'0'}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
	<label>3. {#LB_price#}:</label>
	<input name="price_2" id="price_2" type="text" value="{$details.price_2|default:'0'}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
	<label>4. {#LB_piece#}:</label>
	<input name="amount_3" id="amount_3" type="text" value="{$details.amount_3|default:0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
	<label>4. {#LB_price#}:</label>
	<input name="price_3" id="price_3" type="text" value="{$details.price_3|default:0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
</div>
<div class="w3-half">
	<label>{#LB_tax#}:</label>
	<input name="tax" id="tax" type="text" value="{$details.tax|default:0.0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
	<label>{#LB_currency#}:</label>
	<input name="currency" id="currency" type="text" value="{$details.currency|default:''}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>

<p class="w3-clear">
<p><label>{#LB_status#}: </label>
{section name=itr loop=$status_list}
	<input value="{$status_list[itr].id}"{if $details.status == $status_list[itr].id} checked="checked"{/if} type="radio" name="status" class="w3-radio">
	<label>&nbsp;{$status_list[itr].title}</label>&nbsp; &nbsp;
{/section}
</p>
<p>
{#LB_modified#}: {$details.modifytime|date_format:"%d.%m.%Y %H:%M"|default:'--'}<br>
{#LB_user#}: {$details.createnick|default:$user_info.nick}
</p>
<input name="family_ids" id="family_ids" type="hidden" value="{$details.family_ids|default:''}">
<input name="old_status" id="old_status" type="hidden" value="{$details.status|default:0}">
<input name="action" id="action" type="hidden" value="{if $details.id|default:0}edit{else}create{/if}">
<input name="subaction" id="subaction" type="hidden" value="product">
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
{if $details.id|default:0}<input id="newObj4" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','options&amp;details_id={$details.id}')" value="{#LB_options#}">{/if}
<!-- buttons -->

</form>

<div id="upload_bar" style="display:none;">
<img src="../images/loading.gif" width="32" height="32" alt="{#LB_loading#}" style="padding:20px;">
</div>

<hr class="w3-light-grey">

<script>toggle('upload_bar', 0);</script>

