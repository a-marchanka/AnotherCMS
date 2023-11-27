<div class="w3-display-container w3-padding">
    <h1 class="w3-text-blue-grey">{$entry_title}</h1>

<form id="form_details" name="form_details" method="post" action="#" class="w3-margin-bottom">
<div class="w3-row-padding">
<div style="float:left; max-width:220px;">
	<input name="filter" id="filter" maxlength="128" onkeyup="filterObj.set(this.value)" value="{$details_search.filter|default:''}" class="w3-input w3-margin-bottom-8">
</div>
<div style="float:left; min-width:200px; max-width:400px;">
	<input name="go" id="go" type="submit" value="{#LB_search#}" class="w3-button w3-grey w3-margin-bottom">
</div>
</div>
<input name="action" id="action" type="hidden" value="list">
<input name="subaction" id="subaction" type="hidden" value="search">
<input name="m" value="{$entry_name}" type="hidden">
<input name="sid" value="{$sid}" type="hidden">
</form>

{section name=item loop=$items_list}
      <h4><a href="javascript:toggle('news{$items_list[item].id}',-1);">{$items_list[item].title}</a></h4>
	<div id="news{$items_list[item].id}" style="display:none;" class="w3-container w3-border-bottom">
	{$items_list[item].message}
	</div>
{sectionelse}
...
{/section}

<!-- pager -->
{if $pager_list.pages > 1}
<div class="w3-container w3-theme w3-medium w3-center">
<form name="form_pager_header" id="form_pager_header" method="post" action="#">
	{if $pager_list.page ne 1}
		<a href="javascript:pagerGo('form_pager_header','first');" class="w3-bar-item w3-button w3-padding-16">{#LB_first#}</a>
	{else}
		<span class="w3-bar-item w3-button w3-disabled w3-padding-16">{#LB_first#}</span>
	{/if}
	{if $pager_list.page ne 1}
		<a href="javascript:pagerGo('form_pager_header','prev');" class="w3-bar-item w3-button w3-padding-16">{#LB_prev#}</a>
	{else}
		<span class="w3-bar-item w3-button w3-disabled w3-padding-16">{#LB_prev#}</span>
	{/if}
	<span class="w3-bar-item w3-padding-16">{#LB_page#}:</span>
	<select name="page" id="page" onchange="pagerGo('form_pager_header','search');">
	{section name=itemer loop=$pager_list.pages}
		<option value="{$smarty.section.itemer.iteration}"{if $pager_list.page eq $smarty.section.itemer.iteration} selected{/if}>
		{$smarty.section.itemer.iteration}
		</option>
	{/section}
	</select>&nbsp;/&nbsp;{$pager_list.pages}
	<input name="action" type="hidden" value="list" />
	<input name="subaction" type="hidden" value="search" />
	<input name="m" value="{$entry_name}" type="hidden" />
	<input name="sid" value="{$sid}" type="hidden" />
	{if $pager_list.page ne $pager_list.pages}
		<a href="javascript:pagerGo('form_pager_header','next');" class="w3-bar-item w3-button w3-padding-16">{#LB_next#}</a>
	{else}
		<span class="w3-bar-item w3-button w3-disabled w3-padding-16">{#LB_next#}</span>
	{/if}
	{if $pager_list.page ne $pager_list.pages}
		<a href="javascript:pagerGo('form_pager_header','last');" class="w3-bar-item w3-button w3-padding-16">{#LB_last#}</a>
	{else}
		<span class="w3-bar-item w3-button w3-disabled w3-padding-16">{#LB_last#}</span>
	{/if}
        </span>
</form>
</div>
{/if}
<!-- pager -->
</div>
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
	target_obj.subaction.value='search';
	target_obj.submit();
}
</script>
{/literal}
