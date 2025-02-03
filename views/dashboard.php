<?php
    include('../include/header.php');
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    $user_role = $_SESSION['user_role'] ?? 'Guest';
    $user_name = $_SESSION['user_name'] ?? 'User';
?>

    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
        <p>Your role: <strong><?php echo ucfirst($user_role); ?></strong></p>

        <!-- Role-Specific Dashboard Cards -->
        <div class="dashboard-grid">
            
            <?php if ($user_role === 'admin' || $user_role === 'hr') { ?>
                <div class="card">
                    <h3>Manage Users</h3>
                    <p>View and manage employee accounts.</p>
                    <a href="<?php echo BASE_URL; ?>/views/manage_users.php">Go to Users</a>
                </div>
                <div class="card">
                    <h3>Payroll</h3>
                    <p>Manage and process employee salaries.</p>
                    <a href="<?php echo BASE_URL; ?>/views/payroll.php">View Payroll</a>
                </div>
            <?php } ?>

            <?php if ($user_role === 'employee') { ?>
                <div class="card">
                    <h3>Attendance</h3>
                    <p>Check your attendance records.</p>
                    <a href="<?php echo BASE_URL; ?>/views/attendance.php">View Attendance</a>
                </div>
                <div class="card">
                    <h3>Apply for Leave</h3>
                    <p>Request time off and view status.</p>
                    <a href="<?php echo BASE_URL; ?>/views/leave.php">Apply Leave</a>
                </div>
            <?php } ?>

            <div class="card">
                <h3>Reports & Analytics</h3>
                <p>View HR insights and analytics.</p>
                <a href="<?php echo BASE_URL; ?>/views/reports.php">View Reports</a>
            </div>

        </div>
    </div>
    <?php include('../include/footer.php'); ?>
