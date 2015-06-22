<?php 

	$root = realpath(__DIR__ . '/..');
	include "$root/panel/includes/functions.php";


	sec_session_start();
	if(login_check($mysqli) == true) {
	 
	   header('Location:'. MAIN_URL .'panel/panel.php');
	 
	} else {
	   header('Location:'. MAIN_URL .'panel/login.php');
	}

