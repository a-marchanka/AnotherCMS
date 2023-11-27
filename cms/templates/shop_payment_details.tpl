<!-- COPYRIGHTS Another CMS      -->
{literal}
<script type="text/javascript">
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
</div>

<h3>{#LB_details#}</h3>

<div class="w3-half w3-margin-bottom-8">
<label>{#LB_code#} <span class="w3-text-red">*</span>:</label>
<input name="code" id="code" type="text" value="{$details.code}" size="10" maxlength="12" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;" required>
<label>{#LB_description#}:</label>
<input name="title" id="title" type="text" value="{$details.title|default:''}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_country#} {#LB_code#}:</label>
<input name="country_code" id="country_code" type="text" value="{$details.country_code|default:'--'}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_currency#}:</label>
<input name="currency" id="currency" type="text" value="{$details.currency|default:''}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<label>{#LB_price#}:</label>
<input name="price" id="price" type="text" value="{$details.price|default:0.5}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<label>{#LB_tax#}:</label>
<input name="tax" id="tax" type="text" value="{$details.tax|default:0.0}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<p><label>{#LB_type#}:</label> &nbsp; 
<label><input value="fix"{if $details.price_type eq 'fix' or !$details.price_type} checked="checked"{/if} type="radio" name="price_type" class="w3-radio">&nbsp;{$currency}</label> &nbsp; &nbsp;
<label><input value="pct"{if $details.price_type eq 'pct'} checked="checked"{/if} type="radio" name="price_type" class="w3-radio">&nbsp;%</label></p>
</div>

<p class="w3-clear">
<p><label><input name="enabled" id="enabled" type="checkbox" value="1"{if $details.enabled|default:0} checked="checked"{/if} class="w3-check"> &nbsp;{#LB_active#}</label></p>
{#LB_modified#}: {$details.modifytime|date_format:"%d.%m.%Y %H:%M"|default:'--'}<br>
</p>

<input name="old_status" id="old_status" type="hidden" value="{$details.enabled}">
<input name="action" id="action" type="hidden" value="{if $details.id|default:0}edit{else}create{/if}">
<input name="subaction" id="subaction" type="hidden" value="payment">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="details_id" id="details_id" type="hidden" value="{$details.id|default:0}">
<input name="modifytime" id="modifytime" type="hidden" value="{$details.modifytime|default:0}">

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

