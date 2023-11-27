<!-- COPYRIGHTS Another CMS      -->
{literal}
<script>
function loading() {
toggle('form_details', 0);
toggle('upload_bar', 1);
}
function saveAndClose() {
loading();
document.forms['form_details'].elements['subaction'].value = 'save_close';
document.forms['form_details'].submit();
}
</script>
{/literal}

<form id="form_details" name="form_details" method="post" action="#" onsubmit="loading()" style="display:block;">

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
<input name="name" id="name" type="text" value="{$details.name|default:$user_info.nick}" size="45" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<label>{#LB_email#}:</label>
<input name="email" id="email" type="text" value="{$details.email|default:''}" size="45" maxlength="128" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_webPage#}:</label><br>
<select name="menu_id" id="menu_id" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<option value="0">---</option>
{section name=custom loop=$search_list}
	<option value="{$search_list[custom].id}"{if $details.menu_id|default:0 eq $search_list[custom].id} selected="selected"{/if}>
	{'&nbsp;'|indent:$search_list[custom].level:'- '} {$search_list[custom].title}
	</option>
{/section}
</select><br>
<label>{#LB_message#}:</label>
<textarea name="message" rows="12" class="w3-input w3-border w3-round w3-margin-bottom-8" style="width:97%;height:300px;background-color:#F9F9F9;">{$details.message|default:''}</textarea>
<label>{#LB_lang#}:</label>
<input name="ui_lang" id="ui_lang" type="text" value="{$details.ui_lang|default:$ui_lang}" size="6" maxlength="6" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:100px;">
<label>{#LB_status#}:</label> &nbsp; 
{section name=status_counter loop=$status_list}
	<label{if $details.status|default:0 == $status_list[status_counter].id}{if $details.status<2} style="background-color:#FFDFDF"{elseif $details.status==2} style="background-color:#DFFFDF"{else} style="background-color:#FFFF00"{/if}{/if}><input value="{$status_list[status_counter].id}"{if $details.status|default:0 == $status_list[status_counter].id} checked="checked"{/if} type="radio" name="status" class="w3-radio">
	{$status_list[status_counter].title}</label> &nbsp;
{/section}
<p>
{#LB_attributes#}: {$details.ip|default:'empty'}<br>
{#LB_webClient#}: {$details.agent|default:'--'}<br>
{#LB_modified#}: {$details.modifytime|date_format:"%d.%m.%Y %H:%M:%S"|default:'--'}<br>
{#LB_user#}: {$details.createnick|default:$user_info.nick}
<input name="ip" id="ip" type="hidden" value="{$details.ip|default:'empty'}">
<input name="agent" id="agent" type="hidden" value="{$details.agent|default:'--'}">
</p>

<input name="action" id="action" type="hidden" value="{if $details.id|default:0}edit{else}create{/if}">
<input name="subaction" id="subaction" type="hidden" value="guestbook">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="details_id" id="details_id" type="hidden" value="{$details.id|default:0}">
<input name="modifytime" id="modifytime" type="hidden" value="{$details.modifytime|default:0}">
<input name="createnick" id="createnick" type="hidden" value="{if $details.id|default:0}{$details.createnick}{else}{$user_info.nick}{/if}">

<!-- buttons -->
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id|default:0 > 0)}
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
<!-- buttons -->

</form>

<div id="upload_bar" style="display:none;">
<img src="../images/loading.gif" width="32" height="32" alt="{#LB_loading#}" style="padding:20px;">
</div>

<hr class="w3-light-grey">
{/strip}

<script>toggle('upload_bar', 0);</script>

