<?php 
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	include "$root/panel/super/includes/db_connect.php";
	include "$root/panel/super/includes/functions.php";
	error_reporting(0); // jane gabime qe duhen pare ne fund !!! 
		// Include database connection and functions here.
	sec_session_start();
	if(login_check($mysqli) == true) {
	 
	   header('Location:http://irishjoy.com/panel/panel.php');
	 
	} else {
	   header('Location:http://irishjoy.com/panel/login.php');
	}

 ?>

 