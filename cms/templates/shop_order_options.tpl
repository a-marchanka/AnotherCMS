<!-- COPYRIGHTS Another CMS      -->
{literal}
<script src="../libs/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
	selector:'textarea#bill_receipt',
	theme:'modern',
	plugins:['advlist autolink lists charmap anchor visualblocks',
		 'code fullscreen table paste'],
	menubar:false,
	toolbar:'bold italic | alignleft aligncenter alignright | bullist numlist | table removeformat code',
	extended_valid_elements:'img[class|style|src|alt|title|width|height|onmouseover|onmouseout|name],hr[class|style],script[src|type]',
	language:'{/literal}{$ui_lang}{literal}',
	document_base_url:'{/literal}{$site_url}{literal}/',
	convert_urls:false,
	relative_urls:false,
	remove_script_host:true,
	content_css : 'images/w3.css'
});
tinymce.init({
	selector:'textarea#delivery_receipt',
	theme:'modern',
	plugins:['advlist autolink lists charmap anchor visualblocks',
		 'code fullscreen table paste'],
	menubar:false,
	toolbar:'bold italic | alignleft aligncenter alignright | bullist numlist | table removeformat code',
	extended_valid_elements:'img[class|style|src|alt|title|width|height|onmouseover|onmouseout|name],hr[class|style],script[src|type]',
	language:'{/literal}{$ui_lang}{literal}',
	document_base_url:'{/literal}{$site_url}{literal}/',
	convert_urls:false,
	relative_urls:false,
	remove_script_host:true,
	content_css : 'images/w3.css'
});
function loading() {
	toggle('form_details', 0);
	toggle('upload_bar', 1);
}
function saveAndClose() {
	loading();
	document.forms['form_details'].elements['subaction'].value = 'save_close_options';
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
<input id="TnewObj4" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','order&amp;details_id={$details.id}')" value="{#LB_order#}">
</div>

<h3>{#LB_options#}</h3>

<div class="w3-margin-bottom">
<h4>{#LB_bill#}</h4>
<div class="w3-half">
<textarea id="bill_receipt" name="bill_receipt" cols="40" rows="18" class="w3-input w3-border w3-round" style="width:97%;height:200px;background-color:#F9F9F9;">{$details.bill_receipt}</textarea>
</div>
<div class="w3-half">
<div class="w3-third">
<label>{if $details.status<3}<a href="javascript:lastNr('bill_nr', {$bill_nr_next})" title="{#LB_refresh#}"><span class="i20s_refr1"></span></a>{/if} {#LB_bill#}:</label>
<input name="bill_nr" id="bill_nr" type="text" value="{$details.bill_nr|default:0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-third">
<label>{#LB_total#} {#LB_gross#}:</label>
<input name="bill_total_gross" id="bill_total_gross" type="text" value="{$details.bill_total_gross|default:0.0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-third">
<label>{#LB_total#} {#LB_nett#}:</label>
<input name="bill_total_nett" id="bill_total_nett" type="text" value="{$details.bill_total_nett|default:0.0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<label>{#LB_payment#}:</label>
<select name="payment_code" id="payment_code" class="w3-select w3-block w3-border w3-round w3-margin-bottom-8" style="width:auto;">
<option value="">---</option>
{section name=item loop=$payment_list}
{if $payment_list[item].enabled==1}
<option value="{$payment_list[item].code}"{if $details.payment_code eq $payment_list[item].code} selected{/if}>{$payment_list[item].title}</option>
{/if}
{/section}
</select>
<div class="w3-third">
<label>{#LB_payment#} {#LB_gross#}:</label>
<input name="payment_gross" id="payment_gross" type="text" value="{$details.payment_gross|default:0.0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-third">
<label>{#LB_payment#} {#LB_nett#}:</label>
<input name="payment_nett" id="payment_nett" type="text" value="{$details.payment_nett|default:0.0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-third">
<label>{#LB_txn#}:</label>
<input name="txn_nr" id="txn_nr" type="text" value="{$details.txn_nr|default:''}" size="12" maxlength="30" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-third">
<label>{#LB_discount#} {#LB_price#}:</label>
<input name="discount_price" id="discount_price" type="text" value="{$details.discount_price|default:0.0}" size="12" maxlength="16" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-twothird">
<label>{#LB_discount#}:</label>
<input name="discount_code" id="discount_code" type="text" value="{$details.discount_code|default:''}" size="12" maxlength="16" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
</div>

<div class="w3-clear">
<h4>{#LB_delivery#}</h4>
<div class="w3-half">
<textarea id="delivery_receipt" name="delivery_receipt" cols="40" rows="18" class="w3-input w3-border w3-round" style="width:97%;height:200px;background-color:#F9F9F9;">{$details.delivery_receipt}</textarea>
</div>
<div class="w3-half">
<label>{#LB_delivery#}:</label>
<select name="delivery_code" id="delivery_code" class="w3-select w3-block w3-border w3-round w3-margin-bottom-8" style="width:auto;">
<option value="">---</option>
{section name=item loop=$delivery_list}
{if $delivery_list[item].enabled==1}
<option value="{$delivery_list[item].code}"{if $details.delivery_code eq $delivery_list[item].code} selected{/if}>{$delivery_list[item].title}</option>
{/if}
{/section}
</select>
<div class="w3-third">
<label>{#LB_delivery#} {#LB_gross#}:</label>
<input name="delivery_gross" id="delivery_gross" type="text" value="{$details.delivery_gross|default:0.0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-third">
<label>{#LB_delivery#} {#LB_nett#}:</label>
<input name="delivery_nett" id="delivery_nett" type="text" value="{$details.delivery_nett|default:0.0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-third">
<label>{#LB_track#}:</label>
<input name="tracking_nr" id="tracking_nr" type="text" value="{$details.tracking_nr|default:''}" size="12" maxlength="30" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-third">
<label>{#LB_weight#}:</label>
<input name="weight_kg_sum" id="weight_kg_sum" type="text" value="{$details.weight_kg_sum|default:0.0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-twothird">
<label>{#LB_length#}:</label>
<input name="length_cm_max" id="length_cm_max" type="text" value="{$details.length_cm_max|default:0.0}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
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
<input name="action" id="action" type="hidden" value="edit">
<input name="subaction" id="subaction" type="hidden" value="order_options">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="details_id" id="details_id" type="hidden" value="{$details.id|default:0}">
<input name="createtime" id="createtime" type="hidden" value="{$details.createtime|default:0}">
<input name="closetime" id="closetime" type="hidden" value="{$details.closetime|default:0}">
<input name="paytime" id="paytime" type="hidden" value="{$details.paytime|default:0}">

<!-- buttons -->
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id > 0)}
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
<input id="newObj4" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','order&amp;details_id={$details.id}')" value="{#LB_order#}">
<!-- buttons -->

</form>

<div id="upload_bar" style="display:none;">
<img src="../images/loading.gif" width="32" height="32" alt="{#LB_loading#}" style="padding:20px;">
</div>
<hr class="w3-light-grey">

<script>toggle('upload_bar', 0);</script>

