<?php
/**
 * Created by PhpStorm.
 * User: Monika
 * Date: 2015-10-18
 * Time: 16:21
 */

//ob_start();
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
                <a class="navbar-brand" href="#">Contracts</a>
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

    <?php include '../menu.php' ?>


    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 class="page-header">Contracts</h1>
        <?php include 'ContractsMainPage.php'; ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
    </html>
    <br/><br/>
<!--do wyja�nienia z Paw�em co to robi - bo mi blokuje wy�wietlanie strony-->
<?php
//$content = ob_get_contents();
//$length = strlen($content);
//header('Content-Length: '.$length);
//echo $content;
////?>