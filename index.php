<?php
ob_start();
include 'session_check_header.php';
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
                <li><a href="#">Menu </a></li>
                <li><a href="#">Umowy</a></li>
                <li><a href="#">Faktury</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Payments</h1>


    <h2>Twoje faktury:</h2>
    <?php
    include_once('invoices.php');
    ?>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Dodaj fakturę
    </button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Dodaj fakturę</h4>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="form-group">
                            <label>Numer faktury</label>
                            <input type="number" class="form-control" placeholder="Podaj numer faktury">
                        </div>
                        <div class="form-group">
                            <label>Kwota</label>
                            <input type="number" class="form-control" placeholder="Podaj kwotę">
                        </div>
                        <div class="form-group">
                            <label>Data wystawienia</label>
                            <input type="date" class="form-control" placeholder="Podaj datę wystawienia faktury">
                        </div>
                        <div class="form-group">
                            <label>Data płatności</label>
                            <input type="date" class="form-control" placeholder="Podaj datę płatności dla tej faktury">
                        </div>
                        <div class="form-group">
                            <label>Data opłacenia</label>
                            <input type="date" class="form-control"
                                   placeholder="Podaj do kiedy należy opłacić tą fakturę">
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    <button type="button" class="btn btn-primary">Zapisz</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$content = ob_get_contents();
$length = strlen($content);
header('Content-Length: '.$length);
echo $content;
?>