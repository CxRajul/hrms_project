<?php
include('../include/header.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/config.php';

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

// Handle attendance marking
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mark_attendance'])) {
    $status = $_POST['status'];

    $stmt = $db->prepare("INSERT INTO attendance (employee_id, date, status) VALUES (?, CURDATE(), ?)
                           ON DUPLICATE KEY UPDATE status = VALUES(status)");
    $stmt->bind_param("is", $user_id, $status);
    $stmt->execute();
}

// Fetch attendance records
$query = ($user_role === 'admin' || $user_role === 'hr') 
    ? $db->query("SELECT u.name, a.date, a.status FROM attendance a JOIN users u ON a.employee_id = u.id ORDER BY a.date DESC")
    : $db->prepare("SELECT date, status FROM attendance WHERE employee_id = ? ORDER BY date DESC");

if ($user_role !== 'admin' && $user_role !== 'hr') {
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();
    $attendance = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $attendance = $query->fetch_all(MYSQLI_ASSOC);
}
?>
    <div class="container attendance-container">
        <h2>Attendance Management</h2>

        <?php if ($user_role === 'employee') { ?>
            <form action="" method="POST">
                <label for="status">Mark Attendance:</label>
                <select name="status">
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                    <option value="on leave">On Leave</option>
                </select>
                <button type="submit" name="mark_attendance">Submit</button>
            </form>
        <?php } ?>

        <h3>Attendance Records</h3>
        <table>
            <tr>
                <th>Date</th>
                <?php if ($user_role === 'admin' || $user_role === 'hr') { ?>
                    <th>Employee</th>
                <?php } ?>
                <th>Status</th>
            </tr>
            <?php foreach ($attendance as $record) { ?>
                <tr>
                    <td><?php echo $record['date']; ?></td>
                    <?php if ($user_role === 'admin' || $user_role === 'hr') { ?>
                        <td><?php echo $record['name']; ?></td>
                    <?php } ?>
                    <td><?php echo ucfirst($record['status']); ?></td>
                </tr>
            <?php } ?>
        </table>

        <a href="<?php echo BASE_URL; ?>/views/dashboard.php">Back to Dashboard</a>
    </div>
<?php include('../include/footer.php'); ?>
