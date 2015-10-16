 <?php
/**
 * Created by PhpStorm.
 * User: jakubmatyka
 * Date: 08.10.15
 * Time: 16:18
 */
 //
 $tempFile =  $_FILES['qrFile']['tmp_name'];

 $imginfo_array = getimagesize($tempFile);

 if ($imginfo_array !== false) {
  $mime_type = $imginfo_array['mime'];
  switch($mime_type) {

   case "image/jpeg":
    require('lib/QrReader.php');
    $qrcode = new QrReader($_FILES['qrFile']['tmp_name']);
    $text = $qrcode->text();
    $qrcode_array = explode('|', $text.'<br/>');
    list($id,$signature,$amount,$issue_date,$maturity_date,$payment_date) = explode('|', $text.'<br/>');
    echo $id.'<br/>';
    echo $signature.'<br/>';
    echo $amount.'<br/>';
    echo $issue_date.'<br/>';
    echo $maturity_date.'<br/>';
    echo $payment_date.'<br/>';
    break;

   case "image/png":
    require('lib/QrReader.php');
    $qrcode = new QrReader($_FILES['qrFile']['tmp_name']);
    $text = $qrcode->text();
    $qrcode_array = explode('|', $text.'<br/>');
    list($id,$signature,$amount,$issue_date,$maturity_date,$payment_date) = explode('|', $text.'<br/>');
    echo $id.'<br/>';
    echo $signature.'<br/>';
    echo $amount.'<br/>';
    echo $issue_date.'<br/>';
    echo $maturity_date.'<br/>';
    echo $payment_date.'<br/>';
    break;

  }
 }
 else {
  echo "This is not a valid image file";
 }

?>
