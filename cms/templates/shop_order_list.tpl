<!-- COPYRIGHTS Another CMS      -->
{literal}
<script>
function oDel(uid) {
oCnfr('delete','order',uid,'{/literal}{#LB_delete#}{literal} #'+uid+'?');
}
</script>
{/literal}

{strip}
<!-- filter -->
<form id="form_search_header" method="post" action="#">
<div class="w3-row">
	<div class="w3-margin-right w3-left">
	<label>{#LB_sort#}:</label><select name="sort" onchange="this.form.submit()" class="w3-select w3-border w3-round w3-margin-bottom-8">
	<option value="0">---</option>
	{section name=item loop=$sort_list}
	<option value="{$sort_list[item].id}"{if $details_search.sort|default:'' eq $sort_list[item].id} selected{/if}>{$sort_list[item].title}</option>
	{/section}
	</select>
	</div>
	<div class="w3-left">
	<label>{#LB_search#}:</label>
	<input name="filter" type="text" id="filter" value="{$details_search.filter|default:''}" size="15" maxlength="128" class="w3-input w3-border w3-round w3-margin-bottom-8">
	</div>
	<div class="w3-margin-right w3-left">&nbsp;<br>
	<input class="w3-button w3-theme" type="submit" value="{#LB_go#}">
	</div>
	<!-- buttons -->
	<div class="w3-right w3-hide-small w3-hide-medium">
	{if $entry_info.entry_attr > 2} &nbsp;<br>
	<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','order')" value="{#LB_newOrder#}">
	<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oModul('126','list')" value="{#LB_products#}">
	<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oModul('127','list')" value="{#LB_discount#}">
	{/if}
	</div>
</div>
	<input name="action" type="hidden" id="action" value="list">
	<input name="subaction" type="hidden" id="subaction" value="search">
</form>
<!-- filter -->

<table class="w3-table w3-bordered w3-striped">
<tr>
<th class="w3-hide-small">{#LB_id#}</th>
<th>{#LB_name#} {#LB_surname#}</th>
<th class="w3-hide-small">{#LB_tel#}</th>
<th class="w3-center">{#LB_email#}</th>
<th class="w3-hide-small">{#LB_payment#}</th>
<th class="w3-hide-medium">{#LB_bill#}</th>
<th>{#LB_options#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_created#} / {#LB_closed#}</th>
<th class="w3-center">{#LB_status#}</th>
<th class="w3-center">{#LB_delete#}</th>
</tr>
{section name=item loop=$items_list}
	<tr>
	<td class="w3-hide-small">{$items_list[item].id}{if $items_list[item].status == 1} *{/if}</td>
	<td><a href="javascript:rScr('details','order&amp;details_id={$items_list[item].id}');" title="{$items_list[item].id} - {if $items_list[item].createtime}{$items_list[item].createtime|date_format:"%d.%m.%Y %H:%M"}{else}--{/if}" style="text-decoration:none"{if $items_list[item].status < 1} class="w3-text-dark-grey"{/if}>
	<span class="{if $items_list[item].status > 0}i20s_ed{else}i20s_ed0{/if}"></span>
	{$items_list[item].bill_name} {$items_list[item].bill_surname}</a></td>
	<td class="w3-hide-small">{$items_list[item].bill_tel|default:'--'}</td>
	<td style="text-align:center; text-align:-webkit-center; text-align:-moz-center;"><a href="mailto:{$items_list[item].bill_email}" class="{if $items_list[item].status > 0}i20s_em{else}i20s_em0{/if}" title="{$items_list[item].bill_email}"></a></td>
	<td class="w3-hide-small">
       	{if $items_list[item].payment_code}
	{section name=itr loop=$payment_list}
	{if $items_list[item].payment_code eq $payment_list[itr].code}{$payment_list[itr].title}{/if}
	{/section}
	{else}--{/if}</td>
	<td class="w3-hide-medium">{if $items_list[item].bill_nr>0}<b>{$items_list[item].bill_nr}</b>{/if} {if $items_list[item].bill_total_gross|default:0>0}{$items_list[item].bill_total_gross}{$currency}{/if} {$items_list[item].bill_country_code}</td>
	<td><a href="javascript:rScr('details','options&amp;details_id={$items_list[item].id}');" title="{#LB_edit#}"><span class="i20s_ed"></span></a>
	{if $items_list[item].status>0 and $items_list[item].bill_receipt}
		<a href="javascript:oDtl('bill','{$items_list[item].id}');" class="i20s_ord" title="{#LB_bill#}" onmouseover="toggle('bill_{$items_list[item].id}',-1)" onmouseout="toggle('bill_{$items_list[item].id}',-1)"></a>
		<!-- PopUp -->
		<div id="bill_{$items_list[item].id}" class="opt320 w3-small" style="display:none;">
		{$items_list[item].bill_receipt|default:'--'}
		</div>
	{else}
		<span class="i20s_ord0" title="{#LB_bill#}"></span>
	{/if}
	{if $items_list[item].status>0 && $items_list[item].delivery_receipt}
		<a href="javascript:oDtl('delivery','{$items_list[item].id}');" class="i20s_delv" title="{#LB_delivery#}"></a>
	{else}
		<span class="i20s_delv0" title="{#LB_delivery#}"></span>
	{/if}
	{if ($items_list[item].status==1 or $items_list[item].status==2 or $items_list[item].status==5) and $items_list[item].createtime<$smarty.now-864000}
		<a href="javascript:oDtl('dunning','{$items_list[item].id}');" class="i20s_att" title="{#LB_dunning#}"></a>
	{/if}
	{if $items_list[item].notes}
		<a href="javascript:rScr('details','order&amp;details_id={$items_list[item].id}');" class="i20s_warn w3-hide-small" title="{#LB_note#}" onmouseover="toggle('note_{$items_list[item].id}',-1)" onmouseout="toggle('note_{$items_list[item].id}',-1)"></a>
		<!-- PopUp -->
		<div id="note_{$items_list[item].id}" class="opt200 w3-small" style="display:none;">
		{$items_list[item].notes|nl2br}
		</div>
	{/if}
	</td>
	<td class="w3-hide-small w3-hide-medium">{if $items_list[item].createtime}{$items_list[item].createtime|date_format:"%d.%m.%Y"}{else}--{/if} / {if $items_list[item].closetime}{$items_list[item].closetime|date_format:"%d.%m.%Y"}{else}--{/if}</td>
	<td style="text-align:center; text-align:-webkit-center; text-align:-moz-center;">
	{if $items_list[item].status == 5}
	<span class="i20s_inact" title="{#LB_dunning#}"></span>
	{elseif $items_list[item].status == 4}
	<span class="i20s_canc" title="{#LB_canceled#}"></span>
	{elseif $items_list[item].status == 3}
	<span class="i20s_act" title="{#LB_closed#}"></span>
	{elseif $items_list[item].status == 2}
	<span class="i20s_new" title="{#LB_active#}"></span>
	{elseif $items_list[item].status == 1}
	<span class="i20s_new" title="{#LB_new#}"></span>
	{else}
	<span class="i20s_new0" title="{#LB_inactive#}"></span>
	{/if}
	</td>
	<td style="text-align:center; text-align:-webkit-center; text-align:-moz-center;">
	{if $entry_info.entry_attr > 2}
		<a href="javascript:oDel('{$items_list[item].id}');" class="i20s_del" title="{#LB_delete#}"></a>
	{else}
		<span class="i20s_del0"></span>
	{/if}
	</td>
	</tr>
{/section}
</table>
<!-- list -->

{if $pager_list.pages > 1}
<!-- pager -->
<form name="form_pager_header" id="form_pager_header" method="post" action="#" class="w3-clear">
<div class="w3-row w3-margin-top">
	{if $pager_list.page ne 1}
		<a href="javascript:pagerGo('form_pager_header','first');" class="w3-border w3-light-grey w3-round w3-padding-small w3-margin-right-8" style="text-decoration:none">{#LB_first#}</a>
	{else}
		<span class="w3-border w3-text-grey w3-round w3-padding-small w3-margin-right-8">{#LB_first#}</span>
	{/if}
	{if $pager_list.page ne 1}
		<a href="javascript:pagerGo('form_pager_header','prev');" class="w3-border w3-light-grey w3-round w3-padding-small w3-margin-right-8" style="text-decoration:none">{#LB_prev#}</a>
	{else}
		<span class="w3-border w3-text-grey w3-round w3-padding-small w3-margin-right-8">{#LB_prev#}</span>
	{/if}
	<span style="padding-left:10px;">{#LB_page#}:&nbsp;</span>
	<select name="page" id="page" onchange="pagerGo('form_pager_header','search');" class="w3-select w3-border w3-round w3-padding-small" style="width:auto;">
	{section name=item loop=$pager_list.pages}
		<option value="{$smarty.section.item.iteration}"{if $pager_list.page eq $smarty.section.item.iteration} selected{/if}>
		{$smarty.section.item.iteration}
		</option>
	{/section}
	</select> : {$pager_list.pages} &nbsp;
	<input name="sort" type="hidden" value="{$details_search.sort|default:0}">
	<input name="filter" type="hidden" value="{$details_search.filter|default:''}">
	<input name="menu_id" type="hidden" value="{$details_search.menu_id|default:0}">
	<input name="action" type="hidden" value="list">
	<input name="subaction" type="hidden" value="search">
	{if $pager_list.page ne $pager_list.pages}
		<a href="javascript:pagerGo('form_pager_header','next');" class="w3-border w3-light-grey w3-round w3-padding-small w3-margin-right-8" style="text-decoration:none">{#LB_next#}</a>
	{else}
		<span class="w3-border w3-text-grey w3-round w3-padding-small w3-margin-right-8">{#LB_next#}</span>
	{/if}
	{if $pager_list.page ne $pager_list.pages}
		<a href="javascript:pagerGo('form_pager_header','last');" class="w3-border w3-light-grey w3-round w3-padding-small w3-margin-right-8" style="text-decoration:none">{#LB_last#}</a>
	{else}
		<span class="w3-border w3-text-grey w3-round w3-padding-small w3-margin-right-8">{#LB_last#}</span>
	{/if}
</div>
</form>
<!-- pager -->
{/if}

<!-- buttons -->
<div class="w3-row">
{if $entry_info.entry_attr > 2} &nbsp;<br>
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','order')" value="{#LB_newOrder#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oModul('126','list')" value="{#LB_products#}">
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oModul('127','list')" value="{#LB_discount#}">
{/if}
</div>
<hr class="w3-light-grey">
{/strip}
