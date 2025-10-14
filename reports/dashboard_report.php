<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_admin();

// --- 1. สมาชิกตามแพ็กเกจ ---
$sql1 = "SELECT p.name, COUNT(m.id) AS members
          FROM packages p
          LEFT JOIN memberships m ON m.package_id=p.id AND m.status='active'
          GROUP BY p.id ORDER BY p.price ASC";
$data1 = $conn->query($sql1)->fetch_all(MYSQLI_ASSOC);

// --- 2. รายได้รายเดือน ---
$sql2 = "SELECT DATE_FORMAT(start_date,'%Y-%m') AS ym, SUM(p.price) AS revenue, COUNT(m.id) AS subs
          FROM memberships m
          JOIN packages p ON p.id=m.package_id
          GROUP BY ym ORDER BY ym DESC";
$data2 = $conn->query($sql2)->fetch_all(MYSQLI_ASSOC);
?>
<?php include "../shared/header.php"; ?>

<h1 class="text-3xl font-extrabold mb-8">รายงานสรุปรวมระบบสมาชิกฟิตเนส</h1>

<!-- แถวที่ 1: Pie Chart สมาชิกตามแพ็กเกจ -->
<div class="grid md:grid-cols-2 gap-8 mb-12">
  <div class="border border-white/10 rounded-2xl p-6 bg-[#0b0b0c]">
    <h2 class="text-xl font-bold mb-4">รายงานสมาชิกตามแพ็กเกจ (Active)</h2>
    <div id="chart-members" style="height:320px;"></div>
  </div>
  
  <div class="border border-white/10 rounded-2xl p-6 bg-[#0b0b0c] overflow-x-auto">
    <table class="min-w-[300px] border border-white/10 rounded overflow-hidden">
      <thead class="bg-[#0f0f11]">
        <tr><th class="px-4 py-2 text-left">แพ็กเกจ</th><th class="px-4 py-2 text-right">จำนวน</th></tr>
      </thead>
      <tbody>
        <?php foreach($data1 as $row): ?>
          <tr class="border-t border-white/10">
            <td class="px-4 py-2"><?=htmlspecialchars($row['name'])?></td>
            <td class="px-4 py-2 text-right"><?=$row['members']?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- แถวที่ 2: Bar Chart รายได้รายเดือน -->
<div class="grid md:grid-cols-2 gap-8">
  <div class="border border-white/10 rounded-2xl p-6 bg-[#0b0b0c]">
    <h2 class="text-xl font-bold mb-4">รายงานรายได้รายเดือน</h2>
    <div id="chart-revenue" style="height:320px;"></div>
  </div>
  
  <div class="border border-white/10 rounded-2xl p-6 bg-[#0b0b0c] overflow-x-auto">
    <table class="min-w-[360px] border border-white/10 rounded overflow-hidden">
      <thead class="bg-[#0f0f11]">
        <tr><th class="px-4 py-2 text-left">เดือน</th><th class="px-4 py-2 text-right">สมาชิกใหม่</th><th class="px-4 py-2 text-right">รายได้ (บาท)</th></tr>
      </thead>
      <tbody>
        <?php foreach($data2 as $row): ?>
          <tr class="border-t border-white/10">
            <td class="px-4 py-2"><?=htmlspecialchars($row['ym'])?></td>
            <td class="px-4 py-2 text-right"><?=intval($row['subs'])?></td>
            <td class="px-4 py-2 text-right"><?=number_format($row['revenue'],0)?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- สคริปต์กราฟ -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
const data1 = <?=json_encode($data1)?>;
const data2 = <?=json_encode($data2)?>;

// กราฟ Pie สมาชิกตามแพ็กเกจ
new ApexCharts(document.querySelector("#chart-members"), {
  chart: { type: 'pie', background: 'transparent' },
  labels: data1.map(d => d.name),
  series: data1.map(d => parseInt(d.members)),
  colors: ['#F97316','#FB923C','#FDBA74','#FED7AA'],
  legend: { labels: { colors: '#ccc' } },
}).render();

// กราฟ Bar รายได้รายเดือน
new ApexCharts(document.querySelector("#chart-revenue"), {
  chart: { type: 'bar', background: 'transparent' },
  series: [{ name: 'รายได้ (บาท)', data: data2.map(d=>parseFloat(d.revenue)) }],
  xaxis: {
    categories: data2.map(d=>d.ym),
    labels: { style: { colors: '#ccc' } }
  },
  yaxis: { labels: { style: { colors: '#ccc' } } },
  colors: ['#F97316'],
  grid: { borderColor: '#333' },
}).render();
</script>

<?php include "../shared/footer.php"; ?>
