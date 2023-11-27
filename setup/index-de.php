<!DOCTYPE html>
<html lang="de">
<head>
	<title>CMS. Einrichten.</title>
	<link rel="shortcut icon" href="../images/favicon.ico" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="../images/cms_core.js"></script>
<style>
#errMsg {display:block;font-size:14px;color:#f00;font-weight:bold;border:1px solid #aaa;background-color:#fff;padding:8px;border-radius:3px;-webkit-box-shadow:0 0 5px #888;box-shadow:0 0 5px #888;width:500px;}
#warnMsg {display:block;font-size:14px;color:#090;font-weight:bold;border:1px solid #aaa;background-color:#fff;padding:8px;border-radius:3px;-webkit-box-shadow:0 0 5px #888;box-shadow:0 0 5px #888;width:500px;}
input, select, textarea {font-size:14px;color:#000;background-color:#fff;
border-top:1px solid #999;border-left:1px solid #999;border-bottom:1px solid #666;border-right:1px solid #666;margin:3px;padding:5px;border-radius:3px;}
.btnB {padding:10px 5px;}
.btnT {float:right;}
.spacer {height:8px;clear:both;font-size:8px;}
input.bcss {background-color:#5e94ff;border:1px solid #666;color:#fff;cursor:pointer;font-size:14px;margin:1px;outline-style:none;outline-width:0;padding:5px 10px;border-radius:3px;}
span.brbcss {display:inline-block;margin:5px;}
input.bcss:hover {background-color:#999;}
input[type="radio"], input[type="checkbox"] {-webkit-appearance:checkbox; -moz-appearance:checkbox;}
</style>
</head>
<body style="font-family:Arial,Helvetica,sans-serif;font-size:14px;margin:0;padding:20px;color:#666;background-image:linear-gradient(to bottom, #fdfdfd, #ddd);">
<?php
ini_set('default_charset','utf-8');

include '../cms/modules/functions.php';
include '../cms/modules/user/func_user.php';

chdir('../');
$def_dir = getcwd();

$constants = array('www_dir' => '', 'db_prefix' => '', 'db_filename' => '');

$dbini = array('site_usr' => '', 'site_pwd' => '', 'site_url' => '', 'site_alias' => '', 'site_title' => '', 'site_description' => '', 
    'site_keywords' => '', 'site_dir' => '', 'site_subdir' => '', 'email' => '', 'site_ver' => '', 'action' => '', 'web_server' => '');

// set default values
$constants['www_dir'] = $def_dir;
$dbini['site_dir'] = $def_dir;
$constants['db_prefix'] = 'cms';
$constants['db_filename'] = 'cms-db';
$dbini['site_url'] = 'https://'.$_SERVER['HTTP_HOST'];
$dbini['site_alias'] = 'https://www.'.$_SERVER['HTTP_HOST'];
$dbini['email'] = 'info@'.$_SERVER['HTTP_HOST'];
$dbini['site_usr'] = 'admin';
$dbini['site_pwd'] = 'admin';
$dbini['site_ver'] = 'v2.0';
$error_msg = '';
$warning_msg = '';
$f_cms = '';
$fa_site = '';
$fa_cms = '';
$fh_site = '';
$result = '';

$dir_what = array("a:\\", "A:\\", "b:\\", "B:\\", "c:\\", "C:\\", "d:\\", "D:\\", "e:\\", "E:\\", "f:\\", "F:\\", "g:\\", "G:\\", "\\");
$dir_with = "/";

// get values
foreach ($constants as $var => $param) {
	if(!empty($_POST[$var])) {
		$$var = $_POST[$var]; 
	} else
		$$var = $param;
}
foreach ($dbini as $var => $param) {
	if(!empty($_POST[$var])) {
		$$var = $_POST[$var];
	} else
		$$var = $param;
}
// prepare dir name
if ($www_dir)
	$www_dir = str_replace($dir_what, $dir_with, $www_dir);

if ($action == 'run') $step = 1;
else $step = 0;

if ($step == 1) {
// step 1
if (!$www_dir || !$site_usr || !$site_pwd) {
	$error_msg = 'Nicht alle Pflichtfelder vom  Schritt 1 wurden ausgef&uuml;llt.';
} else {
	if (file_exists($www_dir.'/cms/data/'.$db_filename.'.sqlite'))
	$db_link = new SQLite3($www_dir.'/cms/data/'.$db_filename.'.sqlite') or die('Unable to open database '.$www_dir.'/cms/data/'.$db_filename.'.sqlite');
	$warning_msg .= 'Datenbank Konfiguration wurde erfolgreich gespeichert.';
	$step = 2;
}
// get template and replace variables
if(isset($_POST['site_pwd'])) $_POST['site_pwd'] = md5($_POST['site_pwd']);
}


// step 2
if ($step == 2) {
$site_dir = $www_dir;
if (!$site_url||!$site_alias||!$site_title||!$site_description||!$site_keywords||!$site_dir||!$email) {
	$error_msg .= '<br />Nicht alle Pflichtfelder vom Schritt 2 wurden ausgef&uuml;llt.';
} else {
	// get template and replace variables
	$sql_tpl = replaceContentWithValues(getContentFromPath($www_dir.'/setup/setup-db-de.tpl'), $_POST);
	$sql_array = explode(';;', $sql_tpl);
	//print_r($sql_array);
	for ($i = 0; $i < sizeof($sql_array); $i ++) {
		if (trim($sql_array[$i])) {
			$result = $db_link->query($sql_array[$i]);
			$result->finalize();
		}
		if (!$result)
			$error_msg .= '<br />Fehlerhafte Abfrage: '.$i.' '.$db_link->lastErrorMsg().'<p><textarea cols="80" rows="5">'.$sql_array[$i].'</textarea></p>';
	}
	if (!$error_msg) $warning_msg .= '<br />Konfiguration der Webseite wurde erfolgreich gespeichert.';
	$step = 3;
}
}


// step 3
if ($step == 3) {
if (!$web_server) {
	$error_msg .= '<br />Nicht alle Pflichtfelder vom Schritt 3 wurden ausgef&uuml;llt.';
} else {
	// try to save configurations
	$conf_2 = $www_dir.'/cms/modules/constants.php';
	$conf_3 = $www_dir.'/.htaccess';
	$conf_4 = $www_dir.'/cms/.htaccess';
	$conf_5 = $www_dir.'/cms/.htpasswd';
	$result = (file_exists($conf_2)) ? (true) : (false);
	$f_cms = replaceContentWithValues(getContentFromPath($www_dir.'/setup/constants-cms.tpl'), $_POST);
	$fa_site = replaceContentWithValues(getContentFromPath($www_dir.'/setup/htaccess-site.tpl'), $_POST);
	$fa_cms = replaceContentWithValues(getContentFromPath($www_dir.'/setup/htaccess-cms.tpl'), $_POST);
	if ($result) {
		if ($fd2 = fopen($conf_2, 'w')) {
			//print $file_path;
			if (fwrite($fd2, $f_cms) === FALSE)
				$error_msg .= '<br />Datei '.$conf_2.' kann nicht ueberschrieben werden. ';
			else
				$warning_msg .= '<br />Datei '.$conf_2.' wurde erfolgreich aktualisiert. ';
			fclose($fd2);
		}
		if ($fd3 = fopen($conf_3, 'w')) {
			//print $file_path;
			if (fwrite($fd3, $fa_site) === FALSE)
				$error_msg .= '<br />Datei '.$conf_3.' kann nicht ueberschrieben werden. ';
			else
				$warning_msg .= '<br />Datei '.$conf_3.' wurde erfolgreich aktualisiert. ';
			fclose($fd3);
		}
		if ($fd4 = fopen($conf_4, 'w')) {
			//print $file_path;
			if (fwrite($fd4, $fa_cms) === FALSE)
				$error_msg .= '<br />Datei '.$conf_4.' kann nicht ueberschrieben werden. ';
			else
				$warning_msg .= '<br />Datei '.$conf_4.' wurde erfolgreich aktualisiert. ';
			fclose($fd4);
		}
		if ($fd5 = fopen($conf_5, 'w')) {
			// create password md5
			//$fa_pwd .= $site_usr.":".crypt($site_pwd,'$12$_r1.cms$')."\n";
			// ot create standard
			$fa_pwd = $site_usr.":".crypt($site_pwd, 'c2')."\n";
			// save
			if (fwrite($fd5, $fa_pwd) === FALSE)
				$error_msg .= '<br />Datei '.$conf_5.' kann nicht ueberschrieben werden. ';
			else 
				$warning_msg .= '<br />Datei '.$conf_5.' wurde erfolgreich aktualisiert. ';
			fclose($fd5);
		}
	}
}
$fh_site = replaceContentWithValues(getContentFromPath($www_dir.'/setup/lighttpd.conf.tpl'), $_POST);
}

if (isset($db_link)) $db_link->close();

?>
<h3>CMS Setup</h3>
<?php
if ($warning_msg) echo '<p id="warnMsg">'.$warning_msg.'</p>';
if ($error_msg) echo '<p id="errMsg">'.$error_msg.'</p>';
?>
<form method="post" action="index-de.php" style="margin:0; padding:0">
<div id="searchPanel" class="content">
<h3>1. Datenbank konfigurieren</h3>
    <table border="0">
      <tr>
        <td width="180"> Benutzername <span style="color:#FF0000">*</span>:</td>
        <td>
          <input name="site_usr" type="text" value="<?php echo $site_usr; ?>" size="40" maxlength="255" required />
          (Administrator) </td>
      </tr>
      <tr>
        <td width="180"> Passwort <span style="color:#FF0000">*</span>:</td>
        <td>
          <input name="site_pwd" type="text" value="<?php echo $site_pwd; ?>" size="40" maxlength="255" required />
          (password) </td>
      </tr>
      <tr>
        <td width="180">Home Dir <span style="color:#FF0000">*</span>:</td>
        <td>
          <input name="www_dir" type="text" value="<?php echo $www_dir; ?>" size="40" maxlength="255" required />
          (/home/domain/htdocs/subdir)</td>
      </tr>
      <tr>
        <td> Unterordner separat:</td>
        <td>
          <input name="site_subdir" type="text" value="<?php echo $site_subdir; ?>" size="40" maxlength="255" />
          (subdir) </td>
      </tr>
    </table>

    <input type="hidden" name="site_ver" value="<?php echo $site_ver; ?>" />
    <input type="hidden" name="db_filename" value="<?php echo $db_filename; ?>" />

<h3>2. Website konfigurieren</h3>
    <table border="0">
      <tr>
        <td width="180"> URL <span style="color:#FF0000">*</span>:</td>
        <td>
          <input name="site_url" type="text" value="<?php echo $site_url; ?>" size="40" maxlength="255" required />
          (http://domain) </td>
      </tr>
      <tr>
        <td width="180"> ALIAS <span style="color:#FF0000">*</span>:</td>
        <td>
          <input name="site_alias" type="text" value="<?php echo $site_alias; ?>" size="40" maxlength="255" required />
          (http://www.domain) </td>
      </tr>
      <tr>
        <td width="180"> Titel <span style="color:#FF0000">*</span>:</td>
        <td>
          <input name="site_title" type="text" value="<?php echo $site_title; ?>" size="40" maxlength="255" required />
          (Titel) </td>
      </tr>
      <tr>
        <td width="180"> Beschreibung <span style="color:#FF0000">*</span>:</td>
        <td>
          <input name="site_description" type="text" value="<?php echo $site_description; ?>" size="40" maxlength="255" required />
          (Satz1, Satz2, ...) </td>
      </tr>
      <tr>
        <td width="180"> Schlüsselwörter <span style="color:#FF0000">*</span>:</td>
        <td>
          <input name="site_keywords" type="text" value="<?php echo $site_keywords; ?>" size="40" maxlength="255" required />
          (Wort1, Wort2, ...) </td>
      </tr>
      <tr>
        <td> Tabellenpräfix:</td>
        <td>
          <input name="db_prefix" type="text" value="<?php echo $db_prefix; ?>" size="40" maxlength="255" />
          (cms) </td>
      </tr>
      <tr>
        <td> System Post <span style="color:#FF0000">*</span>:</td>
        <td>
          <input name="email" type="text" value="<?php echo $email; ?>" size="40" maxlength="255" />
          (support@domain.de) </td>
      </tr>
      <tr>
        <td width="180"> Webserver <span style="color:#FF0000">*</span>:</td>
        <td>
	<label><input value="apache"<?php echo ($web_server == 'apache')?(' checked="checked"'):(''); ?> type="radio" name="web_server" onclick="javascript:toggle('s_apache',1);toggle('s_lighttpd',0);" />Apache</label> &nbsp; 
	<label><input value="lighttpd"<?php echo ($web_server == 'lighttpd')?(' checked="checked"'):(''); ?> type="radio" name="web_server" onclick="javascript:toggle('s_apache',0);toggle('s_lighttpd',1);" />lighttpd</label></td>
      </tr>
    </table>

<input type="hidden" name="action" value="run" />
<p class="brbcss"><input class="bcss" type="submit" value="Setup ausf&uuml;hren" /></p>


<h3>3. Webserver konfigurieren</h3>
	<div id="s_apache" style="display:none;">
	Setup wird versuchen, automatisch die Dateien zu aktualisieren. Ersetzen Sie bitte den Inhalt folgenden Dateien mit neu generierten Daten, falls die Fehlermeldung erscheint.
	<table border="0">
      <tr>
        <td>
          <?php if ($fa_site) echo '<strong>/.htaccess</strong><br /><textarea name="fa_site" cols="60" rows="10">'.$fa_site.'</textarea>'; ?>
        </td>
        <td>
          <?php if ($fa_cms) echo '<strong>/cms/.htaccess</strong><br /><textarea name="fa_cms" cols="60" rows="10">'.$fa_cms.'</textarea>'; ?>
        </td>
      </tr>
	</table>
	</div>
	<div id="s_lighttpd" style="display:none;">
	Ersetzen Sie bitte den Inhalt folgender Datei mit neu generierten Daten. Oder kopieren Sie die Datei setup/lighttpd.conf.tpl nach /etc/lighttpd/lighttpd.conf Ihres Webservers.
	<table border="0">
      <tr>
        <td>
          <?php if ($fh_site) echo '<strong>/etc/lighttpd/lighttpd.conf</strong><br /><textarea name="fh_site" cols="70" rows="10">'.$fh_site.'</textarea>'; ?>
        </td>
      </tr>
	</table>
	</div>
<?php if ($web_server == 'apache') echo '<script>toggle(\'s_apache\',1);</script>'; ?>
<?php if ($web_server == 'lighttpd') echo '<script>toggle(\'s_lighttpd\',1);</script>'; ?>

<h3>4. Konfiguration speichern</h3>
	Setup wird versuchen, automatisch die Dateien zu aktualisieren. Ersetzen Sie bitte den Inhalt folgenden Dateien mit neu generierten Daten, falls die Fehlermeldung erscheint.
	<table border="0">
      <tr>
        <td>
          <?php if ($f_cms) echo '<strong>/cms/modules/constants.php</strong><br /><textarea name="f_cms" cols="70" rows="10">'.$f_cms.'</textarea>'; ?>
        </td>
      </tr>
    </table>

</div>
</form>

<div id="searchPanel" class="content">
<h3>5. Login und Aufr&auml;umen</h3>
	Nach dem Login finden Sie einen Link &quot;Konfiguration&quot;, mit welchem Sie das CMS weiter anpassen k&ouml;nnen.
	<br />
	<form action="../cms/index.php" method="post" id="Login" target="_blank">
		<input name="action" id="action" type="hidden" value="login" />
        <table><tr><td>
        <p><strong>Verwaltungsseite:</strong></p>
		<table border="0" cellpadding="1" cellspacing="0">
		  <tr>
			<td>Benutzer:</td>
			<td><input name="nick" type="text" id="nick" value="<?php echo $site_usr;?>" size="12" maxlength="64" /></td>
		  </tr>
		  <tr>
			<td>Passwort:</td>
			<td><input name="pwd" id="pwd" type="text" size="12" maxlength="64" value="<?php echo $site_pwd;?>" /></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><span class="brbcss"><input class="bcss" type="submit" value="Login" /></span></td>
		  </tr>
		</table>
        </td>
        <td>&nbsp; &nbsp;</td>
        <td valign="top"><p><strong>Webseite:</strong></p><a href="<?php echo $site_url;?>" target="_blank"><?php echo $site_url;?></a></td>
        </tr></table>
	</form>
<h3 style="color:#dd0000">Wichtig: im Rootverzeichnis l&ouml;schen Sie bitte <strong>setup/</strong> Verzeichnis vollst&auml;ndig.</h3>

</div>
<p>&nbsp;</p>

</body>
</html>
