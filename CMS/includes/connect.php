<?php
define('DB_HOST','localhost');
define('DB_USER', 'root');
define('DB_PASS', 'usbw');
define('DB_NAME', 'cms');
define('DB_PORT', 3307);

$connection = mysql_connect(DB_HOST, DB_USER, DB_PASS, DB_PORT) or die (mysql_error());
mysql_select_db(DB_NAME) or die (mysql_error());

#Connectie maken met de database
?>