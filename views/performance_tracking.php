<?php
    include('../include/header.php');
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    require_once '../controllers/PerformanceManagementController.php';
    $employee_id = $_SESSION['user_id'];
    $performance_goals = $performanceController->getPerformanceGoals($employee_id);
    $kpi_data = $performanceController->getKPIs($employee_id);
?>
    <div class="container">
        <h2>Performance Goals (OKRs)</h2>
        <table>
            <thead>
                <tr>
                    <th>Goal</th>
                    <th>Description</th>
                    <th>Target Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($performance_goals as $goal): ?>
                <tr>
                    <td><?php echo $goal['goal_name']; ?></td>
                    <td><?php echo $goal['description']; ?></td>
                    <td><?php echo $goal['target_date']; ?></td>
                    <td><?php echo $goal['status']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>KPI Tracking</h2>
        <table>
            <thead>
                <tr>
                    <th>KPI</th>
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
