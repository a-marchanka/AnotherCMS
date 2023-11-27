{strip}
<nav class="w3-top w3-bar w3-card w3-dark-grey" style="z-index:3;letter-spacing:1px;">
<div class="w3-bar-item"><a href="/{if $sid}?sid={$sid}{/if}" class="w3-border w3-btn">LOGO</a></div>
<div class="w3-right w3-hide-large">
<a href="javascript:void(0)" class="w3-margin-8 w3-bar-item w3-button" onclick="w3Nav();">&equiv;&nbsp;{#LB_menu#}</a>
</div>
<div class="w3-right w3-hide-small">
{assign var="folder_trig" value=0}
{section name=item loop=$menu_tree} 
	{if $menu_tree[item].content_type eq 'folder' and $menu_tree[item].name eq 'templates'}
		{assign var="folder_trig" value=$menu_tree[item].id}
	{/if}
	{if $folder_trig == $menu_tree[item].parent_id and $menu_tree[item].status ne 'disabled' and $menu_tree[item].level == 1}
		<a href="{$menu_tree[item].name}{if $sid}?sid={$sid}{/if}" class="w3-margin-8 w3-bar-item w3-button{if $menu_tree[item].status eq 'selected'} w3-white{/if}">{$menu_tree[item].title}</a>
	{/if}
{/section}
</div>
<!-- Navbar on small screens -->
<div id="myNav" class="w3-bar-block w3-dark-grey w3-hide w3-hide-large w3-hide-medium w3-medium">
<a class="w3-bar-item w3-button w3-white" href="javascript:void(0);" onclick="w3Nav()" title="{#LB_close#}">{#LB_close#}&nbsp;&times;</a>
{assign var="folder_trig" value=0}
{section name=item loop=$menu_tree}
	{if $menu_tree[item].content_type eq 'folder' and $menu_tree[item].name eq 'templates'}
		{assign var="folder_trig" value=1}
	{/if}
	{if $folder_trig == 1 and $menu_tree[item].status ne 'disabled' and $menu_tree[item].level == 1}
		<a href="{$menu_tree[item].name}{if $sid}?sid={$sid}{/if}" class="w3-bar-item w3-button w3-padding-medium{if $menu_tree[item].status eq 'selected'} w3-white{/if}">{$menu_tree[item].title}</a>
	{/if}
{/section}
</div>
</nav>
{/strip}

