<?php
    // models/Reports.php - HR Analytics & Reports Model
    require_once '../config/config.php';

    class ReportsModel {
        private $conn;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function getEmployeePerformanceReport() {
            $query = "SELECT employees.id, employees.designation, employees.department, COUNT(attendance.id) AS total_days_present 
                      FROM employees 
                      LEFT JOIN attendance ON employees.id = attendance.employee_id AND attendance.status = 'present'
                      GROUP BY employees.id, employees.designation, employees.department";
            $result = $this->conn->query($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getPayrollReport() {
            $query = "SELECT payroll.*, employees.designation, employees.department FROM payroll 
                      JOIN employees ON payroll.employee_id = employees.id";
            $result = $this->conn->query($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getLeaveReport() {
            $query = "SELECT leave_requests.*, employees.designation, employees.department FROM leave_requests 
                      JOIN employees ON leave_requests.employee_id = employees.id";
            $result = $this->conn->query($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    // Database Connection
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $reportsModel = new ReportsModel($db);
?>
