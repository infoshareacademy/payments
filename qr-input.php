<?php
/**
 * Created by PhpStorm.
 * User: jakubmatyka
 * Date: 08.10.15
 * Time: 16:18
 */
require('lib/QrReader.php');
$qrcode = new QrReader('QR/invoice_qr.png');
$text = $qrcode->text();

//var_dump($text);

list($nip,$language,$accountNumber,$amount,$operator,$invoiceNumber) = explode('|', $text.'<br/>');

echo $nip.'<br/>';
echo $language.'<br/>';
echo $accountNumber.'<br/>';
echo $amount.'<br/>';
echo $operator.'<br/>';
echo $invoiceNumber.'<br/>';

?>