<!-- COPYRIGHTS Another CMS      -->
{literal}
<script>
function oDel(uid) {
oCnfr('delete','product',uid,'{/literal}{#LB_delete#}{literal} #'+uid+'?');
}
</script>
{/literal}

{strip}
<!-- filter -->
<form id="form_search_header" method="post" action="#">
<div class="w3-row">
	<div class="w3-margin-right w3-left">
	<label>{#LB_webPage#}:</label><select name="menu_id" onchange="this.form.submit()" class="w3-select w3-border w3-round w3-margin-bottom-8">
	<option value="0">---</option>
	{section name=item loop=$search_list}
	<option value="{$search_list[item].id}"{if $details_search.menu_id|default:0 eq $search_list[item].id} selected="selected"{/if}{if $search_list[item].content_type eq 'folder'} style="font-weight:bold"{/if}>
	{'&nbsp;'|indent:$search_list[item].level:'- '} {$search_list[item].title}</option>
	{/section}
	</select>
	</div>
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
	<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','product')" value="{#LB_newProduct#}">
	<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','prices')" value="{#LB_prices#}">
	<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oModul('125','list')" value="{#LB_orders#}">
	{/if}
	</div>
</div>
	<input name="action" type="hidden" id="action" value="list">
	<input name="subaction" type="hidden" id="subaction" value="search">
</form>
<!-- filter -->

<table class="w3-table w3-bordered w3-striped">
<tr>
<th>{#LB_id#}</th>
<th>{#LB_title#}</th>
<th class="w3-hide-small">{#LB_productNumber#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_webPage#}</th>
<th>{#LB_options#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_tax#}</th>
<th class="w3-hide-small">{#LB_count#}</th>
<th class="w3-center w3-hide-small w3-hide-medium">{#LB_prio#}</th>
<th class="w3-center">{#LB_status#}</th>
<th class="w3-center">{#LB_delete#}</th>
</tr>
{section name=item loop=$items_list}
	<tr>
	<td>{$items_list[item].id}</td>
	<td><a href="javascript:rScr('details','product&amp;details_id={$items_list[item].id}');" style="text-decoration:none"{if $items_list[item].status < 2} class="w3-text-dark-grey"{/if}><span class="i20s_ed" title="{#LB_change#}"></span>
	{$items_list[item].title}</a>
	</td>
       	<td class="w3-hide-small">
	{if $items_list[item].image|count_characters > 4}
		<a onmouseover="toggle('opt_{$items_list[item].id}',-1)" onmouseout="toggle('opt_{$items_list[item].id}',-1)"><span class="i20s_jpg"></span></a>
		<img src="../content/images/thumbs/{$items_list[item].image}" alt="{$items_list[item].image}" title="{$items_list[item].image}" width="75" height="75" id="opt_{$items_list[item].id}" style="display:none; position:absolute; clear:both; margin-top:22px; padding:4px; background-color:white; border-radius:3px; box-shadow:0 0 3px #888;"></a>
	{/if}
       	{$items_list[item].pr_number}</td>
	<td class="w3-hide-small w3-hide-medium">
	{if $items_list[item].menu_main_id > 0}
		{section name=category loop=$search_list}
		{if $items_list[item].menu_main_id eq $search_list[category].id}
		{$search_list[category].title}
		{/if}
		{/section}
	{else}--{/if}
	</td>
	<td>
	{if $items_list[item].family_ids}
		<a href="javascript:rScr('details','options&amp;details_id={$items_list[item].id}');" class="i20s_delv" onmouseover="toggle('fam_{$items_list[item].id}',-1)" onmouseout="toggle('fam_{$items_list[item].id}',-1)"></a>
		<!-- PopUp -->
		<div id="fam_{$items_list[item].id}" class="opt320" style="display:none;">{#LB_productFamily#}:<br>
		{$items_list[item].family_products|default:'--'}
		</div>
	{else}
		<a href="javascript:rScr('details','options&amp;details_id={$items_list[item].id}');" class="i20s_delv0" title="{#LB_productFamily#}"></a>
	{/if}
	<span class="i20s_warn" title="{#LB_prices#}" onmouseover="toggle('pram_{$items_list[item].id}',-1)" onmouseout="toggle('pram_{$items_list[item].id}',-1)"></span>
	<!-- PopUp -->
	<div id="pram_{$items_list[item].id}" class="opt200" style="display:none;">{#LB_prices#}:<br>
       	{$items_list[item].amount} {#LB_piece#}: {$items_list[item].price_str} {$items_list[item].currency}<br>
       	{$items_list[item].amount_1} {#LB_pieces#}: {$items_list[item].price_1_str} {$items_list[item].currency}<br>
       	{$items_list[item].amount_2} {#LB_pieces#}: {$items_list[item].price_2_str} {$items_list[item].currency}<br>
       	{$items_list[item].amount_3} {#LB_pieces#}: {$items_list[item].price_3_str} {$items_list[item].currency}
	{if $items_list[item].weight_kg > 0}<hr>{#LB_weight#}: {$items_list[item].weight_kg_str}{/if}
	</div>
	</td>
	<td class="w3-hide-small w3-hide-medium">{$items_list[item].tax_str}%</td>
	<td class="w3-hide-small">{$items_list[item].amount_total}</td>
	<td class="w3-hide-small w3-hide-medium" style="text-align:center; text-align:-webkit-center; text-align:-moz-center;">{$items_list[item].priority}</td>
	<td style="text-align:center; text-align:-webkit-center; text-align:-moz-center;">
	{if $items_list[item].status == 4}
	<span class="i20s_inact" title="{#LB_special#}"></span>
	{elseif $items_list[item].status == 3}
	<span class="i20s_new" title="{#LB_newProduct#}"></span>
	{elseif $items_list[item].status == 2}
	<span class="i20s_act" title="{#LB_active#}"></span>
	{else}
	<span class="i20s_inact0" title="{#LB_inactive#}"></span>
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
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','product')" value="{#LB_newProduct#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','prices')" value="{#LB_prices#}">
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oModul('125','list')" value="{#LB_orders#}">
{/if}
</div>
<hr class="w3-light-grey">
{/strip}
