<?php
session_start();
if (!isset($_SESSION['gebruiker'])) {
    header("location: ../login.php");
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

        if (empty($_POST['titel'])) {
            echo ("Geef uw nieuwsbericht een titel!");
        } elseif (empty($_POST['tekstvak'])) {
            echo ("Geef uw nieuwsbericht tekst!");
        } else {
            addNieuws($_POST['titel'], $_POST['tekstvak']);
            header("Location: nieuws.php");
        }
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
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <li class="page-scroll">
                            <a href="#portfolio">Yotta</a>
                        </li>
                        <li class="page-scroll">
                            <a href="#about">Diensten en<br> producten</a>
                        </li>
                        <li class="page-scroll">
                            <a href="#contact">Nieuws en<br> mededelingen</a>
                        </li>
                        <li class="page-scroll">
                            <a href="#contact">Support</a>
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
                    <h1>Mededeling toevoegen</h1>
                    <?php
                    if (isset($_POST['titel'])) {
                        $titel = $_POST['titel'];
                    } else {
                        $titel = "";
                    }
                    if (isset($_POST['tekstvak'])) {
                        $text = $_POST['tekstvak'];
                    } else {
                        $text = "";
                    }
                    ?>

                    <a href="nieuws.php">Nieuws weergeven</a>
                    <form method="POST" action="nieuws-verwerk.php">
                        <table>
                            <tr>
                                <td>Titel</td>
                                <td><input type="text" name="titel" value="<?php echo($titel); ?>" ></td>
                            </tr>
                            <tr>
                                <td>Tekst</td>
                            <script type="text/javascript" src="js/NE/nicEdit.js"></script>
                            <script type="text/javascript">
                                bkLib.onDomLoaded(function () {
                                    nicEditors.allTextAreas()
                                });
                            </script>
                            <td><textarea name="tekstvak" ROWS="4" COLS="50" WRAP="soft"><?php echo($text); ?></textarea></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input class="btn-style" type="submit" name="button" value="Verzenden"></td>
                            </tr>
                        </table>

                    </form>
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
                    <div class="col-sm-3">
                        <h4>Hosting</h4>
                        <p>Wij bieden u voordelige hostingpakketten met onbeperkt dataverkeer,<br> e-mail aliassen en een uitstekende beveiliging tegen ongewenste personen.</p>
                    </div>
                    <div class="col-sm-3">
                        <h4>Dedicated servers</h4>
                        <p>U krijgt de server en wij zorgen voor het volledige beheer. Wilt u liever zelf de controle? Dan kunt u ook kiezen voor unmanaged en krijgt u root toegang tot uw server.  </p>
                    </div>
                    <div class="col-sm-3">
                        <h4>Webdesign</h4>
                        <p>Weinig ervaring met webdesign? Dat kunt u aan ons overlaten, wij bieden u webdesign een compleet webdesign aan. Wij zorgen er ook voor dat u de website helemaal aan kunt passen naar uw stijl.</p>
                    </div>
                    <div class="col-sm-3">
                        <h4>VoIP</h4>
                        <p>Overstappen naar VoIP? Dat kan bij ons! Wij bieden u VoIP oplossingen aan. Met VoIP heeft u vele voordelen zo bent u beter bereikbaar en is het een stuk goedkoper dan gewone telefoon!</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"<p><a class="btn btn-primary btn-lg btstyle">Meer</a></p></div>
                    <div class="col-sm-3"<p><a class="btn btn-primary btn-lg btstyle">Meer</a></p></div>
                    <div class="col-sm-3"<p><a class="btn btn-primary btn-lg btstyle">Meer</a></p></div>
                    <div class="col-sm-3"<p><a class="btn btn-primary btn-lg btstyle">Meer</a></p></div>
                </div>
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
