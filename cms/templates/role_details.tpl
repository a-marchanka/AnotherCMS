<!-- COPYRIGHTS ©Another CMS -->
{literal}
<script>
function saveAndClose() {
document.forms['form_details'].elements['subaction'].value = 'save_close_role';
document.forms['form_details'].submit();
}
</script>
{/literal}

<form id="form_details" name="form_details" method="post" action="#">

<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id|default:0 > 0)}
<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
</div>

<h3>{#LB_details#}</h3>

<!-- details -->
<label>{#LB_name#} <span class="w3-text-red">*</span>:</label>
<input name="role" id="role" type="text" value="{$details.role|default:''}" size="45" maxlength="32" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_description#}:</label>
<input name="descr" id="descr" type="text" value="{$details.descr|default:''}" size="45" maxlength="255" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">

<!-- list -->
{if $entry_list}
<h3>{#LB_manage#}</h3>
<table class="w3-table w3-bordered w3-striped">
<tr>
<th>{#LB_title#}</th>
<th class="w3-center">{#LB_off#}</th>
<th class="w3-center">{#LB_preview#}</th>
<th class="w3-center">{#LB_edit#}</th>
<th class="w3-center">{#LB_create#}</th>
<th class="w3-hide-small">{#LB_path#}</th>
</tr>
{section name=custom loop=$entry_list}
	<tr>
	<td><div class="{$entry_list[custom].entry_icon}{if $entry_list[custom].entry_level eq 2} w3-margin-left-8{/if}{if $entry_list[custom].entry_level eq 3} w3-margin-left{/if}">&nbsp;</div>&nbsp; {$entry_list[custom].entry_title}</td>
	<td class="w3-center"><input type="radio" name="dr{$entry_list[custom].dtree_role_id}" value="0"{if $entry_list[custom].entry_attr eq 0} checked{/if} class="w3-radio"></td>
	<td class="w3-center"><input type="radio" name="dr{$entry_list[custom].dtree_role_id}" value="1"{if $entry_list[custom].entry_attr eq 1} checked{/if} class="w3-radio"></td>
	<td class="w3-center"><input type="radio" name="dr{$entry_list[custom].dtree_role_id}" value="2"{if $entry_list[custom].entry_attr eq 2} checked{/if} class="w3-radio"></td>
	<td class="w3-center"><input type="radio" name="dr{$entry_list[custom].dtree_role_id}" value="3"{if $entry_list[custom].entry_attr eq 3} checked{/if} class="w3-radio"></td>
	<td class="w3-hide-small">{$entry_list[custom].entry_path}</td>
	</tr>
{/section}
</table>
{/if}
<br>
<input name="dtree_cnt" id="dtree_cnt" type="hidden" value="{$smarty.section.custom.total}">
<input name="action" id="action" type="hidden" value="{if $details.id|default:0}edit{else}create{/if}">
<input name="subaction" id="subaction" type="hidden" value="role">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="details_id" id="details_id" type="hidden" value="{$details.id|default:0}">

<!-- buttons -->
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id|default:0 > 0)}
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
<!-- buttons -->

</form>
<hr class="w3-light-grey">

