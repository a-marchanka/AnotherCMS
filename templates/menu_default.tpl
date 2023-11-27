<div class="w3-bar-block">
<a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu">{#LB_close#}</a>
{strip}

{section name=custom loop=$menu_tree}
{if $menu_tree[custom].name eq 'en'}
	{assign var="folder_id" value=$menu_tree[custom].id}
{/if}
{/section}

{if $sid}
  <a href="?sid={$sid}&action=logout" class="w3-bar-item w3-button w3-padding">&rsaquo; {#LB_logout#}</a>
{/if}

{section name=custom loop=$menu_tree}
{if $menu_tree[custom].parent_id == $folder_id and $menu_tree[custom].active == 1 and $menu_tree[custom].level == 1}
<a href="{$menu_tree[custom].name}{if $sid}?sid={$sid}{/if}" class="w3-bar-item w3-button w3-padding{if $menu_tree[custom].status eq 'selected'} w3-blue{/if}">{$menu_tree[custom].title}</a>
{/if}
{/section}

{/strip}

</div>

