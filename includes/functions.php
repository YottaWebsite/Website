<?php
include ('connect.php');                                                        #verbinding met database

function drop1() {
    $sql = mysql_query("SELECT * FROM onderdeel WHERE p_id = 1 ORDER BY o_id ASC");
    while ($myrow = mysql_fetch_array($sql)) {
        echo ("<li><a href='" . $myrow['link'] . "'>" . $myrow['paginanaam'] . "</a></li>");
    }
}

function drop2() {
    $sql = mysql_query("SELECT * FROM onderdeel WHERE p_id = 2 ORDER BY o_id ASC");
    while ($myrow = mysql_fetch_array($sql)) {
        echo ("<li><a href='" . $myrow['link'] . "'>" . $myrow['paginanaam'] . "</a></li>");
    }
}

function drop3() {
    $sql = mysql_query("SELECT * FROM onderdeel WHERE p_id = 3 ORDER BY o_id ASC");
    while ($myrow = mysql_fetch_array($sql)) {
        echo ("<li><a href='" . $myrow['link'] . "'>" . $myrow['paginanaam'] . "</a></li>");
    }
}

function drop4() {
    $sql = mysql_query("SELECT * FROM onderdeel WHERE p_id = 4 ORDER BY o_id ASC");
    while ($myrow = mysql_fetch_array($sql)) {
        echo ("<li><a href='" . $myrow['link'] . "'>" . $myrow['paginanaam'] . "</a></li>");
    }
}

function drop5() {
    $sql = mysql_query("SELECT * FROM onderdeel WHERE p_id = 5 ORDER BY o_id ASC");
    while ($myrow = mysql_fetch_array($sql)) {
        echo ("<li><a href='CMS/" . $myrow['link'] . "'>" . $myrow['paginanaam'] . "</a></li>");
    }
}

function getPost() {
    $query = mysql_query("SELECT * FROM mededeling ORDER BY m_id DESC") or die(mysql_error());
    if (mysql_num_rows($query) == 0) {
        echo ("Er zijn geen mededelingen gevonden!");                           #indien er geen mededelingen zijn, wordt dit weergegeven
    } else {
        $rows = mysql_num_rows($query);
        $per_pagina = 5;                                                        #aantal post per pagina
        $totaal_pagina = ceil($rows / $per_pagina);                             #ceil voor afronding naar boven
        if (isset($_GET['pagina']) && $_GET['pagina'] <= $totaal_pagina) {
            $pagina = mysql_real_escape_string($_GET['pagina']);                #indien gezet naar de juiste pagina gaan anders naar de 1e
        } else {
            $pagina = 1;
        }
        echo ("U bevindt zich op pagina $pagina van $totaal_pagina");
        echo ("<br>");
        if ($pagina != 1) {
            echo ("<a href='mededeling.php?pagina=1'>←Eerste</a> ");
            $vorige = $pagina - 1;
            echo ("<a href='mededeling.php?pagina=$vorige'>Vorige</a> ");       #linkjes naar de vorige/eerste pagina indien het nodig is
        }
        if (($pagina != 1) && ($pagina != $totaal_pagina)) {                    #bij eerste/vorige en volgende laatste komt er een | tussen
            echo (" | ");
        }
        if ($pagina != $totaal_pagina) {
            $volgende = $pagina + 1;
            echo ("<a href='mededeling.php?pagina=$volgende'>Volgende</a> ");
            echo ("<a href='mededeling.php?pagina=$totaal_pagina'>Laatste→</a> "); #linkjes naar de volgende/laatste pagina indien het nodig is
        }
        echo ("<hr>");                                                          #lijn over pagina
        $x = ($pagina - 1) * $per_pagina;
        $sql = "SELECT * FROM mededeling ORDER BY m_id DESC LIMIT $x , $per_pagina ";
        $result = mysql_query($sql);
        while ($myrow = mysql_fetch_array($result)) {
            echo ("<h3>" . ucfirst($myrow['titel']) . "</h3>");                 #kop eerste letter met hoofdletter
            echo ("Datum: " . $myrow['datum'] . "<br>");                        #datum
            echo ($myrow['bericht']);                                           #bericht
            echo ("<hr>");
            #wijzig en verwijder knop van mededelingen
        }
        if ($pagina != 1) {
            echo ("<a href='mededeling.php?pagina=1'>←Eerste</a> ");            #linkjes naar de vorige/eerste pagina indien het nodig is
            $vorige = $pagina - 1;
            echo ("<a href='mededeling.php?pagina=$vorige'>Vorige</a> ");
        }
        if (($pagina != 1) && ($pagina != $totaal_pagina)) {                    #bij eerste/vorige en volgende laatste komt er een | tussen
            echo (" | ");
        }
        if ($pagina != $totaal_pagina) {
            $volgende = $pagina + 1;
            echo ("<a href='mededeling.php?pagina=$volgende'>Volgende</a> ");
            echo ("<a href='mededeling.php?pagina=$totaal_pagina'>Laatste→</a> "); #linkjes naar de volgende/laatste pagina indien het nodig is
        }
    }
}

function zoekMededeling($woord) {
    ?>
    <form method="POST">
        <input type="text" name="woord" value="<?php echo ($woord); ?>">
        <input class='btn-style' type="submit"  name="zoek" value="Zoek">
    </form>
    <?php
    if ($woord == "") {
        $woord = "Zoek op titel";
        echo ("Geef een zoekwoord op<br><br>");                                 #indien er niks gezocht word alle mededelingen weergeven
        getPost();
    } else {
        $query = mysql_query("SELECT * FROM mededeling WHERE titel LIKE '%" . $woord . "%' OR bericht LIKE '%" . $woord . "%'") or die(mysql_error());
        if (mysql_num_rows($query) == 0) {
            echo ("Er zijn geen mededelingen gevonden!");                       #indien er niks gevonden wordt op het zoekword dit weergeven
        } else {
            $rows = mysql_num_rows($query);
            $per_pagina = 5;                                                    #aantal post per pagina
            $totaal_pagina = ceil($rows / $per_pagina);                         #ceil voor afronding naar boven. totaal pagina's berekenen
            if (isset($_GET['pagina']) && $_GET['pagina'] <= $totaal_pagina) {
                $pagina = mysql_real_escape_string($_GET['pagina']);            #indien gezet naar de juiste pagina gaan anders naar de 1e
            } else {
                $pagina = 1;
            }
            echo ("<br>U bevindt zich op pagina $pagina van $totaal_pagina");   #huidige pagina weergeven 
            echo ("<br>");
            if ($pagina != 1) {                                                 #linkjes naar de vorige/eerste pagina indien het nodig is
                echo ("<a href='mededeling.php?pagina=1'>←Eerste</a> ");
                $vorige = $pagina - 1;
                echo ("<a href='mededeling.php?pagina=$vorige'>Vorige</a> ");
            }
            if (($pagina != 1) && ($pagina != $totaal_pagina)) {                #bij eerste/vorige en volgende laatste komt er een | tussen
                echo (" | ");
            }
            if ($pagina != $totaal_pagina) {                                    #linkjes naar de volgende/laatste pagina indien het nodig is
                $volgende = $pagina + 1;
                echo ("<a href='mededeling.php?pagina=$volgende'>Volgende</a> ");
                echo ("<a href='mededeling.php?pagina=$totaal_pagina'>Laatste→</a> ");
            }
            echo ("<hr>");                                                      #lijn over pagina
            $x = ($pagina - 1) * $per_pagina;
            $sql = "SELECT * FROM mededeling WHERE titel LIKE '%" . $woord . "%' OR bericht LIKE '%" . $woord . "%'";
            $result = mysql_query($sql);
            while ($myrow = mysql_fetch_array($result)) {
                echo ("<h3>" . ucfirst($myrow['titel']) . "</h3>");             #kop eerste letter met hoofdletter
                echo ("Datum: " . $myrow['datum'] . "<br>");                    #datum
                echo ($myrow['bericht']);                                       #de mededeling
                echo ("<hr>");
                #lijn over pagina
            }
            if ($pagina != 1) {                                                 #linkjes naar de vorige/eerste pagina indien het nodig is
                echo ("<a href='mededeling.php?pagina=1'>←Eerste</a> ");
                $vorige = $pagina - 1;
                echo ("<a href='mededeling.php?pagina=$vorige'>Vorige</a> ");
            }
            if (($pagina != 1) && ($pagina != $totaal_pagina)) {                #bij eerste/vorige en volgende laatste komt er een | tussen
                echo (" | ");
            }
            if ($pagina != $totaal_pagina) {
                $volgende = $pagina + 1;
                echo ("<a href='mededeling.php?pagina=$volgende'>Volgende</a> "); #linkjes naar de volgende/laatste pagina indien het nodig is
                echo ("<a href='mededeling.php?pagina=$totaal_pagina'>Laatste→</a> ");
            }
        }
    }
}

function getNieuws() {
    $query = mysql_query("SELECT * FROM nieuws ORDER BY n_id DESC") or die(mysql_error());
    if (mysql_num_rows($query) == 0) {
        echo ("Er zijn geen nieuwsberichten gevonden!");                           #indien er geen mededelingen zijn, wordt dit weergegeven
    } else {
        $rows = mysql_num_rows($query);
        $per_pagina = 5;                                                        #aantal post per pagina
        $totaal_pagina = ceil($rows / $per_pagina);                             #ceil voor afronding naar boven
        if (isset($_GET['pagina']) && $_GET['pagina'] <= $totaal_pagina) {
            $pagina = mysql_real_escape_string($_GET['pagina']);                #indien gezet naar de juiste pagina gaan anders naar de 1e
        } else {
            $pagina = 1;
        }
        echo ("U bevindt zich op pagina $pagina van $totaal_pagina");
        echo ("<br>");
        if ($pagina != 1) {
            echo ("<a href='nieuws.php?pagina=1'>←Eerste</a> ");
            $vorige = $pagina - 1;
            echo ("<a href='nieuws.php?pagina=$vorige'>Vorige</a> ");       #linkjes naar de vorige/eerste pagina indien het nodig is
        }
        if (($pagina != 1) && ($pagina != $totaal_pagina)) {                    #bij eerste/vorige en volgende laatste komt er een | tussen
            echo (" | ");
        }
        if ($pagina != $totaal_pagina) {
            $volgende = $pagina + 1;
            echo ("<a href='nieuws.php?pagina=$volgende'>Volgende</a> ");
            echo ("<a href='nieuws.php?pagina=$totaal_pagina'>Laatste→</a> "); #linkjes naar de volgende/laatste pagina indien het nodig is
        }
        echo ("<hr>");                                                          #lijn over pagina
        $x = ($pagina - 1) * $per_pagina;
        $sql = "SELECT * FROM nieuws ORDER BY n_id DESC LIMIT $x , $per_pagina ";
        $result = mysql_query($sql);
        while ($myrow = mysql_fetch_array($result)) {
            echo ("<h1>" . ucfirst($myrow['titel']) . "</h1>");                 #kop eerste letter met hoofdletter
            echo ("Datum: " . $myrow['datum'] . "<br>");                        #datum
            echo ($myrow['bericht'] . "<hr>");                                           #bericht
            #wijzig en verwijder knop van mededelingen
        }
        if ($pagina != 1) {
            echo ("<a href='nieuws.php?pagina=1'>←Eerste</a> ");            #linkjes naar de vorige/eerste pagina indien het nodig is
            $vorige = $pagina - 1;
            echo ("<a href='nieuws.php?pagina=$vorige'>Vorige</a> ");
        }
        if (($pagina != 1) && ($pagina != $totaal_pagina)) {                    #bij eerste/vorige en volgende laatste komt er een | tussen
            echo (" | ");
        }
        if ($pagina != $totaal_pagina) {
            $volgende = $pagina + 1;
            echo ("<a href='nieuws.php?pagina=$volgende'>Volgende</a> ");
            echo ("<a href='nieuws.php?pagina=$totaal_pagina'>Laatste→</a> "); #linkjes naar de volgende/laatste pagina indien het nodig is
        }
    }
}

function zoekNieuws($woord) {
    ?>
    <form method="POST">
        <input type="text" name="woord" value="<?php echo ($woord); ?>">
        <input class='btn-style' type="submit"  name="zoek" value="Zoek">
    </form>
    <?php
    if ($woord == "") {
        $woord = "Zoek op titel";
        echo ("Geef een zoekwoord op<br><br>");                                 #indien er niks gezocht word alle mededelingen weergeven
        getNieuws();
    } else {
        $query = mysql_query("SELECT * FROM nieuws WHERE titel LIKE '%" . $woord . "%' OR bericht LIKE '%" . $woord . "%'") or die(mysql_error());
        if (mysql_num_rows($query) == 0) {
            echo ("Er zijn geen mededelingen gevonden!");                       #indien er niks gevonden wordt op het zoekword dit weergeven
        } else {
            $rows = mysql_num_rows($query);
            $per_pagina = 5;                                                    #aantal post per pagina
            $totaal_pagina = ceil($rows / $per_pagina);                         #ceil voor afronding naar boven. totaal pagina's berekenen
            if (isset($_GET['pagina']) && $_GET['pagina'] <= $totaal_pagina) {
                $pagina = mysql_real_escape_string($_GET['pagina']);            #indien gezet naar de juiste pagina gaan anders naar de 1e
            } else {
                $pagina = 1;
            }
            echo ("<br>U bevindt zich op pagina $pagina van $totaal_pagina");   #huidige pagina weergeven 
            echo ("<br>");
            if ($pagina != 1) {                                                 #linkjes naar de vorige/eerste pagina indien het nodig is
                echo ("<a href='nieuws.php?pagina=1'>←Eerste</a> ");
                $vorige = $pagina - 1;
                echo ("<a href='nieuws.php?pagina=$vorige'>Vorige</a> ");
            }
            if (($pagina != 1) && ($pagina != $totaal_pagina)) {                #bij eerste/vorige en volgende laatste komt er een | tussen
                echo (" | ");
            }
            if ($pagina != $totaal_pagina) {                                    #linkjes naar de volgende/laatste pagina indien het nodig is
                $volgende = $pagina + 1;
                echo ("<a href='nieuws.php?pagina=$volgende'>Volgende</a> ");
                echo ("<a href='nieuws.php?pagina=$totaal_pagina'>Laatste→</a> ");
            }
            echo ("<hr>");                                                      #lijn over pagina
            $x = ($pagina - 1) * $per_pagina;
            $sql = "SELECT * FROM nieuws WHERE titel LIKE '%" . $woord . "%' OR bericht LIKE '%" . $woord . "%'";
            $result = mysql_query($sql);
            while ($myrow = mysql_fetch_array($result)) {
                echo ("<h1>" . ucfirst($myrow['titel']) . "</h1>");             #kop eerste letter met hoofdletter
                echo ("Datum: " . $myrow['datum'] . "<br>");                    #datum
                echo ($myrow['bericht'] . "<hr>");                                       #de mededeling
            }
            if ($pagina != 1) {                                                 #linkjes naar de vorige/eerste pagina indien het nodig is
                echo ("<a href='nieuws.php?pagina=1'>←Eerste</a> ");
                $vorige = $pagina - 1;
                echo ("<a href='nieuws.php?pagina=$vorige'>Vorige</a> ");
            }
            if (($pagina != 1) && ($pagina != $totaal_pagina)) {                #bij eerste/vorige en volgende laatste komt er een | tussen
                echo (" | ");
            }
            if ($pagina != $totaal_pagina) {
                $volgende = $pagina + 1;
                echo ("<a href='nieuws.php?pagina=$volgende'>Volgende</a> "); #linkjes naar de volgende/laatste pagina indien het nodig is
                echo ("<a href='nieuws.php?pagina=$totaal_pagina'>Laatste→</a> ");
            }
        }
    }
}

function blokRandomizer() {
    $query = mysql_query("SELECT * FROM paginablok");
    $rows = mysql_num_rows($query);
    $random1 = rand(1, $rows);
    $random2 = rand(1, $rows);
    $random3 = rand(1, $rows);
    $random4 = rand(1, $rows);
    while ($random2 == $random1) {
        $random2 = rand(1, $rows);
    }
    while ($random3 == $random2 || $random3 == $random1) {
        $random3 = rand(1, $rows);
    }
    while ($random4 == $random3 || $random4 == $random2 || $random4 == $random1) {
        $random4 = rand(1, $rows);
    }
    PaginaBlok($random1);
    PaginaBlok($random2);
    PaginaBlok($random3);
    PaginaBlok($random4);
}

function PaginaBlok($blokId) {
    $sql = ("SELECT * FROM paginablok b LEFT JOIN onderdeel o ON o.i_id = b.i_id WHERE b.b_id = $blokId");
    $query = mysql_query($sql);
    while ($myrow = mysql_fetch_array($query)) {
        echo ("<div class='col-sm-3'><h4>" . $myrow['paginanaam'] . "</h4>"); #volgorde en de paginanaam
        echo ($myrow['samenvatting'] . "<br><br>");     #paginainhoud weergeven
        echo ("<a href='" . $myrow['link'] . "'class='btn btn-primary btn-lg btstyle'>Meer</a></form></div>");
    }                                                                           #wijzig knop
}

function getPagina ($i_id){
    $sql = ("SELECT * FROM onderdeel WHERE i_id = $i_id");
    $query = mysql_query($sql);
    while ($myrow = mysql_fetch_array($query)) {
        echo ("<h1>" . $myrow['paginanaam'] . "</h1>"); #volgorde en de paginanaam
        echo ($myrow['paginainhoud']);     #paginainhoud weergeven
    }
}

function bestelform ($domeinnaam, $voornaam, $achternaam, $straat, $woonplaats, $postcode, $huisnummer, $emailadres, $ext, $domeinoptie, $hostingoptie){
    $stmt = mysql_query("INSERT INTO Bestellingen VALUES (null, '$domeinnaam', '$voornaam', '$achternaam', '$straat', '$woonplaats', '$postcode', '$huisnummer', '$emailadres', '$ext', '$domeinoptie', '$hostingoptie')");
}