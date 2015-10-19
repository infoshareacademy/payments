<?php

require_once 'Model/InvoiceClass.php';

if (@$_GET['edit'] && (int)$_GET['edit']) {
    $edit = (int)$_GET['edit'];
    $invoice = new InvoiceClass($edit);
} elseif (@$_GET['delete'] && (int)$_GET['delete']) {
    $delete_entry = (int)$_GET['delete'];
} else {
    $invoice = new InvoiceClass();
}

$error = array();
if (count($_POST)) {
    $invoice = new InvoiceClass();

    $invoice->id = @$_POST['id'];

    $invoice->signature_id = @$_POST['signature_id'];

    $invoice->signature = @$_POST['signature'];
    if (!$invoice->signature) // if null
        $error['signature'] = 'Podaj nazwę faktury';

    $invoice->amount = @$_POST['amount'];
    if (!$invoice->amount)
        $error['amount'] = 'Podaj kwotę z faktury';

    $invoice->issue_date = @$_POST['issue_date'];
    if (!$invoice->issue_date)
        $error['issue_date'] = 'Podaj poprawną datę lub skorzystaj z kalendarza';

    $invoice->maturity_date = @$_POST['maturity_date'];
    if (!$invoice->maturity_date)
        $error['maturity_date'] = 'Podaj poprawną datę lub skorzystaj z kalendarza';

    $invoice->payment_date = @$_POST['payment_date'];

    if (!count($error)) {

        if (isset($_POST['create_new_record'])) {
            $invoice->id = null;
        }

        $upload = $invoice->save_to_db();
        if ($upload == InvoiceClass::SAVE_OK) {
            $success = 'Brawo! Dodałeś nowy rekord do bazy';
            $invoice = new InvoiceClass();
        } else if ($upload == InvoiceClass::SAVE_ERROR_DUPLICATE_SIG) {
            $error['signature'] = 'Faktura o tym numerze już istnieje.';
        } else {
            $error['general'] = 'Błąd zapisu do bazy danych.';
        }
    }

}

?>


<?php
if (@$success)
    echo '<div style="color:#22aa22; font-weight:bold;">' . $success . '</div><br/>';
if (@$error['general'])
    echo '<div style="color:#f00; font-weight:bold;">' . $error['general'] . '</div><br/>';

echo '<form action="?" method="post">';
echo '<div class ="form-group"><input name="id" type="hidden" value="' . @$invoice->id . '"/></div><br>';
echo '<input name="signature_id" type="hidden" value="' . @$invoice->signature_id . '"/><br>';

require_once('functions/select.php');
renderSelectInput($invoice->signature_id);

echo 'Numer faktury: <input name="signature" value="' . @$invoice->signature . '"/><br><div style="color:#f00;">' . @$error['signature'] . '</div>';
echo 'Kwota: <input name="amount" value="' . @$invoice->amount . '" /><br><div style="color:#f00;">' . @$error['amount'] . '</div>';
echo 'Data wystawienia: <input name="issue_date" type="date" value="' . @$invoice->issue_date . '" /><br><div style="color:#f00;">' . @$error['issue_date'] . '</div>';
echo 'Data płatności: <input name="maturity_date" type="date" value="' . @$invoice->maturity_date . '" /><br><div style="color:#f00;">' . @$error['maturity_date'] . '</div>';
echo 'Data opłacenia: <input name="payment_date" type="date" value="' . @$invoice->payment_date . '" /><br>';

echo  (@$invoice->id ?
        (
            '<button id="btn_send">' . 'ZACHOWAJ ZMIANY' . '</button>' .
            '<button id="btn_send" name="create_new_record">' . 'ZACHOWAJ JAKO NOWY' . '</button>'

        ) :
        '<button id="btn_send">' . 'DODAJ NOWY' . '</button>') ;
echo '</form>';

?>

