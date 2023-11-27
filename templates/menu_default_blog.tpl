{strip}
<nav class="w3-sidebar w3-bar-block w3-white w3-top w3-collapse w3-border-right" style="z-index:3;width:270px;letter-spacing:1px;" id="myNav">
<a class="w3-bar-item w3-button w3-hide-large w3-hover-light-grey w3-grey" href="javascript:void(0);" onclick="w3Nav()" title="{#LB_close#}">&times;&nbsp;{#LB_close#}</a>
<div class="w3-center"><a href="/{if $sid}?sid={$sid}{/if}" class="w3-border w3-margin w3-btn">BLOG NAME</a></div>
<div class="w3-large">
<a class="w3-bar-item w3-button {if $entry_name eq 'podcast'}w3-light-grey{/if}" href="blog{if $SID}?{$SID}{/if}">Podcast</a>
<a class="w3-bar-item w3-button {if $entry_name eq 'blog'}w3-light-grey{/if}" href="blog{if $SID}?{$SID}{/if}">Blog</a>
<a class="w3-bar-item w3-button {if $entry_name eq 'images'}w3-light-grey{/if}" href="blog{if $SID}?{$SID}{/if}">Images</a>
<a class="w3-bar-item w3-button {if $entry_name eq 'channels'}w3-light-grey{/if}" href="blog{if $SID}?{$SID}{/if}">Channels</a>
</div>
{if $menu_last}
	<hr>
	<div class="w3-medium">
	<p class="w3-margin-left-8 w3-text-grey">Last changes:</p>
	{section name=item loop=$menu_last}
	<a class="w3-bar-item w3-button {if $entry_name eq $menu_last[item].name}w3-light-grey{/if}" href="{$menu_last[item].name}{if $SID}?{$SID}{/if}">{$menu_last[item].title}
	&nbsp;<span class="w3-tiny">{$menu_last[item].modifytime|date_format:"%d.%m.%y"}</span></a>
	{/section}
	</div>
{/if}
<hr>
<p class="w3-margin-left-8 w3-text-grey">Templates:</p>
{section name=item loop=$menu_tree}
	{if $menu_tree[item].content_type eq 'folder' and $menu_tree[item].name eq 'templates'}
		{assign var="folder_trig" value=$menu_tree[item].id}
	{/if}
	{if $folder_trig == $menu_tree[item].parent_id and $menu_tree[item].status ne 'disabled' and $menu_tree[item].level == 1}
		<a href="{$menu_tree[item].name}{if $sid}?sid={$sid}{/if}" class="w3-bar-item w3-button{if $menu_tree[item].status eq 'selected'} w3-light-grey{/if}">{$menu_tree[item].title}</a>
	{/if}
{/section}
</nav>
{/strip}
<!-- Header -->
<header class="w3-bar w3-top w3-hide-large w3-white">
<div class="w3-bar w3-wide">
<a href="/{if $sid}?sid={$sid}{/if}" class="w3-button">BLOG NAME</a>
<a href="javascript:void(0)" class="w3-button w3-right" onclick="w3Nav();">&equiv;&nbsp;{#LB_menu#}</a>
</div>
</header>
