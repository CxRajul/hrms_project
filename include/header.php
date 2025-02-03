<?php
    session_start();
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    // Get the current script filename
    $current_page = basename($_SERVER['PHP_SELF']);
    //base url
    function getBaseUrl(){
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    }
    if($_SERVER['HTTP_HOST'] == "localhost"){
        $baseUrl = getBaseUrl()."/hrms_project";
    }else{
        $baseUrl = getBaseUrl();
    }
    define('BASE_URL', $baseUrl);
    //end
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
</head>
<body>

    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li><a href="<?php echo BASE_URL; ?>/views/dashboard.php">Dashboard</a></li>
            <li><a href="<?php echo BASE_URL; ?>/views/profile.php">Profile</a></li>
            <li><a href="<?php echo BASE_URL; ?>/views/attendance.php">Attendance</a></li>
            <li><a href="<?php echo BASE_URL; ?>/views/payroll.php">Payroll</a></li>
            <li><a href="<?php echo BASE_URL; ?>/views/leave.php">Leave</a></li>
            <li><a href="<?php echo BASE_URL; ?>/views/reports.php">Reports</a></li>
            <li><a href="<?php echo BASE_URL; ?>/views/logout.php">Logout</a></li>
        </ul>
    </nav>
