<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="../controllers/authController.php" method="POST">
            <input type="hidden" name="action" value="register">

            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <label for="role">Select Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="hr">HR</option>
                <option value="employee">Employee</option>
            </select>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="<?php echo BASE_URL; ?>/views/login.php">Login here</a></p>
    </div>
</body>
</html>
