<?php
/**
 * Created by PhpStorm.
 * User: jakubmatyka
 * Date: 08.10.15
 * Time: 16:18
 */
include_once('./lib/QrReader.php');
$qrcode = new QrReader('QR/invoice_qr.png');
$text = $qrcode->text();

var_dump($text);

?>