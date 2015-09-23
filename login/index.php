<?php 

	$root = realpath(__DIR__ . '/..');
	include("$root/admin/functions-admin.php");

	sec_session_start();
	if(login_check($mysql_conn) == true) {
	 
	   header('Location:'. MAIN_URL .'admin/index.php');
	 
	} else {
	   header('Location:'. MAIN_URL .'admin/login.php');
	}

