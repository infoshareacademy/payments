<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 2015-10-17
 * Time: 22:28
 */
require_once __DIR__ . '/../Model/ContractClass.php';


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
        $delete = $stmt->execute();
        if(empty($delete) == true) {
            $output .= '<br><div style="color:#f00;">Contract deleted successfully</div><br/>';
        } else {
            $output .='<br><div style="color:#f00;">I cant delete record</div><br/>';
        }
    }
    $error = array();
    if (count($_POST)) {
        $contract = new ContractClass();

        $contract->signature = @$_POST['signature'];
        $contract->companyName = @$_POST['companyName'];
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
                $success = 'Contract added to database';
                $contract = new ContractClass();
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
    $output .= '<form action="?" method="post">';
    $output .= 'Signature : <input name="signature" value="' . @$contract->signature . '"/><br><div style="color:#f00;">' . @$error['signature'] . '</div>';
    $output .= '</br>';
    $output .= 'Company : <input name="companyName" value="' . @$contract->companyName . '"/><br><div style="color:#f00;">' . @$error['companyName'] . '</div>';
    $output .= '</br>';
    $output .= (@$contract->id ?
        (
            '<button id="btn_send">' . 'Save changes on existing contract' . '</button>' .
            '<button id="btn_send" name="create_new_record">' . 'Create new contract details' . '</button>'
        ) :
        '<button id="btn_send">' . 'Add contract details' . '</button>');
    $output .= '</form>';
    $output .= '</br></br>';

    return $output;
}
