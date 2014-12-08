<?php
include ('connect.php');                                                        #verbinding met database
#Mededelingen

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
            echo ("<h1>" . ucfirst($myrow['titel']) . "</h1>");                 #kop eerste letter met hoofdletter
            echo ("Datum: " . $myrow['datum'] . "<br>");                        #datum
            echo ($myrow['bericht']);                                           #bericht
            ?>
            <table>
                <tr>
                    <td>
                        <form method='POST' action='editmededeling.php'>
                            <input type='hidden' name='id' value='<?php echo ($myrow['m_id']) ?>'>
                            <input class='btn-style' type='submit' value='Wijzig' name='wijzigknop'>&nbsp; 
                        </form>
                    </td>
                    <td>
                        <form method='POST' action='deletemededeling.php'>
                            <input type='hidden' name='id' value='<?php echo ($myrow['m_id']) ?>'>
                            &nbsp;<input class='btn-style' type='submit' value='Verwijder' name='verwijderknop'>
                        </form>
                    </td>
                </tr>
            </table> 

            <hr>                                                    
            <?php
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

function deletePost($id) {
    $id = (int) $id;
    mysql_query("DELETE FROM mededeling WHERE m_id = '$id'") or die(mysql_error());
    header("Location: mededeling.php");                                         #verwijderen van mededelingen
}

function addPost($titel, $tekst) {                                              #toevoegen van mededelingen
    $query = mysql_query("INSERT INTO mededeling VALUES (NULL,'$titel','$tekst', CURRENT_DATE( ))") or die(mysql_error());
}

#id/datum wordt automatisch gezet

function editPostForm($id) {
    $id = (int) $id;
    $query = mysql_query("SELECT * FROM mededeling WHERE m_id = '$id'") or die(mysql_error());
    return mysql_fetch_assoc($query);                                           #zet de huidige gegevens van de database in een formulier
}

function editPost($id, $titel, $tekst) {
    $id = (int) $id;                                                            #veranderd de huidige gegevens in de database
    $query = mysql_query("UPDATE mededeling SET titel = '$titel', bericht = '$tekst', datum = CURRENT_DATE( ) WHERE m_id = '$id'") or die(mysql_error());
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
                echo ("<h1>" . ucfirst($myrow['titel']) . "</h1>");             #kop eerste letter met hoofdletter
                echo ("Datum: " . $myrow['datum'] . "<br>");                    #datum
                echo ($myrow['bericht']);                                       #de mededeling
                ?>
                <table>
                    <tr>
                        <td>
                            <form method='POST' action='editmededeling.php'>
                                <input type='hidden' name='id' value='<?php echo ($myrow['m_id']) ?>'>
                                <input class='btn-style' type='submit' value='Wijzig' name='wijzigknop'>&nbsp; 
                            </form>
                        </td>
                        <td>
                            <form method='POST' action='deletemededeling.php'>
                                <input type='hidden' name='id' value='<?php echo ($myrow['m_id']) ?>'>
                                &nbsp;<input class='btn-style' type='submit' value='Verwijder' name='verwijderknop'>
                            </form>
                        </td>
                    </tr>
                </table> 

                <hr>                                                    
                <?php
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

#Pagina's

function getPagina() {
    $sql = "SELECT * FROM pagina";
    $result = mysql_query($sql);
    while ($myrow = mysql_fetch_array($result)) {

        echo ("<hr><h1>" . ucfirst($myrow['paginanaam']) . "</h1>");                #paginanaam
        echo ($myrow['paginainhoud']);                                          #pagina inhoud

        echo ("<form method='POST' action='editpagina.php'><input type='hidden' name='id' value='" . $myrow['p_id'] . "'><input type='submit' value='Wijzig' name='wijzigknop'></form>");
        echo ("<hr>");                                                          #lijn over pagina
    }
}

function editPaginaForm($id) {
    $id = (int) $id;
    $query = mysql_query("SELECT * FROM pagina WHERE p_id = '$id'") or die(mysql_error());
    return mysql_fetch_assoc($query);                                           #zet de huidige gegevens van de database in een formulier
}

function editPagina($id, $titel, $tekst) {
    $id = (int) $id;                                                            #veranderd de huidige gegevens in de database
    $query = mysql_query("UPDATE pagina SET paginanaam = '$titel', paginainhoud = '$tekst' WHERE p_id = '$id'") or die(mysql_error());
}

#Onderdelen                 pagina's die in de dropdownmenu staan

function editOnderdeelForm($iID) {
    $iID = (int) $iID;                                               #zet de huidige gegevens van de database in een formulier
    $query = mysql_query("SELECT * FROM onderdeel WHERE i_id = '$iID'") or die(mysql_error());
    return mysql_fetch_assoc($query);
}

function editOnderdeel($iID, $paginaId, $o_id, $volgorde, $titel, $tekst) {
    if ($volgorde != $o_id) {
        $nieuw = 100;                                                          #indien de volgorde veranderd wordt, zorgt dit ervoor dat er geen dubbele id's in de tabellen komen
        $verander1 = mysql_query("UPDATE onderdeel SET o_id = '$nieuw' WHERE o_id = '$volgorde'") or die(mysql_error());
        $verander2 = mysql_query("UPDATE onderdeel SET o_id = '$volgorde' WHERE i_id = '$iID'") or die(mysql_error()); #verandert het onderdeel-id na de gekozen id.
        $verander3 = mysql_query("UPDATE onderdeel SET o_id = '$o_id' WHERE o_id = '$nieuw' AND p_id = $paginaId") or die(mysql_error());
    }
    $sql = mysql_query("UPDATE onderdeel SET paginanaam = '$titel', paginainhoud = '$tekst' WHERE i_id = $iID ") or die(mysql_error());
#veranderd huidige inhoud van database
}

function volgordeOnderdeel($paginaId, $onderdeelId) {
    echo ("<select name='volgorde'>");                                          #geeft een dropdownmenu met keuze voor volgorde
    $sql = "SELECT * FROM onderdeel WHERE p_id ='$paginaId' AND o_id != '$onderdeelId' Order by o_id";
    $query = "SELECT * FROM onderdeel WHERE p_id ='$paginaId' AND o_id = '$onderdeelId'";
    $result = mysql_query($sql);
    $result2 = mysql_query($query);
    while ($myrow = mysql_fetch_array($result)) {
        echo ("<option value='" . $myrow['o_id'] . "'>" . $myrow['o_id'] . "</option>");
    }
    while ($myrow = mysql_fetch_array($result2)) {
        echo ("<option SELECTED value='" . $myrow['o_id'] . "'>" . $myrow['o_id'] . "</option>");
    }
    echo ("</select>");
}

function drop1() {
    $sql = mysql_query("SELECT * FROM onderdeel WHERE p_id = 1 ORDER BY o_id ASC");
    while ($myrow = mysql_fetch_array($sql)) {
        echo ("<li><a href='../" . $myrow['link'] . "'>" . $myrow['paginanaam'] . "</a></li>");
    }
}

function drop2() {
    $sql = mysql_query("SELECT * FROM onderdeel WHERE p_id = 2 ORDER BY o_id ASC");
    while ($myrow = mysql_fetch_array($sql)) {
        echo ("<li><a href='../" . $myrow['link'] . "'>" . $myrow['paginanaam'] . "</a></li>");
    }
}

function drop3() {
    $sql = mysql_query("SELECT * FROM onderdeel WHERE p_id = 3 ORDER BY o_id ASC");
    while ($myrow = mysql_fetch_array($sql)) {
        echo ("<li><a href='../" . $myrow['link'] . "'>" . $myrow['paginanaam'] . "</a></li>");
    }
}

function drop4() {
    $sql = mysql_query("SELECT * FROM onderdeel WHERE p_id = 4 ORDER BY o_id ASC");
    while ($myrow = mysql_fetch_array($sql)) {
        echo ("<li><a href='../" . $myrow['link'] . "'>" . $myrow['paginanaam'] . "</a></li>");
    }
}

function drop5() {
    $sql = mysql_query("SELECT * FROM onderdeel WHERE p_id = 5 ORDER BY o_id ASC");
    while ($myrow = mysql_fetch_array($sql)) {
        echo ("<li><a href='" . $myrow['link'] . "'>" . $myrow['paginanaam'] . "</a></li>");
    }
}

function getOnderdeelYotta() {
    $query = mysql_query("SELECT * FROM onderdeel WHERE p_id = 1 AND paginainhoud != ''") or die(mysql_error());
    if (mysql_num_rows($query) == 0) {
        echo ("Er zijn geen pagina's gevonden!");                       #indien er niks gevonden wordt op het zoekword dit weergeven
    } else {
        $rows = mysql_num_rows($query);
        $per_pagina = 3;                                                    #aantal post per pagina
        $totaal_pagina = ceil($rows / $per_pagina);                         #ceil voor afronding naar boven. totaal pagina's berekenen
        if (isset($_GET['pagina']) && $_GET['pagina'] <= $totaal_pagina) {
            $pagina = mysql_real_escape_string($_GET['pagina']);            #indien gezet naar de juiste pagina gaan anders naar de 1e
        } else {
            $pagina = 1;
        }
        echo ("<br>U bevindt zich op pagina $pagina van $totaal_pagina");   #huidige pagina weergeven 
        echo ("<br>");
        if ($pagina != 1) {                                                 #linkjes naar de vorige/eerste pagina indien het nodig is
            $vorige = $pagina - 1;
            echo ("<a href='onderdeelyotta.php?pagina=$vorige'>Vorige</a> ");
        }
        if (($pagina != 1) && ($pagina != $totaal_pagina)) {                #bij eerste/vorige en volgende laatste komt er een | tussen
            echo (" | ");
        }
        if ($pagina != $totaal_pagina) {                                    #linkjes naar de volgende/laatste pagina indien het nodig is
            $volgende = $pagina + 1;
            echo ("<a href='onderdeelyotta.php?pagina=$volgende'>Volgende</a> ");
        }
        echo ("<hr>");                                                      #lijn over pagina
        $x = ($pagina - 1) * $per_pagina;
        $sql = "SELECT * FROM onderdeel WHERE p_id = 1 AND paginainhoud != '' ORDER BY o_id LIMIT $x , $per_pagina";
        $result = mysql_query($sql);
        while ($myrow = mysql_fetch_array($result)) {
            echo ("<h3>" . ucfirst($myrow['paginanaam']) . "</h3>");             #kop eerste letter met hoofdletter
            echo ($myrow['paginainhoud']);                                       #de mededeling
            ?>
            <table>
                <tr>
                    <td>
                        <form method='POST' action='editOnderdeel.php'>
                            <input type='hidden' name='iid' value='<?php echo ($myrow['i_id']) ?>'>
                            <input type='hidden' name='oid' value='<?php echo ($myrow['o_id']) ?>'>
                            <input type='hidden' name='pid' value='<?php echo ($myrow['p_id']) ?>'>
                            <input class='btn-style' type='submit' value='Wijzig' name='wijzigknop'>&nbsp; 
                        </form>
                    </td>
                    <td>
                    </td>
                </tr>
            </table> 

            <hr>                                                    
            <?php
#lijn over pagina
        }
        if ($pagina != 1) {                                                 #linkjes naar de vorige/eerste pagina indien het nodig is
            $vorige = $pagina - 1;
            echo ("<a href='onderdeelyotta.php?pagina=$vorige'>Vorige</a> ");
        }
        if (($pagina != 1) && ($pagina != $totaal_pagina)) {                #bij eerste/vorige en volgende laatste komt er een | tussen
            echo (" | ");
        }
        if ($pagina != $totaal_pagina) {
            $volgende = $pagina + 1;
            echo ("<a href='onderdeelyotta.php?pagina=$volgende'>Volgende</a> "); #linkjes naar de volgende/laatste pagina indien het nodig is
        }
    }
}

function getOnderdeelDiensten() {
    $query = mysql_query("SELECT * FROM onderdeel WHERE p_id = 2 AND paginainhoud != ''") or die(mysql_error());
    if (mysql_num_rows($query) == 0) {
        echo ("Er zijn geen pagina's gevonden!");                       #indien er niks gevonden wordt op het zoekword dit weergeven
    } else {
        $rows = mysql_num_rows($query);
        $per_pagina = 3;                                                    #aantal post per pagina
        $totaal_pagina = ceil($rows / $per_pagina);                         #ceil voor afronding naar boven. totaal pagina's berekenen
        if (isset($_GET['pagina']) && $_GET['pagina'] <= $totaal_pagina) {
            $pagina = mysql_real_escape_string($_GET['pagina']);            #indien gezet naar de juiste pagina gaan anders naar de 1e
        } else {
            $pagina = 1;
        }
        echo ("<br>U bevindt zich op pagina $pagina van $totaal_pagina");   #huidige pagina weergeven 
        echo ("<br>");
        if ($pagina != 1) {                                                 #linkjes naar de vorige/eerste pagina indien het nodig is
            $vorige = $pagina - 1;
            echo ("<a href='onderdeeldienst.php?pagina=$vorige'>Vorige</a> ");
        }
        if (($pagina != 1) && ($pagina != $totaal_pagina)) {                #bij eerste/vorige en volgende laatste komt er een | tussen
            echo (" | ");
        }
        if ($pagina != $totaal_pagina) {                                    #linkjes naar de volgende/laatste pagina indien het nodig is
            $volgende = $pagina + 1;
            echo ("<a href='onderdeeldienst.php?pagina=$volgende'>Volgende</a> ");
        }
        echo ("<hr>");                                                      #lijn over pagina
        $x = ($pagina - 1) * $per_pagina;
        $sql = "SELECT * FROM onderdeel WHERE p_id = 2 AND paginainhoud != '' ORDER BY o_id LIMIT $x , $per_pagina";
        $result = mysql_query($sql);
        while ($myrow = mysql_fetch_array($result)) {
            echo ("<h3>" . ucfirst($myrow['paginanaam']) . "</h3>");             #kop eerste letter met hoofdletter
            echo ($myrow['paginainhoud']);                                       #de mededeling
            ?>
            <table>
                <tr>
                    <td>
                        <form method='POST' action='editOnderdeel.php'>
                            <input type='hidden' name='iid' value='<?php echo ($myrow['i_id']) ?>'>
                            <input type='hidden' name='oid' value='<?php echo ($myrow['o_id']) ?>'>
                            <input type='hidden' name='pid' value='<?php echo ($myrow['p_id']) ?>'>
                            <input class='btn-style' type='submit' value='Wijzig' name='wijzigknop'>&nbsp; 
                        </form>
                    </td>
                    <td>
                    </td>
                </tr>
            </table> 

            <hr>                                                    
            <?php
#lijn over pagina
        }
        if ($pagina != 1) {                                                 #linkjes naar de vorige/eerste pagina indien het nodig is
            $vorige = $pagina - 1;
            echo ("<a href='onderdeeldienst.php?pagina=$vorige'>Vorige</a> ");
        }
        if (($pagina != 1) && ($pagina != $totaal_pagina)) {                #bij eerste/vorige en volgende laatste komt er een | tussen
            echo (" | ");
        }
        if ($pagina != $totaal_pagina) {
            $volgende = $pagina + 1;
            echo ("<a href='onderdeeldienst.php?pagina=$volgende'>Volgende</a> "); #linkjes naar de volgende/laatste pagina indien het nodig is
        }
    }
}

function getOnderdeelNieuws() {
    $query = mysql_query("SELECT * FROM onderdeel WHERE p_id = 3 AND paginainhoud != ''") or die(mysql_error());
    if (mysql_num_rows($query) == 0) {
        echo ("Er zijn geen pagina's gevonden!");                       #indien er niks gevonden wordt op het zoekword dit weergeven
    } else {
        $rows = mysql_num_rows($query);
        $per_pagina = 3;                                                    #aantal post per pagina
        $totaal_pagina = ceil($rows / $per_pagina);                         #ceil voor afronding naar boven. totaal pagina's berekenen
        if (isset($_GET['pagina']) && $_GET['pagina'] <= $totaal_pagina) {
            $pagina = mysql_real_escape_string($_GET['pagina']);            #indien gezet naar de juiste pagina gaan anders naar de 1e
        } else {
            $pagina = 1;
        }
        echo ("<br>U bevindt zich op pagina $pagina van $totaal_pagina");   #huidige pagina weergeven 
        echo ("<br>");
        if ($pagina != 1) {                                                 #linkjes naar de vorige/eerste pagina indien het nodig is
            $vorige = $pagina - 1;
            echo ("<a href='onderdeelnieuws.php?pagina=$vorige'>Vorige</a> ");
        }
        if (($pagina != 1) && ($pagina != $totaal_pagina)) {                #bij eerste/vorige en volgende laatste komt er een | tussen
            echo (" | ");
        }
        if ($pagina != $totaal_pagina) {                                    #linkjes naar de volgende/laatste pagina indien het nodig is
            $volgende = $pagina + 1;
            echo ("<a href='onderdeelnieuws.php?pagina=$volgende'>Volgende</a> ");
        }
        echo ("<hr>");                                                      #lijn over pagina
        $x = ($pagina - 1) * $per_pagina;
        $sql = "SELECT * FROM onderdeel WHERE p_id = 3 AND paginainhoud != '' ORDER BY o_id LIMIT $x , $per_pagina";
        $result = mysql_query($sql);
        while ($myrow = mysql_fetch_array($result)) {
            echo ("<h3>" . ucfirst($myrow['paginanaam']) . "</h3>");             #kop eerste letter met hoofdletter
            echo ($myrow['paginainhoud']);                                       #de mededeling
            ?>
            <table>
                <tr>
                    <td>
                        <form method='POST' action='editOnderdeel.php'>
                            <input type='hidden' name='iid' value='<?php echo ($myrow['i_id']) ?>'>
                            <input type='hidden' name='oid' value='<?php echo ($myrow['o_id']) ?>'>
                            <input type='hidden' name='pid' value='<?php echo ($myrow['p_id']) ?>'>
                            <input class='btn-style' type='submit' value='Wijzig' name='wijzigknop'>&nbsp; 
                        </form>
                    </td>
                    <td>
                    </td>
                </tr>
            </table> 

            <hr>                                                    
            <?php
#lijn over pagina
        }
        if ($pagina != 1) {                                                 #linkjes naar de vorige/eerste pagina indien het nodig is
            $vorige = $pagina - 1;
            echo ("<a href='onderdeelnieuws.php?pagina=$vorige'>Vorige</a> ");
        }
        if (($pagina != 1) && ($pagina != $totaal_pagina)) {                #bij eerste/vorige en volgende laatste komt er een | tussen
            echo (" | ");
        }
        if ($pagina != $totaal_pagina) {
            $volgende = $pagina + 1;
            echo ("<a href='onderdeelnieuws.php?pagina=$volgende'>Volgende</a> "); #linkjes naar de volgende/laatste pagina indien het nodig is
        }
    }
}

function getOnderdeelSupport() {
    $query = mysql_query("SELECT * FROM onderdeel WHERE p_id = 4 AND paginainhoud != ''") or die(mysql_error());
    if (mysql_num_rows($query) == 0) {
        echo ("Er zijn geen pagina's gevonden!");                       #indien er niks gevonden wordt op het zoekword dit weergeven
    } else {
        $rows = mysql_num_rows($query);
        $per_pagina = 3;                                                    #aantal post per pagina
        $totaal_pagina = ceil($rows / $per_pagina);                         #ceil voor afronding naar boven. totaal pagina's berekenen
        if (isset($_GET['pagina']) && $_GET['pagina'] <= $totaal_pagina) {
            $pagina = mysql_real_escape_string($_GET['pagina']);            #indien gezet naar de juiste pagina gaan anders naar de 1e
        } else {
            $pagina = 1;
        }
        echo ("<br>U bevindt zich op pagina $pagina van $totaal_pagina");   #huidige pagina weergeven 
        echo ("<br>");
        if ($pagina != 1) {                                                 #linkjes naar de vorige/eerste pagina indien het nodig is
            $vorige = $pagina - 1;
            echo ("<a href='onderdeelsupport.php?pagina=$vorige'>Vorige</a> ");
        }
        if (($pagina != 1) && ($pagina != $totaal_pagina)) {                #bij eerste/vorige en volgende laatste komt er een | tussen
            echo (" | ");
        }
        if ($pagina != $totaal_pagina) {                                    #linkjes naar de volgende/laatste pagina indien het nodig is
            $volgende = $pagina + 1;
            echo ("<a href='onderdeelsupport.php?pagina=$volgende'>Volgende</a> ");
        }
        echo ("<hr>");                                                      #lijn over pagina
        $x = ($pagina - 1) * $per_pagina;
        $sql = "SELECT * FROM onderdeel WHERE p_id = 4 AND paginainhoud != '' ORDER BY o_id LIMIT $x , $per_pagina";
        $result = mysql_query($sql);
        while ($myrow = mysql_fetch_array($result)) {
            echo ("<h3>" . ucfirst($myrow['paginanaam']) . "</h3>");             #kop eerste letter met hoofdletter
            echo ($myrow['paginainhoud']);                                       #de mededeling
            ?>
            <table>
                <tr>
                    <td>
                        <form method='POST' action='editOnderdeel.php'>
                            <input type='hidden' name='iid' value='<?php echo ($myrow['i_id']) ?>'>
                            <input type='hidden' name='oid' value='<?php echo ($myrow['o_id']) ?>'>
                            <input type='hidden' name='pid' value='<?php echo ($myrow['p_id']) ?>'>
                            <input class='btn-style' type='submit' value='Wijzig' name='wijzigknop'>&nbsp; 
                        </form>
                    </td>
                    <td>
                    </td>
                </tr>
            </table> 

            <hr>                                                    
            <?php
#lijn over pagina
        }
        if ($pagina != 1) {                                                 #linkjes naar de vorige/eerste pagina indien het nodig is
            $vorige = $pagina - 1;
            echo ("<a href='onderdeelsupport.php?pagina=$vorige'>Vorige</a> ");
        }
        if (($pagina != 1) && ($pagina != $totaal_pagina)) {                #bij eerste/vorige en volgende laatste komt er een | tussen
            echo (" | ");
        }
        if ($pagina != $totaal_pagina) {
            $volgende = $pagina + 1;
            echo ("<a href='onderdeelsupport.php?pagina=$volgende'>Volgende</a> "); #linkjes naar de volgende/laatste pagina indien het nodig is
        }
    }
}

function getPaginaBlok() {
    $sql = ("SELECT * FROM paginablok b LEFT JOIN onderdeel o ON o.i_id = b.i_id");
    $query = mysql_query($sql);
    while ($myrow = mysql_fetch_array($query)) {
        echo ("<table>");
        echo ("<tr><th>" . $myrow['paginanaam'] . "</th></tr>");
        echo ("<tr><td>" . $myrow['samenvatting'] . "</td></tr>");
        echo ("<tr><td><form method='POST' action='editPaginaBlok.php'><input type='hidden' name='i_id' value='" . $myrow['i_id'] . "'><input type='hidden' name='b_id' value='" . $myrow['b_id'] . "'><input class='btn-style' type='submit' value='Wijzig' name='wijzigknop'></form></td></tr>");
        echo ("</table>");
        echo ("<hr>");
    }                                                                           #wijzig knop
}

function editBlokForm($blokId) {                                             #zet de huidige gegevens van de database in een formulier
    $blokId = (int) $blokId;
    $query = mysql_query("SELECT * FROM paginablok b LEFT JOIN onderdeel o ON o.i_id = b.i_id WHERE o.i_id =b.i_id AND b_id = $blokId") or die(mysql_error());
    return mysql_fetch_assoc($query);
}

function PaginaBlok($blokId) {
    $sql = ("SELECT * FROM paginablok b LEFT JOIN onderdeel o ON o.i_id = b.i_id WHERE o.i_id = b.i_id AND b.b_id = $blokId");
    $query = mysql_query($sql);
    while ($myrow = mysql_fetch_array($query)) {
        echo ("<div class='col-sm-3'><h4>" . $myrow['paginanaam'] . "</h4>"); #volgorde en de paginanaam
        echo ($myrow['samenvatting'] . "<br><br>");     #paginainhoud weergeven
        echo ("<div class='col-sm-3'><a href='" . $myrow['link'] . "'class='btn btn-primary btn-lg btstyle'>Meer</a></div></form></div>");
    }                                                                           #wijzig knop
}

function editPaginaBlok($tekst, $blokId) {
    $blokId = (int) $blokId;
    $sql = mysql_query("UPDATE paginablok SET samenvatting = '$tekst' WHERE b_id = '$blokId' ") or die(mysql_error());
#veranderd huidige inhoud van database
}

function blokRandomizerCMS() {
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
    PaginaBlokCMS($random1);
    PaginaBlokCMS($random2);
    PaginaBlokCMS($random3);
    PaginaBlokCMS($random4);
}

function PaginaBlokCMS($blokId) {
    $sql = ("SELECT * FROM paginablok b LEFT JOIN onderdeel o ON o.i_id = b.i_id WHERE o.i_id = b.i_id AND b.b_id = $blokId");
    $query = mysql_query($sql);
    while ($myrow = mysql_fetch_array($query)) {
        echo ("<div class='col-sm-3'><h4>" . $myrow['paginanaam'] . "</h4>"); #volgorde en de paginanaam
        echo ($myrow['samenvatting'] . "<br><br>");     #paginainhoud weergeven
        echo ("<div class='col-sm-3'><a href='../" . $myrow['link'] . "'class='btn btn-primary btn-lg btstyle'>Meer</a></div></form></div>");
    }                                                                           #wijzig knop
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
                echo ($myrow['bericht']);                                       #de mededeling
                ?>
                <table>
                    <tr>
                        <td>
                            <form method='POST' action='editmededeling.php'>
                                <input type='hidden' name='id' value='<?php echo ($myrow['m_id']) ?>'>
                                <input class='btn-style' type='submit' value='Wijzig' name='wijzigknop'>&nbsp; 
                            </form>
                        </td>
                        <td>
                            <form method='POST' action='deletemededeling.php'>
                                <input type='hidden' name='id' value='<?php echo ($myrow['m_id']) ?>'>
                                &nbsp;<input class='btn-style' type='submit' value='Verwijder' name='verwijderknop'>
                            </form>
                        </td>
                    </tr>
                </table> 

                <hr>                                                    
                <?php
#lijn over pagina
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
            echo ($myrow['bericht']);                                           #bericht
            ?>
            <table>
                <tr>
                    <td>
                        <form method='POST' action='editnieuws.php'>
                            <input type='hidden' name='id' value='<?php echo ($myrow['n_id']) ?>'>
                            <input class='btn-style' type='submit' value='Wijzig' name='wijzigknop'>&nbsp; 
                        </form>
                    </td>
                    <td>
                        <form method='POST' action='deletenieuws.php'>
                            <input type='hidden' name='id' value='<?php echo ($myrow['n_id']) ?>'>
                            &nbsp;<input class='btn-style' type='submit' value='Verwijder' name='verwijderknop'>
                        </form>
                    </td>
                </tr>
            </table> 

            <hr>                                                    
            <?php
#wijzig en verwijder knop van nieuws
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

function deleteNieuws($id) {
    $id = (int) $id;
    mysql_query("DELETE FROM nieuws WHERE n_id = '$id'") or die(mysql_error());
    header("Location: nieuws.php");                                         #verwijderen van mededelingen
}

function addNieuws($titel, $tekst) {                                              #toevoegen van mededelingen
    $query = mysql_query("INSERT INTO nieuws VALUES (NULL,CURRENT_DATE( ),'$titel','$tekst')") or die(mysql_error());
}

#id/datum wordt automatisch gezet

function editNieuwsForm($id) {
    $id = (int) $id;
    $query = mysql_query("SELECT * FROM nieuws WHERE n_id = '$id'") or die(mysql_error());
    return mysql_fetch_assoc($query);                                           #zet de huidige gegevens van de database in een formulier
}

function editNieuws($id, $titel, $tekst) {
    $id = (int) $id;                                                            #veranderd de huidige gegevens in de database
    $query = mysql_query("UPDATE nieuws SET titel = '$titel', bericht = '$tekst', datum = CURRENT_DATE( ) WHERE n_id = '$id'") or die(mysql_error());
}

function addImage($naam) {
    $query = mysql_query("INSERT INTO images VALUES (NULL,'$naam')");
}

function getImages() {
    $sql = ("SELECT * FROM images");
    $query = mysql_query($sql);
    echo ("<form method='POST'><table class='afbeelding'>");
    echo ("<tr class='afbeelding'><th>Naam</th><th>Afbeelding</th></tr>");
    while ($myrow = mysql_fetch_array($query)) {
        ?>
        <tr class="afbeelding">
            <td class="afbeelding"><input type='checkbox' name='<?php echo $myrow['naam']; ?>'><?php echo $myrow['naam']; ?></input></td>
            <td class="afbeelding"><img src='uploads/<?php echo $myrow['naam']; ?>' width='200px' height='120px'></td>
        </tr>
        <?php
    }
    echo ("<tr class='afbeelding'><td><input class='btn-style' type='submit' value='selecteer' name='verwijderknop'></td></td><td>");
    echo ("</table></form>");
}
function getPaginaInhoud ($i_id){
    $sql = ("SELECT * FROM onderdeel WHERE i_id = $i_id");
    $query = mysql_query($sql);
    while ($myrow = mysql_fetch_array($query)) {
        echo ("<h1>" . $myrow['paginanaam'] . "</h1>"); #volgorde en de paginanaam
        echo ($myrow['paginainhoud']);     #paginainhoud weergeven
    }
}

function newPagina() {
    $query = mysql_query("SELECT * FROM onderdeel") or die(mysql_error());
    $rows = mysql_num_rows($query);
    echo ("getPaginaInhoud(".$rows. ";)");  
}

function newPaginaKop() {
    echo ("<select name='kop'>");                                          #geeft een dropdownmenu met keuze voor volgorde
    $sql = "SELECT * FROM pagina WHERE p_id != 5";
    $result = mysql_query($sql);
    while ($myrow = mysql_fetch_array($result)) {
        echo ("<option value='" . $myrow['p_id'] . "'>" . $myrow['paginanaam'] . "</option>");
    }
}

function getvolgorde ($pid) {
    $query = mysql_query("SELECT * FROM onderdeel WHERE p_id = $pid") or die(mysql_error());
    $rows = mysql_num_rows($query);
    $nieuw = $rows + 1;
    return ($nieuw);
}
function addPagina($pid, $naam, $tekst) {
    $volgorde = getvolgorde($pid);
    $query = mysql_query("INSERT INTO onderdeel VALUES (NULL, $pid, $volgorde, '$naam.php' '$naam','$tekst')") or die(mysql_error());
}