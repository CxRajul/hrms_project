<?php
    // models/Payroll.php - Payroll Model
    require_once '../config/config.php';

    class PayrollModel {
        private $conn;

        public function __construct($db) {
            $this->conn = $db;
        }

        public function addPayroll($employee_id, $salary_month, $salary_paid, $payment_status) {
            $stmt = $this->conn->prepare("INSERT INTO payroll (employee_id, salary_month, salary_paid, payment_status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isds", $employee_id, $salary_month, $salary_paid, $payment_status);
            return $stmt->execute();
        }

        public function getPayrollRecords() {
            $query = "SELECT payroll.*, employees.designation, employees.department FROM payroll JOIN employees ON payroll.employee_id = employees.id";
            $result = $this->conn->query($query);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getPayrollByEmployeeId($employee_id) {
            $stmt = $this->conn->prepare("SELECT * FROM payroll WHERE employee_id = ?");
            $stmt->bind_param("i", $employee_id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function updatePayroll($id, $salary_paid, $payment_status) {
            $stmt = $this->conn->prepare("UPDATE payroll SET salary_paid = ?, payment_status = ? WHERE id = ?");
            $stmt->bind_param("dsi", $salary_paid, $payment_status, $id);
            return $stmt->execute();
        }

        public function deletePayroll($id) {
            $stmt = $this->conn->prepare("DELETE FROM payroll WHERE id = ?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
    }

    // Database Connection
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $payrollModel = new PayrollModel($db);
?>
