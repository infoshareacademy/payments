<?php

function layout($name, $content) {

// Include this file on every new page you create.
session_start();

if (!@$_SESSION['user_login'] || !@$_SESSION['user_pass']) {
    header("location: login");
}


return <<<EOT
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
            <a class="navbar-brand" href="#">Pied Pieper Payments</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
        <li class="dropdown hidden-sm hidden-md hidden-lg">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="active"><a href="index">Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="index_reports">Reports</a></li>
            <li><a href="index_contracts">Contracts</a></li>
            <li><a href="index_invoices">Invoices</a></li>
            <li><a href="invoice_import">Import from QR code</a></li>
          </ul>
        </li>
      </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout">Wyloguj</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-user"
                                      aria-hidden="true"></span>&nbsp;{$_SESSION ['user_login']}</a></li>
            </ul>
        </div>


    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar active">
                <li id="overview"><a href="index">Overview <span class="sr-only">(current)</span></a></li>
                <li id="reports"><a href="index_reports">Reports</a></li>
                <li id="contracts"><a href="index_contracts">Contracts</a></li>
                <li id="invoices"><a href="index_invoices">Invoices</a></li>
                <li id="import"><a href="invoice_import">Import from QR code</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">{$content}
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
EOT;
}
