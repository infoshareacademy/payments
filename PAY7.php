<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 09.10.15
 * Time: 12:22
 */

include 'config.php';
function upload_file($file_field, $force_type='') {
    $user_filename = $_POST['contractId'];
    $extension = substr($user_filename, strrpos($user_filename, '.')+1, 5);

    do {
        $hash = uniqid(@$_POST['contractId'] . '-' . rand(0, 99999));
        $server_filename = $hash . '.' . $extension;
    } while (file_exists(ContractsUploadDirectory . $server_filename));

    $status = move_uploaded_file($file_field['tmp_name'], ContractsUploadDirectory . $server_filename);

    if ($status)
        echo 'file uploaded';
    else
        echo 'upps something went wrong';
}


if (count($_FILES)) {
    $status = upload_file($_FILES['upload'], 'application/pdf');
}
//
//
//?>
<form action="?" method="post" enctype="multipart/form-data">
    Wpisz ID umowy: <input name="contractId" value="contract name" /><br/>
    Tylko pliki PDF: <input type="file" name="upload" value=""/><br/>
    <input type="submit" name="send" value="upload" />
</form>
