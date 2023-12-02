{assign var='yyyy' value=1970}
{assign var='mm' value=13}
<h1>{$entry_title}</h1>
{section name=item loop=$news_list}
    {if $mm!=$news_list[item].time_month}
    {assign var='mm' value=$news_list[item].time_month}
    <div class="w3-center w3-text-dark-grey"><h3>{$news_list[item].time_month}/{$news_list[item].time_year}</h3></div>
    {/if}
    <div class="w3-panel w3-light-green w3-round-medium w3-hover-light-grey" onclick="toggle('news{$news_list[item].id}',-1);" style="cursor:pointer;"><h4>{$news_list[item].title_short}</h4></div>
    <div id="news{$news_list[item].id}" style="display:none;" class="w3-container w3-border-left">
    {$news_list[item].message}
    </div>
{sectionelse}
no events
{/section}
