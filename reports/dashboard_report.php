<?php
require_once "../includes/conn.php"; require_once "../includes/auth.php"; require_admin();

// สมาชิกตามแพ็กเกจ
$sql1 = "SELECT p.name, COUNT(m.id) AS members FROM packages p LEFT JOIN memberships m ON m.package_id=p.id AND m.status='active' GROUP BY p.id ORDER BY p.price ASC";
$data1 = $conn->query($sql1)->fetch_all(MYSQLI_ASSOC);

// รายได้รายเดือน
$sql2 = "SELECT DATE_FORMAT(start_date,'%Y-%m') AS ym, SUM(p.price) AS revenue FROM memberships m JOIN packages p ON p.id=m.package_id GROUP BY ym ORDER BY ym DESC";
$data2 = $conn->query($sql2)->fetch_all(MYSQLI_ASSOC);
?>
<?php include "../shared/header.php"; echo '<br>';?>

<h1 class="page-title">รายงานสรุปรวม</h1>

<div class="grid-2" style="margin-bottom: 2rem;">
  <div class="card">
    <h2 class="card-title">รายงานสมาชิกตามแพ็กเกจ (Active)</h2>
    <div id="chart-members" data-chart-data='<?=json_encode($data1)?>'></div>
  </div>
  <div class="card">
    <h2 class="card-title">ข้อมูล</h2>
    <div class="table-wrapper">
        <table class="styled-table">
        <thead><tr><th>แพ็กเกจ</th><th class="text-right">จำนวน</th></tr></thead>
        <tbody><?php foreach($data1 as $row): ?><tr><td><?=htmlspecialchars($row['name'])?></td><td class="text-right"><?=$row['members']?></td></tr><?php endforeach; ?></tbody>
        </table>
    </div>
  </div>
</div>

<div class="grid-2">
  <div class="card">
    <h2 class="card-title">รายงานรายได้รายเดือน</h2>
    <div id="chart-revenue" data-chart-data='<?=json_encode($data2)?>'></div>
  </div>
  <div class="card">
    <h2 class="card-title">ข้อมูล</h2>
    <div class="table-wrapper">
        <table class="styled-table">
        <thead><tr><th>เดือน</th><th class="text-right">รายได้ (บาท)</th></tr></thead>
        <tbody><?php foreach($data2 as $row): ?><tr><td><?=htmlspecialchars($row['ym'])?></td><td class="text-right"><?=number_format($row['revenue'],0)?></td></tr><?php endforeach; ?></tbody>
        </table>
    </div>
  </div>
</div>
<br>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<?php include "../shared/footerdashboard.php"; ?>