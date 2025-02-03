<?php
    // controllers/KPIController.php - Handles KPI Tracking
    require_once '../config/config.php';
    session_start();

    class KPIController {
        private $conn;

        public function __construct($db) {
            $this->conn = $db;
        }

        // Add a new KPI record
        public function addKPI($employee_id, $kpi_name, $kpi_value, $target_value, $status) {
            $stmt = $this->conn->prepare("INSERT INTO employee_kpis (employee_id, kpi_name, kpi_value, target_value, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isdss", $employee_id, $kpi_name, $kpi_value, $target_value, $status);
            return $stmt->execute();
        }

        // Fetch all KPIs for an employee
        public function getKPIs($employee_id) {
            $stmt = $this->conn->prepare("SELECT * FROM employee_kpis WHERE employee_id = ?");
            $stmt->bind_param("i", $employee_id);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        // Update KPI record
        public function updateKPI($id, $kpi_name, $kpi_value, $target_value, $status) {
            $stmt = $this->conn->prepare("UPDATE employee_kpis SET kpi_name = ?, kpi_value = ?, target_value = ?, status = ? WHERE id = ?");
            $stmt->bind_param("sdssi", $kpi_name, $kpi_value, $target_value, $status, $id);
            return $stmt->execute();
        }

        // Delete KPI record
        public function deleteKPI($id) {
            $stmt = $this->conn->prepare("DELETE FROM employee_kpis WHERE id = ?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
    }

    // Database Connection
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $kpiController = new KPIController($db);
?>
