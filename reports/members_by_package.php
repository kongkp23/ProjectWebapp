<?php
require_once "../includes/conn.php"; require_once "../includes/auth.php"; require_admin();
$sql = "SELECT p.name, COUNT(m.id) AS members FROM packages p LEFT JOIN memberships m ON m.package_id=p.id AND m.status='active' GROUP BY p.id ORDER BY p.price ASC";
$data = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
?>
<?php include "../shared/header.php"; ?>
<h1 class="page-title">รายงาน: สมาชิกตามแพ็กเกจ (Active)</h1>

<div class="grid-2">
  <div class="card">
    <h2 class="card-title">ข้อมูล</h2>
    <div class="table-wrapper">
        <table class="styled-table">
        <thead><tr><th>แพ็กเกจ</th><th class="text-right">จำนวน</th></tr></thead>
        <tbody><?php foreach($data as $row): ?><tr><td><?=htmlspecialchars($row['name'])?></td><td class="text-right"><?=$row['members']?></td></tr><?php endforeach; ?></tbody>
        </table>
    </div>
  </div>
  <div class="card">
    <h2 class="card-title">กราฟ</h2>
    <div id="chart-members" data-chart-data='<?=json_encode($data)?>'></div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<?php include "../shared/footer.php"; ?>