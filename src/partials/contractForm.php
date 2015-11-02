<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 2015-10-17
 * Time: 22:28
 */
require_once __DIR__ . '/../Model/ContractClass.php';
require_once __DIR__ . '/../functions/uploadPDF.php';


function contractForm()
{
    $output = '';


    if (@$_GET['edit'] && (int)$_GET['edit']) {
        $edit = (int)$_GET['edit'];
        $contract = new ContractClass($edit);
    } else {
        $contract = new ContractClass();
    }
    error_reporting(0);
    if (isset($_GET['delete']) and is_numeric($_GET['delete'])) {
        $pdo = DBHandler::getPDO();
        $stmt = $pdo->prepare("DELETE FROM contract WHERE id =:id");
        $stmt->bindParam(':id', $_GET['delete'], PDO::PARAM_STR);
        $delete = $pdo->exec(@$stmt);
        $output .= '<br><div style="color:#f00;">Contract deleted successfully</div><br/>';
    }
    if (isset($_GET['view_file']) and is_numeric($_GET['view_file'])) {
        $pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');
        $stmt = $pdo->query("Select fileName FROM contract WHERE id =" . $_GET['view_file']);
        $report = $pdo->exec(@$stmt);
        $output .= '<br><div style="color:#f00;">Widzisz teraz plik</div><br/>';
    }

    $error = array();
    if (count($_POST)) {
        $contract = new ContractClass();
        $contract->signature = @$_POST['signature'];
        $contract->companyName = @$_POST['companyName'];
        $hash = uniqid(@$_POST['fileName'] . '-' . rand(0, 99999));
        $contract-> fileName = $hash . @$_POST['fileName'] . '.pdf';

        if (!$contract->signature) // if null
            $error['signature'] = 'Contract number cannot be empty';
        if (!$contract->companyName) // if null
            $error['companyName'] = 'Company name cannot be empty';
        if (!count($error)) {
            if (isset($_POST['create_new_record'])) {
                $contract->id = null;
            }
            $upload = $contract->save_to_db();
            if ($upload == ContractClass::SAVE_OK) {
                $success = 'Contract info added to database';
                if (count($_FILES)) {
                    $status = upload_file($contract->fileName, $_FILES['upload'], 'application/pdf');
                    if ($status == '1') {
                        $error['fileName'] = 'Contract info added to database, but file is not uploded. PDF file type required';
                    } else {
                        $success = 'Contract info and file added to database';

                    }
                }
                $contract = new ContractClass();

            } else if ($upload == ContractClass::SAVE_ERROR_DUPLICATE_SIGNATURE) {
                $error['signature'] = 'Cant add contract. Contract number already exist, if u want change parameters of the contract, move to update section';
            } else {
                $error['general'] = 'Nothing is added to your database';
            }
        }
    }
    $output = '';
    ob_start(); ?>




    <?php if (@$success) { ?>
    <div style="color:#22aa22; font-weight:bold;"><?= $success ?></div><br/>
<?php } ?>

    <?php if (@$error['general']) { ?>
    <div style="color:#f00; font-weight:bold;"><?= $error['general'] ?></div><br/>
<?php } ?>


    <form action="?" method="post" class="form-horizontal" enctype="multipart/form-data">
        <fieldset>
            <legend>Add/modify contract details</legend>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="signature">Contract signature:</label>

                <div class="col-sm-4">
                    <input class="form-control" name="signature" placeholder="contract signature here"
                           value="<?= @$contract->signature ?>"/>

                    <div style="color:#f00;"><?= @$error['signature'] ?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="companyName">Company name:</label>

                <div class="col-sm-4">

                    <input name="companyName" class="form-control" placeholder="company name here"
                           value="<?= @$contract->companyName ?>"/>

                    <div style="color:#f00;"><?= @$error['companyName'] ?></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="fileName">File name:</label>

                <div class="col-sm-4">
                    <input name="fileName" class="form-control" value="<?= @$contract->fileName ?>"/>

                    <div style="color:#f00;"><?= @$error['fileName'] ?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="upload">File upload:</label>
                <div class="col-sm-4">
                    <div style="height:0;overflow:hidden">
                    <input type="file" id="fileInput" name="upload" value=""/>
                    </div>
                    <button type="button" id="btn_send" class="btn btn-success" onclick="chooseFile();">Choose file</button>
                </div>
            </div>
                <script>
                    function chooseFile() {
                        $("#fileInput").click();
                    }
                </script>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <?= (@$contract->id ?
                        (
                        '<button class="btn btn-primary" id="btn_send">Save changes on existing contract</button>
                        <button id="btn_send" class="btn btn-success" name="create_new_record">Create new contract details</button>'
                        ) :
                        '<button id="btn_send" class="btn btn-success">Add new contract details</button>'); ?>
                </div>
            </div>
        </fieldset>
    </form>


    <?php
    $output .= ob_get_clean();

    return $output;

}