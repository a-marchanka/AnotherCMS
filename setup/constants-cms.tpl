<?php
// -----------------------------------
// File: /cms/modules/constants.php
// -----------------------------------

define('WWW_DIR', '{$www_dir}/');
define('CMS_DIR', WWW_DIR.'cms/');

// dir for session info, permissions: 0777
define('SESS_DIR', CMS_DIR.'auth/');

// data base table prefix
define('DB_PREFIX', '{$db_prefix}_');

date_default_timezone_set('Europe/Berlin');

?>
