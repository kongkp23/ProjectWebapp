<?php
require_once __DIR__."/includes/conn.php";
require_once __DIR__."/includes/auth.php";
require_login();
echo "<br>";
$uid = $_SESSION['user']['id'];

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
  $end_date = new DateTime($mem['end_date']);
  $today = new DateTime('today');
  $diff = $today->diff($end_date);
  $days_left = (int)$diff->format("%r%a");
}
?>
<?php include __DIR__."/shared/header.php"; ?>

<section class="welcome-banner">
  <div class="welcome-banner-content">
    <div>
      <h1 class="page-title" style="margin-bottom: 0.5rem;">สวัสดี, <?=htmlspecialchars($_SESSION['user']['full_name'])?></h1>
      <p class="text-muted">
        <?php if($mem): ?>
          ยินดีต้อนรับกลับสู่ KOS Fitness — แพ็กเกจปัจจุบันของคุณคือ <span class="highlight"><?=htmlspecialchars($mem['package_name'])?></span>
        <?php else: ?>
          ยังไม่มีแพ็กเกจสมาชิก เลือกแพ็กเกจเพื่อเริ่มต้นได้เลย
        <?php endif; ?>
      </p>
    </div>
    <div class="welcome-banner-actions">
      <a class="btn btn-secondary" href="/kos_fitness/member/card.php">บัตรสมาชิก</a>
      <a class="btn btn-primary" href="/kos_fitness/packages/select_package.php">
        <?=$mem ? "เปลี่ยน/ต่ออายุแพ็กเกจ" : "เลือกแพ็กเกจ"?>
      </a>
    </div>
  </div>
</section>

<section class="grid-2" style="margin-top: 1.5rem;">
  <div class="card">
    <h2 class="card-title">สถานะสมาชิก</h2>
    <?php if(!$mem): ?>
      <p class="text-muted">ยังไม่มีข้อมูลสมาชิกของคุณ</p>
      <a class="btn btn-primary" style="margin-top: 1rem;" href="/kos_fitness/packages/select_package.php">เลือกแพ็กเกจ</a>
    <?php else: ?>
      <div class="info-grid">
        <div><span class="info-label">แพ็กเกจ</span><?=htmlspecialchars($mem['package_name'])?></div>
        <div><span class="info-label">ราคา</span><?=number_format($mem['price'],0)?> บาท/เดือน</div>
        <div><span class="info-label">เริ่ม</span><?=htmlspecialchars($mem['start_date'])?></div>
        <div><span class="info-label">สิ้นสุด</span><?=htmlspecialchars($mem['end_date'])?></div>
        <div>
          <span class="info-label">สถานะ</span>
          <span class="status-badge <?=($mem['status']==='active' ? 'active' : 'inactive')?>"><?=htmlspecialchars($mem['status'])?></span>
        </div>
        <?php if($days_left !== null): ?>
          <div><span class="info-label">คงเหลือ</span><?=($days_left >= 0 ? $days_left." วัน" : "-")?></div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="card">
    <h2 class="card-title">เมนูลัด</h2>
    <div class="quick-action-grid">
      <a class="quick-action-card" href="/kos_fitness/packages/select_package.php">
        <div class="quick-action-title">แพ็กเกจสมาชิก</div>
        <div class="quick-action-desc">ดูแพ็กเกจ/เปลี่ยนแพ็กเกจ</div>
      </a>
      <a class="quick-action-card" href="/kos_fitness/member/card.php">
        <div class="quick-action-title">บัตรสมาชิก</div>
        <div class="quick-action-desc">ดูข้อมูลบัตรของฉัน</div>
      </a>
      <?php if(!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? 'user')==='admin'): ?>
      <a class="quick-action-card" href="/kos_fitness/member/list.php">
        <div class="quick-action-title">จัดการสมาชิก (Admin)</div>
        <div class="quick-action-desc">ค้นหา/เพิ่ม/แก้ไข/ลบ</div>
      </a>
      <a class="quick-action-card" href="/kos_fitness/reports/dashboard_report.php">
        <div class="quick-action-title">รายงาน (Admin)</div>
        <div class="quick-action-desc">สรุปภาพรวมและรายได้</div>
      </a>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include __DIR__."/shared/footerhome.php"; ?>