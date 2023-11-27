<!-- COPYRIGHTS Another CMS      -->
{literal}
<script>
function loading() {
	toggle('form_details', 0);
	toggle('upload_bar', 1);
}
function saveAndClose() {
	loading();
	document.forms['form_details'].elements['subaction'].value = 'save_close_options';
	document.forms['form_details'].submit();
}
</script>
{/literal}

<form id="form_details" name="form_details" method="post" action="#" onsubmit="loading()" style="display:block;">

<div class="w3-half">
<h3>{#LB_details#}</h3>

<table class="w3-table w3-bordered w3-striped" style="width:96%">
<tr>
<th>{#LB_id#}</th>
<th>{#LB_title#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_productNumber#}</th>
<th>{#LB_image#}</th>
<th>{#LB_status#}</th>
</tr>
<tr>
<td>{$details.id}</td>
<td style="max-width:370px">{$details.title}</td>
<td class="w3-hide-small w3-hide-medium">{$details.pr_number}</td>
<td>
{if $details.image and $details.image|count_characters > 4}
<a onmouseover="toggle('det_{$details.id}',-1)" onmouseout="toggle('det_{$details.id}',-1)"><span class="i20s_jpg"></span></a>
<img src="../content/images/thumbs/{$details.image}" alt="{$details.image}" title="{$details.image}" width="75" height="75" id="det_{$details.id}" style="display:none; position:absolute; clear:both; margin-top:22px; padding:4px; background-color:white; border-radius:3px; box-shadow:0 0 3px #888;"></a>
{else}--{/if}
</td>
<td>
{if $details.status == 4}
<span class="i20s_inact" title="{#LB_special#}"></span>
{elseif $details.status == 3}
<span class="i20s_new" title="{#LB_newProduct#}"></span>
{elseif $details.status == 2}
<span class="i20s_act" title="{#LB_active#}"></span>
{else}
<span class="i20s_inact0" title="{#LB_inactive#}"></span>
{/if}
</td>
</tr>
</table>

<h3>{#LB_productFamily#}</h3>
{if $details_items}
<table class="w3-table w3-bordered w3-striped" style="width:96%">
<tr>
<th>{#LB_id#}</th>
<th>{#LB_title#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_productNumber#}</th>
<th>{#LB_image#}</th>
<th>{#LB_status#}</th>
</tr>
{section name=item loop=$details_items}
	<tr>
	<td>{$details_items[item].id}</td>
	<td style="max-width:370px">{$details_items[item].title}</td>
	<td class="w3-hide-small w3-hide-medium">{$details_items[item].pr_number}</td>
	<td>
	{if $details_items[item].image|count_characters > 4}
	<a onmouseover="toggle('opt_{$details_items[item].id}',-1)" onmouseout="toggle('opt_{$details_items[item].id}',-1)"><span class="i20s_jpg"></span></a>
	<img src="../content/images/thumbs/{$details_items[item].image}" alt="{$details_items[item].image}" title="{$details_items[item].image}" width="75" height="75" id="opt_{$details_items[item].id}" style="display:none; position:absolute; clear:both; margin-top:22px; padding:4px; background-color:white; border-radius:3px; box-shadow:0 0 3px #888;"></a>
	{else}--{/if}
	</td>
	<td>
	{if $details_items[item].status == 4}
	<span class="i20s_inact" title="{#LB_special#}"></span>
	{elseif $details_items[item].status == 3}
	<span class="i20s_new" title="{#LB_newProduct#}"></span>
	{elseif $details_items[item].status == 2}
	<span class="i20s_act" title="{#LB_active#}"></span>
	{else}
	<span class="i20s_inact0" title="{#LB_inactive#}"></span>
	{/if}
	</td>
	</tr>
{/section}
</table>
{else}
{#LB_empty#}
{/if}
</div>

<div class="w3-half">
<h3>{#LB_edit#}</h3>
	<label>{#LB_ids#}:</label>
	<input name="family_ids" id="family_ids" type="text" value="{$details.family_ids|default:''}" size="50" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom" style="max-width:500px;">
	<div style="float:left; max-width:220px;">
	{#LB_search#}:
	<input name="filter" id="filter" maxlength="128" onkeyup="filterObj.set(this.value)" value="{$details_search.filter|default:''}" class="w3-input w3-border w3-round w3-margin-bottom-8">
	<input name="filter_clean" id="filter_clean" type="button" onclick="resetItem()" value="{#LB_delete#}" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme">
	</div>
	<div style="float:left; min-width:300px; max-width:450px;">
	<select name="filter_list" id="filter_list" onchange="javascript:selectItem()" size="6" class="w3-input w3-border w3-round" style"overflow:auto;">
	{section name=item loop=$details_all}
		<option value="{$details_all[item].id}">{$details_all[item].id}. {$details_all[item].title}</option>
	{/section}
	</select>
	</div>
<p class="w3-clear"></p>
<!-- buttons -->
{if $entry_info.entry_attr > 2}
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','product')" value="{#LB_close#}">
<!-- buttons -->
</div>

<p class="w3-clear"></p>
<input name="action" id="action" type="hidden" value="edit">
<input name="subaction" id="subaction" type="hidden" value="product_options">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="details_id" id="details_id" type="hidden" value="{$details.id|default:0}">
<input name="modifytime" id="modifytime" type="hidden" value="{$details.modifytime|default:0}">

<input name="title" id="title" type="hidden" value="{$details.title|default:''}">
<input name="pr_number" id="pr_number" type="hidden" value="{$details.pr_number|default:''}">
<input name="image" id="image" type="hidden" value="{$details.image|default:''}">
<input name="family_ids_old" id="family_ids_old" type="hidden" value="{$details.family_ids|default:''}">
<input name="status" id="status" type="hidden" value="{$details.status|default:''}">

</form>

<div id="upload_bar" style="display:none;">
<img src="../images/loading.gif" width="32" height="32" alt="{#LB_loading#}" style="padding:20px;">
</div>

<hr class="w3-light-grey">

<script>toggle('upload_bar', 0);</script>
{literal}
<script>
/** Object filtert die Liste */
function filterList(targetObj) {
	// PARAMETERS
	this.targetObj = targetObj;
	this.flags = 'i'; // 'i' = ignore case, '' - do not igrore
	this.default_text = 'keine Treffer';
	this.default_value = '0';
	this.out_limit = 10;
	this.show_debug = false; // debug alert
	// METHODS
	this.init = function() {
		if (!this.targetObj) return false;
		if (!this.targetObj.options) return false;
		this.optionscopy = new Array();
		if (this.targetObj && this.targetObj.options) {
			var sum = this.targetObj.options.length;
			for (var i = 0; i < sum; i ++) {
				this.optionscopy[i] = new Option();
				this.optionscopy[i].text = targetObj.options[i].text; // set text
				if (targetObj.options[i].value)
					this.optionscopy[i].value = targetObj.options[i].value;
				else
					this.optionscopy[i].value = '';
			}
		}
	}
	this.set = function(pattern) {
		var loop=0, index=0, regexp, e;
		if (!this.targetObj) return false;
		if (!this.targetObj.options) return false;
		this.targetObj.options.length = 0;
		try {
			regexp = new RegExp(pattern, this.flags);
		} catch(e) {
			if (typeof this.hook == 'function')
				this.hook();
			return;
		}
		var sum = this.optionscopy.length;
		var limit = this.out_limit;
		for (loop = 0; loop < sum; loop ++) {
			if (limit==0) break;
			var option = this.optionscopy[loop];
			// check if we have a match
			if (regexp.test(option.text)) {
				this.targetObj.options[index++] = new Option(option.text, option.value, false);
				limit--;
			}
		}
		// if empty then default value
		if (!this.targetObj.options.length)
			this.targetObj.options[0] = new Option(this.default_text, this.default_value, false);
		// if user specified a function hook
		if (typeof this.hook == 'function')
			this.hook();
	}
	this.reset = function() {
		this.set('');
	}
	this.set_ignore_case = function(value) {
		if (value)
			this.flags = 'i';
		else
			this.flags = '';
	}
	this.set_default = function(text, value) {
		if (text)
			this.default_text = text;
		else
			this.default_text = '';
		if (value)
			this.default_value = value;
		else
			this.default_value = '';
	}
	this.debug = function(msg) {
		if (this.show_debug)
			alert('FilterList: ' + msg);
	}
	this.init();
}
function selectItem() {
	var target_obj = document.getElementById('filter_list');
	var source_obj = document.getElementById('family_ids');
	var text = target_obj.options[target_obj.selectedIndex].text;
	var textid = text.substr(0, text.indexOf('.'));
	if (source_obj.value) source_obj.value = source_obj.value + ',' + textid;
	else source_obj.value = textid;
}
function searchItem() {
	var filter_obj = document.getElementById('filter');
	filterObj.set(filter_obj.value);
}
function resetItem() {
	var filter_obj = document.getElementById('filter');
	filter_obj.value = '';
	filterObj.set(filter_obj.value);
}
function setupFilter() {
	var target_obj = document.getElementById('filter_list');
	if (target_obj)
		filterObj = new filterList(target_obj);
}
setupFilter();
</script>
{/literal}

