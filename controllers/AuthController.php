<?php
session_start();

// Database connection
require_once '../config/config.php';

class Auth {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // User registration with password hashing
    public function register($name, $email, $password, $role) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
        return $stmt->execute();
    }

    // User login with password verification
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT id, name, password, role FROM users WHERE email = ? AND status = 'active'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        var_dump($result);

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Debugging output (Remove after testing)
            error_log("Stored Hash: " . $user['password']);
            error_log("Input Password: " . $password);

            if (password_verify($password, $user['password'])) {
                // var_dump($user);
                // echo $password;
                // exit();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                // Debugging message
                error_log("Login Successful for: " . $_SESSION['user_name']);

                // Redirect to dashboard
                header("Location: /hrms_project/views/dashboard.php");
                exit();
            } else {
                error_log("Password mismatch for: $email");
            }
        } else {
            error_log("User not found or inactive: $email");
        }

        // Redirect back to login page if login fails
        header("Location: ../views/login.php?error=invalid_credentials");
        exit();
    }

    // Logout function
    public function logout() {
        session_destroy();
        header("Location: ../views/login.php");
        exit();
    }
}

// Database connection setup
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$auth = new Auth($db);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'login' && isset($_POST['email'], $_POST['password'])) {
        $auth->login($_POST['email'], $_POST['password']);
    } elseif ($action === 'logout') {
        $auth->logout();
    }
}
?>


<!-- <?php
// controllers/AuthController.php - Handles authentication logic
require_once '../config/config.php';
session_start();

class AuthController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $email, $password, $role) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
        return $stmt->execute();
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT id, name, password, role FROM users WHERE email = ? AND status = 'active'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                return true;
            }
        }
        return false;
    }

    public function logout() {
        session_destroy();
        header("Location: ../views/login.php");
        exit();
    }
}

// Database Connection
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$authController = new AuthController($db);
?> -->