<?php
    // models/Auth.php - Authentication Model
    require_once '../config/config.php';

    class AuthModel {
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

        public function login($email) {
            $stmt = $this->conn->prepare("SELECT id, name, password, role FROM users WHERE email = ? AND status = 'active'");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
    }

    // Database Connection
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $authModel = new AuthModel($db);
?>
