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
<label>{#LB_email#} <span class="w3-text-red">*</span>:</label>
<input name="email" id="email" type="text" value="{$details.email|default:''}" size="45" maxlength="128" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_webPage#}:</label><br>
<select name="menu_id" id="menu_id" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<option value="0">---</option>
{section name=item loop=$search_list}
	<option value="{$search_list[item].id}"{if $details.menu_id|default:0 eq $search_list[item].id} selected="selected"{/if}>
	{'&nbsp;'|indent:$search_list[item].level:'- '} {$search_list[item].title}
	</option>
{/section}
</select><br>
<label>{#LB_validTo#}:</label>
<input name="validetime" id="validetime" type="text" value="{$details.validetime|date_format:"%d.%m.%Y"|default:"--"}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<input name="trigger" id="trigger" type="button" value="{#LB_calendar#}" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-blue-grey">
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
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_title#}:</label>
<input name="title" id="title" type="text" value="{$details.title|default:''}" size="45" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_name#}:</label>
<input name="name" id="name" type="text" value="{$details.name|default:''}" size="45" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_surname#}:</label>
<input name="surname" id="surname" type="text" value="{$details.surname|default:''}" size="45" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_firm#}:</label>
<input name="firm" id="firm" type="text" value="{$details.firm|default:''}" size="45" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
</div>
<div class="w3-margin-top w3-clear">
<label>{#LB_priority#}:</label>
<input name="priority" id="priority" type="text" value="{$details.priority|default:1}" size="4" maxlength="4" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<p><label>{#LB_active#} <span class="w3-text-red">*</span>: </label> &nbsp; 
<input type="radio" name="enabled" value="1"{if $details.enabled} checked="checked"{/if} class="w3-radio">
{#LB_yes#} &nbsp; &nbsp;
<input type="radio" name="enabled" value="0"{if !$details.enabled} checked="checked"{/if} class="w3-radio">
{#LB_no#}
</p><p>
{#LB_modified#}: {$details.modifytime|date_format:"%d.%m.%Y %H:%M:%S"|default:'--'}<br>
{#LB_user#}: {$details.createnick|default:$user_info.nick}
</p>
</div>

<input name="action" id="action" type="hidden" value="{if $details.id|default:0}edit{else}create{/if}">
<input name="subaction" id="subaction" type="hidden" value="item">
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
{/strip}

<script>toggle('upload_bar', 0);</script>

