<?php
require_once __DIR__."/includes/conn.php";
require_once __DIR__."/includes/auth.php";
require_login();

$uid = $_SESSION['user']['id'];

// ดึงสมาชิกล่าสุดของผู้ใช้
$sql = "SELECT m.*, p.name AS package_name, p.price
        FROM memberships m
        JOIN packages p ON p.id=m.package_id
        WHERE m.user_id=? 
        ORDER BY m.id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$mem = $stmt->get_result()->fetch_assoc();

$days_left = null;
if ($mem) {
  $days_left = (new DateTime($mem['end_date']))->diff(new DateTime('today'))->format("%r%a");
}
?>
<?php include __DIR__."/shared/header.php"; ?>

<!-- HERO ยินดีต้อนรับ -->
<section class="py-12">
  <div class="container mx-auto px-4">
    <div class="rounded-2xl p-6 md:p-8 bg-gradient-to-br from-[#0b0b0c] to-[#18181b] border border-white/10">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <h1 class="text-3xl md:text-4xl font-extrabold">สวัสดี, <?=htmlspecialchars($_SESSION['user']['full_name'])?></h1>
          <p class="mt-2 text-gray-300">
            <?php if($mem): ?>
              ยินดีต้อนรับกลับสู่ KOS Fitness — แพ็กเกจปัจจุบันของคุณคือ <span class="font-semibold text-orange-400"><?=htmlspecialchars($mem['package_name'])?></span>
            <?php else: ?>
              ยังไม่มีแพ็กเกจสมาชิก เลือกแพ็กเกจเพื่อเริ่มต้นได้เลย
            <?php endif; ?>
          </p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
          <a class="px-5 py-2 rounded-full bg-gray-700 hover:bg-gray-600" href="/kos_fitness/member/card.php">บัตรสมาชิก</a>
          <a class="px-5 py-2 rounded-full bg-orange-500 hover:bg-orange-600" href="/kos_fitness/packages/select_package.php">
            <?=$mem ? "เปลี่ยน/ต่ออายุแพ็กเกจ" : "เลือกแพ็กเกจ"?>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- สรุปสถานะสมาชิก -->
<section class="pb-6">
  <div class="container mx-auto px-4">
    <div class="grid md:grid-cols-2 gap-6">
      <!-- การ์ดสถานะ -->
      <div class="rounded-2xl border border-white/10 bg-[#0b0b0c] p-6">
        <h2 class="text-xl font-bold mb-4">สถานะสมาชิก</h2>
        <?php if(!$mem): ?>
          <p class="text-gray-300">ยังไม่มีข้อมูลสมาชิกของคุณ</p>
          <a class="inline-block mt-4 px-5 py-2 rounded-full bg-orange-500 hover:bg-orange-600" href="/kos_fitness/packages/select_package.php">
            เลือกแพ็กเกจ
          </a>
        <?php else: ?>
          <div class="grid grid-cols-2 gap-4 text-gray-300">
            <div><span class="text-gray-400">แพ็กเกจ</span><br><?=htmlspecialchars($mem['package_name'])?></div>
            <div><span class="text-gray-400">ราคา</span><br><?=number_format($mem['price'],0)?> บาท/เดือน</div>
            <div><span class="text-gray-400">เริ่ม</span><br><?=htmlspecialchars($mem['start_date'])?></div>
            <div><span class="text-gray-400">สิ้นสุด</span><br><?=htmlspecialchars($mem['end_date'])?></div>
            <div><span class="text-gray-400">สถานะ</span><br>
              <span class="inline-block px-3 py-1 rounded-full text-sm <?=($mem['status']==='active'?'bg-green-500/20 text-green-300':'bg-gray-500/20 text-gray-300')?>"><?=htmlspecialchars($mem['status'])?></span>
            </div>
            <?php if(is_numeric($days_left)): ?>
              <div><span class="text-gray-400">คงเหลือ</span><br>
                <?=($days_left>=0? intval($days_left)." วัน":"-")?>
              </div>
            <?php endif; ?>
          </div>
          <div class="mt-5 flex gap-3">
            <a class="px-5 py-2 rounded-full bg-gray-700 hover:bg-gray-600" href="/kos_fitness/member/card.php">ดูบัตรสมาชิก</a>
            <a class="px-5 py-2 rounded-full bg-orange-500 hover:bg-orange-600" href="/kos_fitness/packages/select_package.php">ต่ออายุ/เปลี่ยนแพ็กเกจ</a>
          </div>
        <?php endif; ?>
      </div>

      <!-- ทางลัด (Quick actions) -->
      <div class="rounded-2xl border border-white/10 bg-[#0b0b0c] p-6">
        <h2 class="text-xl font-bold mb-4">เมนูลัด</h2>
        <div class="grid sm:grid-cols-2 gap-3">
          <a class="block rounded-xl border border-white/10 bg-[#111113] p-4 hover:bg-white/5" href="/kos_fitness/packages/select_package.php">
            <div class="text-gray-300 font-semibold">แพ็กเกจสมาชิก</div>
            <div class="text-gray-400 text-sm">ดูแพ็กเกจ/เปลี่ยนแพ็กเกจ</div>
          </a>
          <a class="block rounded-xl border border-white/10 bg-[#111113] p-4 hover:bg-white/5" href="/kos_fitness/member/card.php">
            <div class="text-gray-300 font-semibold">บัตรสมาชิก</div>
            <div class="text-gray-400 text-sm">ดูข้อมูลบัตรของฉัน</div>
          </a>
          <?php if(!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? 'user')==='admin'): ?>
          <a class="block rounded-xl border border-white/10 bg-[#111113] p-4 hover:bg-white/5" href="/kos_fitness/member/list.php">
            <div class="text-gray-300 font-semibold">จัดการสมาชิก (Admin)</div>
            <div class="text-gray-400 text-sm">ค้นหา/เพิ่ม/แก้ไข/ลบ</div>
          </a>
          <a class="block rounded-xl border border-white/10 bg-[#111113] p-4 hover:bg-white/5" href="/kos_fitness/reports/dashboard_report.php">
            <div class="text-gray-300 font-semibold">รายงาน (Admin)</div>
            <div class="text-gray-400 text-sm">สมาชิกตามแพ็กเกจ/รายได้รายเดือน</div>
          </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__."/shared/footer.php"; ?>
