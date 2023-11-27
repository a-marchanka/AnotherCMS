<div style="height:940px;margin:10px;border:0px solid #fff;">
<p>&nbsp;</p>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td>
<p style="font-size:10px;text-decoration:none;">{$cnt_firm} – {$cnt_address} – {$cnt_postcode} {$cnt_city}</p></td>
</tr>
<tr>
<td>{$cust_firm}<br>{$cust_title} {$cust_name} {$cust_surname}<br>{$cust_street}<br>{$cust_postcode} {$cust_city}<br>{$cust_country}</td>
</tr>
</tbody>
</table>
<p style="text-align:right;">Datum: {$current_date}<br>Bestellnummer: {$id}</p>
<p><b>Zahlungserinnerung</b></p>
<p>{$cust_reference},</p>
<p>sicherlich wurde die Zahlung der u.g. Rechnung übersehen, denn der Rechnungsbetrag ist bei uns noch nicht eingegangen.<br>
<br>Wir bitten Sie daher, u.g. Betrag in den nächsten Tagen zu überweisen. Bitte betrachten Sie dieses Schreiben als gegenstandslos, falls Sie zwischenzeitlich bereits eine Zahlung vorgenommen haben sollten.<br>
<br>Anbei erhalten Sie eine Kopie der noch offenen Rechnung. Bitte beachten Sie, dass diese Zahlungserinnerung nur per E-Mail versendet wird.</p>
<hr />
{$bill_receipt}
<hr />
<p>Vorsorglich nochmal unsere Bankverbindung:</p>
<blockquote>IBAN: {$cnt_iban}<br>BIC: {$cnt_bic}</blockquote>
<p>Verwendungszweck: <b>Nr. {$id}</b><br>Zu &uuml;berweisender Betrag: <b>{$bill_total_gross_str} &euro;</b></p>
<p>&nbsp;</p>
<p>Mit besten Grüßen<br>
{$cnt_firm}
</p>
</div>
<p>&nbsp;</p>
