<?php
// Include this file on every new page you create.

session_start();

if (!@$_SESSION['user_login'] || !@$_SESSION['user_pass']) {
    header("location: login.php");
}

?>