<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 09.10.15
 * Time: 12:22
 */

define('ContractsUploadDirectory', '/home/tomek/workspace/contracts_files/');





function upload_file($file_field, $force_type='') {
    $user_filename = $_POST['contractId'];
    $extension = substr($user_filename, strrpos($user_filename, '.')+1, 5);

    do {
        $hash = uniqid(@$_POST['contractId'] . '-' . rand(0, 99999));
        $server_filename = $hash . '.' . $extension;
    } while (file_exists(ContractsUploadDirectory . $server_filename));

    $status = move_uploaded_file($file_field['tmp_name'], ContractsUploadDirectory . $server_filename);

    $mime = mime_content_type(ContractsUploadDirectory . $server_filename);
    if ($force_type && $force_type!=$mime) {
        unlink(ContractsUploadDirectory . $server_filename);
        return 'BLEDNY TYP PLIKU, WYMAGAMY PDF'.$force_type;
    }

    if ($status)
        return 'OK';
    else
        return 'BLAD';
}


if (count($_FILES)) {
    $status = upload_file($_FILES['upload'], 'application/pdf');
}

?>
<form action="?" method="post" enctype="multipart/form-data">
    Wpisz ID umowy: <input name="contractId" value="" /><br/>
    Tylko pliki PDF: <input type="file" name="upload" value=""/><br/>
    <input type="submit" name="send" value="upload" />
</form>
