<h1>{#LB_basket#}</h1>
{strip}

{if $basket_amount>0}
<form id="fbasket" name="fbasket" method="post" action="basket" onsubmit="getSig1()" class="w3-display-container w3-margin-top" style="display:block;">
<table class="w3-table w3-bordered"><tbody><tr>
<th>{#LB_product#}</th>
<th class="w3-right-align">{#LB_price#}</th>
<th class="w3-right-align">{#LB_count#}</th>
<th class="w3-right-align">{#LB_sum#}</th>
</tr>
{section name=item loop=$items_list}
	<tr>
	<td style="max-width:560px"><img src="content/images/thumbs/{$items_list[item].image}" alt="{$items_list[item].title_1} {$items_list[item].title_2}" class="w3-round w3-margin-right w3-margin-bottom-8" width="70" height="70" style="float:left;">
	<a href="shop?action=details&amp;subaction=product&amp;pid={$items_list[item].id}{if $SID}&amp;{$SID}{/if}" title="{$items_list[item].title_1}">{$items_list[item].title_1} {$items_list[item].title_2}</a>
	{if $items_list[item].pr_number}<br><span{if $items_list[item].weight_kg>0} title="{$items_list[item].weight_kg_str} kg"{/if}>{$items_list[item].pr_number}{/if}</span></td>
	<td class="w3-right-align">{$items_list[item].currency}&nbsp;{$items_list[item].single_price_str}
	{if $items_list[item].tax>0}<br><span class="w3-small">{$items_list[item].tax_str}% {#LB_tax#}</span>{/if}</td>
	<td class="w3-right-align">
	<input type="button" class="w3-button w3-margin-bottom-8 w3-margin-top-8 w3-light-grey" onclick="javascript:delBs('cnt{$smarty.section.item.index}')" value="{#LB_delete#}">
	<input name="cnt{$smarty.section.item.index}" id="cnt{$smarty.section.item.index}" type="number" value="{$items_list[item].amount}"  min="0" max="{$items_list[item].amount_total}" class="w3-input w3-border w3-margin-left-8 w3-round" style="max-width:68px;display:inline;">
	<input name="id{$smarty.section.item.index}" id="id{$smarty.section.item.index}" value="{$items_list[item].id}" type="hidden">
	</td>
	<td class="w3-right-align">{$items_list[item].currency}&nbsp;{$items_list[item].subtotal_price_str}
	<!-- {if $items_list[item].tax>0}<br><span class="w3-small">{$items_list[item].currency}&nbsp;{$items_list[item].subtotal_price_nett_str} {#LB_nett#}</span>{/if} -->
	</td>
	</tr>
{/section}
<tr><td><img src="images/shop_discount.png" alt="{#LB_coupon#}" title="{#LB_coupon#}" width="25" height="25">&nbsp; {#LB_coupon#}</td>
<td>&nbsp;</td>
<td class="w3-right-align">
{if $discount_info.discount_code|default:''}
<input type="button" class="w3-button w3-margin-bottom-8 w3-light-grey" onclick="javascript:delBs('discount_code')" value="{#LB_delete#}">
{else}
<input type="button" class="w3-button w3-margin-bottom-8 w3-light-grey" onclick="javascript:refBs()" value="{#LB_couponUse#}">
{/if}
<input name="discount_code" id="discount_code" type="text" value="{$discount_info.discount_code|default:''}" size="10" maxlength="16" class="w3-input w3-border w3-round w3-margin-left-8 w3-right" style="max-width:100px;"></td>
<td class="w3-right-align">{if $discount_info.price|default:0 > 0}-{if $discount_info.price_type eq 'pct'}%{else}{$sum_list.currency}{/if}&nbsp;{$discount_info.price_str}{else}--{/if}</td>
</tr></tbody></table>
<div class="w3-right-align w3-margin-top-8"><b>{#LB_subtotal#}: {$sum_list.currency}&nbsp;{$sum_list.total_price_str}</b>
<!-- {if $sum_list.total_price!=$sum_list.total_price_nett}<br><span class="w3-small">{$sum_list.currency}&nbsp;{$sum_list.total_price_nett_str} {#LB_nett#}</span>{/if} -->
</div>
	<input name="cnt" id="cnt" type="hidden" value="{$smarty.section.item.total}">
	<input name="action" id="action" type="hidden" value="list">
	<input name="subaction" id="subaction" type="hidden" value="refresh">
	<input name="ip" type="hidden" value="empty">
	<input name="m" type="hidden" value="{$entry_name}">
	<input name="sid" type="hidden" value="{$sid}">
	<script>
	function getSig1() { document.forms['fbasket'].elements['ip'].value=screen.width+'#'+screen.height+'#'+screen.colorDepth+'#'+navigator.language; }
	</script>
</form>
<table class="w3-table w3-margin-top">
<tr><td>
	<a href="shop{if $SID}?{$SID}{/if}" class="w3-button w3-round w3-grey w3-margin-right">{#LB_backShopping#}</a>
	<p>
	{assign var="menuid" value=0}
	{section name=item loop=$items_list}
	{section name=imenu loop=$menu_tree}
		{if $items_list[item].menu_main_id==$menu_tree[imenu].id and $items_list[item].menu_main_id!=$menuid}
		{assign var="menuid" value=$items_list[item].menu_main_id}
		<a href="{$menu_tree[imenu].name}?action=list&amp;subaction=products{if $SID}&amp;{$SID}{/if}" title="{$menu_tree[imenu].title}">{$menu_tree[imenu].title}</a><br>
		{/if}
	{/section}
	{/section}
	</p>
</td><td style="text-align:center">
	<form id="fshop" name="fshop" method="post" action="order" onsubmit="getSig2()">
	<input type="submit" value="{#LB_checkout#}" class="w3-button w3-indigo">
	<input name="action" type="hidden" value="list">
	<input name="subaction" type="hidden" value="order">
	<input name="ip" type="hidden" value="empty">
	<input name="sid" type="hidden" value="{$sid}">
	<script>
	function getSig2() { document.forms['fshop'].elements['ip'].value=screen.width+'#'+screen.height+'#'+screen.colorDepth+'#'+navigator.language; }
	</script>
	</form>
</td>
<td style="text-align:right"><input type="button" onclick="refBs();" value="{#LB_refresh#}" class="w3-button w3-dark-grey"></td></tr>
</table>
{else}
<p>{#LB_basketEmpty#}</p>
<a href="shop{if $SID}?{$SID}{/if}" class="w3-button w3-round w3-grey w3-margin-right">{#LB_backShopping#}</a>
{/if}
{/strip}

{literal}
<script>
function delBs(targedId) {
	target_obj = document.getElementById(targedId);
	target_obj.value = 0;
	var frm = document.getElementById('fbasket');
	toggle('fbasket', 0);
	frm.submit();
}
function refBs() {
	var frm = document.getElementById('fbasket');
	var action = document.getElementById('action');
	var subaction = document.getElementById('subaction');
	action.value = 'list';
	subaction.value = 'refresh';
	toggle('fbasket', 0);
	frm.submit();
}
</script>
{/literal}
