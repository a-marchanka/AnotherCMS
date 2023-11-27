<div class="w3-hide-small w3-hide-medium w3-display-topright w3-round-large w3-padding w3-margin-right w3-border w3-white w3-medium" style="width:auto;">
<a href="shop?action=list&subaction=prices{if $SID}&{$SID}{/if}"><img src="images/shop_prices.png" width="25" height="25" alt="{#LB_prices#}" title="{#LB_prices#}"></a>
{if $basket_amount|default:0 > 0}
<a href="basket?action=list{if $SID}&{$SID}{/if}"><img src="images/shop_basket.png" width="25" height="25" alt="{#LB_basket#}" title="{#LB_basket#}"></a>&nbsp;({$basket_amount|default:0})
<a href="order?action=list{if $SID}&{$SID}{/if}"><img src="images/shop_buy.png" width="25" height="25" alt="{#LB_order#}" title="{#LB_order#}"></a>
{/if}
</div>

{strip}
<nav class="w3-sidebar w3-bar-block w3-light-grey w3-top w3-collapse" style="z-index:3;width:270px;letter-spacing:1px;" id="myNav">
<a class="w3-bar-item w3-button w3-hide-large w3-hover-light-grey w3-grey" href="javascript:void(0);" onclick="w3Nav()" title="{#LB_menu#}">&times;&nbsp;{#LB_close#}</a>
<a href="shop{if $sid}?sid={$sid}{/if}" class="w3-border w3-margin w3-btn">SHOP LOGO</a>
<!-- level 1 -->
{assign var="folder_id" value=0}
<div class="w3-medium w3-text-dark-grey w3-margin-top">
{section name=lev1 loop=$menu_tree}
	{if $menu_tree[lev1].name eq 'shop_catalog'}
		{assign var="folder_id" value=$menu_tree[lev1].id}
	{/if}
	{if $menu_tree[lev1].parent_id == $folder_id and $menu_tree[lev1].active == 1 and $menu_tree[lev1].level == 1 and $menu_tree[lev1].status ne 'disabled'}
	<a class="w3-bar-item w3-button w3-blue-grey w3-margin-top-8 w3-padding-medium {if $menu_tree[lev1].status eq 'selected' or $menu_tree[lev1].id == $entry_parent_id}w3-grey{/if}" href="{$menu_tree[lev1].name}{if $SID}?{$SID}{/if}" >{$menu_tree[lev1].title}</a>
	{/if}
	{if $menu_tree[lev1].id eq $entry_parent_id}
		{section name=lev2 loop=$menu_tree}
		{if $menu_tree[lev2].parent_id == $entry_parent_id and $menu_tree[lev2].active == 1 and $menu_tree[lev2].level == 2 and $menu_tree[lev2].status ne 'disabled'}
		<a class="w3-bar-item w3-button {if $menu_tree[lev2].status eq 'selected'}w3-grey{/if}" href="{$menu_tree[lev2].name}{if $SID}?{$SID}{/if}">&bullet; {$menu_tree[lev2].title}</a>
		{/if}
		{/section}
	{/if}
{/section}
</div>
<br>
{if $basket_amount|default:0 > 0}
<a href="basket?action=list{if $SID}&{$SID}{/if}" class="w3-bar-item w3-button">{#LB_basket#}&nbsp;({$basket_amount|default:0})</a>
<a href="order?action=list{if $SID}&{$SID}{/if}" class="w3-bar-item w3-button">{#LB_order#}</a>
{/if}
{if $sid}
  <a href="?sid={$sid}&action=logout" class="w3-bar-item w3-button">{#LB_logout#}</a>
{/if}
<a href="terms_conditions{if $sid}?sid={$sid}{/if}" class="w3-bar-item w3-button">AGB</a>
<div class="w3-border-top w3-margin-top w3-padding w3-text-dark-grey"><p>Zahlungsarten</p>
<ul><li>PayPal</li><li>Rechnung</li><li>Vorkasse</li><li>Nachnahme</li></ul></div>

<div class="w3-border-top w3-margin-top w3-text-dark-grey">
{assign var="folder_trig" value=0}
{section name=item loop=$menu_tree} 
	{if $menu_tree[item].content_type eq 'folder' and $menu_tree[item].name eq 'templates'}
		{assign var="folder_trig" value=$menu_tree[item].id}
	{/if}
	{if $folder_trig == $menu_tree[item].parent_id and $menu_tree[item].status ne 'disabled' and $menu_tree[item].level == 1}
		<a href="{$menu_tree[item].name}{if $sid}?sid={$sid}{/if}" class="w3-bar-item w3-button{if $menu_tree[item].status eq 'selected'} w3-grey{/if}">{$menu_tree[item].title}</a>
	{/if}
{/section}
</div>

</nav>
{/strip}

<!-- Header -->
<header class="w3-bar w3-top w3-hide-large w3-white w3-card">
<div class="w3-bar-item w3-wide">
<a href="shop{if $sid}?sid={$sid}{/if}" class="w3-border w3-btn">SHOP LOGO</a>
</div>
<div class="w3-display-topmiddle w3-margin-right w3-padding-small w3-medium" id="basket" style="width:auto;">
<a href="shop?action=list&subaction=prices{if $SID}&{$SID}{/if}"><img src="images/shop_prices.png" width="25" height="25" alt="{#LB_prices#}" title="{#LB_prices#}"></a>
{if $basket_amount|default:0 > 0}
<a href="basket?action=list{if $SID}&{$SID}{/if}"><img src="images/shop_basket.png" width="25" height="25" alt="{#LB_basket#}" title="{#LB_basket#}"></a>&nbsp;({$basket_amount|default:0})
<a href="order?action=list{if $SID}&{$SID}{/if}"><img src="images/shop_buy.png" width="25" height="25" alt="{#LB_order#}" title="{#LB_order#}"></a>
{/if}
</div>
<a href="javascript:void(0)" class="w3-button w3-right w3-margin-right" onclick="w3Nav();">&equiv;&nbsp;{#LB_menu#}</a>
</header>


