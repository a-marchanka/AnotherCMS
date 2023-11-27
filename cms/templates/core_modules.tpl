<div class="w3-bar">
{section name=customer loop=$modules_list}
{if $modules_list[customer].is_child eq '1'}
<div class="w3-quarter w3-margin-bottom w3-large" style="min-width:230px;">
<a href="?entry_id={$modules_list[customer].entry_id}&amp;{$SID}" id="i50_{$modules_list[customer].entry_prefix}" class="i50 w3-left"></a>
<a href="?entry_id={$modules_list[customer].entry_id}&amp;{$SID}" class="w3-button w3-hover-none w3-border-white w3-clear">{$modules_list[customer].entry_title}</a>
</div>
{/if}
{/section}
</div>
