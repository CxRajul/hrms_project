<?php
include('../include/header.php');
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'hr')) {
    header("Location: dashboard.php");
    exit();
}

require_once '../config/config.php';

// Handle salary updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['employee_id'], $_POST['salary'])) {
    $employee_id = $_POST['employee_id'];
    $salary = $_POST['salary'];

    $updateQuery = $db->prepare("UPDATE employees SET salary = ? WHERE id = ?");
    $updateQuery->bind_param("di", $salary, $employee_id);
    $updateQuery->execute();
}

// Fetch employees and salary details
$query = $db->query("SELECT e.id, u.name, e.designation, e.salary FROM employees e JOIN users u ON e.user_id = u.id ORDER BY u.name ASC");
$employees = $query->fetch_all(MYSQLI_ASSOC);
?>

    <div class="container payroll-container">
        <h2>Payroll Management</h2>
        
        <h3>Employee Salary Details</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Designation</th>
                <th>Salary</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($employees as $employee) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($employee['name']); ?></td>
                    <td><?php echo htmlspecialchars($employee['designation']); ?></td>
                    <td>$<?php echo number_format($employee['salary'], 2); ?></td>
                    <td>
                        <form action="" method="POST" class="inline-form">
                            <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
                            <input type="number" name="salary" value="<?php echo $employee['salary']; ?>" required>
                            <button type="submit">Update Salary</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <a href="<?php echo BASE_URL; ?>/views/dashboard.php">Back to Dashboard</a>
    </div>
<?php include('../include/footer.php'); ?>
