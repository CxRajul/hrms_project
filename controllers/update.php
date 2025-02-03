<?php
require_once '../config/config.php';

// Connect to database
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Define users and their plaintext passwords (as per your dummy data)
$users = [
    ['admin@example.com', 'admin123'],
    ['hr@example.com', 'hr123'],
    ['john@example.com', 'employee123']
];

foreach ($users as $user) {
    $email = $user[0];
    $hashed_password = password_hash($user[1], PASSWORD_BCRYPT);

    $stmt = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    $stmt->execute();
}

echo "Passwords updated successfully!";
?>
