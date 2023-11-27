<!-- COPYRIGHTS ©Another CMS -->
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

<form id="form_details" name="form_details" enctype="multipart/form-data" method="post" action="#" onsubmit="loading()" style="display:block;">

<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id > 0)}
<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="rScr('list&amp;dir={$details.dir}','')" value="{#LB_close#}">
</div>

<h3>{#LB_upload#}</h3>

<!-- details -->
<label>{#LB_file#} <span class="w3-text-red">*</span>:</label>
<input type="file" name="file[]" id="file" size="40" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" multiple required>
<label>{#LB_path#}:</label>
{if $entry_info.entry_attr > 2}
<input name="dir" id="dir" type="text" value="{$details.dir}" size="45" maxlength="128" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" placeholder="content/">
{else}
/{$details.dir}
<input name="dir" id="dir" type="hidden" value="{$details.dir}">
{/if}
<label>{#LB_replace#}:</label>
<input name="replace" id="replace" type="checkbox" value="1" class="w3-check">

<input name="action" id="action" type="hidden" value="create">
<input name="subaction" id="subaction" type="hidden" value="upload">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="attr" id="attr" type="hidden" value="{$details.attr|default:'0664'}">

<div class="w3-clear w3-small">&nbsp;</div>

<!-- buttons -->
{if $entry_info.entry_attr > 2}
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="rScr('list&amp;dir={$details.dir}','')" value="{#LB_close#}">
<!-- buttons -->

</form>

<div id="upload_bar" style="display:none;">
<img src="../images/loading.gif" width="32" height="32" alt="{#LB_loading#}" style="padding:20px;">
</div>

<hr class="w3-light-grey">

<script>toggle('upload_bar', 0);</script>

