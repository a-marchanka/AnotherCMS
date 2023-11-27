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
</script>
{/literal}
<!-- CALENDAR -->
<link href="../libs/calendar/{$cms_theme|default:'core'}.css" rel="stylesheet" type="text/css">
<script src="../libs/calendar/calendar.js"></script>
<script src="../libs/calendar/lang/calendar-{$ui_lang|default:'en'}.js"></script>
<script src="../libs/calendar/calendar-setup.js"></script>

{strip}
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
<div class="w3-half w3-margin-bottom-8">
<div class="w3-left w3-margin-bottom-8" style="width:120px;">
	{if $details.filepath eq $user_img}
	<a href="../{$details.filepath}{$details.filename}" class="lytebox" data-title="{$details.alttext} {$details.width}x{$details.height}">
	<img src="../{$details.filepath}thumbs/{$details.filename}" alt="{$details.alttext}" title="{$details.filename}" width="95" height="95" class="w3-card-2"></a>
	{/if}
	{if $details.filepath eq $user_vid}
	<a href="../{$details.filepath}{$details.filename}" class="lytebox" data-title="{$details.alttext} {$details.width}x{$details.height}">
	<img src="../{$details.filepath}default_video.png" alt="{$details.alttext}" title="{$details.filename}" width="95" height="95" class="w3-card-2"></a>
	{/if}
	{if $details.filepath eq $user_aud}
	<a href="../{$details.filepath}{$details.filename}" class="lytebox" data-title="{$details.alttext} {$details.width}x{$details.height}">
	<img src="../{$details.filepath}default_audio.png" alt="{$details.alttext}" title="{$details.filename}" width="95" height="95" class="w3-card-2"></a>
	{/if}
</div>
<label>{#LB_date#}:</label>
<input name="shoottime" id="shoottime" type="text" value="{$details.shoottime|date_format:"%d.%m.%Y"|default:"--"}" size="12" maxlength="10" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
<input name="trigger" id="trigger" type="button" value="{#LB_calendar#}" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme">
	<!-- CALENDAR -->
	{literal}
	<script>
	  Calendar.setup( {
		inputField:"shoottime",
		ifFormat:"%d.%m.%Y",
		button:"trigger"
		} );
	</script>
	{/literal}
</div>
<div class="w3-third w3-margin-bottom-8">
<p>{#LB_file#}: {$details.filepath} {$details.filename|truncate:40}</p>
<label>{#LB_description#}:</label>
<input name="alttext" id="alttext" type="text" value="{$details.alttext|default:$details.filename}" size="45" maxlength="128" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
</div>
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_webPage#}:</label><br>
<select name="menu_id" id="menu_id" class="w3-select w3-border w3-round w3-margin-bottom-8 w3-margin-right" style="max-width:430px;">
<option value="0">---</option>
{section name=custom loop=$search_list}
	<option value="{$search_list[custom].id}"{if $details.menu_id eq $search_list[custom].id} selected="selected"{/if}>
	{'&nbsp;'|indent:$search_list[custom].level:'- '} {$search_list[custom].title}
	</option>
{/section}
</select>
{if $details.filepath eq $user_img}
	<br><label>{#LB_crop#}:</label><br>
	<label>
		<img src="../images/crop_1x1.png" alt="1x1" title="1x1" width="36" height="36">&nbsp;
		<input value="0" type="radio" name="crop"{if $details.crop|default:0 == 0} checked="checked"{/if} class="w3-radio">
	</label>&nbsp; &nbsp;
	<label>
		<img src="../images/crop_2x1.png" alt="2x1" title="2x1" width="36" height="36">&nbsp;
		<input value="0.5" type="radio" name="crop"{if $details.crop|default:0 == 0.5} checked="checked"{/if} class="w3-radio">
	</label>&nbsp; &nbsp;
	<label>
		<img src="../images/crop_3x2.png" alt="3x2" title="3x2" width="36" height="36">&nbsp;
		<input value="0.67" type="radio" name="crop"{if $details.crop|default:0 == 0.67} checked="checked"{/if} class="w3-radio">
	</label>&nbsp; &nbsp;
	<label>
		<img src="../images/crop_4x3.png" alt="4x3" title="4x3" width="36" height="36">&nbsp;
		<input value="0.75" type="radio" name="crop"{if $details.crop|default:0 == 0.75} checked="checked"{/if} class="w3-radio">
	</label>
	<div class="w3-small">&nbsp;</div>
	<label>{#LB_rotate#}:</label><br>
	<label>
		<img src="../images/rotate_0.png" alt="0&deg;" title="0&deg;" width="36" height="36">&nbsp;
		<input value="0" type="radio" name="rotation"{if $details.rotation == 0} checked="checked"{/if} class="w3-radio">
	</label>&nbsp; &nbsp;
	<label>
		<img src="../images/rotate_90.png" alt="90&deg;" title="90&deg;" width="36" height="36">&nbsp;
		<input value="90" type="radio" name="rotation"{if $details.rotation == 90} checked="checked"{/if} class="w3-radio">
	</label>&nbsp; &nbsp;
	<label>
		<img src="../images/rotate_180.png" alt="180&deg;" title="180&deg;" width="36" height="36">&nbsp;
		<input value="180" type="radio" name="rotation"{if $details.rotation == 180} checked="checked"{/if} class="w3-radio">
	</label>&nbsp; &nbsp;
	<label>
		<img src="../images/rotate_270.png" alt="270&deg;" title="270&deg;" width="36" height="36">&nbsp;
		<input value="270" type="radio" name="rotation"{if $details.rotation == 270} checked="checked"{/if} class="w3-radio">
	</label>
{else}
	<input name="rotation" id="rotation" type="hidden" value="{$details.rotation}">
{/if}
</div>
<div class="w3-half w3-margin-bottom-8">
{if $details.filepath eq $user_img}
	<label>{#LB_resize#}:</label><br>
	<select name="width" id="width" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
	{section name=custom loop=$prop_list}
		<option value="{$prop_list[custom].id}"{if $details.width|default:0 eq $prop_list[custom].id or $details.height|default:0 eq $prop_list[custom].id} selected="selected"{/if}>{$prop_list[custom].title}</option>
	{/section}
	</select><br>
{else}
	<input name="width" id="width" type="hidden" value="{$details.width}">
{/if}
<label>{#LB_priority#}:</label><br>
<input name="priority" id="priority" type="text" value="{$details.priority|default:1}" size="4" maxlength="4" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:130px;">
</div>
<div class="w3-half w3-margin-bottom-8">
<label>{#LB_who#}:</label>
<input name="meta_who" id="meta_who" type="text" value="{$details.meta_who}" size="35" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
<label>{#LB_where#}:</label>
<input name="meta_where" id="meta_where" type="text" value="{$details.meta_where}" size="35" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
</div>
<div class="w3-margin-top w3-clear">
<label>{#LB_status#}: </label> &nbsp; 
{section name=status_counter loop=$status_list}
	<label{if $details.status == $status_list[status_counter].id}{if $details.status<2} style="background-color:#FFDFDF"{elseif $details.status==2} style="background-color:#DFFFDF"{else} style="background-color:#FFFF00"{/if}{/if}><input value="{$status_list[status_counter].id}"{if $details.status == $status_list[status_counter].id} checked="checked"{/if} type="radio" name="status" class="w3-radio">
	&nbsp;{$status_list[status_counter].title}</label>&nbsp; &nbsp;
{/section}
<p>{#LB_user#}: {$details.createnick}</p>
</div>
<input name="action" id="action" type="hidden" value="edit">
<input name="subaction" id="subaction" type="hidden" value="media">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="details_id" id="details_id" type="hidden" value="{$details.id|default:0}">
<input name="filepath" id="filepath" type="hidden" value="{$details.filepath}">
<input name="filename" id="filename" type="hidden" value="{$details.filename}">
<input name="modifytime" id="modifytime" type="hidden" value="{$details.modifytime}">
<input name="createnick" id="createnick" type="hidden" value="{$details.createnick}">

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

