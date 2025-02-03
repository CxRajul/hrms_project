<?php
    // leaveController.php - Handles leave management logic
    require_once '../config/config.php';
    session_start();

    class LeaveController {
        private $conn;

        public function __construct($db) {
            $this->conn = $db;
        }

        // Apply for Leave
        public function applyLeave($employee_id, $leave_type, $start_date, $end_date, $status = 'pending') {
            $stmt = $this->conn->prepare("INSERT INTO leave_requests (employee_id, leave_type, start_date, end_date, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $employee_id, $leave_type, $start_date, $end_date, $status);
            return $stmt->execute();
        }

        // Get All Leave Requests
        public function getLeaveRequests() {
            $query = "SELECT leave_requests.*, employees.designation, employees.department FROM leave_requests JOIN employees ON leave_requests.employee_id = employees.id";
            $result = $this->conn->query($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        // Get Leave Request by Employee ID
        public function getLeaveByEmployeeId($employee_id) {
            $stmt = $this->conn->prepare("SELECT * FROM leave_requests WHERE employee_id = ?");
            $stmt->bind_param("i", $employee_id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        // Update Leave Status
        public function updateLeaveStatus($id, $status) {
            $stmt = $this->conn->prepare("UPDATE leave_requests SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $id);
            return $stmt->execute();
        }

        // Delete Leave Request
        public function deleteLeave($id) {
            $stmt = $this->conn->prepare("DELETE FROM leave_requests WHERE id = ?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
    }

    // Database Connection
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $leaveController = new LeaveController($db);
?>