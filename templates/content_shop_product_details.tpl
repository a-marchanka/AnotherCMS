<h1>{$entry_title}</h1>
{section name=item loop=$items_list}
<div id="tab{$items_list[item].id}" style="{if $items_list[item].id==$pid}display:block{else}display:none{/if}">
	<div class="w3-third w3-center w3-display-container">
	<a rel="lytebox[galery]" href="content/images/{$items_list[item].image}" title="{$items_list[item].title_1}">
	<img src="content/images/{$items_list[item].image}" alt="{$items_list[item].title_1}" class="w3-round" style="width:100%;"></a>
	{if $items_list[item].status==4}<span class="w3-tag w3-display-topleft w3-pink w3-small">{#LB_special#}</span>{/if}
	{if $items_list[item].status==3}<span class="w3-tag w3-display-topleft w3-yellow w3-small">{#LB_new#}</span>{/if}
	<br>
	<a rel="lytebox[galery]" href="content/images/{$items_list[item].image}" class="w3-small">{#LB_zoom#}</a>
	</div>
	<div class="w3-twothird w3-container">
	<h3>{$items_list[item].title_1} {$items_list[item].title_2}</h3>
	{if $items_list[item].title_2}
	{section name=subi loop=$items_list}
		<input class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-grey" type="button" onclick="toTab('tab{$items_list[item].id}','tab{$items_list[subi].id}','ref{$items_list[item].id}','ref{$items_list[subi].id}');" value="{$items_list[subi].title_2}" {if $items_list[subi].title_2 eq $items_list[item].title_2}disabled="disabled"{/if}>
	{/section}
	{/if}
	<p>{#LB_productNumber#}: {$items_list[item].pr_number}</p>
	<table class="w3-table w3-bordered w3-striped"><tbody>
	<tr><th>{#LB_from1#} {$items_list[item].amount}</th>
	{if $items_list[item].amount_1 != $items_list[item].amount}<th>{#LB_from1#} {$items_list[item].amount_1}</th>{/if}
	{if $items_list[item].amount_2 != $items_list[item].amount_1}<th>{#LB_from1#} {$items_list[item].amount_2}</th>{/if}
	{if $items_list[item].amount_3 != $items_list[item].amount_2}<th>{#LB_from1#} {$items_list[item].amount_3}</th>{/if}
	<th>{#LB_tax#}</th></tr>
	<tr><td><b>{$items_list[item].currency}&nbsp;{$items_list[item].price_str}</b></td>
	{if $items_list[item].amount_1 != $items_list[item].amount}<td><b>{$items_list[item].currency}&nbsp;{$items_list[item].price_1_str}</b></td>{/if}
	{if $items_list[item].amount_2 != $items_list[item].amount_1}<td><b>{$items_list[item].currency}&nbsp;{$items_list[item].price_2_str}</b></td>{/if}
	{if $items_list[item].amount_3 != $items_list[item].amount_2}<td><b>{$items_list[item].currency}&nbsp;{$items_list[item].price_3_str}</b></td>{/if}
	<td>{$items_list[item].tax_str}%</td></tr>
<!--	<tr><td class="w3-small">{$items_list[item].currency}&nbsp;{$items_list[item].price_nett_str}</td>
	{if $items_list[item].amount_1 != $items_list[item].amount}<td class="w3-small">{$items_list[item].currency}&nbsp;{$items_list[item].price_1_nett_str}</td>{/if}
	{if $items_list[item].amount_2 != $items_list[item].amount_1}<td class="w3-small">{$items_list[item].currency}&nbsp;{$items_list[item].price_2_nett_str}</td>{/if}
	{if $items_list[item].amount_3 != $items_list[item].amount_2}<td class="w3-small">{$items_list[item].currency}&nbsp;{$items_list[item].price_3_nett_str}</td>{/if}
	<td class="w3-small">{#LB_nett#}</td></tr> -->
	</tbody></table>
	{if $items_list[item].amount_total>0}
	<form id="fo{$items_list[item].id}" name="det{$items_list[item].id}" method="post" action="#" onsubmit="getSig{$items_list[item].id}()" class="w3-margin-top">
		{#LB_count#}: <input name="cnt" type="number" min="{$items_list[item].amount}" max="{$items_list[item].amount_total}" value="1" class="w3-input w3-border w3-round w3-margin-right-8" style="max-width:68px;display:inline;" required="">
		<input type="submit" value="{#LB_basketAdd#}" class="w3-button w3-indigo">
		{if $basket_amount|default:0 > 0}
		<a href="basket?action=list{if $SID}&amp;{$SID}{/if}" class="w3-button w3-round w3-grey">{#LB_basket#}</a>
		{/if}
		<a href="{$entry_name}{if $SID}?{$SID}{/if}" class="w3-button w3-round w3-grey">{#LB_backShopping#}</a>
		<input name="pid" type="hidden" value="{$items_list[item].id}">
		<input name="action" type="hidden" value="details">
		<input name="subaction" type="hidden" value="add">
		<input name="ip" value="empty" type="hidden">
		<input name="m" value="{$entry_name}" type="hidden">
		<input name="sid" value="{$sid}" type="hidden">
		<script>
		function getSig{$items_list[item].id}() {
		var c = "document.forms['det" + {$items_list[item].id} + "'].elements['ip'].value=screen.width+'#'+screen.height+'#'+screen.colorDepth+'#'+navigator.language";	eval(c); }
		</script>
	</form>
	{else}<p class="w3-text-deep-orange">{#LB_sold#} <a href="{$entry_name}{if $SID}?{$SID}{/if}" class="w3-button w3-round w3-grey w3-margin-left">{#LB_backShopping#}</a></p>{/if}
	</div>
	<div class="w3-clear">{$items_list[item].descr}</div>
</div>
{/section}

<script>
function toTab(diTab,enTab,diRef,enRef) { toggle(diTab,0); toggle(enTab,1); toggle(diRef,0); toggle(enRef,1); }
</script>
{assign var="curr_cat" value=0}
{if $subitems_list|default:0}
<div class="w3-padding w3-border-top">
<h4>{#LB_productFamily#}</h4>
{section name=item loop=$subitems_list}
{if $subitems_list[item].id_ref != $curr_cat}{assign var="curr_cat" value=$subitems_list[item].id_ref}
</div>
<div id="ref{$subitems_list[item].id_ref}" style="{if $subitems_list[item].id_ref==$pid}display:block{else}display:none{/if}">
{/if}
	<div class="w3-quarter" style="min-height:219px"><div class="w3-display-container w3-margin-right">
	<a href="?action=details&amp;subaction=product&amp;pid={$subitems_list[item].id}{if $SID}&amp;{$SID}{/if}"><img src="content/images/{$subitems_list[item].image}" alt="{$subitems_list[item].title_1}" title="{$subitems_list[item].title_1}" id="opt_{$subitems_list[item].id}" class="w3-round w3-hover-opacity" style="width:100%;"></a>
	{if $subitems_list[item].status==4}<span class="w3-tag w3-display-topleft w3-pink w3-small">{#LB_special#}</span>{/if}
	{if $subitems_list[item].status==3}<span class="w3-tag w3-display-topleft w3-yellow w3-small">{#LB_new#}</span>{/if}
	<p class="w3-small" style="margin-top:5px"><a href="?action=details&amp;subaction=product&amp;pid={$subitems_list[item].id}{if $SID}&amp;{$SID}{/if}" style="text-decoration:none">{$subitems_list[item].title_1|truncate:35} {$subitems_list[item].title_2}</a><br><b>{$subitems_list[item].currency}&nbsp;{$subitems_list[item].price_str}</b></p>
	</div></div>
{/section}
{if $curr_cat != 0}</div>{/if}
<div class="w3-clear">&nbsp;</div>
{/if}

