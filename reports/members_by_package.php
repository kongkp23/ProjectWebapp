<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_admin();

$sql = "SELECT p.name, COUNT(m.id) AS members
        FROM packages p
        LEFT JOIN memberships m ON m.package_id=p.id AND m.status='active'
        GROUP BY p.id ORDER BY p.price ASC";
$data = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
?>
<?php include "../shared/header.php"; ?>
<h1 class="text-3xl font-extrabold mb-6">รายงาน: สมาชิกตามแพ็กเกจ (Active)</h1>

<div class="grid md:grid-cols-2 gap-8">
  <div class="overflow-x-auto">
    <table class="min-w-[300px] border border-white/10 rounded overflow-hidden">
      <thead class="bg-[#0f0f11]">
        <tr><th class="px-4 py-2 text-left">แพ็กเกจ</th><th class="px-4 py-2 text-right">จำนวน</th></tr>
      </thead>
      <tbody>
        <?php foreach($data as $row): ?>
          <tr class="border-t border-white/10">
            <td class="px-4 py-2"><?=htmlspecialchars($row['name'])?></td>
            <td class="px-4 py-2 text-right"><?=$row['members']?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div>
    <div id="chart-members" style="width:100%;height:320px;"></div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
const data = <?=json_encode($data)?>;
const options = {
  chart: { type: 'pie', background: 'transparent' },
  labels: data.map(d => d.name),
  series: data.map(d => parseInt(d.members)),
  colors: ['#F97316','#FB923C','#FED7AA','#FDBA74'],
  legend: { labels: { colors: '#ccc' } },
  responsive: [{ breakpoint: 768, options: { chart: { width: '100%' } } }]
};
new ApexCharts(document.querySelector("#chart-members"), options).render();
</script>

<?php include "../shared/footer.php"; ?>
