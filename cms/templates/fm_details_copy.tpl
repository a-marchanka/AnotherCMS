<!-- COPYRIGHTS ©Another CMS -->
{literal}
<script>
function saveAndClose() {
document.forms['form_details'].elements['subaction'].value = 'copy_close';
document.forms['form_details'].submit();
}
</script>
{/literal}

<form id="form_details" name="form_details" method="post" action="#" style="margin:0;padding:0;">

<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id > 0)}
<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list&amp;dir={$details.dir}','')" value="{#LB_close#}">
</div>

<h3>{#LB_copy#}</h3>

<!-- details -->
<div class="w3-half">
<label>{#LB_path#} <span class="w3-text-red">*</span>:</label>
<input name="dir_new" id="dir_new" type="text" value="{$details.dir_new}" size="45" maxlength="128" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
</div>
<div class="w3-half">
<label>{#LB_file#} <span class="w3-text-red">*</span>: {if $details.ext}<b>{$details.ext}</b>{/if}</label>
<input name="name_new" id="name_new" type="text" value="{$details.name_new}" size="45" maxlength="128" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<input name="ext" id="ext" type="hidden" value="{$details.ext}">
</div>
<input name="action" id="action" type="hidden" value="{if $details.name}edit{else}create{/if}">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="subaction" id="subaction" type="hidden" value="copy">
<input name="dir" id="dir" type="hidden" value="{$details.dir}">
<input name="name" id="name" type="hidden" value="{$details.name}">
<input name="attr" id="attr" type="hidden" value="{$details.attr}">

<div class="w3-clear w3-small">&nbsp;</div>

<!-- buttons -->
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id > 0)}
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list&amp;dir={$details.dir}','')" value="{#LB_close#}">
<!-- buttons -->

</form>
<hr class="w3-light-grey">

