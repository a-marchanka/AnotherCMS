<!-- COPYRIGHTS ©Another CMS -->
<!-- buttons -->
<div class="w3-right w3-hide-small w3-hide-medium">
<input id="TnewObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8  w3-theme" type="button" onclick="rScr('list&amp;dir={$details.dir}','')" value="{#LB_close#}">
</div>

<!-- details -->
<table class="w3-table w3-bordered w3-striped">
<tr>
<td>HTTP_ACCEPT_LANGUAGE:</td><td>{$webclient.HTTP_ACCEPT_LANGUAGE}</td></tr><tr>
<td>HTTP_USER_AGENT:</td><td>{$webclient.HTTP_USER_AGENT}</td></tr><tr>
<td>REMOTE_ADDR:</td><td>{$webclient.REMOTE_ADDR}</td></tr><tr>
<td>SERVER_SOFTWARE:</td><td>{$webclient.SERVER_SOFTWARE}</td></tr><tr>
<td>SERVER_PROTOCOL:</td><td>{$webclient.SERVER_PROTOCOL}</td>
</tr>
</table>
<form name="form_details1" method="post" action="#" class="w3-margin-top">
	<textarea name="name" cols="60" rows="5" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">{$details.name|default:'sample@mail'}</textarea>
	<input name="action" type="hidden" value="create">
	<input name="subaction" type="hidden" value="emailjs">
	<input name="entry_id" type="hidden" value="{$entry_info.entry_id}">
	<input name="dir" type="hidden" value="{$details.dir}">
	<input id="newObj1" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="submit" value="{#LB_codeEmail#}">
</form>
<hr class="w3-light-grey">
<b>{#LB_password#}</b>
<form name="form_details2" method="post" action="#" class="w3-margin-top">
	8 <input id="pas8" name="ext" class="w3-radio w3-margin-right-8 w3-margin-bottom-8 w3-light-grey" type="radio" value="8" onclick="this.form.submit()">
	7 <input id="pas7" name="ext" class="w3-radio w3-margin-right-8 w3-margin-bottom-8 w3-light-grey" type="radio" value="7" onclick="this.form.submit()">
	6 <input id="pas6" name="ext" class="w3-radio w3-margin-right-8 w3-margin-bottom-8 w3-light-grey" type="radio" value="6" onclick="this.form.submit()">
	5 <input id="pas5" name="ext" class="w3-radio w3-margin-right-8 w3-margin-bottom-8 w3-light-grey" type="radio" value="5" onclick="this.form.submit()">
	4 <input id="pas4" name="ext" class="w3-radio w3-margin-right-8 w3-margin-bottom-8 w3-light-grey" type="radio" value="4" onclick="this.form.submit()">
	<input name="action" type="hidden" value="create">
	<input name="subaction" type="hidden" value="pincode">
	<input name="entry_id" type="hidden" value="{$entry_info.entry_id}">
	<input name="dir" type="hidden" value="{$details.dir}">
	<input name="attr" type="text" value="{$details.attr|default:''}" size="30" maxlength="64" class="w3-input w3-border w3-round w3-margin-bottom-8" style="max-width:430px;">
</form>
<div>&nbsp;</div>

<input id="newObj3" class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-theme" type="button" onclick="rScr('list&amp;dir={$details.dir}','')" value="{#LB_close#}">

<hr class="w3-light-grey">

