<nav id="dtreeSidebar" class="w3-sidebar w3-collapse w3-border-right w3-light-grey" style="z-index:3;width:230px;">
<p class="w3-container w3-hide-small w3-hide-medium">{#LB_user#}: {$user_info.nick}</p>
<div class="w3-bar-block">
<a href="#" class="w3-bar-item w3-button w3-padding w3-hide-large w3-hover-dark-grey w3-blue-grey" onclick="dtreeSidebar()" title="{#LB_close#}" style="width:inherit;"><i class="i20_nolines_minus"></i>&nbsp; {#LB_close#}</a>
{section name=custom loop=$dtree_list}
<a href="?entry_id={$dtree_list[custom].entry_id}&amp;{$SID}" class="w3-bar-item w3-button w3-padding{if $dtree_list[custom].entry_id eq $entry_id} w3-theme{/if}" style="width:inherit;"><i class="{$dtree_list[custom].entry_icon}"></i>&nbsp; {$dtree_list[custom].entry_title}</a>
{sectionelse}
<a href="?entry_id=1&amp;{$SID}" class="w3-bar-item w3-button w3-padding" style="width:inherit;"><i class="i20_base"></i>&nbsp; Home</a>
<a href="?entry_id=15&amp;{$SID}" class="w3-bar-item w3-button w3-padding" style="width:inherit;"><i class="i20_logout"></i>&nbsp; Logout</a>
{/section}
</div>
</nav>
