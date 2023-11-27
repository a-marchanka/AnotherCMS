<?php
/* ================================================= ##
##             COPYRIGHTS © Another CMS              ##
## ================================================= ##
## PRODUCT : CMS(CONTENT MANAGEMENT SYSTEM)          ##
## LICENSE : GNU(General Public License v.3)         ##
## TECHNOLOGIES : PHP & Sqlite                       ##
## WWW : www.zapms.de | www.marchenko.de             ##
## E-MAIL : andrey@marchenko.de                      ##
## ================================================= */

// info
$valide = 0;

$uid_total = $_POST['uid_total']; if (!is_numeric($uid_total)) $uid_total = 0; // total products
// verify
for ($i = 0; $i < $uid_total; $i ++) {
	$var_id = 'id_'.$i;
	$var_title = 'title_'.$i;
	$var_cnt = 'cnt_'.$i;
	$var_price = 'pr_'.$i;
	$var_cnt1 = 'cnt_1_'.$i;
	$var_price1 = 'pr_1_'.$i;
	$var_cnt2 = 'cnt_2_'.$i;
	$var_price2 = 'pr_2_'.$i;
	$var_cnt3 = 'cnt_3_'.$i;
	$var_price3 = 'pr_3_'.$i;
	$var_status = 'st_'.$i;
	// -----------
	$id = $_POST[$var_id];
	$cnt = $_POST[$var_cnt]; if (!is_numeric($cnt)) $cnt = 0;
	$price = $_POST[$var_price]; if (!is_numeric($price)) $price = 0;
	$cnt1 = $_POST[$var_cnt1]; if (!is_numeric($cnt1) || empty($cnt1)) $cnt1 = $cnt;
	$price1 = $_POST[$var_price1]; if (!is_numeric($price1) || empty($price1)) $price1 = $price;
	$cnt2 = $_POST[$var_cnt2]; if (!is_numeric($cnt2) || empty($cnt2)) $cnt2 = $cnt1;
	$price2 = $_POST[$var_price2]; if (!is_numeric($price2) || empty($price2)) $price2 = $price1;
	$cnt3 = $_POST[$var_cnt3]; if (!is_numeric($cnt3) || empty($cnt3)) $cnt3 = $cnt2;
	$price3 = $_POST[$var_price3]; if (!is_numeric($price3) || empty($price3)) $price3 = $price2;
	$status = $_POST[$var_status];
	$title = htmlEncode($_POST[$var_title]);
	// -----------
	$indx ++;
	$out_var = array_pad($out_var, $indx, array(
		'id' => $id,
		'title' => $title,
		'amount' => $cnt,
		'price' => $price,
		'amount_1' => $cnt1,
		'price_1' => $price1,
		'amount_2' => $cnt2,
		'price_2' => $price2,
		'amount_3' => $cnt3,
		'price_3' => $price3,
		'status' => $status ));
	$in_db_var = array_pad($in_db_var, $indx, array(
		'id' => $id,
		'amount' => $cnt,
		'price' => $price,
		'amount_1' => $cnt1,
		'price_1' => $price1,
		'amount_2' => $cnt2,
		'price_2' => $price2,
		'amount_3' => $cnt3,
		'price_3' => $price3,
		'status' => $status,
		'modifytime' => time() ));
	$valide = 1;
}
//print $details_id;
if ($valide == 1) {
	for ($i = 0; $i < sizeof($in_db_var); $i ++) {
		if (productUpdate(DB_PREFIX, $db_link, $in_db_var[$i]['id'], $in_db_var[$i])) {
			$warning_msg .= $in_db_var[$i]['id'].' '.$SYS_WARN_MSG['updated'].'<br>';
			$success = ($subaction == 'save_close_prices')?(2):(1);
		} else
			$error_msg .= $in_db_var[$i]['id'].' '.$SYS_WARN_MSG['notupdated'].'<br>';
	}
} else
	$error_msg .= $validate_array['error_msg'];

if ($details_id) $in_var['id'] = $details_id;

//print_r($out_var);
assignArray($out_var, 'items_list');

?>
