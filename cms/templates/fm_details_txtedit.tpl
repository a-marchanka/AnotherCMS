<!-- COPYRIGHTS ©Another CMS -->
{literal}
<script>
function saveAndClose() {
document.forms['txtEditor'].elements['subaction'].value = 'txtcontent_close';
document.forms['txtEditor'].submit();
}
</script>
{/literal}

<form id="txtEditor" name="txtEditor" method="post" action="#" style="margin:0;padding:0;">

<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
{if $entry_info.entry_attr > 1}
<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
{if $details.name}
<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
{/if}
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="rScr('list&amp;dir={$details.dir}','')" value="{#LB_close#}">
</div>

<h3>{#LB_details#}</h3>

<!-- details -->
{#LB_file#} <span class="w3-text-red">*</span>: <b>/{$details.dir}</b>
{if $details.name}
	<b>{$details.name_new}</b>
	<input name="name_new" id="name_new" type="hidden" value="{$details.name_new}">
{else}
	<input name="name_new" id="name_new" class="w3-input w3-border w3-round w3-margin-bottom-8" type="text" value="{$details.name_new}" size="35" maxlength="64" style="max-width:300px;" required>
{/if}
<input name="ext" id="ext" class="w3-input w3-border w3-round" type="hidden" value="{$details.ext|default:''}"><b>{$details.ext|default:''}</b>

{if $details.name}
<a class="lytebox" title="{#LB_preview#}" href="?{$SID}&amp;entry_id={$entry_id}&amp;action=details&amp;subaction=preview&amp;dir={$details.dir}&amp;name={$details.name}&amp;ext={$details.ext}">
<div class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-margin-left-8 w3-light-grey w3-round">{#LB_preview#}</div></a>
{/if}

<textarea id="editor_content" name="editor_content" class="w3-input w3-border w3-round w3-margin-bottom" style="width:97%;height:400px;background-color:#F9F9F9;">{$editor_content|default:''}</textarea>
<div class="w3-row">
	<input id="var_s" type="text" size="15" class="w3-input w3-border w3-round w3-margin-right w3-margin-bottom" placeholder="{#LB_search#}" style="float:left; max-width:220px;">
	<input id="var_r" type="text" size="15" class="w3-input w3-border w3-round w3-margin-right w3-margin-bottom" placeholder="{#LB_replace#}" style="float:left; max-width:220px;">
	<input class="w3-button  w3-theme" type="button" value="{#LB_go#}" onclick="searchReplaceTxt('editor_content')">
</div>
<input name="action" type="hidden" value="{if $details.name}edit{else}create{/if}">
<input name="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="attr" type="hidden" value="{$details.attr|default:'0644'}">
<input name="dir" type="hidden" value="{$details.dir}">
<input name="subaction" type="hidden" value="txtcontent">
<input name="name" type="hidden" value="{$details.name}">
<!-- buttons -->
{if $entry_info.entry_attr > 1}
<input id="newObj1" class="w3-button w3-margin-top-8 w3-margin-right-8 w3-margin-bottom w3-theme" type="submit" value="{#LB_save#}">
{if $details.name}
<input id="newObj2" class="w3-button w3-margin-top-8 w3-margin-right-8 w3-margin-bottom  w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
{/if}
<input id="newObj3" class="w3-button w3-margin-top-8 w3-margin-right-8 w3-margin-bottom  w3-theme" type="button" onclick="rScr('list&amp;dir={$details.dir}','')" value="{#LB_close#}">
<!-- buttons -->

</form>
<hr class="w3-light-grey">

