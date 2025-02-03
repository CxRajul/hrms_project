<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'phpmyadmin');
    define('DB_PASS', 'password');
    define('DB_NAME', 'hrms_db');

    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
?>
