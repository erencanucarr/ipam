<?php
// Database configuration for shared hosting (cPanel/Plesk)
define('DB_HOST', 'localhost');
define('DB_NAME', 'ipam');
define('DB_USER', 'root');
define('DB_PASS', '');

// Ensure mysqli extension is loaded
if (!extension_loaded('mysqli')) {
    die('The mysqli extension is not loaded. Please enable it in your PHP configuration.');
}

// Create global MySQLi connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

// Session settings
session_start();

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);