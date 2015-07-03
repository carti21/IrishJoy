<?php 

	define('MAIN_URL', 'http://localhost/irishjoy/');
	define('UPLOADS_URL', MAIN_URL.'/uploads/');

    define('PANEL_URL', 'http://localhost/irishjoy/panel/');
    define('GOOGLE_ANALYTICS_URL', '/irishjoy/');
    define('PHPMYADMIN_URL', 'localhost/phpmyadmin/');
    define('EMAIL_URL', '/irishjoy/');
    define('SERVER_URL', dirname( __FILE__ ).'/');

	define("HOST", "localhost"); // The host you want to connect to.
	define("USER", "root"); // The database username.
	define("PASSWORD", "112"); // The database password. 
	define("DATABASE", "irishjoy"); // The database name.
	  
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
