<h1>{#LB_checkout#}</h1>

<form id="forder" name="forder" method="post" action="order" onsubmit="getSig1()" class="w3-display-container w3-margin-top" style="display:block;">

<input class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-light-grey w3-border" type="button" onclick="toggleOn(1);" value="1. {#LB_address#}"{if $tab|default:1<1 or $basket_amount|default:0==0} disabled{/if}>
<input class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-light-grey w3-border" type="button" onclick="toggleOn(2);" value="2. {#LB_delivery#}"{if $tab|default:1<2 or $basket_amount|default:0==0} disabled{/if}>
<input class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-light-grey w3-border" type="button" onclick="toggleOn(3);" value="3. {#LB_payment#}"{if $tab|default:1<3 or $basket_amount|default:0==0} disabled{/if}>
<input class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-light-grey w3-border" type="button" onclick="toggleOn(4);" value="4. {#LB_accept#}"{if $tab|default:1<4 or $basket_amount|default:0==0} disabled{/if}>

<input name="action" type="hidden" value="list">
<input name="subaction" type="hidden" value="refresh">
<input name="details_id" id="details_id" type="hidden" value="{$details.id|default:0}">
<input name="ip" type="hidden" value="empty">
<input name="m" type="hidden" value="{$entry_name}">
<input name="sid" type="hidden" value="{$sid}">
<input name="createnick" type="hidden" value="{$user_info.nick|default:'none'}">

<div id="tab1" style="display:none;">
{if $tab|default:1>0 and $basket_amount|default:0>0}
<!-- bill address -->
<h2>{#LB_billAddr#}</h2>
<div class="w3-half">
<label><b>{#LB_email#} <span class="w3-text-red">*</span>:</b></label><input name="bill_email" id="bill_email_b" type="email" value="{$details.bill_email|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_tel#}:</label><input name="bill_tel" id="bill_tel_b" type="tel" value="{$details.bill_tel|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_firm#}:</label><input name="bill_firm" id="bill_firm_b" type="text" value="{$details.bill_firm|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_firmCode#}:</label><input name="bill_firm_vat_nr" id="bill_firm_vat_nr_b" type="text" value="{$details.bill_firm_vat_nr|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_reference#}:</label>
	<input value="---" name="bill_reference" id="bill_reference_b2" {if $details.bill_reference|default:'' eq '---'}checked{/if} type="radio" class="w3-check w3-margin-left w3-margin-right-8 w3-margin-bottom">---
	<input value="{$reference_list.mr_id}" name="bill_reference" id="bill_reference_b1" {if $details.bill_reference|default:'' eq $reference_list.mr_id}checked{/if} type="radio" class="w3-check w3-margin-left w3-margin-right-8 w3-margin-bottom">{$reference_list.mr_id}
	<input value="{$reference_list.ms_id}" name="bill_reference" id="bill_reference_b0" {if $details.bill_reference|default:'' eq $reference_list.ms_id}checked{/if} type="radio" class="w3-check w3-margin-left w3-margin-right-8 w3-margin-bottom">{$reference_list.ms_id}<br>
<label>{#LB_title#}:</label><input name="bill_title" id="bill_title_b" type="text" value="{$details.bill_title|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:200px;">
<label><b>{#LB_givenname#} <span class="w3-text-red">*</span>:</b></label><input name="bill_name" id="bill_name_b" type="text" value="{$details.bill_name|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label><b>{#LB_surname#} <span class="w3-text-red">*</span>:</b></label><input name="bill_surname" id="bill_surname_b" type="text" value="{$details.bill_surname|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label><b>{#LB_address#} <span class="w3-text-red">*</span>:</b></label><input name="bill_street" id="bill_street_b" type="text" value="{$details.bill_street|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label><b>{#LB_zip#} <span class="w3-text-red">*</span>:</b></label><input name="bill_postcode" id="bill_postcode_b" type="text" value="{$details.bill_postcode|default:''}" size="8" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:200px;" required>
<label><b>{#LB_city#} <span class="w3-text-red">*</span>:</b></label><input name="bill_city" id="bill_city_b" type="text" value="{$details.bill_city|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
</div>
<div class="w3-half">
Für unsere Schweizer Kunden: &uuml;ber MeinEinkauf.ch können Sie einfach, zu günstigen Versandkosten und OHNE Zollabgaben in unserem Shop einkaufen.
<a href="MeinEinkaufCh{if $SID}?{$SID}{/if}" target="_blank">Weiter lesen</a>&nbsp;
<input class="w3-button w3-margin-top-8 w3-light-grey" type="button" onclick="MeinEinkauf();" value="&Uuml;ber MeinEinkauf.ch einkaufen">
</div><div class="w3-clear">&nbsp;</div>
<label><b>{#LB_country#} <span class="w3-text-red">*</span>:</b></label><br>
	<select name="bill_country_code" id="bill_country_code_b" class="w3-select w3-block w3-border w3-round w3-margin-bottom-8" style="max-width:200px;" required>
	<option value=""{if !$details.bill_country_code|default:''} selected="selected"{/if}>--</option>
	{section name=item loop=$country_list}
	<option value="{$country_list[item].country_code}"{if $details.bill_country_code|default:'DE' eq $country_list[item].country_code} selected="selected"{/if}>{$country_list[item].country}</option>
	{/section}
	</select>
<label><b>{#LB_birthyear#} <span class="w3-text-red">*</span>:</b></label><br>
	<select name="bill_birth_year" id="bill_birth_year_b" class="w3-select w3-block w3-border w3-round w3-margin-bottom-8" style="max-width:200px;" required>
	<option value="">---</option>
	{section name=birthy loop=2010 start=1930 step=1}
	<option value="{$smarty.section.birthy.index}"{if $details.bill_birth_year|default:'1974' eq $smarty.section.birthy.index} selected="selected"{/if}>{$smarty.section.birthy.index}</option>
	{/section}
	</select>
<p><input name="terms_flag" id="terms_flag" type="checkbox" value="1"{if $details.terms_flag|default:0} checked="checked"{/if} class="w3-check w3-margin-right-8 w3-margin-bottom" required><label><a href="terms_conditions{if $SID}?{$SID}{/if}" target="_blank"><b>{#LB_termsFlag#} <span class="w3-text-red">*</span></b></a></label></p>
<label>{#LB_additional#}:</label><textarea name="notes" id="notes" cols="30" rows="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">{$details.notes|default:''}</textarea>
<hr>
<!-- delivery address -->
<h2>{#LB_deliveryAddr#}</h2>
<input type="button" onclick="addrSame()" value="{#LB_address_equal#}" class="w3-button w3-dark-grey w3-margin-bottom"><br>
<label>{#LB_firm#}:</label><input name="cust_firm" id="cust_firm_a" type="text" value="{$details.cust_firm|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_reference#}:</label>
	<input value="---" name="cust_reference" id="cust_reference_a2" {if $details.cust_reference|default:'' eq '---'}checked{/if} type="radio" class="w3-check w3-margin-left w3-margin-right-8 w3-margin-bottom">---
	<input value="{$reference_list.mr_id}" name="cust_reference" id="cust_reference_a1" {if $details.cust_reference|default:'' eq $reference_list.mr_id}checked{/if} type="radio" class="w3-check w3-margin-left w3-margin-right-8 w3-margin-bottom">{$reference_list.mr_id}
	<input value="{$reference_list.ms_id}" name="cust_reference" id="cust_reference_a0" {if $details.cust_reference|default:'' eq $reference_list.ms_id}checked{/if} type="radio" class="w3-check w3-margin-left w3-margin-right-8 w3-margin-bottom">{$reference_list.ms_id}<br>
<label>{#LB_title#}:</label><input name="cust_title" id="cust_title_a" type="text" value="{$details.cust_title|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:200px;">
<label><b>{#LB_givenname#} <span class="w3-text-red">*</span>:</b></label><input name="cust_name" id="cust_name_a" type="text" value="{$details.cust_name|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label><b>{#LB_surname#} <span class="w3-text-red">*</span>:</b></label><input name="cust_surname" id="cust_surname_a" type="text" value="{$details.cust_surname|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label><b>{#LB_address#} <span class="w3-text-red">*</span>:</b></label><input name="cust_street" id="cust_street_a" type="text" value="{$details.cust_street|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label><b>{#LB_zip#} <span class="w3-text-red">*</span>:</b></label><input name="cust_postcode" id="cust_postcode_a" type="text" value="{$details.cust_postcode|default:''}" size="8" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:200px;" required>
<label><b>{#LB_city#} <span class="w3-text-red">*</span>:</b></label><input name="cust_city" id="cust_city_a" type="text" value="{$details.cust_city|default:''}" size="35" maxlength="127" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label><b>{#LB_country#} <span class="w3-text-red">*</span>:</b></label><br>
	<select name="cust_country_code" id="cust_country_code_a" class="w3-select w3-block w3-border w3-round w3-margin-bottom-8" style="max-width:200px;" required>
	<option value=""{if !$details.cust_country_code|default:''} selected="selected"{/if}>--</option>
	{section name=item loop=$country_list}
	<option value="{$country_list[item].country_code}"{if $details.cust_country_code|default:'' eq $country_list[item].country_code} selected="selected"{/if}>{$country_list[item].country}</option>
	{/section}
	</select>
<input type="button" value="{#LB_back#}" onclick="toggleOn(1)" class="w3-button w3-dark-grey w3-margin-top w3-margin-right">
<input type="submit" value="{#LB_next#}" class="w3-button w3-indigo w3-margin-top">
{else}
<p>{#LB_basketEmpty#}</p>
<a href="shop{if $SID}?{$SID}{/if}" class="w3-button w3-round w3-grey w3-margin-right">{#LB_backShopping#}</a>
{/if}
</div>

<!-- delivery -->
<div id="tab2" style="display:none;">
{if $tab|default:1>1 and $basket_amount|default:0>0}
<h2>{#LB_delivery#}</h2>
<table class="w3-table">
<tr><th>{#LB_deliveryT#}</th>
<th>{#LB_costs#}</th><th>&nbsp;</th></tr>
{section name=item loop=$delivery_list}
	<tr><td><label>
	<input name="delivery_code" id="delivery_code{$smarty.section.item.index}" type="radio" value="{$delivery_list[item].delivery_code}" class="w3-radio w3-margin-right"{if $details.delivery_code|default:'' eq $delivery_list[item].delivery_code} checked="checked"{/if}>
	{$delivery_list[item].delivery_title}</label></td>
	<td>{$delivery_list[item].currency} {$delivery_list[item].price_str}</td>
	<td><img src="images/shop_{$delivery_list[item].delivery_code}.png" width="135" height="67" alt="{$delivery_list[item].delivery_title}" title="{$delivery_list[item].delivery_title}" class="w3-border"></td>
	</tr>
{/section}
</table>
<input type="button" value="{#LB_back#}" onclick="toggleOn(1)" class="w3-button w3-dark-grey w3-margin-top w3-margin-right">
<input type="submit" value="{#LB_next#}" class="w3-button w3-indigo w3-margin-top">
{else}
<p>{#LB_basketEmpty#}</p>
<a href="shop{if $SID}?{$SID}{/if}" class="w3-button w3-round w3-grey w3-margin-right">{#LB_backShopping#}</a>
{/if}
</div>

<!-- payment -->
<div id="tab3" style="display:none;">
{if $tab|default:1>2 and $basket_amount|default:0>0}
<h2>{#LB_payment#}</h2>
<table class="w3-table">
<tr><th>{#LB_paymentT#}</th>
<th>{#LB_costs#}</th><th>&nbsp;</th></tr>
{section name=item loop=$payment_list}
{if $details.bill_name|default:'' eq 'MeinEinkauf' and ($payment_list[item].payment_code eq 'cash' or $payment_list[item].payment_code eq 'postpaid' or $payment_list[item].payment_code eq 'post' or $payment_list[item].payment_code eq 'elv')}
<!-- not supported -->
{else}
	<tr><td><label>
	<input name="payment_code" id="payment_list{$smarty.section.item.index}" type="radio" value="{$payment_list[item].payment_code}" class="w3-radio w3-margin-right"{if $details.payment_code|default:'' eq $payment_list[item].payment_code} checked="checked"{/if}>
	{$payment_list[item].payment_title}</label></td>
	<td>{$payment_list[item].currency} {$payment_list[item].price_str}</td>
	<td><img src="images/shop_{$payment_list[item].payment_code}.png" width="135" height="67" alt="{$payment_list[item].payment_title}" title="{$payment_list[item].payment_title}" class="w3-border"></td>
	</tr>
{/if}
{/section}
</table>
<input type="button" value="{#LB_back#}" onclick="toggleOn(2)" class="w3-button w3-dark-grey w3-margin-top w3-margin-right">
<input type="submit" value="{#LB_next#}" class="w3-button w3-indigo w3-margin-top">
{else}
<p>{#LB_basketEmpty#}</p>
<a href="shop{if $SID}?{$SID}{/if}" class="w3-button w3-round w3-grey w3-margin-right">{#LB_backShopping#}</a>
{/if}
</div>
</form>

<!-- accept -->
<div id="tab4" style="display:none;">
{if $tab|default:1>3 and $basket_amount|default:0>0}
<h2>{#LB_accept#}</h2>
{if $bill_receipt|default:''}
	<h3>{#LB_order#} {$details.id|default:0}</h3>
	{$bill_receipt|default:''}
{/if}
<div class="w3-half">
{if $details.bill_name|default:'' and $details.bill_surname|default:'' and $details.bill_country_code|default:'' and $details.terms_flag|default:0}
	<h3>{#LB_billAddr#}</h3>
	{$details.bill_firm|default:''}<br>
	{$details.bill_title|default:''} {$details.bill_name|default:''} {$details.bill_surname|default:''}<br>
	{$details.bill_street|default:''}<br>
	{$details.bill_postcode|default:''} {$details.bill_city|default:''}<br>
	{section name=item loop=$country_list}
	{if $details.bill_country_code|default:'' eq $country_list[item].country_code}{$country_list[item].country}{/if}
	{/section}
{/if}
{if $details.payment_code|default:''}
	<h3>{#LB_payment#}</h3>
	<img src="images/shop_{$details.payment_code|default:'cash'}.png" width="135" height="67" alt="$details.payment_code|default:'cash'" title="{$details.payment_code|default:'cash'}" class="w3-border">
{/if}
</div><div class="w3-half">
{if $details.cust_name|default:'' and $details.cust_surname|default:'' and $details.cust_country_code|default:''}
	<h3>{#LB_deliveryAddr#}</h3>
	{$details.cust_firm|default:''}<br>
	{$details.cust_title|default:''} {$details.cust_name|default:''} {$details.cust_surname|default:''}<br>
	{$details.cust_street|default:''}<br>
	{$details.cust_postcode|default:''} {$details.cust_city|default:''}<br>
	{section name=item loop=$country_list}
	{if $details.cust_country_code|default:'' eq $country_list[item].country_code}{$country_list[item].country}{/if}
	{/section}
{/if}
{if $details.delivery_code|default:''}
	<h3>{#LB_delivery#}</h3>
	<img src="images/shop_{$details.delivery_code|default:'email'}.png" width="135" height="67" alt="$details.delivery_code|default:'email'" title="{$details.delivery_code|default:'email'}" class="w3-border">
{/if}
</div><div class="w3-clear">&nbsp;</div>
{if $details.payment_code|default:'' eq 'paypal'}
	<form id="fbill" name="fbill" method="post" action="{$ppl_checkout}?token={$ppl_txn}" class="w3-display-container w3-margin-top" style="display:block;">
	<input type="button" value="{#LB_back#}" onclick="toggleOn(3)" class="w3-button w3-dark-grey w3-margin-top w3-margin-right">
	{if $ppl_txn ne 'na' and $ppl_client_id|default:'CLIENT_ID' ne 'CLIENT_ID'}
	<input type="submit" value="{#LB_buy#}" class="w3-button w3-indigo w3-margin-top">
	{/if}
	</form>
{else}
	<form id="fbill" name="fbill" method="post" action="order" onsubmit="getSig2()" class="w3-display-container w3-margin-top" style="display:block;">
	<input name="action" type="hidden" value="details">
	<input name="subaction" type="hidden" value="checkout">
	<input name="details_id" id="details_id" type="hidden" value="{$details.id|default:0}">
	<input name="ip" type="hidden" value="empty">
	<input name="m" type="hidden" value="{$entry_name}">
	<input name="sid" type="hidden" value="{$sid}">
	<input type="button" value="{#LB_back#}" onclick="toggleOn(3)" class="w3-button w3-dark-grey w3-margin-top w3-margin-right">
	<input type="submit" value="{#LB_buy#}" class="w3-button w3-indigo w3-margin-top">
	</form>
{/if}
{else}
<p>{#LB_basketEmpty#}</p>
<a href="shop{if $SID}?{$SID}{/if}" class="w3-button w3-round w3-grey w3-margin-right">{#LB_backShopping#}</a>
{/if}
</div>

<!-- finish -->
<div id="tab5" style="display:none;">
{if $tab|default:1>4}
{$log|default:''}
<a href="shop{if $SID}?{$SID}{/if}" class="w3-button w3-round w3-grey w3-margin-right">{#LB_backShopping#}</a>
{/if}
</div>

<script>
function getSig1() {
	document.forms['forder'].elements['ip'].value=screen.width+'#'+screen.height+'#'+screen.colorDepth+'#'+navigator.language;
	toggle('forder', 0);
}
function getSig2() {
	document.forms['fbill'].elements['ip'].value=screen.width+'#'+screen.height+'#'+screen.colorDepth+'#'+navigator.language;
	toggle('forder', 0);
}
function toggleOn(id) {
	for(i = 1; i <= 4; i ++) {
		var elem = document.getElementById('tab'+i);
		if (elem) toggle('tab'+i, 0);
	}
	toggle('tab'+id, 1);
	document.body.scrollTop = 0; // For Safari
	document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
function addrSame() {
	var tmp_b = document.getElementById('bill_firm_b');
	var tmp_a = document.getElementById('cust_firm_a');
	if (tmp_b && tmp_a) tmp_a.value = tmp_b.value;
	var tmp_b = document.getElementById('bill_name_b');
	var tmp_a = document.getElementById('cust_name_a');
	if (tmp_b && tmp_a) tmp_a.value = tmp_b.value;
	var tmp_b = document.getElementById('bill_surname_b');
	var tmp_a = document.getElementById('cust_surname_a');
	if (tmp_b && tmp_a) tmp_a.value = tmp_b.value;
	for (var i = 0; i < 3; i ++) {
		var tmp_b = document.getElementById('bill_reference_b'+i);
		var tmp_a = document.getElementById('cust_reference_a'+i);
		if (tmp_b && tmp_a) if (tmp_b.checked) tmp_a.checked = true;
	}
	var tmp_b = document.getElementById('bill_title_b');
	var tmp_a = document.getElementById('cust_title_a');
	if (tmp_b && tmp_a) tmp_a.value = tmp_b.value;
	var tmp_b = document.getElementById('bill_street_b');
	var tmp_a = document.getElementById('cust_street_a');
	if (tmp_b && tmp_a) tmp_a.value = tmp_b.value;
	var tmp_b = document.getElementById('bill_postcode_b');
	var tmp_a = document.getElementById('cust_postcode_a');
	if (tmp_b && tmp_a) tmp_a.value = tmp_b.value;
	var tmp_b = document.getElementById('bill_city_b');
	var tmp_a = document.getElementById('cust_city_a');
	if (tmp_b && tmp_a) tmp_a.value = tmp_b.value;
	var tmp_b = document.getElementById('bill_country_code_b');
	var tmp_a = document.getElementById('cust_country_code_a');
	if (tmp_b && tmp_a) tmp_a.selectedIndex = tmp_b.selectedIndex;
}
function MeinEinkauf() {
	var tmp_b = document.getElementById('bill_email_b');
	if (tmp_b) { tmp_b.value = '@meineinkauf.ch'; }
	var tmp_b = document.getElementById('bill_firm_b');
	var tmp_a = document.getElementById('cust_firm_a');
	if (tmp_b && tmp_a) { tmp_a.value = ''; tmp_b.value = ''; }
	var tmp_b = document.getElementById('cust_reference_b2');
	var tmp_a = document.getElementById('cust_reference_a2');
	if (tmp_b && tmp_a) { tmp_a.value = '---'; tmp_b.value = '---'; }
	var tmp_b = document.getElementById('bill_name_b');
	var tmp_a = document.getElementById('cust_name_a');
	if (tmp_b && tmp_a) { tmp_a.value = 'MeinEinkauf'; tmp_b.value = 'MeinEinkauf'; }
	var tmp_b = document.getElementById('bill_surname_b');
	var tmp_a = document.getElementById('cust_surname_a');
	if (tmp_b && tmp_a) { tmp_a.value = 'GmbH'; tmp_b.value = 'GmbH'; }
	var tmp_b = document.getElementById('bill_reference_b2');
	var tmp_a = document.getElementById('cust_reference_a2');
	if (tmp_b && tmp_a) { tmp_a.checked = true; tmp_b.checked = true; }
	var tmp_b = document.getElementById('bill_title_b');
	var tmp_a = document.getElementById('cust_title_a');
	if (tmp_b && tmp_a) { tmp_a.value = ''; tmp_b.value = ''; }
	var tmp_b = document.getElementById('bill_street_b');
	var tmp_a = document.getElementById('cust_street_a');
	if (tmp_b && tmp_a) { tmp_a.value = 'Maybachstraße 19'; tmp_b.value = 'Maybachstraße 19'; }
	var tmp_b = document.getElementById('bill_postcode_b');
	var tmp_a = document.getElementById('cust_postcode_a');
	if (tmp_b && tmp_a) { tmp_a.value = '78467'; tmp_b.value = '78467'; }
	var tmp_b = document.getElementById('bill_city_b');
	var tmp_a = document.getElementById('cust_city_a');
	if (tmp_b && tmp_a) { tmp_a.value = 'Konstanz'; tmp_b.value = 'Konstanz'; }
	var tmp_b = document.getElementById('bill_country_code_b');
	var tmp_a = document.getElementById('cust_country_code_a');
	if (tmp_b && tmp_a) { tmp_a.value = 'DE'; tmp_b.value = 'DE'; }
}
{if $tab}toggleOn({$tab});
{else}toggleOn(1);
{/if}
</script>

