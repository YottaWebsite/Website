     <?php
    include 'functies.php';
    //Complete array voor alle door Yotta ondersteunde domeinen.
    $servers = array(
    ".nl" => "whois.domain-registry.nl", // Nederland
    ".com" => "whois.verisign-grs.com",
    ".biz" => "whois.biz",
    ".tv" => "tvwhois.verisign-grs.com",
    ".se" => "whois.iis.se", // Zweden
    ".bz" => "whois.belizenic.bz", // Belize
    ".sh" => "whois.nic.sh", // Sint Helena
    ".es" => "whois.nic.cc", // Spanje
    ".eu" => "whois.eu", //Europa
    ".net" => "whois.verisign-grs.net",
    ".nu" => "whois.nic.nu", // Niue
    ".uk" => "whois.nic.uk", // Verenigd Koningkrijk
    ".co.uk" => "whois.nic.uk", // Verenigd Koningkrijk
    ".co" => "whois.nic.co", // Colombië
    ".jp" => "whois.jprs.jp", // Japan
    ".cc" => "whois.nic.cc", // Kokos Eilanden
    ".tc" => "whois.meridiantld.net", // Turkije
    ".mobi" => "whois.dotmobiregistry.net",
    ".be" => "whois.dns.be", // België
    ".org" => "whois.pir.org",
    ".ws" => "whois.website.ws",
    ".ch" => "whois.nic.ch", // Zwitserland
    ".ac" => "whois.nic.ac", // Ascension Eiland
    ".gs" => "whois.nic.gs", // Zuid Georgië
    ".vg" => "whois.nic.vg", // Virgin Islands, Verenigd Koningkrijk
    ".de" => "whois.verisign-grs.com", // Duitsland
    ".info" => "whois.afilias.net",
    ".fm" => "whois.godaddy.com",
    ".cn" => "whois.cnnic.net.cn", // China
    ".ag" => "whois.nic.ag",
    ".ag" => "whois.nic.ag",
    ".ms" => "whois.nic.ms", // Montserrat
    ".ro" => "whois.rotld.ro", // Roemenië
    ".it" => "whois.nic.it", // Italië
    ".ca" => "whois.cira.ca", // Canada
    ".am" => "whois.amnic.net", // Armenië
    ".us" => "whois.nic.us", // Verenigde Staten
    ".at" => "whois.nic.at", // Oostenrijk
    ".pl" => "whois.dns.pl", // Polen
    ".ru" => "whois.tcinet.ru", // Russische Federatie
    );

    //Voor controle op beschikbaarheid
    $ischk = array(
        "is free", 
        "No match for", 
        "not found", 
        "is available",
        "No match", 
        "status: available",
        "is available",
        "We do not have an entry in our database", 
        "no object found", 
        "no matching record", 
        "no entries", 
        "nothing found", 
        "no information available"
    );

    
    $pass = false;

    //Controleert of button 'con' ingedrukt is
    if (!isset($_POST['con'])) {
    goto c;
    }

    //Controleert of domeinnaam is opgegeven
    if (empty($_POST['donaam'])) {
    print ("<h3>Er is geen domeinnaam opgegeven om te controleren.</h3>");
    goto c;
    }


    if (!empty($_POST['donaam'])) {
    $domein = $_POST['donaam'];
    }
    

    //Override functie (niet in final prod.)
    if ($_POST['donaam'] == "1=1") {
        $domeinn = $_POST['donaam'];
        $domeinn .= $_POST['ext'];
        echo "<b>Override in gebruik (niet in eindproduct)</b>";
        echo var_dump($pass);
        echo "<h4>Domein: " . "$domeinn<br>" . "</h4><h4><br>Server:" . $servers['.nl'] . "<a href='extrawhois.php' target='_blank'><br>Extra info</a></h4>";
        echo "<h4><u>Het gecontroleerde domein is beschikbaar voor aankoop!</u></h4>";
        $pass = true;
        echo var_dump($pass);
        goto c;
    }

    if ($_POST['donaam'] == "1=2") {
        $domeinn = $_POST['donaam'];
        $domeinn .= $_POST['ext'];
        echo "<b>Override in gebruik (niet in eindproduct)</b>";
        echo var_dump($pass);
        echo "<h4>Domein: " . "$domeinn<br>" . "</h4><h4><br>Server:" . $servers['.nl'] . "<a href='extrawhois.php' target='_blank'><br>Extra info</a></h4>";
        echo "<h4><u>Het gecontroleerde domein is beschikbaar voor aankoop!</u></h4>";
        $pass = true;
        $chk = false;
        $ext = ".nl";
        goto x;
    }
    
    $ext = ($_POST['ext']);
    $domein = clean($domein);

    //Extra controle na clean functie
    if ($domein == '' || strlen($domein) >= 100) {
        echo "<h3>Het opgegeven domeinnaam is niet geldig of is te lang.</h3>";
        goto c;
    }
    
    $domeinf = $domein;
    $domeinf = wordwrap($domeinf, 20 , "<br>", true);
    $domeinf .= $ext;
    
    //Controleert of er niet geklungeld is met de extensie of dat er niets is ingevult
    if (array_key_exists($ext, $servers) && (!empty($_POST['donaam']))) {
    $server = ($servers[$ext]);
    echo ("<h4>Domein: " . "$domeinf<br>" . "</h4><h4><br>Server: $server <a href='extrawhois.php' target='_blank'><br>Extra info</a></h4>");
    $result = QueryWhoisServer($server, $domeinf);
    $chk = check($result, $ischk);
        if (!$chk) {
            echo '<p>Er kon geen verbinding worden gemaakt met de server, probeer het opnieuw</p>';
            goto c;
        }
    } else {
    echo "<h3>Geen geldige extensie.<br></h3><h4>Gebruik voor het controleren van een domein een geldige extensie.</h4><br>";
    goto c;
    }
    
    x:
    if ($chk) {
    $bs = "<p><b><u>Het gecontroleerde domein is beschikbaar voor aankoop!</u></b></p>";
    echo ("<p> $bs </p>");
    $pass = true;
    } else {
    $bs = "<p><b><u>Het gecontroleerde domein is al in gebruik, we hebben voor u een paar alternatieven gekozen.</u></b><br></p><h5> Is dit uw domein?<br> Dan kunt ook voor de optie kiezen om uw domein<br> te verhuizen naar de voordelige servers van Yotta.</h5><br>";
    echo ("<p> $bs </p>");
    echo $domein . 'site' . $ext . "<br>";
    echo $domein . 'bv' . $ext . "<br>";
    echo $domein . 'nv' . $ext . "<br>";
    echo $domein . 'vof' . $ext . "<br>";
    echo $domein . 'online' . $ext . "<br>";
    echo $domein . 'shop' . $ext ."<br>";
    $pass = true;
    }

    
//Delete
i:
  /*  $smsg = $result;
    $_SESSION['einfo'] = $smsg;
    */
    $_SESSION['webdom1'] = $domeinn;
    $_SESSION['ext'] = $ext;
c: 
?>