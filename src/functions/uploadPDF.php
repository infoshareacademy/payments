<?php
//error_reporting(0);

define('CONTRACT_FILES', __DIR__.'/../../uploadedFiles/');

function upload_file($file_field, $force_type='application/pdf') {
    $user_filename = $file_field['fileName'];
    $extension = substr($user_filename, strrpos($user_filename, '.')+1, 5);
    do {
        $hash = uniqid(@$_POST['fileName'] . '-' . rand(0, 99999));
        $server_filename = $hash . '.' . $extension;
    } while (file_exists(CONTRACT_FILES . $server_filename));

    $status = move_uploaded_file($file_field['tmp_name'], CONTRACT_FILES . $server_filename);
    $mime = mime_content_type(CONTRACT_FILES . $server_filename);
    if ($force_type && $force_type!=$mime) {
        unlink(CONTRACT_FILES . $server_filename);
        return '1';
    }

    if ($status)
        return '2';
    else
        return '3';
}


//
//
//if (count($_FILES)) {
//    echo '<pre>';
////    print_r($_FILES);
//
//    $status = upload_file($_FILES['upload'], 'application/pdf');
////    var_dump($status);
//}

?>
<!---->
<!--<form action="?" method="post" enctype="multipart/form-data">-->
<!--    <input name="name" value="" /><br/>-->
<!--    podaj pdf: <input type="file" name="upload" value=""/><br/>-->
<!--    <input type="submit" name="send" value="send" />-->
<!--</form>-->