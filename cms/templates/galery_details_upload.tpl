<!-- COPYRIGHTS Another CMS      -->
{literal}
<script>
function loading() {
toggle('form_details', 0);
toggle('upload_bar', 1);
}
function saveAndClose() {
loading();
document.forms['form_details'].elements['subaction'].value = 'upload_close';
document.forms['form_details'].submit();
}
</script>
{/literal}

{strip}
<form id="form_details" name="form_details" enctype="multipart/form-data" method="post" action="#" onsubmit="loading()" style="display:block;">

<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id|default:0 > 0)}
<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
</div>

<h3>{#LB_upload#}</h3>

<!-- details -->
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_media#} jpg, png, gif, ogg, mp3, m4a, webm, mp4, mov <span class="w3-text-red">*</span>:</label>
<input type="file" name="file[]" id="file" size="40" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" accept="audio/*, video/*, image/*" multiple required>
<label>{#LB_description#}:</label>
<input name="alttext" id="alttext" type="text" value="{$details.alttext|default:''}" size="45" maxlength="128" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
</div>
<div class="w3-half w3-margin-bottom">
<label>{#LB_webPage#}:</label><br>
<select name="menu_id" id="menu_id" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<option value="0">---</option>
{section name=customer loop=$search_list}
	<option value="{$search_list[customer].id}"{if $details.menu_id eq $search_list[customer].id} selected="selected"{/if}>
	{'&nbsp;'|indent:$search_list[customer].level:'- '} {$search_list[customer].title}
	</option>
{/section}
</select><br>
<label>{#LB_resize#}:</label><br>
<select name="width" id="width" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
{section name=customer loop=$prop_list}
	<option value="{$prop_list[customer].id}"{if $details.width|default:0 eq $prop_list[customer].id or $details.height|default:0 eq $prop_list[customer].id} selected="selected"{/if}>{$prop_list[customer].title}</option>
{/section}
</select>
</div>
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_priority#}:</label><br>
<input name="priority" id="priority" type="text" value="{$details.priority|default:1}" size="4" maxlength="4" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_who#}:</label>
<input name="meta_who" id="meta_who" type="text" value="{$details.meta_who|default:''}" size="45" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_where#}:</label>
<input name="meta_where" id="meta_where" type="text" value="{$details.meta_where|default:''}" size="45" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
</div>
<label>{#LB_status#}:</label> &nbsp;
{section name=status_counter loop=$status_list}
	<label{if $details.status == $status_list[status_counter].id}{if $details.status<2} style="background-color:#FFDFDF"{elseif $details.status==2} style="background-color:#DFFFDF"{else} style="background-color:#FFFF00"{/if}{/if}><input value="{$status_list[status_counter].id}"{if $details.status == $status_list[status_counter].id} checked="checked"{/if} type="radio" name="status" class="w3-radio">
	&nbsp;{$status_list[status_counter].title}</label>&nbsp; &nbsp;
{/section}
<input name="action" id="action" type="hidden" value="create">
<input name="subaction" id="subaction" type="hidden" value="upload">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="rotation" id="rotation" type="hidden" value="0">
<input name="crop" id="crop" type="hidden" value="0">
<input name="modifytime" id="modifytime" type="hidden" value="{$details.modifytime|default:0}">
<input name="createnick" id="createnick" type="hidden" value="{$user_info.nick}">

<div class="w3-clear w3-small">&nbsp;</div>

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

