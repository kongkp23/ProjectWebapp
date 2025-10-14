<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_admin();

$sql = "SELECT DATE_FORMAT(start_date,'%Y-%m') AS ym, SUM(p.price) AS revenue, COUNT(m.id) AS subs
        FROM memberships m
        JOIN packages p ON p.id=m.package_id
        GROUP BY ym ORDER BY ym DESC";
$data = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
?>
<?php include "../shared/header.php"; ?>
<h1 class="text-3xl font-extrabold mb-6">รายงาน: รายได้รายเดือน</h1>

<div class="grid md:grid-cols-2 gap-8">
  <div class="overflow-x-auto">
    <table class="min-w-[360px] border border-white/10 rounded overflow-hidden">
      <thead class="bg-[#0f0f11]"><tr><th class="px-4 py-2 text-left">เดือน</th><th class="px-4 py-2 text-right">สมาชิกใหม่</th><th class="px-4 py-2 text-right">รายได้ (บาท)</th></tr></thead>
      <tbody>
        <?php foreach($data as $row): ?>
          <tr class="border-t border-white/10">
            <td class="px-4 py-2"><?=htmlspecialchars($row['ym'])?></td>
            <td class="px-4 py-2 text-right"><?=intval($row['subs'])?></td>
            <td class="px-4 py-2 text-right"><?=number_format($row['revenue'],0)?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div>
    <div id="chart-revenue" style="width:100%;height:320px;"></div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
const data = <?=json_encode($data)?>;
const options = {
  chart: { type: 'bar', background: 'transparent' },
  series: [{ name: 'รายได้ (บาท)', data: data.map(d=>parseFloat(d.revenue)) }],
  xaxis: {
    categories: data.map(d=>d.ym),
    labels: { style: { colors: '#ccc' } }
  },
  yaxis: { labels: { style: { colors: '#ccc' } } },
  colors: ['#F97316'],
  grid: { borderColor: '#333' }
};
new ApexCharts(document.querySelector("#chart-revenue"), options).render();
</script>

<?php include "../shared/footer.php"; ?>
