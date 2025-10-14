<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_login();

$uid = $_SESSION['user']['id'];
$sql = "SELECT m.*, p.name AS package_name, p.price
        FROM memberships m
        JOIN packages p ON p.id=m.package_id
        WHERE m.user_id=? ORDER BY m.id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$mem = $stmt->get_result()->fetch_assoc();
?>
<?php include "../shared/header.php"; ?>
<h1 class="text-3xl font-extrabold mb-6">บัตรสมาชิกของฉัน</h1>

<?php if(!$mem): ?>
  <p class="text-gray-300">ยังไม่มีบัตรสมาชิก <a class="text-orange-400 underline" href="/kos_fitness/packages/select_package.php">เลือกแพ็กเกจ</a> ก่อนนะ</p>
<?php else: ?>
  <div class="max-w-xl mx-auto bg-gradient-to-br from-[#0b0b0c] to-[#18181b] border border-white/10 rounded-2xl p-6">
    <div class="flex justify-between items-center">
      <div>
        <div class="text-sm text-gray-400">KOS FITNESS</div>
        <div class="text-2xl font-bold"><?=htmlspecialchars($mem['package_name'])?></div>
      </div>
      <div class="text-right">
        <div class="text-gray-400 text-sm">Card No.</div>
        <div class="font-mono text-xl"><?=htmlspecialchars($mem['card_number'])?></div>
      </div>
    </div>
    <div class="mt-4 grid grid-cols-2 gap-4 text-gray-300">
      <div><span class="text-gray-400">ชื่อ</span><br><?=htmlspecialchars($_SESSION['user']['full_name'])?></div>
      <div><span class="text-gray-400">ราคา</span><br><?=number_format($mem['price'],0)?> บาท/เดือน</div>
      <div><span class="text-gray-400">เริ่ม</span><br><?=htmlspecialchars($mem['start_date'])?></div>
      <div><span class="text-gray-400">สิ้นสุด</span><br><?=htmlspecialchars($mem['end_date'])?></div>
      <div><span class="text-gray-400">สถานะ</span><br><?=htmlspecialchars($mem['status'])?></div>
    </div>
  </div>
<?php endif; ?>
<?php include "../shared/footer.php"; ?>
