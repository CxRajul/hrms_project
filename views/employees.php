<?php
// employees.php - Employee Management Page
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once '../controllers/employeeController.php';
$employees = $employeeController->getEmployees();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees - HRMS</title>
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
        <h2>Employee Management</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?php echo $employee['id']; ?></td>
                    <td><?php echo $employee['name']; ?></td>
                    <td><?php echo $employee['email']; ?></td>
                    <td><?php echo $employee['designation']; ?></td>
                    <td><?php echo $employee['department']; ?></td>
                    <td><?php echo $employee['salary']; ?></td>
                    <td>
                        <a href="edit_employee.php?id=<?php echo $employee['id']; ?>">Edit</a>
                        <a href="delete_employee.php?id=<?php echo $employee['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
