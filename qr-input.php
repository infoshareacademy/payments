 <?php
/**
 * Created by PhpStorm.
 * User: jakubmatyka
 * Date: 08.10.15
 * Time: 16:18
 */

//print_r($_FILES);
 //move_uploaded_file($_FILES['qrFile']['tmp_name'], 'test.png');

 require('lib/QrReader.php');
 $qrcode = new QrReader($_FILES['qrFile']['tmp_name']);

 $text = $qrcode->text();
//
//print_r($text);
// exit;
// list($nip,$language,$accountNumber,$amount,$operator,$invoiceNumber)

 $qrcode_array = explode('|', $text.'<br/>');
 print_r($qrcode_array);


 echo $nip.'<br/>';
 echo $language.'<br/>';
 echo $accountNumber.'<br/>';
 echo $amount.'<br/>';
 echo $operator.'<br/>';
 echo $invoiceNumber.'<br/>';

?>
