<?php 

	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	// to be checked the irishjoy. find out how can remove
	include "$root/irishjoy/panel/includes/functions.php";

		// Include database connection and functions here.
	sec_session_start();
	if(login_check($mysqli) == true) {
	 
	   header('Location:'. MAIN_URL .'panel/panel.php');
	 
	} else {
	   header('Location:'. MAIN_URL .'panel/login.php');
	}


 



