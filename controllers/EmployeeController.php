<?php
    // employeeController.php - Handles employee management logic
    require_once '../config/config.php';
    session_start();

    class EmployeeController {
        private $conn;

        public function __construct($db) {
            $this->conn = $db;
        }

        // Add Employee
        public function addEmployee($user_id, $designation, $department, $salary, $date_of_joining) {
            $stmt = $this->conn->prepare("INSERT INTO employees (user_id, designation, department, salary, date_of_joining) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issds", $user_id, $designation, $department, $salary, $date_of_joining);
            return $stmt->execute();
        }

        // Get All Employees
        public function getEmployees() {
            $query = "SELECT employees.*, users.name, users.email FROM employees JOIN users ON employees.user_id = users.id";
            $result = $this->conn->query($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        // Get Employee by ID
        public function getEmployeeById($id) {
            $stmt = $this->conn->prepare("SELECT employees.*, users.name, users.email FROM employees JOIN users ON employees.user_id = users.id WHERE employees.id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        // Update Employee
        public function updateEmployee($id, $designation, $department, $salary, $date_of_joining) {
            $stmt = $this->conn->prepare("UPDATE employees SET designation = ?, department = ?, salary = ?, date_of_joining = ? WHERE id = ?");
            $stmt->bind_param("ssdsi", $designation, $department, $salary, $date_of_joining, $id);
            return $stmt->execute();
        }

        // Delete Employee
        public function deleteEmployee($id) {
            $stmt = $this->conn->prepare("DELETE FROM employees WHERE id = ?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
    }

    // Database Connection
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $employeeController = new EmployeeController($db);
?>