<?php
require_once "../includes/conn.php"; require_once "../includes/auth.php"; require_admin();
$sql = "SELECT DATE_FORMAT(start_date,'%Y-%m') AS ym, SUM(p.price) AS revenue, COUNT(m.id) AS subs FROM memberships m JOIN packages p ON p.id=m.package_id GROUP BY ym ORDER BY ym DESC";
$data = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
?>
<?php include "../shared/header.php"; ?>
<h1 class="page-title">รายงาน: รายได้รายเดือน</h1>

<div class="grid-2">
  <div class="card">
    <h2 class="card-title">ข้อมูล</h2>
    <div class="table-wrapper">
        <table class="styled-table">
        <thead><tr><th>เดือน</th><th class="text-right">สมาชิกใหม่</th><th class="text-right">รายได้ (บาท)</th></tr></thead>
        <tbody>
            <?php foreach($data as $row): ?>
            <tr><td><?=htmlspecialchars($row['ym'])?></td><td class="text-right"><?=intval($row['subs'])?></td><td class="text-right"><?=number_format($row['revenue'],0)?></td></tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>
  </div>
  <div class="card">
    <h2 class="card-title">กราฟ</h2>
    <div id="chart-revenue" data-chart-data='<?=json_encode($data)?>'></div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<?php include "../shared/footer.php"; ?>