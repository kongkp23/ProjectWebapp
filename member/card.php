<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_login();
echo "<br>";
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
<h1 class="page-title-card">บัตรสมาชิกของฉัน</h1>

<?php if(!$mem): ?>
  <p class="text-muted-nocard">ยังไม่มีบัตรสมาชิก <a href="/kos_fitness/packages/select_package.php">เลือกแพ็กเกจ</a> ก่อนนะ</p>
<?php else: ?>
  <div class="member-card">
    <div class="member-card-header">
      <div>
        <div class="text-muted" style="font-size: 0.875rem;">KOS FITNESS</div>
        <div class="member-card-package-name"><?=htmlspecialchars($mem['package_name'])?></div>
      </div>
      <div style="text-align: right;">
        <div class="text-muted" style="font-size: 0.875rem;">Card No.</div>
        <div class="member-card-no"><?=htmlspecialchars($mem['card_number'])?></div>
      </div>
    </div>
    <div class="member-card-details">
      <div><span class="info-label">ชื่อ</span><?=htmlspecialchars($_SESSION['user']['full_name'])?></div>
      <div><span class="info-label">ราคา</span><?=number_format($mem['price'],0)?> บาท/เดือน</div>
      <div><span class="info-label">เริ่ม</span><?=htmlspecialchars($mem['start_date'])?></div>
      <div><span class="info-label">สิ้นสุด</span><?=htmlspecialchars($mem['end_date'])?></div>
      <div>
        <span class="info-label">สถานะ</span>
        <span class="status-badge <?=($mem['status']==='active' ? 'active' : 'inactive')?>"><?=htmlspecialchars($mem['status'])?></span>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php include "../shared/footerhome.php"; ?>