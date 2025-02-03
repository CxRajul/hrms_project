<?php
include('../include/header.php');
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'hr')) {
    header("Location: dashboard.php");
    exit();
}

require_once '../config/config.php';

// Handle user role updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'], $_POST['role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['role'];

    $updateQuery = $db->prepare("UPDATE users SET role = ? WHERE id = ?");
    $updateQuery->bind_param("si", $new_role, $user_id);
    $updateQuery->execute();
}

// Fetch all users
$query = $db->query("SELECT id, name, email, role, status FROM users ORDER BY name ASC");
$users = $query->fetch_all(MYSQLI_ASSOC);
?>

    <div class="container manage-users-container">
        <h2>Manage Users</h2>

        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo ucfirst($user['role']); ?></td>
                    <td><?php echo ucfirst($user['status']); ?></td>
                    <td>
                        <form action="" method="POST" class="inline-form">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <select name="role">
                                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                                <option value="hr" <?php if ($user['role'] == 'hr') echo 'selected'; ?>>HR</option>
                                <option value="employee" <?php if ($user['role'] == 'employee') echo 'selected'; ?>>Employee</option>
                            </select>
                            <button type="submit">Update Role</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <a href="<?php echo BASE_URL; ?>/views/dashboard.php">Back to Dashboard</a>
    </div>
<?php include('../include/footer.php'); ?>
