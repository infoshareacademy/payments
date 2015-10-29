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

    <!--    KOMUNIKATY O BŁĘDACH -->

    <?php if (@$success) { ?>
    <div style="color:#22aa22; font-weight:bold;"><?= $success ?></div><br/>
<?php } ?>

    <?php if (@$error['general']) { ?>
    <div style="color:#f00; font-weight:bold;"><?= $error['general'] ?></div><br/>
<?php } ?>

    <!--    POCZĄTEK FORMULARZA Z FAKTURAMI -->

    <form action="?" method="post" class="form-horizontal">
        <fieldset>
            <legend>Payments form</legend>

            <input name="id" type="hidden" value="<?= @$invoice->id ?>"/>
            <input name="signature_id" type="hidden" value="<?= @$invoice->signature_id ?>"/>
            <input name="id" type="hidden" value="<?= @$invoice->id ?>"/>
            <input name="signature_id" type="hidden" value="<?= @$invoice->signature_id ?>"/>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="inputEmail">Company name:</label>

                <div class="col-sm-4">
                    <select class="form-control">
                        <option value="" disabled selected>Select company</option>
                        <?php $data = selectData($invoice->signature_id);
                        foreach ($data as $option) {
                            ?>
                            <option
                                value="<?= $option['value'] ?>" <?= ($option['isSelected'] ? 'selected' : '') ?>><?= $option['label'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="invoiceNumber">Invoice number:</label>

                <div class="col-sm-4">
                    <input class="form-control" name="signature" placeholder="Put invoice number"
                           value="<?= @$invoice->signature ?>"/>
                </div>
                <div style="color:#f00;"><?= @$error['signature'] ?></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="amount">Amount:</label>

                <div class="col-sm-4">

                    <input name="amount" class="form-control" placeholder="Put invoice amount"
                           value="<?= @$invoice->amount ?>"/>
                </div>
                <div style="color:#f00;"><?= @$error['amount'] ?></div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="IssueDate">Issue date:</label>
                <div class="col-sm-4">
                    <input name="issue_date" class="form-control" type="date" value="<?= @$invoice->issue_date ?>"/>
                    <div style="color:#f00;"><?= @$error['issue_date'] ?></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="MaturityDate">Maturity date:</label>
                <div class="col-sm-4">

          <input name="maturity_date" class="form-control" type="date" value="<?= @$invoice->maturity_date ?>"/>

            <div style="color:#f00;"><?= @$error['maturity_date'] ?></div>

                    </div>
                </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="PaymentDate">Payment date:</label>
                <div class="col-sm-4">
            <input name="payment_date" class="form-control" type="date" value="<?= @$invoice->payment_date ?>"/>
            </div>
                </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
            <?= (@$invoice->id ?
                (
                '<button class="btn btn-primary" id="btn_send">SAVE EDIT</button>
                <button id="btn_send" class="btn btn-success" name="create_new_record">SAVE AS NEW</button>'
                ) :
                '<button type="button" id="btn_send" class="btn btn-success">ADD NEW</but>'); ?>
                    </div>
                </div>
        </fieldset>
    </form>


    <?php
    $output .= ob_get_clean();

    return $output;
}
//  KONIEC FORMULARZA Z FAKTURAMI

