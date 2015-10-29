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
        $pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');
        $stmt = $pdo->query("DELETE FROM contract WHERE id =" . $_GET['delete']);
        $delete = $pdo->exec(@$stmt);
        $output .= '<br><div style="color:#f00;">Contract deleted successfully</div><br/>';
    }
    $error = array();
    if (count($_POST)) {
        $contract = new ContractClass();
        $contract->signature = @$_POST['signature'];
        $contract->companyName = @$_POST['companyName'];
        $contract-> fileName = @$_POST ['fileName'];

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
                $contract = new ContractClass();
                if (count($_FILES)) {
                    $status = upload_file($_FILES['upload'], 'application/pdf');
                    if ($status == '1') {
                        $error['fileName'] = 'Contract info added to database, but file is not uploded. PDF file type required';
                    } else {
                        $success = 'Contract info and file added to database';

                    }
                }

            } else if ($upload == ContractClass::SAVE_ERROR_DUPLICATE_SIGNATURE) {
                $error['signature'] = 'Cant add contract. Contract number already exist, if u want change parameters of the contract, move to update section';
            } else {
                $error['general'] = 'Nothing is added to your database';
            }
        }
    }
    $output .= '<h2>Add/modify contract details</h2>';

    if (@$success)
        $output .= '<div style="color:#22aa22; font-weight:bold;">' . $success . '</div><br/>';
    if (@$error['general'])
        $output .= '<div style="color:#f00; font-weight:bold;">' . $error['general'] . '</div><br/>';
    $output .= '<form action="?" method="post" enctype="multipart/form-data">';
    $output .= 'Signature : <input name="signature" value="' . @$contract->signature . '"/><br><div style="color:#f00;">' . @$error['signature'] . '</div>';
    $output .= '</br>';
    $output .= 'Company : <input name="companyName" value="' . @$contract->companyName . '"/><br><div style="color:#f00;">' . @$error['companyName'] . '</div>';
    $output .= '</br>';
    $output .= 'File name: <input name="fileName" value="'. @$contract->fileName . '"/><br><div style="color:#f00;">' . @$error['fileName'] . '</div>';;
    $output .= '</br></br>';
    $output .= 'PDF file: <input type="file" name="upload" value=""/>';
    $output .= '</br>';
    $output .= (@$contract->id ?
        (
            '<button id="btn_send" name="save_changes">' . 'Save changes on existing contract' . '</button>' .
            '<button id="btn_send" name="create_new_record">' . 'Create new contract details' . '</button>'
        ) :
        '<button id="btn_send">' . 'Add contract details' . '</button>');
    $output .= '</form>';
    $output .= '</br></br>';



    return $output;
}
