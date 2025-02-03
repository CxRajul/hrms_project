<?php
    // routes.php - Handles navigation between pages
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: views/login.php");
        exit();
    }

    // Routing Logic
    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

    switch ($page) {
        case 'dashboard':
            include 'views/dashboard.php';
            break;
        case 'employees':
            include 'views/employees.php';
            break;
        case 'payroll':
            include 'views/payroll.php';
            break;
        case 'attendance':
            include 'views/attendance.php';
            break;
        case 'leave':
            include 'views/leave.php';
            break;
        case 'reports':
            include 'views/reports.php';
            break;
        case 'logout':
            session_destroy();
            header("Location: views/login.php");
            exit();
        default:
            include 'views/404.php';
            break;
    }
?>
