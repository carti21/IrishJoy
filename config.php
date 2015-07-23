<?php 
	
	define('MAIN_URL', 'http://localhost/irishjoy/');

	/*
	Database Configurations
	*/
	define('HOST', 'localhost'); // The host you want to connect to.
	define('USER', 'root'); // The database username.
	define('PASSWORD', '112'); // The database password. 
	define('DATABASE', 'irishjoy'); // The database name.
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	
	/*
	Paths - Changing not Recommanded. Only if changing folder structure directory
	*/
	define('UPLOADS_URL', MAIN_URL.'uploads/');
	define('PANEL_URL', MAIN_URL.'panel/');
	define('SERVER_URL', dirname( __FILE__ ).'/');
	
	define('GOOGLE_ANALYTICS_URL', '/irishjoy/');
	define('PHPMYADMIN_URL', 'localhost/phpmyadmin/');
	define('EMAIL_URL', '/irishjoy/');


	define('MAX_LOGIN_ATTEMPTS', 5);
	define('BLOCK_USER_DURATION', 2*60*60);
	
	
