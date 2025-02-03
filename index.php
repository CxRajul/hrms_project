<?php
session_start();
var_dump($_SESSION);
// exit();
// Redirect users based on login status
if (isset($_SESSION['user_id'])) {
    header("Location: views/dashboard.php");
    exit();
} else {
    header("Location: views/login.php");
    exit();
}
?>
