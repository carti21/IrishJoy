<?php 
define("HOST", "localhost"); // The host you want to connect to.
define("USER", "irishjoy_member"); // The database username.
define("PASSWORD", "user.member."); // The database password. 
define("DATABASE", "irishjoy_db"); // The database name.
 
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
// If you are connecting via TCP/IP rather than a UNIX socket remember to add the port number as a parameter

?>
