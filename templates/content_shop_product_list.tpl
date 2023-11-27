<h1>{$entry_title}</h1>
{strip}
{section name=item loop=$items_list}
	<div class="w3-quarter" style="min-height:465px"><div class="w3-display-container w3-margin-right">
	<a href="?action=details&subaction=product&pid={$items_list[item].id}{if $SID}&{$SID}{/if}"><img src="content/images/{$items_list[item].image}" alt="{$items_list[item].title}" title="{$items_list[item].title}" id="opt_{$items_list[item].id}" class="w3-round w3-hover-opacity" style="width:100%;"></a>
	{if $items_list[item].status==4}<span class="w3-tag w3-display-topleft w3-pink w3-small">{#LB_special#}</span>{/if}
	{if $items_list[item].status==3}<span class="w3-tag w3-display-topleft w3-yellow w3-small">{#LB_new#}</span>{/if}
	<p class="w3-small" style="margin-top:5px"><a href="?action=details&subaction=product&pid={$items_list[item].id}{if $SID}&{$SID}{/if}" style="text-decoration:none">{$items_list[item].title|truncate:55}</a><br><b>{$items_list[item].currency} {$items_list[item].price_min_str}</b></p>
	</div></div>
{sectionelse}
{#LB_empty#}
{/section}
{/strip}
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
	<input name="subaction" type="hidden" value="products">
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
	target_obj.subaction.value='products';
	target_obj.submit();
}
</script>
{/literal}
<!-- pager -->
</div>
