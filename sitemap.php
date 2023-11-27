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
// include MENU
include 'modules/menu/func_menu.php';
// include GALERY
include 'modules/galery/func_galery.php';

$sitemap_str = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$sitemap_str.= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"";
$sitemap_str.= " xmlns:image=\"http://www.google.com/schemas/sitemap-image/1.1\"";
$sitemap_str.= " xmlns:video=\"http://www.google.com/schemas/sitemap-video/1.1\">\n";

// get config
$cfg_global = configGetInfo(DB_PREFIX, $db_link, 1);
// get menu
$menu_array = menuGetAll(DB_PREFIX, $db_link);
// loop menu
foreach ($menu_array as $key => $m_array) {
	if ($m_array['active'] == 1 && empty($m_array['role_ids']) && ($m_array['content_type'] == 'static' || $m_array['content_type'] == 'module')) {
		$sitemap_str.= "<url>\n";
		$sitemap_str.= "<loc>".$cfg_global['site_url']."/".$m_array['name']."</loc>\n";
		$sitemap_str.= "<lastmod>".date('Y-m-d', $m_array['modifytime'])."</lastmod>\n";
		$sitemap_str.= "<changefreq>weekly</changefreq>\n";
		// get image
		$img_array = galeryGetByMenu(DB_PREFIX, $db_link, $m_array['id']);
		//print_r($img_array);
		foreach ($img_array as $k => $i_array) {
			if (strpos($i_array['filepath'], 'images') !== false) {
			$sitemap_str.= "<image:image>\n";
			$sitemap_str.= " <image:loc>".$cfg_global['site_url']."/".$i_array['filepath'].$i_array['filename']."</image:loc>\n";
			$sitemap_str.= "</image:image>\n";
			}
			if (strpos($i_array['filepath'], 'video') !== false) {
			$sitemap_str.= "<video:video>\n";
			$sitemap_str.= " <video:title>".$i_array['filename']."</video:title>\n";
			$sitemap_str.= " <video:content_loc>".$cfg_global['site_url']."/".$i_array['filepath'].$i_array['filename']."</video:content_loc>\n";
			$sitemap_str.= "</video:video>\n";
			}
		}
		$sitemap_str.= "</url>\n";
	}
}
$sitemap_str.= "</urlset>";

$db_link->close();

header('Content-Type: application/xml');
header('Content-Disposition: inline; filename="sitemap.xml"');
header('Content-Length: '.strlen($sitemap_str));
echo $sitemap_str;

// unset variables
unset($db_link);
unset($cfg_global);
unset($menu_array);
unset($img_array);
unset($sitemap_str);

?>
