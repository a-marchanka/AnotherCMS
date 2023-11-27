<!-- COPYRIGHTS Another CMS      -->
{literal}
<script>
function oDel(uid, fn) {
oCnfr('delete','media',uid,'{/literal}{#LB_delete#}{literal} '+fn+'?');
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
	<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','upload')" value="{#LB_upload#}">
	{/if}
	</div>
</div>
<div class="w3-row w3-margin-bottom-8">
<input onchange="this.form.submit()" value="long" type="radio" name="viewer" id="long"{if $details_search.viewer eq 'long'} checked="checked"{/if} class="w3-radio"> {#LB_table#} &nbsp; &nbsp;
<input onchange="this.form.submit()" value="short" type="radio" name="viewer" id="short"{if $details_search.viewer eq 'short' or !$details_search.viewer} checked="checked"{/if} class="w3-radio"> {#LB_image#}
</div>
	<input name="action" type="hidden" id="action" value="list">
	<input name="subaction" type="hidden" id="subaction" value="search">
</form>
<!-- filter -->

{if $details_search.viewer|default:'short' eq 'long'}
<table class="w3-table w3-bordered w3-striped">
<tr>
<th class="w3-hide-large">{#LB_id#}</th>
<th>{#LB_image#}</th>
<th>{#LB_name#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_webPage#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_description#}</th>
<th>{#LB_size#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_date#}</th>
<th class="w3-center w3-hide-small">{#LB_prio#}</th>
<th class="w3-center">{#LB_status#}</th>
<th class="w3-center">{#LB_delete#}</th>
</tr>
{section name=item loop=$galery_list}
	<tr>
	<td class="w3-hide-large">{$galery_list[item].id}</td>
	<td>
	{if $galery_list[item].filepath eq $user_img}
		<a class="lytebox" data-lyte-options="group:gal" data-title="{$galery_list[item].alttext} {$galery_list[item].meta_who} {$galery_list[item].meta_where}" href="../{$galery_list[item].filepath}{$galery_list[item].filename}">
		<img src="../{$galery_list[item].filepath}thumbs/{$galery_list[item].filename}" alt="{$galery_list[item].filename}" title="{$galery_list[item].filename}" width="44" height="44"></a>
	{/if}
	{if $galery_list[item].filepath eq $user_vid}
		<a class="lytebox" data-lyte-options="group:gal" data-title="{$galery_list[item].alttext} {$galery_list[item].meta_who} {$galery_list[item].meta_where}" href="../{$galery_list[item].filepath}{$galery_list[item].filename}">
		<img src="../{$galery_list[item].filepath}default_video.png" alt="{$galery_list[item].filename}" title="{$galery_list[item].filename}" width="44" height="44"></a>
	{/if}
	{if $galery_list[item].filepath eq $user_aud}
		<a class="lytebox" data-lyte-options="group:gal" data-title="{$galery_list[item].alttext} {$galery_list[item].meta_who} {$galery_list[item].meta_where}" href="../{$galery_list[item].filepath}{$galery_list[item].filename}">
		<img src="../{$galery_list[item].filepath}default_audio.png" alt="{$galery_list[item].filename}" title="{$galery_list[item].filename}" width="44" height="44"></a>
	{/if}
	</td>
	<td>
	{if $entry_info.entry_attr > 2}
		<a href="javascript:rScr('details','media&amp;details_id={$galery_list[item].id}');" title="{#LB_change#}" style="text-decoration:none"{if $galery_list[item].status < 2} class="w3-text-dark-grey"{/if}><span class="i20s_ed"></span><span class="w3-hide-small">{$galery_list[item].filename|truncate:30}</span></a><br>
	{else}
		<span class="w3-hide-small">{$galery_list[item].filename|truncate:30}</span>
	{/if}
	</td>
	<td class="w3-hide-small w3-hide-medium">
	{if $galery_list[item].menu_id > 0}
	{section name=cat loop=$search_list}
		{if $galery_list[item].menu_id eq $search_list[cat].id}{$search_list[cat].title}
		{/if}
	{/section}
	{else} --- {/if}
	</td>
	<td class="w3-hide-small w3-hide-medium">{$galery_list[item].alttext}</td>
	<td>{$galery_list[item].width}x{$galery_list[item].height}</td>
	<td class="w3-hide-small w3-hide-medium">{$galery_list[item].shoottime|date_format:"%d.%m.%Y"}</td>
	<td class="w3-hide-small" style="text-align:center; text-align:-webkit-center; text-align:-moz-center;">{$galery_list[item].priority}</td>
	<td style="text-align:center; text-align:-webkit-center; text-align:-moz-center;">
	{if $galery_list[item].status eq 3}
		<span class="i20s_new" title="{#LB_new#}"></span>
	{elseif $galery_list[item].status eq 2}
		<span class="i20s_act" title="{#LB_active#}"></span>
	{elseif $galery_list[item].status eq 1}
		<span class="i20s_inact" title="{#LB_inactive#}"></span>
	{else}
		<span class="i20s_new0"></span>
	{/if}
	</td>
	<td style="text-align:center; text-align:-webkit-center; text-align:-moz-center;">
	{if $entry_info.entry_attr > 2}
		<a href="javascript:oDel('{$galery_list[item].id}','{$galery_list[item].filename}');" class="i20s_del" title="{#LB_delete#}"></a>
	{else}
		<span class="i20s_del0"></span>
	{/if}
	</td>
	</tr>
{/section}
</table>
{else}
{section name=item loop=$galery_list}
<div class="w3-left" style="width:180px;">
	<div class="w3-margin-top w3-margin-bottom-8">{if $galery_list[item].priority > 0}{$galery_list[item].priority}. {/if}
	{$galery_list[item].filename|truncate:20}</div>
	<div class="w3-left w3-margin-right">
	{if $galery_list[item].filepath eq $user_img}
		<a class="lytebox" data-lyte-options="group:gal" data-title="{$galery_list[item].alttext} {$galery_list[item].meta_who} {$galery_list[item].meta_where}" href="../{$galery_list[item].filepath}{$galery_list[item].filename}">
		<img src="../{$galery_list[item].filepath}thumbs/{$galery_list[item].filename}" alt="{$galery_list[item].alttext}" title="{$galery_list[item].meta_where}" width="95" height="95" class="w3-card-2"></a>
	{/if}
	{if $galery_list[item].filepath eq $user_vid}
		<a class="lytebox" data-lyte-options="group:gal" data-title="{$galery_list[item].alttext} {$galery_list[item].meta_who} {$galery_list[item].meta_where}" href="../{$galery_list[item].filepath}{$galery_list[item].filename}">
		<img src="../{$galery_list[item].filepath}default_video.png" alt="{$galery_list[item].alttext}" title="{$galery_list[item].alttext}" width="95" height="95" class="w3-card-2"></a>
	{/if}
	{if $galery_list[item].filepath eq $user_aud}
		<a class="lytebox" data-lyte-options="group:gal" data-title="{$galery_list[item].alttext} {$galery_list[item].meta_who} {$galery_list[item].meta_where}" href="../{$galery_list[item].filepath}{$galery_list[item].filename}">
		<img src="../{$galery_list[item].filepath}default_audio.png" alt="{$galery_list[item].alttext}" title="{$galery_list[item].alttext}" width="95" height="95" class="w3-card-2"></a>
	{/if}
	</div>
	<div class="w3-left w3-margin-right">
	{if $entry_info.entry_attr > 2}
		<a href="javascript:rScr('details','media&amp;details_id={$galery_list[item].id}');" class="i20s_ed1" title="{#LB_change#}"></a>
	{/if}
	<span class="i20s_warn1" onmouseover="toggle('opt_{$galery_list[item].id}',-1)" onmouseout="toggle('opt_{$galery_list[item].id}',-1)" style="margin:5px 0;"></span>
	<div id="opt_{$galery_list[item].id}" class="opt200 w3-small" style="display:none;">
		ID: {$galery_list[item].id} &nbsp;{#LB_user#}: {$galery_list[item].createnick}<br>{$galery_list[item].width}x{$galery_list[item].height}<br>{$galery_list[item].shoottime|date_format:"%d.%m.%Y"}
		{if $galery_list[item].alttext}<br>{#LB_description#}: {$galery_list[item].alttext}{/if}
		{if $galery_list[item].meta_who}<br>{#LB_who#}: {$galery_list[item].meta_who}{/if}
		{if $galery_list[item].meta_where}<br>{#LB_where#}: {$galery_list[item].meta_where}{/if}
	</div>
	<div style="margin:5px 0;">
	{if $galery_list[item].status eq 3}
		<span class="i20s_new" title="{#LB_new#}"></span>
	{elseif $galery_list[item].status eq 2}
		<span class="i20s_act" title="{#LB_active#}"></span>
	{elseif $galery_list[item].status eq 1}
		<span class="i20s_inact" title="{#LB_inactive#}"></span>
	{else}
		<span class="i20s_new0"></span>
	{/if}
	</div>
	<div style="margin:5px 0;">
	{if $entry_info.entry_attr > 2}
		<a href="javascript:oDel('{$galery_list[item].id}','{$galery_list[item].filename}');" class="i20s_del" title="{#LB_delete#}"></a>
	{else}
		<span class="i20s_del0"></span>
	{/if}
	</div>
	</div>
</div>
{/section}
{/if}

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
	<input name="viewer" type="hidden" value="{$details_search.viewer|default:'short'}">
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
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','upload')" value="{#LB_upload#}">
{/if}
</div>
<hr class="w3-light-grey">
{/strip}

