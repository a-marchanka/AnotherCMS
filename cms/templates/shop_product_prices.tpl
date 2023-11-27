<!-- COPYRIGHTS Another CMS      -->
{literal}
<script>
function loading() {
	toggle('form_details', 0);
	toggle('upload_bar', 1);
}
function saveAndClose() {
	loading();
	document.forms['form_details'].elements['subaction'].value = 'save_close_prices';
	document.forms['form_details'].submit();
}
</script>
{/literal}

<form id="form_details" name="form_details" method="post" action="#" onsubmit="loading()" style="display:block;">
<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
{if $entry_info.entry_attr > 2}
<input id="TnewObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="TnewObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','product')" value="{#LB_close#}">
</div>

<h3>{#LB_prices#}</h3>

<table class="w3-table w3-bordered w3-striped">
<tr>
<th>{#LB_title#}</th>
<th>{#LB_amount#}/{#LB_price#}</th>
<th>{#LB_status#}</th>
</tr>
{section name=item loop=$items_list}
	<tr>
	<td style="max-width:300px;">{$items_list[item].title}
	  <input name="id_{$smarty.section.item.index}" type="hidden" value="{$items_list[item].id}">
	  <input name="title_{$smarty.section.item.index}" type="hidden" value="{$items_list[item].title}">
	</td>
	<td>
	<div class="w3-quarter w3-margin-right-8">
	  <div class="w3-half">1.{#LB_piece#}:<input name="cnt_{$smarty.section.item.index}" type="text" value="{$items_list[item].amount|default:'0'}" class="w3-input w3-border w3-round w3-margin-bottom-8" size="8" style="max-width:65px;"></div>
	  <div class="w3-half">1.{#LB_price#}:<input name="pr_{$smarty.section.item.index}" type="text" value="{$items_list[item].price|default:'0'}" class="w3-input w3-border w3-round w3-margin-bottom-8" size="8" style="max-width:65px;"></div>
	</div>
	<div class="w3-quarter w3-margin-right-8">
	  <div class="w3-half">2.{#LB_piece#}:<input name="cnt_1_{$smarty.section.item.index}" type="text" value="{$items_list[item].amount_1|default:'0'}" class="w3-input w3-border w3-round w3-margin-bottom-8" size="8" style="max-width:65px;"></div>
	  <div class="w3-half">2.{#LB_price#}:<input name="pr_1_{$smarty.section.item.index}" type="text" value="{$items_list[item].price_1|default:'0'}" class="w3-input w3-border w3-round w3-margin-bottom-8" size="8" style="max-width:65px;"></div>
	</div>
	<div class="w3-quarter w3-margin-right-8">
	  <div class="w3-half">3.{#LB_piece#}:<input name="cnt_2_{$smarty.section.item.index}" type="text" value="{$items_list[item].amount_2|default:'0'}" class="w3-input w3-border w3-round w3-margin-bottom-8" size="8" style="max-width:65px;"></div>
	  <div class="w3-half">3.{#LB_price#}:<input name="pr_2_{$smarty.section.item.index}" type="text" value="{$items_list[item].price_2|default:'0'}" class="w3-input w3-border w3-round w3-margin-bottom-8" size="8" style="max-width:65px;"></div>
	</div>
	<div class="w3-quarter">
	  <div class="w3-half">4.{#LB_piece#}:<input name="cnt_3_{$smarty.section.item.index}" type="text" value="{$items_list[item].amount_3|default:'0'}" class="w3-input w3-border w3-round w3-margin-bottom-8" size="8" style="max-width:65px;"></div>
	  <div class="w3-half">4.{#LB_price#}:<input name="pr_3_{$smarty.section.item.index}" type="text" value="{$items_list[item].price_3|default:'0'}" class="w3-input w3-border w3-round w3-margin-bottom-8" size="8" style="max-width:65px;"></div>
	</div>
	<td{if $items_list[item].status<2} class="w3-text-pink"{elseif $items_list[item].status==2} class="w3-text-teal"{else} class="w3-text-orange"{/if}><br>
	  <select name="st_{$smarty.section.item.index}" class="w3-select w3-border w3-round w3-margin-bottom-8" style="max-width:160px;">
	  {section name=itr loop=$status_list}
	  <option value="{$status_list[itr].id}"{if $items_list[item].status == $status_list[itr].id} selected="selected"{/if}>{$status_list[itr].title}</option>
	  {/section}
	  </select>
	</td>
	</tr>
{/section}
</table>
<br>
<input name="uid_total" type="hidden" value="{$smarty.section.item.loop}">
<input name="action" id="action" type="hidden" value="edit">
<input name="subaction" id="subaction" type="hidden" value="product_prices">
<input name="entry_id" id="entry_id" type="hidden" value="{$entry_info.entry_id}">

<!-- buttons -->
{if $entry_info.entry_attr > 2}
<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_save#}">
<input id="newObj2" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="saveAndClose()" value="{#LB_saveClose#}">
{/if}
<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list','product')" value="{#LB_close#}">
<!-- buttons -->

</form>

<div id="upload_bar" style="display:none;">
<img src="../images/loading.gif" width="32" height="32" alt="{#LB_loading#}" style="padding:20px;">
</div>

<hr class="w3-light-grey">

<script>toggle('upload_bar', 0);</script>

