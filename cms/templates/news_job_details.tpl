<!-- COPYRIGHTS Another CMS -->
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
function checkJob(state) {
	if (state == 1) {
		toggle('newObj1',1);toggle('newObj2',0);
		document.forms['form_details'].elements['action'].value = 'edit';
		setTimeout(goJob, 6000);
	}
	if (state == 0) {
		toggle('newObj1',0);toggle('newObj2',1);
		document.forms['form_details'].elements['action'].value = 'details';
		clearTimeout(goJob);
	}
}
function goJob() {
	document.forms['form_details'].submit();
}
</script>
{/literal}

{if $details.id|default:0 == 0}

<form id="form_details" name="form_details" method="post" action="#" onsubmit="loading()" style="display:block;">
<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
{if $entry_info.entry_attr > 2}
<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
</div>
<h3>{#LB_details#}</h3>
<div class="w3-margin-bottom-8">
<label>{#LB_webPage#}:</label><br>
<select name="menu_id" id="menu_id" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<option value="0">---</option>
{section name=item loop=$menu_list}
	<option value="{$menu_list[item].id}"{if $details.menu_id|default:0 eq $menu_list[item].id} selected="selected"{/if}>
	{$menu_list[item].title}
	</option>
{/section}
</select><br>
<label>{#LB_news#} <span class="w3-text-red">*</span>:</label><br>
<select name="news_id" id="news_id" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;" required>
<option value="0">---</option>
{section name=item loop=$news_list}
	<option value="{$news_list[item].id}"{if $details.news_id|default:0 eq $news_list[item].id} selected="selected"{/if}>
	{$news_list[item].title}
	</option>
{/section}
</select>
<p>{#LB_user#}: {$details.createnick|default:$user_info.nick}</p>
</div>
<input name="action" id="action" type="hidden" value="create">
<input name="subaction" id="subaction" type="hidden" value="item">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="details_id" id="details_id" type="hidden" value="0">
<input name="modifytime" id="modifytime" type="hidden" value="0">
<input name="createnick" id="createnick" type="hidden" value="{$user_info.nick}">
<!-- buttons -->
{if $entry_info.entry_attr > 2}
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
<!-- buttons -->
</form>

{else}

<form id="form_details" name="form_details" method="post" action="#" onsubmit="loading()" style="display:block;">
<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
</div>
<h3>{#LB_details#}</h3>
<div class="w3-margin-bottom-8">
{#LB_webPage#}: 
{section name=item loop=$menu_list}
	{if $details.menu_id|default:0 eq $menu_list[item].id}{$menu_list[item].title}{/if}
{/section}<br>
{#LB_news#}: 
{section name=item loop=$news_list}
	{if $details.news_id|default:0 eq $news_list[item].id}{$news_list[item].title}{/if}
{/section}<br>
{#LB_user#}: {$details.createnick|default:$user_info.nick}
{if $entry_info.entry_attr > 2 and $success|default:0 > 0}
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="checkJob(0)" value="{#LB_stop#}" style="display:none">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="checkJob(1)" value="{#LB_go#}" style="display:none">
{/if}
<p>{#LB_log#}:
<textarea id="out_log" name="out_log" cols="60" rows="30" class="w3-input w3-border w3-round" style="width:98%;height:350px;background-color:#F9F9F9;">{$details.out_log|default:''}</textarea></p>
</div>
<input name="menu_id" id="menu_id" type="hidden" value="{$details.menu_id|default:0}">
<input name="news_id" id="news_id" type="hidden" value="{$details.news_id|default:0}">
<input name="action" id="action" type="hidden" value="edit">
<input name="subaction" id="subaction" type="hidden" value="item">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="details_id" id="details_id" type="hidden" value="{$details.id}">
<input name="modifytime" id="modifytime" type="hidden" value="0">
<input name="createnick" id="createnick" type="hidden" value="{$user_info.nick}">
<!-- buttons -->
{if $entry_info.entry_attr > 2 or ($entry_info.entry_attr > 1 and $details.id|default:0 > 0)}
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','')" value="{#LB_close#}">
{/if}
</form>

{/if}

<div id="upload_bar" style="display:none;">
<img src="../images/loading.gif" width="32" height="32" alt="{#LB_loading#}" style="padding:20px;">
</div>

<hr class="w3-light-grey">
{/strip}

<script>toggle('upload_bar', 0);</script>

{if $details.id|default:0 > 0}
{if $warning_msg|default:'' eq 'Job ON'}<script>toggle('newObj1',1);toggle('newObj2',0);checkJob(1);</script>{else}<script>toggle('newObj1',0);toggle('newObj2',1);checkJob(0);</script>{/if}
{/if}
