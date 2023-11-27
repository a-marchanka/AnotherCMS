<!-- COPYRIGHTS ©Another CMS -->
{literal}
<script>
function saveAndClose() {
document.forms['form_details'].elements['subaction'].value = 'file_close';
document.forms['form_details'].submit();
}
</script>
{/literal}

<form id="form_details" name="form_details" method="post" action="#">

<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id > 0)}
<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="rScr('list&amp;dir={$details.dir}','')" value="{#LB_close#}">
</div>

<h3>{#LB_details#}</h3>

<label>{#LB_path#}: <b>/{$details.dir}</b></label><br>
<div class="w3-half">
<label>{#LB_file#} <span class="w3-text-red">*</span>: <b>{if $details.ext}{$details.ext}{/if}</b></label>
<input name="name_new" id="name_new" type="text" value="{$details.name_new}" size="45" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<input name="ext" id="ext" type="hidden" value="{$details.ext}">
</div>
<div class="w3-half">
<label>{#LB_attributes#} <span class="w3-text-red">*</span>:</label>
<input name="attr" id="attr" type="text" value="{$details.attr|default:"0644"}" size="4" maxlength="4" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:100px;" required>
</div>
<input name="action" id="action" type="hidden" value="{if $details.name}edit{else}create{/if}">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="subaction" id="subaction" type="hidden" value="file">
<input name="dir" id="dir" type="hidden" value="{$details.dir}">
<input name="name" id="name" type="hidden" value="{$details.name}">

<div class="w3-clear w3-small">&nbsp;</div>

<!-- buttons -->
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id > 0)}
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="rScr('list&amp;dir={$details.dir}','')" value="{#LB_close#}">
<!-- buttons -->

</form>
<hr class="w3-light-grey">

