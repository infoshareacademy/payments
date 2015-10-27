<?php

function invoiceImport() {
    $output = '';

    $output .= '<form action="qr-input.php" method="post" enctype="multipart/form-data">';
    $output .= '<input type="file" name="qrFile"/><br/>';
    $output .= '<input type="submit" value="send"/>';
    $output .= '</form>';

    return $output;
}