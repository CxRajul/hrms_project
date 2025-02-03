<?php
// payroll.php - Payroll Management Page
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once '../controllers/payrollController.php';
$payrollRecords = $payrollController->getPayrollRecords();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll - HRMS</title>
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
        <h2>Payroll Management</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee ID</th>
                    <th>Salary Month</th>
                    <th>Salary Paid</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payrollRecords as $record): ?>
                <tr>
                    <td><?php echo $record['id']; ?></td>
                    <td><?php echo $record['employee_id']; ?></td>
                    <td><?php echo $record['salary_month']; ?></td>
                    <td><?php echo $record['salary_paid']; ?></td>
                    <td><?php echo $record['payment_status']; ?></td>
                    <td>
                        <a href="edit_payroll.php?id=<?php echo $record['id']; ?>">Edit</a>
                        <a href="delete_payroll.php?id=<?php echo $record['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>