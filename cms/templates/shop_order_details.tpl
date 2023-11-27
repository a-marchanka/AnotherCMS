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
function lastNr(obj, val) {
	var elemTo = document.getElementById(obj);
	elemTo.value = val;
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

<div class="w3-half w3-margin-bottom">
<h4>{#LB_billAddr#}</h4>
<label>{if $details.status<3}<a href="javascript:lastNr('bill_nr', {$bill_nr_next})" title="{#LB_refresh#}"><span class="i20s_refr1"></span></a>{/if} {#LB_bill#}:</label>
<input name="bill_nr" id="bill_nr" type="text" value="{$details.bill_nr|default:0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<label>{#LB_firmCode#}:</label>
<input name="bill_firm_vat_nr" id="bill_firm_vat_nr" type="text" value="{$details.bill_firm_vat_nr}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_firm#}:</label>
<input name="bill_firm" id="bill_firm" type="text" value="{$details.bill_firm}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_reference#}:</label>
<select name="bill_reference" id="bill_reference" class="w3-select w3-block w3-border w3-round w3-margin-bottom-8" style="width:auto;">
<option value="">---</option>
<option value="{$reference_list.mr_id}"{if $details.bill_reference eq $reference_list.mr_id} selected{/if}>{$reference_list.mr_id}</option>
<option value="{$reference_list.ms_id}"{if $details.bill_reference eq $reference_list.ms_id} selected{/if}>{$reference_list.ms_id}</option>
</select>
<label>{#LB_title#}:</label>
<input name="bill_title" id="bill_title" type="text" value="{$details.bill_title}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_name#} <span class="w3-text-red">*</span>:</label>
<input name="bill_name" id="bill_name" type="text" value="{$details.bill_name}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_surname#} <span class="w3-text-red">*</span>:</label><br>
<input name="bill_surname" id="bill_surname" type="text" value="{$details.bill_surname}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_street#} <span class="w3-text-red">*</span>:</label>
<input name="bill_street" id="bill_street" type="text" value="{$details.bill_street}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_city#} <span class="w3-text-red">*</span>:</label>
<input name="bill_city" id="bill_city" type="text" value="{$details.bill_city}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_zip#} <span class="w3-text-red">*</span>:</label>
<input name="bill_postcode" id="bill_postcode" type="text" value="{$details.bill_postcode}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_country#} <span class="w3-text-red">*</span>:</label>
<input name="bill_country_code" id="bill_country_code" type="text" value="{$details.bill_country_code}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
</div>

<div class="w3-half w3-margin-bottom">
<h4>{#LB_deliveryAddr#}</h4>
<label>{#LB_email#} <span class="w3-text-red">*</span>:</label>
<input name="bill_email" id="bill_email" type="text" value="{$details.bill_email}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_tel#}:</label>
<input name="bill_tel" id="bill_tel" type="text" value="{$details.bill_tel}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_firm#}:</label>
<input name="cust_firm" id="cust_firm" type="text" value="{$details.cust_firm}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_reference#}:</label>
<select name="cust_reference" id="cust_reference" class="w3-select w3-block w3-border w3-round w3-margin-bottom-8" style="width:auto;">
<option value="">---</option>
<option value="{$reference_list.mr_id}"{if $details.cust_reference eq $reference_list.mr_id} selected{/if}>{$reference_list.mr_id}</option>
<option value="{$reference_list.ms_id}"{if $details.cust_reference eq $reference_list.ms_id} selected{/if}>{$reference_list.ms_id}</option>
</select>
<label>{#LB_title#}:</label>
<input name="cust_title" id="cust_title" type="text" value="{$details.cust_title}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_name#}:</label>
<input name="cust_name" id="cust_name" type="text" value="{$details.cust_name}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_surname#}:</label><br>
<input name="cust_surname" id="cust_surname" type="text" value="{$details.cust_surname}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_street#}:</label>
<input name="cust_street" id="cust_street" type="text" value="{$details.cust_street}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_city#}:</label>
<input name="cust_city" id="cust_city" type="text" value="{$details.cust_city}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_zip#}:</label>
<input name="cust_postcode" id="cust_postcode" type="text" value="{$details.cust_postcode}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_country#}:</label>
<input name="cust_country_code" id="cust_country_code" type="text" value="{$details.cust_country_code}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
</div>

<div class="w3-half">
<label>{#LB_birthyear#} <span class="w3-text-red">*</span>:</label>
<input name="bill_birth_year" id="bill_birth_year" type="text" value="{$details.bill_birth_year|default:'1970'}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;" required>
<label>{#LB_termsFlag#} <span class="w3-text-red">*</span>:</label>
<input name="terms_flag" id="terms_flag" type="text" value="{$details.terms_flag|default:'0'}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;" required>
<label>{#LB_page#}:</label>
<input name="last_step" id="last_step" type="text" value="{$details.last_step|default:'0'}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half">
<label>{#LB_note#}:</label>
<textarea id="notes" name="notes" cols="80" rows="7" class="w3-input w3-border w3-round" style="width:90%;background-color:#F9F9F9;">{$details.notes}</textarea>
</div>

<p class="w3-clear">
<p><label>{#LB_status#}: </label>
{section name=itr loop=$status_list}
	<input value="{$status_list[itr].id}"{if $details.status == $status_list[itr].id} checked="checked"{/if} type="radio" name="status" class="w3-radio">
	<label>&nbsp;{$status_list[itr].title}</label>&nbsp; &nbsp;
{/section}
</p>
<p>
{#LB_created#}: {$details.createtime|date_format:"%d.%m.%Y %H:%M"|default:'--'}<br>
{#LB_modified#}: {$details.modifytime|date_format:"%d.%m.%Y %H:%M"|default:'--'}<br>
{#LB_closed#}: {$details.closetime|date_format:"%d.%m.%Y %H:%M"|default:'--'}<br>
{#LB_payment#}: {$details.paytime|date_format:"%d.%m.%Y %H:%M"|default:'--'}<br>
{#LB_user#}: {$details.createnick|default:$user_info.nick}<br>
</p>
<input name="old_status" id="old_status" type="hidden" value="{$details.status}">
<input name="action" id="action" type="hidden" value="{if $details.id|default:0}edit{else}create{/if}">
<input name="subaction" id="subaction" type="hidden" value="order">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="details_id" id="details_id" type="hidden" value="{$details.id|default:0}">
<input name="agent" id="agent" type="hidden" value="{$details.agent|default:'cms'}">
<input name="createtime" id="createtime" type="hidden" value="{$details.createtime|default:0}">
<input name="closetime" id="closetime" type="hidden" value="{$details.closetime|default:0}">
<input name="paytime" id="paytime" type="hidden" value="{$details.paytime|default:0}">
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

