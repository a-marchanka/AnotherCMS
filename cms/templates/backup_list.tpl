{literal}
<script>
function getDump() {
if (document.forms['form_search_header'].elements['compress'].checked)
	document.forms['form_search_header'].target = '_blank';
else
	document.forms['form_search_header'].target = '_self';
document.forms['form_search_header'].submit();
}
</script>
{/literal}

<!-- filter -->
<form id="form_search_header" method="post" action="#">
<div class="w3-row">
	<div class="w3-quarter w3-margin-right">
	<label>{#LB_table#}:</label><select name="table" id="table" class="w3-select w3-border w3-round">
	<option value="0">---</option>
	{section name=custom loop=$table_list}
	<option value="{$table_list[custom].name}"{if $details.table|default:'' eq $table_list[custom].name} selected="selected"{/if}>{$table_list[custom].name}</option>
	{/section}
	</select>
	<input name="structure" type="checkbox" id="structure"{if $details.structure|default:0} checked="checked"{/if} class="w3-check w3-margin-top-8 w3-margin-bottom"><label>&nbsp;{#LB_structure#}</label> &nbsp;
	<input name="compress" type="checkbox" id="compress"{if $details.compress|default:0} checked="checked"{/if} class="w3-check w3-margin-top-8 w3-margin-bottom"><label>&nbsp;{#LB_download#}</label>
	</div>
	<div class="w3-quarter">
	<label>{#LB_rows#}:</label><input name="count" type="text" id="count" maxlength="6" size="6" value="{$details.count|default:10000}" class="w3-input w3-border w3-round">
	</div>
	<div class="w3-quarter">
	<label>{#LB_startingFrom#}:</label><input name="start" type="text" id="start" maxlength="6" size="6" value="{$details.start|default:0}" class="w3-input w3-border w3-round">
	</div>
	<div class="w3-quarter"><br>
	<input class="w3-button w3-margin-bottom w3-theme" type="submit" value="{#LB_go#}">
	</div>
</div>
	<input name="drop" type="hidden" id="drop" value="1">
	<input name="action" type="hidden" id="action" value="list">
	<input name="subaction" type="hidden" id="subaction" value="search">
</form>
<!-- filter -->

<form id="txtEditor" name="txtEditor" method="post" action="#" target="_blank">
<textarea id="editor_content" name="editor_content" class="w3-input w3-border w3-round w3-margin-bottom" style="width:97%;height:380px;background-color:#F9F9F9;">{$editor_content|default:''}</textarea>
<div class="w3-row">
	<input id="var_s" type="text" size="15" class="w3-input w3-border w3-round w3-margin-right w3-margin-bottom" placeholder="{#LB_search#}" style="float:left; max-width:220px;">
	<input id="var_r" type="text" size="15" class="w3-input w3-border w3-round w3-margin-right w3-margin-bottom" placeholder="{#LB_replace#}" style="float:left; max-width:220px;">
	<input class="w3-button w3-theme" type="button" value="{#LB_go#}" onclick="searchReplaceTxt('editor_content')">
</div>
<input name="action" type="hidden" value="create">
<input name="entry_id" type="hidden" value="{$entry_info.entry_id}">
<input name="subaction" type="hidden" value="dump">
<input name="table" type="hidden" value="{$details.table|default:''}">
<input name="drop" type="hidden" value="{$details.drop|default:0}">
<input name="structure" type="hidden" value="{$details.structure|default:0}">
<input name="compress" type="hidden" value="{$details.compress|default:0}">
<input name="start" type="hidden" value="{$details.start|default:0}">
<input name="count" type="hidden" value="{$details.count|default:10000}">
<!-- save -->
{if $entry_info.entry_attr > 2}
<input class="w3-button w3-margin-top-8 w3-margin-bottom w3-theme" type="submit" value="{#LB_execute#}">
{/if}
<!-- save -->
</form>
<hr class="w3-light-grey">

