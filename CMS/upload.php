<?php
include 'includes/functions.php';
// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip');
$naam = $_FILES['upl']['name'];

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}

	if(move_uploaded_file($_FILES['upl']['tmp_name'], 'uploads/'.$_FILES['upl']['name'])){
		echo '{"status":"success"}';
                addImage($naam);
		exit;
	}
}

echo '{"status":"error"}';
exit;