<?php
// models/Employee.php - Employee Model
require_once '../config/config.php';

class EmployeeModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addEmployee($user_id, $designation, $department, $salary, $date_of_joining) {
        $stmt = $this->conn->prepare("INSERT INTO employees (user_id, designation, department, salary, date_of_joining) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issds", $user_id, $designation, $department, $salary, $date_of_joining);
        return $stmt->execute();
    }

    public function getEmployees() {
        $query = "SELECT employees.*, users.name, users.email FROM employees JOIN users ON employees.user_id = users.id";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEmployeeById($id) {
        $stmt = $this->conn->prepare("SELECT employees.*, users.name, users.email FROM employees JOIN users ON employees.user_id = users.id WHERE employees.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateEmployee($id, $designation, $department, $salary, $date_of_joining) {
        $stmt = $this->conn->prepare("UPDATE employees SET designation = ?, department = ?, salary = ?, date_of_joining = ? WHERE id = ?");
        $stmt->bind_param("ssdsi", $designation, $department, $salary, $date_of_joining, $id);
        return $stmt->execute();
    }

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

$employeeModel = new EmployeeModel($db);
?>
