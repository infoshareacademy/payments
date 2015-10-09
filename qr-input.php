<?php
/**
 * Created by PhpStorm.
 * User: jakubmatyka
 * Date: 08.10.15
 * Time: 16:18
 */
include_once('./lib/QrReader.php');
$qrcode = new QrReader('/home/jakubmatyka/Desktop/Screenshot from 2015-10-09 15:30:13.png');
$text = $qrcode->text();

var_dump($text);

?>