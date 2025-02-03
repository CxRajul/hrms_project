<?php
// reports.php - HR Analytics & Reports Page
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once '../controllers/reportsController.php';
$performanceReport = $reportsController->getEmployeePerformanceReport();
$payrollReport = $reportsController->getPayrollReport();
$leaveReport = $reportsController->getLeaveReport();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Reports - HRMS</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="routes.php?page=dashboard">Dashboard</a></li>
            <li><a href="routes.php?page=employees">Employees</a></li>
            <li><a href="routes.php?page=payroll">Payroll</a></li>
            <li><a href="routes.php?page=attendance">Attendance</a></li>
            <li><a href="routes.php?page=leave">Leave</a></li>
            <li><a href="routes.php?page=reports">Reports</a></li>
            <li><a href="routes.php?page=logout">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>HR Analytics & Reports</h2>
        <h3>Employee Performance Report</h3>
        <table>
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Total Days Present</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($performanceReport as $record): ?>
                <tr>
                    <td><?php echo $record['id']; ?></td>
                    <td><?php echo $record['designation']; ?></td>
                    <td><?php echo $record['department']; ?></td>
                    <td><?php echo $record['total_days_present']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Payroll Report</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee ID</th>
                    <th>Salary Month</th>
                    <th>Salary Paid</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payrollReport as $record): ?>
                <tr>
                    <td><?php echo $record['id']; ?></td>
                    <td><?php echo $record['employee_id']; ?></td>
                    <td><?php echo $record['salary_month']; ?></td>
                    <td><?php echo $record['salary_paid']; ?></td>
                    <td><?php echo $record['payment_status']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Leave Report</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee ID</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaveReport as $record): ?>
                <tr>
                    <td><?php echo $record['id']; ?></td>
                    <td><?php echo $record['employee_id']; ?></td>
                    <td><?php echo $record['leave_type']; ?></td>
                    <td><?php echo $record['start_date']; ?></td>
                    <td><?php echo $record['end_date']; ?></td>
                    <td><?php echo $record['status']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>