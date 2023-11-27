<!-- COPYRIGHTS ©CMS PHP TEAM -->
{literal}
<script>
function oDel(uid, fn) {
oCnfr('delete','menu',uid,'{/literal}{#LB_delete#}{literal} '+fn+'?');
}
</script>
{/literal}

{strip}
<!-- filter -->
<form id="form_search_header" method="post" action="#">
<div class="w3-row">
	<div class="w3-margin-right w3-left">
	<label>{#LB_webPage#}:</label>
	<select name="menu_id" onchange="this.form.submit()" class="w3-select w3-border w3-round w3-margin-bottom-8">
	<option value="0">---</option>
	{section name=custom loop=$search_list}
	<option value="{$search_list[custom].id}"{if $details_search.menu_id|default:0 eq $search_list[custom].id} selected="selected"{/if}{if $search_list[custom].content_type eq 'folder'} style="font-weight:bold"{/if}>
	{'&nbsp;'|indent:$search_list[custom].level:'- '} {$search_list[custom].title}</option>
	{/section}
	</select>
	</div>
	<div class="w3-margin-right w3-left">&nbsp;<br>
	<input class="w3-button w3-theme" type="submit" value="{#LB_go#}">
	</div>
	<!-- buttons -->
	<div class="w3-right w3-hide-small w3-hide-medium">
	{if $entry_info.entry_attr > 2} &nbsp;<br>
	<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','mceedit')" value="{#LB_newPage#}">
	<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','menu')" value="{#LB_newElement#}">
	<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','csv')" value="{#LB_csv#}">
	{/if}
	</div>
</div>
	<input name="action" type="hidden" id="action" value="list">
	<input name="subaction" type="hidden" id="subaction" value="search">
</form>
<!-- filter -->

<!-- list -->
<table class="w3-table w3-bordered w3-striped">
<tr>
<th>{#LB_title#}</th>
<th>{#LB_content#}</th>
<th class="w3-hide-small w3-hide-medium">{#LB_options#}</th>
<th class="w3-center w3-hide-small w3-hide-medium">{#LB_prio#}</th>
<th class="w3-center">{#LB_status#}</th>
<th class="w3-center">{#LB_delete#}</th>
</tr>
{section name=custom loop=$menu_list}
	<tr>
	<td>
	{if $entry_info.entry_attr > 0}
		<a href="javascript:rScr('details','{$menu_list[custom].content_type}&amp;details_id={$menu_list[custom].id}');"{if $menu_list[custom].content_type eq 'folder'} style="font-weight:bold;"{else} style="text-decoration:none"{/if} title="{$menu_list[custom].name}">
		<span class="i20s_{$menu_list[custom].content_type}" style="{if $menu_list[custom].level eq 1}margin-left:10px{/if}{if $menu_list[custom].level eq 2}margin-left:22px{/if}{if $menu_list[custom].level eq 3}margin-left:34px{/if}" title="{$menu_list[custom].content_type}"></span>
		{$menu_list[custom].title|truncate:50}</a>
	{else}
		{$menu_list[custom].title|truncate:50}
	{/if}
	</td>
	<td>
	{if $entry_info.entry_attr > 1 and $menu_list[custom].content_type eq 'static'}
		<a href="javascript:rScr('details','mceedit&amp;details_id={$menu_list[custom].id}');" title="{$menu_list[custom].content_htm}">
		<span class="i20s_ed"></span><span class="w3-hide-small">{$menu_list[custom].content_htm|nl2br|truncate:30}</span></a>
	{else}
		{if $menu_list[custom].content_type ne 'folder'}
		<span class="i20s_ed0"></span><span class="w3-hide-small">{$menu_list[custom].content_txt|nl2br|truncate:30}</span>
		{else}&nbsp;{/if}
	{/if}
	</td>
	<td class="w3-hide-small w3-hide-medium">
	<span class="i20s_warn" onmouseover="toggle('opt_{$menu_list[custom].id}',-1)" onmouseout="toggle('opt_{$menu_list[custom].id}',-1)"></span>
	<div id="opt_{$menu_list[custom].id}" class="opt320 w3-small" style="display:none;">
		<b>{#LB_name#}:</b> {$menu_list[custom].name|default:'--'}<br>
		<b>{#LB_description#}:</b> {$menu_list[custom].description|default:'--'}<br>
		<b>{#LB_keywords#}:</b> {$menu_list[custom].keywords|default:'--'}<br>
		<table><tr>
		<td>{$menu_list[custom].pattern_0|truncate:20|default:'--'}&nbsp;</td><td>&nbsp;{$menu_list[custom].pattern_1|truncate:20|default:'--'}</td>
		</tr><tr>
		<td>{$menu_list[custom].pattern_4|truncate:20|default:'--'}&nbsp;</td><td>&nbsp;{$menu_list[custom].pattern_2|truncate:20|default:'--'}</td>
		</tr><tr>
		<td>{$menu_list[custom].pattern_5|truncate:20|default:'--'}&nbsp;</td><td>&nbsp;{$menu_list[custom].pattern_3|truncate:20|default:'--'}</td>
		</tr>
		</table>
	</div>
	{if $entry_info.entry_attr > 2}
		<a href="javascript:rScr('details','copy&amp;details_id={$menu_list[custom].id}');" class="i20s_copy" title="{#LB_copy#}"></a>
	{/if}
	{if $menu_list[custom].role_ids}
		<span class="i20s_key" onmouseover="toggle('key_{$menu_list[custom].id}',-1)" onmouseout="toggle('key_{$menu_list[custom].id}',-1)"></span>
		<div id="key_{$menu_list[custom].id}" class="opt320" style="display:none;">
		{if $menu_list[custom].role_ids_array}
		{section name=rlist loop=$roles_list}
			{foreach name=idsa from=$menu_list[custom].role_ids_array item=r_id}
			{if $roles_list[rlist].id==$r_id}
				{$roles_list[rlist].role}
				{if !$smarty.foreach.idsa.last}, {/if}
			{/if}
			{/foreach}
		{/section}
		{else}
		--
		{/if}
		</div>
	{/if}
	</td>
	<td class="w3-center w3-hide-small w3-hide-medium">{$menu_list[custom].priority}</td>
	<td style="text-align:center; text-align:-webkit-center; text-align:-moz-center;">
	{if $menu_list[custom].active}
		<span class="i20s_act" title="{#LB_active#}"></span>
	{else}
		<span class="i20s_inact" title="{#LB_inactive#}"></span>
	{/if}
	</td>
	<td style="text-align:center; text-align:-webkit-center; text-align:-moz-center;">
	{if $entry_info.entry_attr > 2}
		<a href="javascript:oDel('{$menu_list[custom].id}','{$menu_list[custom].name}');" class="i20s_del" title="{#LB_delete#}"></a>
	{else}
		<span class="i20s_del0"></span>
	{/if}
	</td>
	</tr>
{/section}
</table>
<!-- list -->

<!-- buttons -->
<div class="w3-row">
{if $entry_info.entry_attr > 2} &nbsp;<br>
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','mceedit')" value="{#LB_newPage#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('details','menu')" value="{#LB_newElement#}">
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','csv')" value="{#LB_csv#}">
{/if}
</div>
<hr class="w3-light-grey">
{/strip}

