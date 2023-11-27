<?php
/* ==================================================== ##
##             COPYRIGHTS © Another CMS PHP TEAM        ##
## ==================================================== ##
## PRODUCT : CMS(CONTENT MANAGEMENT SYSTEM)             ##
## LICENSE : GNU(General Public License v.3)            ##
## TECHNOLOGIES : PHP & Sqlite                          ##
## WWW : www.zapms.de | www.marchenko.de                ##
## E-MAIL : andrey@marchenko.de                         ##
## ==================================================== */

ini_set('default_charset','utf-8');

include 'cms/modules/constants.php';

//------------------------------------------------------------
// data base
$db_file = CMS_DIR.'data/cms-db.sqlite';
// open
if (strpos($db_file, '.sqlite') !== false && file_exists($db_file)) {
	$db_link = new SQLite3($db_file);
	$db_link->busyTimeout(8000);
} else {
	die('Unable to open database '.$db_file);
}
//------------------------------------------------------------
// include CONFIG
include 'modules/config/func_config.php';
$cfg_global = configGetInfo(DB_PREFIX, $db_link, 1, 'site_url');
// close DB
$db_link->close();
unset($db_link);

$content_str = '';
$content_str .= "User-agent: Yisouspider"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: Bytespider"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: PetalBot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: 360Spider"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: adscanner"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: Mail.RU"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: Baiduspider"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: SeznamBot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: Sogou web spider"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: Sogou inst spider"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: BLEXBot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: DotBot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: aiHitBot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: netEstate NE Crawler"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: CCBot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: TurnitinBot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: Cliqzbot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: Exabot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: Scrapy"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: Barkrowler"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: MJ12bot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: AhrefsBot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: dotbot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: SemrushBot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: SEOkicks"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: MixrankBot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: DataForSeoBot"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: YaK"."\n";
$content_str .= "Disallow: /"."\n";
$content_str .= "User-agent: bingbot"."\n";
$content_str .= "Crawl-delay: 1"."\n";
$content_str .= "User-agent: YandexBot"."\n";
$content_str .= "Crawl-delay: 1"."\n";

$content_str .= "User-agent: *"."\n";
$content_str .= "Disallow: /libs/"."\n";
$content_str .= "Disallow: /modules/"."\n";
$content_str .= "Disallow: /cms/"."\n";
$content_str .= "Disallow: /content/images/originals/"."\n";

$content_str .= "Sitemap: ".$cfg_global['site_url']."/sitemap.xml"."\n";

header('Content-Type: text/plain');
header('Content-Disposition: inline; filename="robots.txt"');
header('Content-Length: '.strlen($content_str));
echo $content_str;

// unset variables
unset($cfg_global);
unset($content_str);

?>
