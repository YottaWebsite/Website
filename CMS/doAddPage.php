<?php
include 'includes/functions.php';
include 'includes/paginabegin.php';
include 'includes/paginaeind.php';

$myfile = fopen($_POST['naam'].".php", "w") or die("Unable to open file!");
fwrite($myfile, $begin);
$text = newPagina();
fwrite($myfile, $text);
fwrite($myfile, $eind);
fclose($myfile);
?>