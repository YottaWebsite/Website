<?php
$begin = "<?php
session_start();
?>
<!DOCTYPE html>
<html lang='en'>

    <head>

        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <meta name='description' content=''>
        <meta name='author' content=''>

        <title>Yotta Serveroplossingen</title>

        <link href='css/bootstrap.css' rel='stylesheet'>

        <link href='css/freelancer.css' rel='stylesheet'>

        <!-- Custom Fonts -->
        <link href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' rel='stylesheet'>
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic' rel='stylesheet' type='text/css'>

    </head>

    <body id='page-top' class='index'>
        <?php
        include 'includes/functions.php';
        ?>
        <!-- Navigatie -->
        <nav class='navbar navbar-default navbar-static-top'>
            <div class='container'>
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class='navbar-header page-scroll'>
                    <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>
                        <span class='sr-only'>Toggle navigation</span>
                        <span class='icon-bar'></span>
                        <span class='icon-bar'></span>
                        <span class='icon-bar'></span>
                    </button>
                    <a class='navbar-brand' href='#page-top'>
                        <img class='yottafix' src='images/logo2.png' </a>
                </div>

                <!-- Buttons -->
                <div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
                    <ul class='nav navbar-nav navbar-right'>
                        <li class='dropdown'>
                            <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>Yotta<br> <span class='caret'></span></a>
                            <ul class='dropdown-menu' role='menu'>
                                <?php drop1() ?>
                            </ul>
                        </li>
                        <li class='dropdown'>
                            <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>Diensten en<br> producten <span class='caret'></span></a>
                            <ul class='dropdown-menu' role='menu'>
                                <?php drop2() ?>
                            </ul>
                        </li>
                        <li class='dropdown'>
                            <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>nieuws en<br>mededelingen <span class='caret'></span></a>
                            <ul class='dropdown-menu' role='menu'>
                                <?php drop3() ?>
                            </ul>
                        </li>
                        <li class='dropdown'>
                            <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>support<br> <span class='caret'></span></a>
                            <ul class='dropdown-menu' role='menu'>
                                <?php drop4() ?>
                            </ul>
                        </li>
                        <?php
                        if (isset(". $_SESSION['gebruiker'] . ")) {
                            ?>
                            <li class='dropdown'>
                                <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>CMS<br> <span class='caret'></span></a>
                                <ul class='dropdown-menu' role='menu'>
                                    <?php drop5() ?>
                                </ul>
                            </li>
                            <li>
                                <a href='CMS/logout.php'>Log uit</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>

        <!-- Banners -->


        <!-- Intro -->
        <section>
            <div class='navbar-leegte'>
                <div class='container'>";
