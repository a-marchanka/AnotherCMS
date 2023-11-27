<?php
// -----------------------------------
// File: /cms/modules/constants.php
// -----------------------------------

define('WWW_DIR', '/home/zbook/html/');
define('CMS_DIR', WWW_DIR.'cms/');

// dir for session info, permissions: 0777
define('SESS_DIR', CMS_DIR.'auth/');

// data base table prefix
define('DB_PREFIX', 'cms_');

date_default_timezone_set('Europe/Berlin');

?>
