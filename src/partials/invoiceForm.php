<?php

require_once __DIR__ . '/../Model/InvoiceClass.php';
require_once __DIR__ . '/../functions/select.php';

function invoiceForm()
{



    if (@$_GET['edit'] && (int)$_GET['edit']) {
        $edit = (int)$_GET['edit'];
        $invoice = new InvoiceClass($edit);
    } elseif (@$_GET['delete'] && (int)$_GET['delete']) {
        $delete_entry = (int)$_GET['delete'];
        $invoice = new InvoiceClass();
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
                $success = 'Brawo! Pomyślnie zapisano do bazy';
                $invoice = new InvoiceClass();
            } else if ($upload == InvoiceClass::SAVE_ERROR_DUPLICATE_SIG) {
                $error['signature'] = 'Faktura o tym numerze już istnieje.';
            } else {
                $error['general'] = 'Błąd zapisu do bazy danych.';
            }
        }

    }

    $output = '';
    ob_start(); ?>

    <h1 class="page-header">Payments</h1>

    <?php if (@$success) { ?>
    <div style="color:#22aa22; font-weight:bold;"><?=$success?></div><br/>
    <?php } ?>

    <?php if (@$error['general']) { ?>
    <div style="color:#f00; font-weight:bold;"><?=$error['general']?></div><br/>
    <?php } ?>

    <form action="?" method="post" class="form-horizontal" >

        <input name="id" type="hidden" value="<?=@$invoice->id?>"/><br>
        <input name="signature_id" type="hidden" value="<?=@$invoice->signature_id?>"/><br>


    <?php
    $output .= ob_get_clean();


//    ----------------- POCZĄTEK FORMULARZA ---------------------------------------------


    $output .= '<input name="id" type="hidden" value="' . @$invoice->id . '"/><br>';
    $output .= '<input name="signature_id" type="hidden" value="' . @$invoice->signature_id . '"/><br>';


    $output .= renderSelectInput($invoice->signature_id);

    $output .= 'Numer faktury: <input name="signature" value="' . @$invoice->signature . '"/><br><div style="color:#f00;">' . @$error['signature'] . '</div>';
    $output .= 'Kwota: <input name="amount" value="' . @$invoice->amount . '" /><br><div style="color:#f00;">' . @$error['amount'] . '</div>';
    $output .= 'Data wystawienia: <input name="issue_date" type="date" value="' . @$invoice->issue_date . '" /><br><div style="color:#f00;">' . @$error['issue_date'] . '</div>';
    $output .= 'Data płatności: <input name="maturity_date" type="date" value="' . @$invoice->maturity_date . '" /><br><div style="color:#f00;">' . @$error['maturity_date'] . '</div>';
    $output .= 'Data opłacenia: <input name="payment_date" type="date" value="' . @$invoice->payment_date . '" /><br>';

    $output .= (@$invoice->id ?
        (
            '<button id="btn_send">' . 'ZACHOWAJ ZMIANY' . '</button>' .
            '<button id="btn_send" name="create_new_record">' . 'ZACHOWAJ JAKO NOWY' . '</button>'

        ) :
        '<button id="btn_send">' . 'DODAJ NOWY' . '</button>');
    $output .= '</form>';

    return $output;
}
