<?php
/* ==================================================== ##
##             COPYRIGHTS © Another CMS                 ##
## ==================================================== ##
## PRODUCT : CMS(CONTENT MANAGEMENT SYSTEM)             ##
## LICENSE : GNU(General Public License v.3)            ##
## TECHNOLOGIES : PHP & Sqlite                          ##
## WWW : www.zapms.de | www.marchenko.de                ##
## E-MAIL : andrey@marchenko.de                         ##
## ==================================================== */

//------------------------------------------------------------
function paypalShowOrder($ppl_url, $ppl_client_id, $ppl_client_secret, $txn_nr) {
	$out = array('txn_nr' => $txn_nr, 'status' => 'na' );
	$curl = curl_init($ppl_url.'/'.$txn_nr);
	$headers = array();
	$headers[] = 'Authorization: Basic '.base64_encode($ppl_client_id.':'.$ppl_client_secret);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_HTTPGET, true); // GET
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);
	//print_r($response);
	if (curl_errno($curl)) {
		curl_close ($curl);
		return $out;
	}
	if (!empty($response)) {
		$obj = json_decode($response, TRUE);
		if (!empty($obj['id']) && !empty($obj['status'])) $out['status'] = $obj['status'];
		if (!empty($obj['purchase_units'][0]['amount']['value'])) $out['total_price'] = $obj['purchase_units'][0]['amount']['value'];
	}
	curl_close ($curl);
	return $out;
}
//------------------------------------------------------------
function paypalCreateOrder($ppl_url, $ppl_client_id, $ppl_client_secret, $ppl_locale, $ppl_currency, $return_url, $cancel_url, $order_id, $total_price) {
	$out = array('txn_nr' => 'na', 'status' => 'na' );
	$postdata = '{ "intent":"CAPTURE", "purchase_units": [ { "reference_id":"'.$order_id.'", "amount": { "currency_code":"'.$ppl_currency.'", "value": "'.$total_price.'" } } ],';
	$postdata .= ' "payment_source": { "paypal": { "experience_context": { "payment_method_preference":"IMMEDIATE_PAYMENT_REQUIRED","payment_method_selected":"PAYPAL", "locale":"'.$ppl_locale.'",';
	$postdata .= ' "landing_page":"LOGIN", "user_action":"PAY_NOW", "return_url":"'.$return_url.'", "cancel_url":"'.$cancel_url.'" } } } }';
	//print_r($postdata); echo '<br>';
	$curl = curl_init($ppl_url);
	$headers = array();
	$headers[] = 'Content-Type: application/json';
	$headers[] = 'Authorization: Basic '.base64_encode($ppl_client_id.':'.$ppl_client_secret);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_POST, true); // POST
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
	$response = curl_exec($curl);
	//print_r($response);
	if (curl_errno($curl)) {
		curl_close ($curl);
		return $out;
	}
	if (!empty($response)) {
		$obj = json_decode($response, TRUE);
		if (!empty($obj['id']) && !empty($obj['status'])) {
			$out['txn_nr'] = $obj['id'];
			$out['status'] = $obj['status'];
		}
	}
	curl_close ($curl);
	return $out;
}
//------------------------------------------------------------
function paypalCaptureOrder($ppl_url, $ppl_client_id, $ppl_client_secret, $txn_nr) {
	$out = array('txn_nr' => $txn_nr, 'status' => 'na' );
	$postdata = '{}';
	$curl = curl_init($ppl_url.'/'.$txn_nr.'/capture');
	$headers = array();
	$headers[] = 'Content-Type: application/json';
	$headers[] = 'Authorization: Basic '.base64_encode($ppl_client_id.':'.$ppl_client_secret);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_POST, true); // POST
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
	$response = curl_exec($curl);
	//print_r($response);
	if (curl_errno($curl)) {
		curl_close ($curl);
		return $out;
	}
	if (!empty($response)) {
		$obj = json_decode($response, TRUE);
		if (!empty($obj['id']) && !empty($obj['status'])) $out['status'] = $obj['status'];
	}
	curl_close ($curl);
	return $out;
}

?>
