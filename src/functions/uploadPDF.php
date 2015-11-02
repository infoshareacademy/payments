<?php
//error_reporting(0);

define('CONTRACT_FILES', __DIR__.'/../../uploadedFiles/');

function upload_file($server_filename, $file_field, $force_type='application/pdf') {
    $user_filename = $file_field['fileName'];
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

