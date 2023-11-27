<div style="clear:both;" id="footerId">&nbsp;</div>
<div class="w3-container w3-padding w3-white w3-round-large w3-margin-bottom">
<div class="w3-half">
<h2>{#LB_contact#}</h2>
<form name="conta" method="post" action="{$entry_name}#footerId" onsubmit="getSigConta()">
  <div class="w3-section">
    <label style="color:#333; text-decoration:underline;">{#LB_email#}:</label>
    <input class="w3-input" required="" type="text" name="email" value="{if isset($contact.email)}{$contact.email}{else}email{/if}">
  </div>
  <div class="w3-section">
    <label style="color:#333; text-decoration:underline;">{#LB_message#}:</label>
    <textarea class="w3-input" required="" name="message" id="message" rows="5">{if isset($contact.message)}{$contact.message}{else}{#LB_messageTpl#}{/if}</textarea>
  </div>
  <div class="w3-row">
    <input type="checkbox" name="perm" id="perm" required="" class="w3-check" value="1"{if isset($contact.perm)}{if $contact.perm == 1} checked="checked"{/if}{/if}>
    <label style="color:#999;">{#LB_dataPerm#}</label> <br>
  </div>
  <input name="copy" value="0" type="hidden">
  <input name="ip" value="empty" type="hidden">
  <input name="action" type="hidden" value="create">
  <input name="subaction" type="hidden" value="contact">
  <input name="m" value="{$entry_name}" type="hidden">
  <input name="sid" value="{$sid}" type="hidden">
  <input class="w3-button w3-grey w3-margin-top w3-margin-bottom" type="submit" value="{#LB_send#}">
</form>
</div>
<script>
function getSigConta() { document.forms['conta'].elements['ip'].value = screen.width + '#' + screen.height + '#' + screen.colorDepth + '#' + navigator.language; }
</script>

<div class="w3-half">
<h2>{#LB_newsletter#}</h2>
<form name="newsl" method="post" action="#footerId" onsubmit="getSigEmail()">
  <div class="w3-section">
    <label style="color:#333; text-decoration:underline;">{#LB_email#}</label>
    <input class="w3-input" type="text" name="email" value="{$items.email|default:''}" style="max-width:430px;" required>
  </div>
  <div class="w3-section">
    <label class="w3-text-grey">{#LB_name#}</label>
    <input class="w3-input" type="text" name="name" id="name" value="{$items.name|default:''}" style="max-width:430px;">
  </div>
  <div class="w3-section w3-clear">
  <input name="ip" value="empty" type="hidden">
  <input name="action" type="hidden" value="create">
  <input name="subaction" type="hidden" value="newsletter">
  <input name="m" value="{$entry_name}" type="hidden">
  <input name="sid" value="{$sid}" type="hidden">
  <input name="howlong" value="0" type="hidden">
  <input class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-grey" type="button" onclick="for1y()" value="{#LB_newsletterJ1#}">
  <input class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-grey" type="button" onclick="for2y()" value="{#LB_newsletterJ2#}">
  <input class="w3-button w3-margin-right-8 w3-margin-bottom-8 w3-light-grey" type="submit" value="{#LB_newsletterJ0#}">
  </div>
<script>
function getSigEmail(){ document.forms['newsl'].elements['ip'].value=screen.width+'#'+screen.height+'#'+screen.colorDepth+'#'+navigator.language; }
function for1y(){ document.forms['newsl'].elements['howlong'].value='1';getSigEmail();document.forms['newsl'].submit(); }
function for2y(){ document.forms['newsl'].elements['howlong'].value='2';getSigEmail();document.forms['newsl'].submit(); }
</script>
</form>
</div>

</div>
