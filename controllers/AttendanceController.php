<?php
// attendanceController.php - Handles attendance management logic
require_once '../config/config.php';
session_start();

class AttendanceController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Mark Attendance
    public function markAttendance($employee_id, $date, $status) {
        $stmt = $this->conn->prepare("INSERT INTO attendance (employee_id, date, status) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $employee_id, $date, $status);
        return $stmt->execute();
    }

    // Get All Attendance Records
    public function getAttendanceRecords() {
        $query = "SELECT attendance.*, employees.designation, employees.department FROM attendance JOIN employees ON attendance.employee_id = employees.id";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get Attendance by Employee ID
    public function getAttendanceByEmployeeId($employee_id) {
        $stmt = $this->conn->prepare("SELECT * FROM attendance WHERE employee_id = ?");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update Attendance Record
    public function updateAttendance($id, $status) {
        $stmt = $this->conn->prepare("UPDATE attendance SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    // Delete Attendance Record
    public function deleteAttendance($id) {
        $stmt = $this->conn->prepare("DELETE FROM attendance WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

// Database Connection
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$attendanceController = new AttendanceController($db);
?>
