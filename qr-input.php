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


 list($nip,$language,$accountNumber,$amount,$operator,$invoiceNumber) = explode('|', $text.'<br/>');


 echo $nip.'<br/>';
 echo $language.'<br/>';
 echo $accountNumber.'<br/>';
 echo $amount.'<br/>';
 echo $operator.'<br/>';
 echo $invoiceNumber.'<br/>';

?>
