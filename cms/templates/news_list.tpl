<!-- COPYRIGHTS Another CMS -->
{literal}
<script>
function oDel(uid) {
oCnfr('delete','news',uid,'{/literal}{#LB_delete#}{literal} #'+uid+'?');
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
	<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','news')" value="{#LB_newMessage#}">
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
<th class="w3-hide-small">{#LB_webPage#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_validTo#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_modified#}</th>
<th class="w3-center w3-hide-small">{#LB_prio#}</th>
<th class="w3-center">{#LB_status#}</th>
<th class="w3-center">{#LB_delete#}</th>
</tr>
{section name=item loop=$news_list}
	<tr>
	<td>{$news_list[item].id}{if $news_list[item].status == 2} *{/if}</td>
	<td><a href="javascript:rScr('details','news&amp;details_id={$news_list[item].id}');" style="text-decoration:none"{if $news_list[item].status < 2} class="w3-text-dark-grey"{/if}><span class="i20s_ed"></span>
	{$news_list[item].title}</a>
	</td>
	<td class="w3-hide-small">
	{if $news_list[item].menu_id > 0}
		{section name=category loop=$search_list}
		{if $news_list[item].menu_id eq $search_list[category].id}
		{$search_list[category].title}
		{/if}
		{/section}
	{else}--{/if}
	</td>
       	<td class="w3-hide-small w3-hide-medium">{if $news_list[item].validetime}{$news_list[item].validetime|date_format:"%d.%m.%Y"}{else}--{/if}</td>
	<td class="w3-hide-small w3-hide-medium">{if $news_list[item].modifytime}{$news_list[item].modifytime|date_format:"%d.%m.%Y %H:%M"}{else}--{/if}</td>
	<td class="w3-hide-small" style="text-align:center; text-align:-webkit-center; text-align:-moz-center;">{$news_list[item].priority}</td>
	<td style="text-align:center; text-align:-webkit-center; text-align:-moz-center;">
	{if $news_list[item].status == 4}
	<span class="i20s_cont" title="{#LB_history#}"></span>
	{elseif $news_list[item].status == 3}
	<span class="i20s_act" title="{#LB_active#}"></span>
	{elseif $news_list[item].status == 2}
	<span class="i20s_new" title="{#LB_new#}"></span>
	{elseif $news_list[item].status == 1}
	<span class="i20s_inact" title="{#LB_inactive#}"></span>
	{else}
	<span class="i20s_new0" title="{#LB_inactive#}"></span>
	{/if}
	</td>
	<td style="text-align:center; text-align:-webkit-center; text-align:-moz-center;">
	{if $entry_info.entry_attr > 2}
		<a href="javascript:oDel('{$news_list[item].id}');" class="i20s_del" title="{#LB_delete#}"></a>
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
	<input name="sort" type="hidden" value="{$details_search.sort|default:'0'}">
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
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','news')" value="{#LB_newMessage#}">
{/if}
</div>
<hr class="w3-light-grey">
{/strip}

