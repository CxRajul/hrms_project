<?php
include('../include/header.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once '../config/config.php';
// Fetch user details
$user_id = $_SESSION['user_id'];
$query = $db->prepare("SELECT name, email FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
// Handle profile update
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    $updateQuery = $db->prepare("UPDATE users SET name = ? WHERE id = ?");
    $updateQuery->bind_param("si", $name, $user_id);

    if ($updateQuery->execute()) {
        $_SESSION['user_name'] = $name; // Update session name
        $message = "Profile updated successfully!";
    } else {
        $message = "Failed to update profile.";
    }
}
?>

    <div class="container profile-container">
        <h2>User Profile</h2>
        
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

        <form action="" method="POST">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>

            <button type="submit">Update Profile</button>
        </form>

        <a href="<?php echo BASE_URL; ?>/views/dashboard.php">Back to Dashboard</a>
    </div>
<?php include('../include/footer.php'); ?>
