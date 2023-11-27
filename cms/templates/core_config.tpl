<!-- COPYRIGHTS ©Another CMS -->
{literal}
<script>
function toggleTabs(objId) {
var active_obj = document.getElementById('subaction');
var current = active_obj.value;
active_obj.value = objId;
toggle('tab_'+current, 0);
toggle('tab_'+objId, 1);
}
</script>
{/literal}

{strip}
<!-- filter -->
<form id="config_form" method="post" action="#">
<a id="{#LB_content#}"></a>
<div class="w3-row">
	{assign var="tmp_details_id" value='1'}
	<input class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-light-grey" type="button" onclick="toggleTabs('0');" value="{#LB_global#}">
	{section name=customer loop=$cfg_list}
	{if $cfg_list[customer].dtree_id != $tmp_details_id}
	{assign var="tmp_details_id" value=$cfg_list[customer].dtree_id}
	<input class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-light-grey" type="button" onclick="toggleTabs('{$smarty.section.customer.iteration}');" value="{$cfg_list[customer].title}">
	{/if}
	{/section}
	{assign var="tmp_details_id" value='1'}
	{if $entry_info.entry_attr > 2}
	&nbsp; <input class="w3-button w3-hide-small w3-hide-medium w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
	{/if}
</div>
<!-- filter -->

{assign var="col_cnt" value=2}
{section name=customer loop=$cfg_list}
	{if $smarty.section.customer.iteration == 1}
		<div id="tab_0" style="display:none;">
		<h3>{#LB_global#}</h3>
	{/if}
	{if $cfg_list[customer].dtree_id != $tmp_details_id}
		</div>
		<div id="tab_{$smarty.section.customer.iteration}" style="display:none;">
		{assign var="tmp_details_id" value=$cfg_list[customer].dtree_id}
		<a id="n{$cfg_list[customer].id}"></a>
		<h3>{$cfg_list[customer].title}</h3>
	{/if}
	<div class="w3-half w3-margin-bottom-8">
	<label>{$cfg_list[customer].description}:</label>
	<input name="cfg_{$cfg_list[customer].id}" type="text" value="{$cfg_list[customer].value}" size="45" maxlength="255" class="w3-input w3-border w3-round" style="max-width:430px;" placeholder="{$cfg_list[customer].tip}">
	</div>
{/section}
		</div>
	<div class="w3-clear w3-tiny">&nbsp;</div>
	<input name="action" id="action" type="hidden" value="edit">
	<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
	<input name="subaction" id="subaction" type="hidden" value="{$subaction|default:0}">

	<!-- save -->
	{if $entry_info.entry_attr > 2}
	<input class="w3-button w3-margin-top-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
	{/if}
</form>
<hr class="w3-light-grey">
{/strip}

{literal}
<script>
var active_obj = document.getElementById('subaction');
var current = active_obj.value;
toggle('tab_'+current, 1);
</script>
{/literal}
