<!-- COPYRIGHTS ©Another CMS -->
{literal}
<script>
function saveAndClose() {
document.forms['form_details'].elements['subaction'].value = 'save_close_user';
document.forms['form_details'].submit();
}
</script>
{/literal}

<form id="form_details" name="form_details" method="post" action="#">

<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id|default:0 > 0)}
<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
</div>

<h3>{#LB_details#}</h3>

<!-- details -->
<label>{#LB_user#} <span class="w3-text-red">*</span>:</label>
<input name="nick" id="nick" type="text" value="{$details.nick|default:''}" size="45" maxlength="128" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_password#} <span class="w3-text-red">*</span>:</label>
<input name="pass" id="pass" type="text" value="" size="45" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<input name="trigger1" id="trigger1" type="button" value="{#LB_refresh#}" onclick="genPass('pass',8)" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme"><br>
<label>{#LB_passwordRepeat#} <span class="w3-text-red">*</span>: </label>
<input name="password_confirm" id="password_confirm" type="text" value="" size="45" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_description#}: </label>
<input name="descr" id="descr" type="text" value="{$details.descr|default:''}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_role#} <span class="w3-text-red">*</span>: </label>
{if $entry_info.entry_attr < 3}
	{$details.role}
	<input name="role_id" id="role_id" type="hidden" value="{$details.role_id|default:0}">
	{if $details.id}
	{section name=customer loop=$roles_list}
		{if $details.role_id == $roles_list[customer].id}<input name="role" id="role" type="hidden" value="{$details.role|default:''}">{/if}
	{/section}
	{/if}
{else}
	<select name="role_id" id="role_id" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
	{section name=customer loop=$roles_list}
		<option value="{$roles_list[customer].id}"{if $details.role_id|default:0 eq $roles_list[customer].id} selected{/if}>{$roles_list[customer].role}</option>
	{/section}
	</select>
{/if}
<p><label>{#LB_active#} <span class="w3-text-red">*</span>: </label> &nbsp; 
<input type="radio" name="active" value="1"{if $details.active} checked="checked"{/if} class="w3-radio">
{#LB_yes#} &nbsp; &nbsp;
<input type="radio" name="active" value="0"{if !$details.active} checked="checked"{/if} class="w3-radio">
{#LB_no#}
</p><p>
<label>{#LB_lastVisit#}: </label>
{$details.lastvisit|date_format:"%d.%m.%Y %H:%M:%S"|default:"--"}
</p>
<input name="sig" id="sig" type="hidden" value="{$details.sig|default:'empty'}">
<input name="agent" id="agent" type="hidden" value="{$details.agent|default:'--'}">
<input name="action" id="action" type="hidden" value="{if $details.id|default:0}edit{else}create{/if}">
<input name="subaction" id="subaction" type="hidden" value="user">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">

<input name="details_id" id="details_id" type="hidden" value="{$details.id|default:0}">
<input name="lastvisit" id="lastvisit" type="hidden" value="{$details.lastvisit|default:0}">

<!-- buttons -->
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id|default:0 > 0)}
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
<!-- buttons -->

</form>
<hr class="w3-light-grey">

