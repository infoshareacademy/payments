<?php

define('ADMIN_LOGIN', 'admin@wp.pl');
define('ADMIN_PASS', '12345');


session_start();

if (@$_POST['inputEmail'])
    $_SESSION['user_login'] = $_POST['inputEmail'];

if (@$_POST['inputPassword'])
    $_SESSION['user_pass'] = $_POST['inputPassword'];


if (!@$_SESSION['user_login'] || !@$_SESSION['user_pass']) {
$error = 'Podaj login i haslo';
}
else {
if ($_SESSION['user_login'] == ADMIN_LOGIN && $_SESSION['user_pass']== ADMIN_PASS) {
    header ("location: index.php");
    $error = '';
}
else {
$error = 'Bledny login lub haslo';
}
}




if($error) {

    echo '<!DOCTYPE html >
        <html lang = "en" >
        <head>
        <meta charset = "utf-8" >
        <meta http - equiv = "X-UA-Compatible" content = "IE=edge" >
        <meta name = "viewport" content = "width=device-width, initial-scale=1" >
        <title > Payments - Log in !</title >
        <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" >
        <link href = "login.css" rel = "stylesheet" >
        </head>

        <body >

        <div class="container" >

            <form class="form-signin" method="post" >
                <h2 class="form-signin-heading" > Please sign in </h2 >

                <p style="color:red;">' .$error.'
                <label for="inputEmail" class="sr-only" > Email address </label >
                <input type name="inputEmail" = "email" id = "inputEmail" class="form-control" placeholder = "Email" required autofocus >

                <label for="inputPassword" class="sr-only" > Password</label >
                <input name="inputPassword" type = "password" id = "inputPassword" class="form-control" placeholder = "Password" required >

                <button class="btn btn-lg btn-primary btn-block" type = "submit" > Sign in </button >
            </form >

        </div >

        </body >
        </html >
';
}
?>