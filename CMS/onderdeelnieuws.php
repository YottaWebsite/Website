<?php
session_start();
if (empty($_SESSION['gebruiker'])) {
    header("Location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Yotta Serveroplossingen</title>

        <link href="css/bootstrap.css" rel="stylesheet">

        <link href="css/freelancer.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    </head>

    <body id="page-top" class="index">
        <?php
        include 'includes/functions.php';

        ?>
        <!-- Navigatie -->
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#page-top">
                        <img class="yottafix" src="images/logo2.png" </a>
                </div>

                <!-- Buttons -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Yotta<br> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php drop1() ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Diensten en<br> producten <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php drop2() ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">nieuws en<br>mededelingen <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php drop3() ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">support<br> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php drop4() ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">CMS<br> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php drop5() ?>
                            </ul>
                        </li>
                        <li>
                            <a href="logout.php">Log uit</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>

        <!-- Banners -->


        <!-- Intro -->
        <section>
            <div class="navbar-leegte">
                <div class="container">
                    <div id="navcontainer">
                    <h1>CMS Pagina's</h1>
                        <form method="POST">
                            <button name="yotta" class="btn btn-primary btn-lg btstyle"><a href="onderdeelyotta.php">Yotta</a></button>
                            <button name="dienst" class="btn btn-primary btn-lg btstyle"><a href="onderdeeldienst.php">Diensten en Producten</a></button>
                            <button name="nieuws" class="btn btn-primary btn-lg btstyle"><a href="onderdeelnieuws.php">Nieuws</a></button>
                            <button name="support" class="btn btn-primary btn-lg btstyle"><a href="onderdeelsupport.php">Support</a></button>
                        </form>
                    </div>
<?php getOnderdeelNieuws(); ?>
                        
                </div>
            
            </div>
        </section>

        <!-- Over -->
        <section class="success" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>Wat wij u kunnen bieden</h2>
                    </div>
                </div>
                <div class="row">
                    <?php blokRandomizerCMS() ?>

                </div>
        </section>

        <!-- Footer -->
        <footer class="text-center">
            <div class="footer-above">
                <div class="container">
                    <div class="row">
                        <div class="footer-col col-md-6">
                            <h3>Locatie en Route</h3>
                            <p>Zwolsche Hoek<br> Foksdiep 37
                                <br>8321MK Urk</p>
                        </div>
                        <div class="footer-col col-md-6">
                            <h3>Social Media</h3>
                            <ul class="list-inline">
                                <li>
                                    <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-linkedin"></i></a>
                                </li>
                                <li>
                                    <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-dribbble"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-below">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <img src="https://s3.amazonaws.com/static.globalvoices/img/tmpl/cc-by-icons-300.png" width="5%" height="5%"/>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Knop om naar boven te gaan op kleine schermen -->
        <div class="scroll-top page-scroll visible-xs visble-sm">
            <a class="btn btn-primary" href="#page-top">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>

        <!-- jQuery -->
        <script src="js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Plugin JavaScript -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        <script src="js/classie.js"></script>
        <script src="js/cbpAnimatedHeader.js"></script>

    </body>

</html>
