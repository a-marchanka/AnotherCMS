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
<label>{#LB_code#}<span class="w3-text-red">*</span>:</label>
<input name="code" id="code" type="text" value="{$details.code|default:''}" size="10" maxlength="12" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;" required>
<label>{#LB_description#}:</label>
<input name="title" id="title" type="text" value="{$details.title|default:''}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_country#} {#LB_code#}:</label>
<input name="country_code" id="country_code" type="text" value="{$details.country_code|default:'--'}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<label>{#LB_country#}:</label>
<input name="country" id="country" type="text" value="{$details.country|default:''}" size="12" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<label>{#LB_currency#}:</label>
<input name="currency" id="currency" type="text" value="{$details.currency|default:''}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<label>{#LB_tax#}:</label>
<input name="tax" id="tax" type="text" value="{$details.tax|default:'0.0'}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half"><hr>
<div class="w3-half">
<label>1. {#LB_weight#}:</label>
<input name="weight_kg1" id="weight_kg1" type="text" value="{$details.weight_kg1|default:1}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>1. {#LB_price#}:</label>
<input name="price_kg1" id="price_kg1" type="text" value="{$details.price_kg1|default:0.5}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>2. {#LB_weight#}:</label>
<input name="weight_kg2" id="weight_kg2" type="text" value="{$details.weight_kg2|default:2}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>2. {#LB_price#}:</label>
<input name="price_kg2" id="price_kg2" type="text" value="{$details.price_kg2|default:1.5}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>3. {#LB_weight#}:</label>
<input name="weight_kg3" id="weight_kg3" type="text" value="{$details.weight_kg3|default:3}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>3. {#LB_price#}:</label>
<input name="price_kg3" id="price_kg3" type="text" value="{$details.price_kg3|default:2.5}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>4. {#LB_weight#}:</label>
<input name="weight_kg4" id="weight_kg4" type="text" value="{$details.weight_kg4|default:4}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>4. {#LB_price#}:</label>
<input name="price_kg4" id="price_kg4" type="text" value="{$details.price_kg4|default:3.5}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>1. {#LB_length#}:</label>
<input name="length_cm1" id="length_cm1" type="text" value="{$details.length_cm1|default:10}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>1. {#LB_price#}:</label>
<input name="price_cm1" id="price_cm1" type="text" value="{$details.price_cm1|default:0.5}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>2. {#LB_length#}:</label>
<input name="length_cm2" id="length_cm2" type="text" value="{$details.length_cm2|default:20}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>2. {#LB_price#}:</label>
<input name="price_cm2" id="price_cm2" type="text" value="{$details.price_cm2|default:1.5}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>3.{#LB_length#}:</label>
<input name="length_cm3" id="length_cm3" type="text" value="{$details.length_cm3|default:30}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>3. {#LB_price#}:</label>
<input name="price_cm3" id="price_cm3" type="text" value="{$details.price_cm3|default:2.5}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>4. {#LB_length#}:</label>
<input name="length_cm4" id="length_cm4" type="text" value="{$details.length_cm4|default:40}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>4. {#LB_price#}:</label>
<input name="price_cm4" id="price_cm4" type="text" value="{$details.price_cm4|default:3.5}" size="5" maxlength="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
</div>

<p class="w3-clear">
<p><label><input name="enabled" id="enabled" type="checkbox" value="1"{if $details.enabled|default:0} checked="checked"{/if} class="w3-check"> &nbsp;{#LB_active#}</label></p>
{#LB_modified#}: {$details.modifytime|date_format:"%d.%m.%Y %H:%M"|default:'--'}<br>
</p>

<input name="old_status" id="old_status" type="hidden" value="{$details.enabled}">
<input name="action" id="action" type="hidden" value="{if $details.id|default:0}edit{else}create{/if}">
<input name="subaction" id="subaction" type="hidden" value="delivery">
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

