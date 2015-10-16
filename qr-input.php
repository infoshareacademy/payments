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
    break;

   case "image/png":
    require('lib/QrReader.php');
    $qrcode = new QrReader($_FILES['qrFile']['tmp_name']);
    $text = $qrcode->text();
    $qrcode_array = explode('|', $text.'<br/>');
    list($id,$signature,$amount,$issue_date,$maturity_date,$payment_date) = explode('|', $text.'<br/>');
    print_r($maturity_date);

    break;
//    id=76&signature_id=6&signature=PGNIG%2F9&amount=41.00&issue_date=2015-11-01&maturity_date=2015-11-22&payment_date=2015-10-23


  }
 }
 else {
  echo "This is not a valid image file";
 }

?>

 <html>
 <body>
 <form method="post" action="invoices.php" id="qr-form">
  <input type="hidden" name="signature_id" value="<?php echo $signature ?>">
  <input type="hidden" name="amount_id" value="<?php echo $amount ?>">
  <input type="hidden" name="issue_date_id" value="<?php echo $issue_date ?>">
  <input type="hidden" name="maturity_date_id" value="<?php echo $maturity_date ?>">
  <input type="hidden" name="payment_date_id" value="<?php echo $payment_date ?>">
 </form>
 <script language="JavaScript">
  document.getElementById("qr-form").submit();
 </script>
 </body>
 </html>
