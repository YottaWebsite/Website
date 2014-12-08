    <?php
    //Connectie met WhoIs server
    function QueryWhoisServer($whoisserver, $domain) {
    $port = 43;
    $timeout = 5;
    $errm = "<p1>Er kon geen verbinding worden gemaakt met de server</p1>";
    $fp = @fsockopen($whoisserver, $port, $errno, $errstr, $timeout);
    if (!$fp) {
        goto c;
    }
    fputs($fp, $domain . "\r\n");
    $out = "";
    while (!feof($fp)) {
        $out .= fgets($fp);
    }
    fclose($fp);
    //Ophalen gegevens server
    $res = "";
    if ((strpos(strtolower($out), "error") === FALSE) && (strpos(strtolower($out), "not allocated") === FALSE)) {
        $rows = explode("\n", $out);
        foreach ($rows as $row) {
            $row = trim($row);
            if (($row != ':') && ($row != '#') && ($row != '%')) {
                $res .= $row . "<br>";
            }
        }
    }
    return $res;
    break;
    c:
    return $errm;
    }
    

    function check($hay, $array) {
            foreach ($array as $array_element) {
                if (stripos($hay, $array_element) !== false ) {
                          return true;
                    }
            }
    return false;
    }


    
    function clean($domein) {
    $domein = trim($domein);
    if (substr(strtolower($domein), 0, 7) == "http://") {
    $domein = substr($domein, 7);
    }
    if (substr(strtolower($domein), 0, 4) == "www.") {
    $domein = substr($domein, 4);
    }
    $domein = preg_replace('/[^A-Za-z0-9\-]/', '', $domein);
        return $domein;
    }
?>
