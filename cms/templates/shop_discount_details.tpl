<!-- COPYRIGHTS Another CMS      -->
{literal}
<script>
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
<!-- CALENDAR -->
<link href="../libs/calendar/{$cms_theme|default:'core'}.css" rel="stylesheet" type="text/css">
<script src="../libs/calendar/calendar.js"></script>
<script src="../libs/calendar/lang/calendar-{$ui_lang|default:'en'}.js"></script>
<script src="../libs/calendar/calendar-setup.js"></script>

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

<div class="w3-half w3-margin-bottom-8">
<div class="w3-half">
<label>{#LB_code#} <span class="w3-text-red">*</span>:</label>
<input name="code" id="code" type="text" value="{$details.code|default:''}" size="10" maxlength="12" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;" required>
<input name="trigger1" id="trigger1" type="button" value="{#LB_refresh#}" onclick="genPass('code',6)" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme"><br>
<label>{#LB_discount#}:</label>
<input name="price" id="price" type="text" value="{$details.price|default:0.5}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<p><label>{#LB_type#}:</label> &nbsp; 
<label><input value="fix"{if $details.price_type eq 'fix' or !$details.price_type} checked="checked"{/if} type="radio" name="price_type" class="w3-radio">&nbsp;{$currency}</label> &nbsp; &nbsp;
<label><input value="pct"{if $details.price_type eq 'pct'} checked="checked"{/if} type="radio" name="price_type" class="w3-radio">&nbsp;%</label></p>
</div>
<div class="w3-half">
<label>{#LB_validFrom#}:</label>
<input name="active_from" id="active_from" type="text" value="{$details.active_from|date_format:"%d.%m.%Y"|default:"--"}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<input name="trigger2" id="trigger2" type="button" value="{#LB_calendar#}" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme"><br>
<label>{#LB_validTo#}:</label>
<input name="active_to" id="active_to" type="text" value="{$details.active_to|date_format:"%d.%m.%Y"|default:"--"}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<input name="trigger3" id="trigger3" type="button" value="{#LB_calendar#}" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme">
	<!-- CALENDAR -->
	{literal}
	<script>
	  Calendar.setup( {
		inputField:"active_from",
		ifFormat:"%d.%m.%Y",
		button:"trigger2"
		} );
	  Calendar.setup( {
		inputField:"active_to",
		ifFormat:"%d.%m.%Y",
		button:"trigger3"
		} );
	</script>
	{/literal}
</div>
</div>
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_description#}:</label>
<input name="title" id="title" type="text" value="{$details.title|default:''}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_pattern#}:</label><br>
	<select name="pattern" id="pattern" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
	<option value="">--</option>
	{section name=item loop=$tpl_list}
	{if ($tpl_list[item].nameext|substr:0:4) eq 'shop'}
	<option value="{$tpl_list[item].nameext}"{if ($tpl_list[item].nameext eq $details.pattern|default:'')} selected="selected"{/if}>{$tpl_list[item].nameext}</option>
	{/if}
	{/section}
	</select>
<p><label><input name="reusable" id="reusable" type="checkbox" value="1"{if $details.reusable|default:0} checked="checked"{/if} class="w3-check"> &nbsp;{#LB_reusable#}</label> &nbsp; &nbsp;
<label><input name="enabled" id="enabled" type="checkbox" value="1"{if $details.enabled|default:0} checked="checked"{/if} class="w3-check"> &nbsp;{#LB_active#}</label></p>
</div>

<p class="w3-clear">
{#LB_modified#}: {$details.modifytime|date_format:"%d.%m.%Y %H:%M"|default:"--"}<br>
{#LB_user#}: {$details.createnick|default:$user_info.nick}
</p>

<input name="old_status" id="old_status" type="hidden" value="{$details.enabled}">
<input name="action" id="action" type="hidden" value="{if $details.id|default:0}edit{else}create{/if}">
<input name="subaction" id="subaction" type="hidden" value="discount">
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

