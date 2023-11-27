{section name=item loop=$news_list}
  <div class="w3-margin-bottom w3-round-large w3-white"> 
  <div id="news{$news_list[item].id}" >
  {$news_list[item].message}
  <a href="javascript:toggle('descr{$news_list[item].id}', -1);" class="w3-bar-item w3-button w3-white w3-padding w3-margin w3-border">Read more / Close</a>
  </div></div>
{sectionelse}
...
{/section}
