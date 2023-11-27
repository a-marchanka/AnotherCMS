<!-- COPYRIGHTS Another CMS      -->
{literal}
<script>
function oDel(uid) {
oCnfr('delete','item',uid,'{/literal}{#LB_delete#}{literal} #'+uid+'?');
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
	{section name=item loop=$menu_list}
	<option value="{$menu_list[item].id}"{if $details_search.menu_id|default:0 eq $menu_list[item].id} selected="selected"{/if}{if $menu_list[item].content_type eq 'folder'} style="font-weight:bold"{/if}>
	{$menu_list[item].title}</option>
	{/section}
	</select>
	</div>
	<div class="w3-margin-right w3-left">
	<label>{#LB_sort#}:</label><select name="sort" onchange="this.form.submit()" class="w3-select w3-border w3-round w3-margin-bottom-8">
	<option value="0">---</option>
	{section name=item loop=$sort_list}
	<option value="{$sort_list[item].id}"{if $details_search.sort|default:'0' eq $sort_list[item].id} selected{/if}>{$sort_list[item].title}</option>
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
	<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','item')" value="{#LB_newJob#}">
	<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oModul('131','list')" value="{#LB_emails#}">
	{/if}
	</div>
</div>
	<input name="action" type="hidden" id="action" value="list">
	<input name="subaction" type="hidden" id="subaction" value="search">
</form>
<!-- filter -->
<table class="w3-table w3-bordered w3-striped">
<tr>
<th class="w3-hide-small">{#LB_webPage#}</th>
<th>{#LB_title#}</th>
<th>{#LB_emails#}</th>
<th>{#LB_status#} {#LB_done#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_status#} {#LB_new#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_modified#}</th>
<th class="w3-center">{#LB_delete#}</th>
</tr>
{section name=item loop=$items_list}
	<tr>
	<td class="w3-hide-small">
	{if $items_list[item].menu_id > 0}
		{section name=category loop=$menu_list}
		{if $items_list[item].menu_id eq $menu_list[category].id}
		{$menu_list[category].title}
		{/if}
		{/section}
	{else}--{/if}
	</td>
	<td><a href="javascript:rScr('details','item&amp;details_id={$items_list[item].id}');" style="text-decoration:none"><span class="i20s_ed"></span>
	{$items_list[item].title|default:'n/a'}</a>
	</td>
	<td>{$items_list[item].email_cnt}</td>
	<td>{$items_list[item].status2_cnt}</td>
	<td class="w3-hide-small w3-hide-medium">{$items_list[item].status1_cnt}</td>
	<td class="w3-hide-small w3-hide-medium">{$items_list[item].modifytime|date_format:"%d.%m.%Y %H:%M"}</td>
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

{if $pager_list.pages > 1}
<!-- pager -->
<form name="form_pager_header" id="form_pager_header" method="post" action="#" class="w3-clear">
<div class="w3-row w3-margin-top">
	{if $pager_list.page ne 1}
		<a href="javascript:pagerGo('form_pager_header','first');" style="padding-left:10px; color:#367e9c;">{#LB_first#}</a>
	{else}
		<span style="padding-left:10px; color:#ccc;">{#LB_first#}</span>
	{/if}
	{if $pager_list.page ne 1}
		<a href="javascript:pagerGo('form_pager_header','prev');" style="padding-left:10px; color:#367e9c;">{#LB_prev#}</a>
	{else}
		<span style="padding-left:10px; color:#ccc;">{#LB_prev#}</span>
	{/if}
	<span style="padding-left:10px;">{#LB_page#}:&nbsp;</span>
	<select name="page" id="page" onchange="pagerGo('form_pager_header','search');" class="w3-select w3-border w3-round" style="width:auto;">
	{section name=item loop=$pager_list.pages}
		<option value="{$smarty.section.item.iteration}"{if $pager_list.page eq $smarty.section.item.iteration} selected{/if}>
		{$smarty.section.item.iteration}
		</option>
	{/section}
	</select>:&nbsp;{$pager_list.pages}
	<input name="sort" type="hidden" value="{$details_search.sort|default:'0'}">
	<input name="filter" type="hidden" value="{$details_search.filter|default:''}">
	<input name="action" type="hidden" value="list">
	<input name="subaction" type="hidden" value="search">
	{if $pager_list.page ne $pager_list.pages}
		<a href="javascript:pagerGo('form_pager_header','next');" style="padding-left:10px; color:#367e9c;">{#LB_next#}</a>
	{else}
		<span style="padding-left:10px; color:#ccc;">{#LB_next#}</span>
	{/if}
	{if $pager_list.page ne $pager_list.pages}
		<a href="javascript:pagerGo('form_pager_header','last');" style="padding-left:10px; color:#367e9c;">{#LB_last#}</a>
	{else}
		<span style="padding-left:10px; color:#ccc;">{#LB_last#}</span>
	{/if}
</div>
</form>
<!-- pager -->
{/if}

<!-- buttons -->
<div class="w3-row">
{if $entry_info.entry_attr > 2} &nbsp;<br>
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','item')" value="{#LB_newJob#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="oModul('131','list')" value="{#LB_emails#}">
{/if}
</div>
<hr class="w3-light-grey">
{/strip}

