<h1>{#LB_prices#}</h1>
<table class="w3-table w3-bordered w3-striped">
<tr>
<th>#</th>
<th class="w3-hide-small">{#LB_productNumber#}</th>
<th>{#LB_title#}</th>
<th>{#LB_price#} {#LB_gross#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_tax#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_count#}</th>
</tr>
{assign var="curr_cat" value=0}
{assign var="view_cat" value="disabled"}
{section name=item loop=$items_list}
	{if $items_list[item].menu_main_id ne $curr_cat}
	{section name=category loop=$menu_tree}
	  {if $items_list[item].menu_main_id eq $menu_tree[category].id}
	    {assign var="view_cat" value=$menu_tree[category].status}
	    {if $view_cat ne 'disabled'}
	    <tr><td colspan="6" class="w3-dark-grey">
	    <strong>{$menu_tree[category].title}</strong>
	    </td></tr>
	    {/if}
	  {/if}
	{/section}
	{/if}
	{assign var="curr_cat" value=$items_list[item].menu_main_id}
	{if $view_cat ne 'disabled'}
	<tr>
	<td>{$smarty.section.item.iteration}</td>
	<td class="w3-hide-small">{$items_list[item].pr_number}</td>
	<td style="max-width:320px;">
	<img src="images/shop_image.png" width="19" height="19" onmouseover="toggle('opt_{$items_list[item].id}',-1)" onmouseout="toggle('opt_{$items_list[item].id}',-1)" alt="{$items_list[item].title_1}">&nbsp;
	<img src="content/images/thumbs/{$items_list[item].image}" alt="{$items_list[item].title_1}" title="{$items_list[item].title_1}" width="75" height="75" id="opt_{$items_list[item].id}" style="display:none;position:absolute;margin-top:2px;padding:4px;background-color:white;border-radius:3px;box-shadow:0 0 3px #888;">
	<a href="shop?action=details&amp;subaction=product&amp;pid={$items_list[item].id}{if $SID}&amp;{$SID}{/if}"{if $items_list[item].amount_total==0} class="w3-text-grey"{/if}>{$items_list[item].title_1} {$items_list[item].title_2}</a>
	</td>
	<td>
	<div class="w3-half">
	  ab&nbsp;{$items_list[item].amount|default:'0'}:&nbsp;<b>{$items_list[item].price_str|default:'0'}</b>
	  {if $items_list[item].price_1 <> $items_list[item].price}<br>ab&nbsp;{$items_list[item].amount_1|default:'0'}:&nbsp;<b>{$items_list[item].price_1_str|default:'0'}</b>{/if}
	</div>
	<div class="w3-half">
	  {if $items_list[item].price_2 <> $items_list[item].price_1}ab&nbsp;{$items_list[item].amount_2|default:'0'}:&nbsp;<b>{$items_list[item].price_2_str|default:'0'}</b>{/if}
	  {if $items_list[item].price_3 <> $items_list[item].price_2}<br>ab&nbsp;{$items_list[item].amount_3|default:'0'}:&nbsp;<b>{$items_list[item].price_3_str|default:'0'}</b>{/if}
	</div>
	</td>
	<td class="w3-hide-small w3-hide-medium">{$items_list[item].tax_str|default:'0'}%</td>
	<td class="w3-hide-small w3-hide-medium">{if $items_list[item].amount_total>99}>99{else}{if $items_list[item].amount_total>0}{$items_list[item].amount_total}{else}{#LB_sold#}{/if}{/if}</td>
	</tr>
	{/if}
{/section}
</table>

<div class="w3-margin-top w3-theme w3-medium w3-center w3-clear">
<!-- pager -->
{if $pager_list.pages > 1}
<form name="form_pager_header" id="form_pager_header" method="post" action="#">
	{if $pager_list.page ne 1}
		<a href="javascript:pagerGo('form_pager_header','first');" class="w3-bar-item w3-button w3-padding-8 w3-round">{#LB_first#}</a>
	{else}
		<span class="w3-bar-item w3-button w3-disabled w3-padding-8 w3-round">{#LB_first#}</span>
	{/if}
	{if $pager_list.page ne 1}
		<a href="javascript:pagerGo('form_pager_header','prev');" class="w3-bar-item w3-button w3-padding-8 w3-round">{#LB_prev#}</a>
	{else}
		<span class="w3-bar-item w3-button w3-disabled w3-padding-8 w3-round">{#LB_prev#}</span>
	{/if}
	<span class="w3-bar-item w3-padding-8">{#LB_page#}:</span>
	<select name="page" id="page" onchange="pagerGo('form_pager_header','prices');">
	{section name=item loop=$pager_list.pages}
		<option value="{$smarty.section.item.iteration}"{if $pager_list.page eq $smarty.section.item.iteration} selected{/if}>
		{$smarty.section.item.iteration}
		</option>
	{/section}
	</select>&nbsp;/&nbsp;{$pager_list.pages}
	<input name="action" type="hidden" value="list">
	<input name="subaction" type="hidden" value="prices">
	<input name="m" value="{$entry_name}" type="hidden">
	<input name="sid" value="{$sid}" type="hidden">
	{if $pager_list.page ne $pager_list.pages}
		<a href="javascript:pagerGo('form_pager_header','next');" class="w3-bar-item w3-button w3-padding-8 w3-round">{#LB_next#}</a>
	{else}
		<span class="w3-bar-item w3-button w3-disabled w3-padding-8 w3-round">{#LB_next#}</span>
	{/if}
	{if $pager_list.page ne $pager_list.pages}
		<a href="javascript:pagerGo('form_pager_header','last');" class="w3-bar-item w3-button w3-padding-8 w3-round">{#LB_last#}</a>
	{else}
		<span class="w3-bar-item w3-button w3-disabled w3-padding-8 w3-round">{#LB_last#}</span>
	{/if}
</form>
{/if}
{literal}
<script>
function pagerGo(targetId,action){
	target_obj=document.getElementById(targetId);
	page_obj=document.getElementById('page');
	var ind=0;
	switch(action){
	case 'first':ind=0;break;
	case 'prev':ind=page_obj.selectedIndex-1;break;
	case 'next':ind=page_obj.selectedIndex+1;break;
	case 'last':ind=page_obj.length-1;break;
	default:ind=page_obj.selectedIndex;break};
	page_obj.selectedIndex=ind;
	target_obj.subaction.value='prices';
	target_obj.submit();
}
</script>
{/literal}
<!-- pager -->
</div>
