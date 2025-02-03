<?php
include('../include/header.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/config.php';

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

// Handle leave application
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply_leave'])) {
    $leave_type = $_POST['leave_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $stmt = $db->prepare("INSERT INTO leave_requests (employee_id, leave_type, start_date, end_date, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isss", $user_id, $leave_type, $start_date, $end_date);
    $stmt->execute();
}

// Handle leave approval/rejection (For Admin & HR)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_leave'])) {
    $leave_id = $_POST['leave_id'];
    $status = $_POST['status'];

    $stmt = $db->prepare("UPDATE leave_requests SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $leave_id);
    $stmt->execute();
}

// Fetch leave requests
$query = ($user_role === 'admin' || $user_role === 'hr') 
    ? $db->query("SELECT l.id, u.name, l.leave_type, l.start_date, l.end_date, l.status FROM leave_requests l JOIN users u ON l.employee_id = u.id ORDER BY l.start_date DESC")
    : $db->prepare("SELECT id, leave_type, start_date, end_date, status FROM leave_requests WHERE employee_id = ? ORDER BY start_date DESC");

if ($user_role !== 'admin' && $user_role !== 'hr') {
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();
    $leave_requests = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $leave_requests = $query->fetch_all(MYSQLI_ASSOC);
}
?>

    <div class="container leave-container">
        <h2>Leave Management</h2>

        <?php if ($user_role === 'employee') { ?>
            <form action="" method="POST">
                <label for="leave_type">Leave Type:</label>
                <select name="leave_type" required>
                    <option value="sick">Sick Leave</option>
                    <option value="casual">Casual Leave</option>
                    <option value="paid">Paid Leave</option>
                </select>

                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" required>

                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" required>

                <button type="submit" name="apply_leave">Apply Leave</button>
            </form>
        <?php } ?>

        <h3>Leave Requests</h3>
        <table>
            <tr>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <?php if ($user_role === 'admin' || $user_role === 'hr') { ?>
                    <th>Employee</th>
                    <th>Actions</th>
                <?php } ?>
            </tr>
            <?php foreach ($leave_requests as $leave) { ?>
                <tr>
                    <td><?php echo ucfirst($leave['leave_type']); ?></td>
                    <td><?php echo $leave['start_date']; ?></td>
                    <td><?php echo $leave['end_date']; ?></td>
                    <td><?php echo ucfirst($leave['status']); ?></td>
                    <?php if ($user_role === 'admin' || $user_role === 'hr') { ?>
                        <td><?php echo $leave['name']; ?></td>
                        <td>
                            <form action="" method="POST" style="display:inline;">
                                <input type="hidden" name="leave_id" value="<?php echo $leave['id']; ?>">
                                <select name="status">
                                    <option value="approved">Approve</option>
                                    <option value="rejected">Reject</option>
                                </select>
                                <button type="submit" name="update_leave">Update</button>
                            </form>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>

        <a href="<?php echo BASE_URL; ?>/views/dashboard.php">Back to Dashboard</a>
    </div>
<?php include('../include/footer.php'); ?>
