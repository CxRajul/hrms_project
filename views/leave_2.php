<?php
// leave.php - Leave Management Page
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once '../controllers/leaveController.php';
$leaveRequests = $leaveController->getLeaveRequests();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management - HRMS</title>
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
        <h2>Leave Management</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee ID</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaveRequests as $request): ?>
                <tr>
                    <td><?php echo $request['id']; ?></td>
                    <td><?php echo $request['employee_id']; ?></td>
                    <td><?php echo $request['leave_type']; ?></td>
                    <td><?php echo $request['start_date']; ?></td>
                    <td><?php echo $request['end_date']; ?></td>
                    <td><?php echo $request['status']; ?></td>
                    <td>
                        <a href="edit_leave.php?id=<?php echo $request['id']; ?>">Edit</a>
                        <a href="delete_leave.php?id=<?php echo $request['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>