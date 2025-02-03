<?php
// views/kpi_tracking.php - KPI Tracking UI
include('../include/header.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once '../controllers/KPIController.php';
$employee_id = $_SESSION['user_id'];
$kpi_data = $kpiController->getKPIs($employee_id);
?>
    <div class="container">
        <h2>KPI Tracking</h2>
        <table>
            <thead>
                <tr>
                    <th>KPI Name</th>
                    <th>Value</th>
                    <th>Target</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kpi_data as $kpi): ?>
                <tr>
                    <td><?php echo $kpi['kpi_name']; ?></td>
                    <td><?php echo $kpi['kpi_value']; ?></td>
                    <td><?php echo $kpi['target_value']; ?></td>
                    <td><?php echo $kpi['status']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php include('../include/footer.php'); ?>
