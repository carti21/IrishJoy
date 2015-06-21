<?php 

	define('MAIN_URL', 'http://localhost/irishjoy/');

	define("HOST", "localhost"); // The host you want to connect to.
	define("USER", "root"); // The database username.
	define("PASSWORD", "112"); // The database password. 
	define("DATABASE", "irishjoy"); // The database name.
	  
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
