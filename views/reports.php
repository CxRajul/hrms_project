<?php
include('../include/header.php');
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'hr')) {
    header("Location: dashboard.php");
    exit();
}

require_once '../config/config.php';

// Fetch attendance summary
$attendanceQuery = $db->query("SELECT status, COUNT(*) as count FROM attendance GROUP BY status");
$attendanceStats = [];
while ($row = $attendanceQuery->fetch_assoc()) {
    $attendanceStats[$row['status']] = $row['count'];
}

// Fetch leave statistics
$leaveQuery = $db->query("SELECT status, COUNT(*) as count FROM leave_requests GROUP BY status");
$leaveStats = [];
while ($row = $leaveQuery->fetch_assoc()) {
    $leaveStats[$row['status']] = $row['count'];
}

// Fetch payroll summary
$payrollQuery = $db->query("SELECT SUM(salary) as total_salary FROM employees");
$payrollSummary = $payrollQuery->fetch_assoc();
?>

    <div class="container reports-container">
        <h2>HR Reports & Analytics</h2>

        <div class="dashboard-grid">
            <div class="card">
                <h3>Attendance Summary</h3>
                <table>
                    <tr><th>Status</th><th>Count</th></tr>
                    <?php foreach ($attendanceStats as $status => $count) { ?>
                        <tr>
                            <td><?php echo ucfirst($status); ?></td>
                            <td><?php echo $count; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <div class="card">
                <h3>Leave Statistics</h3>
                <table>
                    <tr><th>Status</th><th>Count</th></tr>
                    <?php foreach ($leaveStats as $status => $count) { ?>
                        <tr>
                            <td><?php echo ucfirst($status); ?></td>
                            <td><?php echo $count; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <div class="card">
                <h3>Payroll Summary</h3>
                <p>Total Salary Expense: <strong>$<?php echo number_format($payrollSummary['total_salary'], 2); ?></strong></p>
            </div>
        </div>

        <a href="<?php echo BASE_URL; ?>/views/dashboard.php">Back to Dashboard</a>
    </div>
<?php include('../include/footer.php'); ?>
 