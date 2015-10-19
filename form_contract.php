<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 15.10.15
 * Time: 21:11
 */
require_once 'home_contract_class.php';

if (@$_GET['edit'] && (int)$_GET['edit']) {
    $edit = (int)$_GET['edit'];
    $contract= new ContractClass($edit);
}
if (@$_GET['delete'] && (int)$_GET['delete']) {
    $delete_entry = (int)$_GET['delete'];
}
$error = array();
if (count($_POST)) {
    $contract = new ContractClass();
    $contract->id = @$_POST['id'];
    $contract->signature = @$_POST['signature'];
    if (!$contract->signature)
        $error['signature'] = 'Add contract number';
    $contract->companyName = @$_POST['companyName'];
    if (!$contract->companyName)
        $error['companyName'] = 'Add company name';
    if (!count($error)) {
        $upload = $contract->save_to_db();
        if ($upload==ContractClass::SAVE_OK)
            $success = 'Contract added';
        else if ($upload==ContractClass::SAVE_ERROR_DUPLICATE_SIG) {
            $error['signature'] = 'Contract with given id exist';
        }
        else {
            $error['general'] = 'Error - nothing has change in db';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formularz</title>

</head>
<body>

<?php
if (@$success)
    echo '<div style="color:#22aa22; font-weight:bold;">'.$success.'</div><br/>';
if (@$error['general'])
    echo '<div style="color:#f00; font-weight:bold;">'.$error['general'].'</div><br/>';
echo '<form action="?" method="post">';
echo 'Contract Number: <input name="id" value="'.@$contract->id.'"/><br>';
echo 'Company Name: <input name="companyName" value="'.@$contract->companyName.'"maxlength="200"/><br><div style="color:#f00;">'.@$error['companyName'].'</div>';
echo 'Contract No: <input name="signature" value="'.@$contract->signature.'"maxlength="200"/><br><div style="color:#f00;">'.@$error['signature'].'</div>';
echo '<button id="btn_send">'.(@$contract->id ? 'SAVE CONTRACT CHANGES' : 'ADD NEW CONTRACT').'</button>';
echo '</form>';
?>

<br/><br/><br/>

<a href="?">wyczysc formularz</a><br/>

<br/><br/><br/>

