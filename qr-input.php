<?php include 'src/partials/header.php'; ?>


<?php
/**
 * Created by PhpStorm.
 * User: jakubmatyka
 * Date: 08.10.15
 * Time: 16:18
 */
//
$tempFile = $_FILES['qrFile']['tmp_name'];

$imginfo_array = getimagesize($tempFile);

if ($imginfo_array !== false) {
    $mime_type = $imginfo_array['mime'];
    switch ($mime_type) {

        case "image/jpeg":
            require('lib/QrReader.php');
            $qrcode = new QrReader($_FILES['qrFile']['tmp_name']);
            $text = $qrcode->text();
            $qrcode_array = explode('|', $text);
            list($id, $signature, $amount, $issue_date, $maturity_date, $payment_date) = explode(' | ', $text);
            break;

        case "image/png":
            require('lib/QrReader.php');
            $qrcode = new QrReader($_FILES['qrFile']['tmp_name']);
            $text = $qrcode->text();
            $qrcode_array = explode('|', $text);
            list($id, $signature, $amount, $issue_date, $maturity_date, $payment_date) = explode(' | ', $text);
            break;

    }
} else {
    echo "This is not a valid image file";
}

?>

<form method="post" action="index.php" id="qr-form">
    <input type="hidden" name="signature" value="<?php echo $signature ?>">
    <input type="hidden" name="amount" value="<?php echo $amount ?>">
    <input type="hidden" name="issue_date" value="<?php echo $issue_date ?>">
    <input type="hidden" name="maturity_date" value="<?php echo $maturity_date ?>">
    <input type="hidden" name="payment_date" value="<?php echo $payment_date ?>">
    <button type="submit"> Zapisz</button>
</form>


<?php include 'src/partials/footer.php'; ?>
