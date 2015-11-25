<?php

/**
 * Main Directory
 */
define('MAIN_URL', 'http://localhost/IrishJoy/');

/**
 * Database Configurations
 */
define('HOST', 'localhost');       // The host you want to connect to.
define('USER', 'root');            // The database username.
define('PASSWORD', '112');         // The database password.
define('DATABASE', 'irishjoy');    // The database name.
$mysql_conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

/**
 * Paths - Changing not Recommended. Only if changing folder structure directory
 */
define('UPLOADS_URL', MAIN_URL . 'uploads/');
define('ADMIN_URL', MAIN_URL . 'admin/');
define('SERVER_URL', dirname(__FILE__) . '/');

define('GOOGLE_ANALYTICS_URL', '/irishjoy/');
define('PHPMYADMIN_URL', 'http://localhost/phpmyadmin/');

define('MAX_LOGIN_ATTEMPTS', 5);
define('BLOCK_USER_DURATION', 2 * 60 * 60);
define('COOKIE_LIFETIME', 60 * 60 * 24);

/**
 *  Error Reporting ON on Development
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

