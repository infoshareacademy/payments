<?php
/**
 * Created by PhpStorm.
 * User: jakubmatyka
 * Date: 08.10.15
 * Time: 16:18
 */


define("UPLOAD_DIR", "uploads/");

if (!empty($_FILES["qrFile"])) {

    $qrFile = $_FILES["qrFile"];

    if ($qrFile["error"] !== UPLOAD_ERR_OK) {
        echo "<p>An error occurred.</p>";
        exit;
    }

    // ensure a safe filename
    $name = preg_replace("/[^A-Z0-9._-]/i", "_", $qrFile["name"]);

    // don't overwrite an existing file
    $i = 0;
    $parts = pathinfo($name);
    while (file_exists(UPLOAD_DIR . $name)) {
        $i++;
        $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
    }
    // preserve file from temporary directory
    $success = move_uploaded_file($qrFile["tmp_name"],
        UPLOAD_DIR . $name);
    if (!$success) {
        echo "<p>Unable to save file.</p>";
        exit;
    }

    // set proper permissions on the new file
    chmod(UPLOAD_DIR . $name, 0644);

    require('lib/QrReader.php');
    $qrcode = new QrReader(UPLOAD_DIR . $name);
    $text = $qrcode->text();

//var_dump($text);
    print_r($text);

    list($nip,$language,$accountNumber,$amount,$operator,$invoiceNumber) = explode('|', $text.'<br/>');


    echo $nip.'<br/>';
    echo $language.'<br/>';
    echo $accountNumber.'<br/>';
    echo $amount.'<br/>';
    echo $operator.'<br/>';
    echo $invoiceNumber.'<br/>';

}

?>
