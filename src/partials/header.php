<?php
ob_start();

// Include this file on every new page you create.
session_start();

if (!@$_SESSION['user_login'] || !@$_SESSION['user_pass']) {
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <title>Pied Piper payments</title>
    <link href="css/dashboard.css" rel="stylesheet">
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Payments</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php">Wyloguj</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"
                                      aria-hidden="true"></span>&nbsp;<?php echo $_SESSION ['user_login']; ?></a></li>
            </ul>
        </div>

    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
                <li><a href="index_reports.php">Raporty</a></li>
                <li><a href="index_contracts.php">Umowy</a></li>
                <li><a href="index.php">Faktury</a></li>
                <li><a href="invoice_import.php">Import faktury z QR kodu</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">