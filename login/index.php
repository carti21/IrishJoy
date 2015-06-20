<?php 

	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	include "$root/panel/super/includes/db_connect.php";
	include "$root/panel/super/includes/functions.php";

		// Include database connection and functions here.
	sec_session_start();
	if(login_check($mysqli) == true) {
	 
	   header('Location:http://irishjoy.flivetech.com/panel/super/panel.php');
	 
	} else {
	   header('Location:http://irishjoy.flivetech.com/panel/super/login.php');
	}


 



