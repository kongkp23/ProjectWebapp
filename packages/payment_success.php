<?php
require_once "../includes/conn.php"; require_once "../includes/auth.php"; require_login();

$mid = intval($_GET['mid'] ?? 0);

// Set membership to active
if ($mid > 0) {
    $stmt_pay = $conn->prepare("UPDATE memberships SET status='active' WHERE id=?");
    $stmt_pay->bind_param("i", $mid);
    $stmt_pay->execute();
}

$uid = $_SESSION['user']['id'];
$sql = "SELECT m.*, p.name AS package_name, p.price FROM memberships m JOIN packages p ON p.id=m.package_id WHERE m.id=? AND m.user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mid, $uid);
$stmt->execute();
$mem = $stmt->get_result()->fetch_assoc();

if (!$mem) { header("Location: /kos_fitness/home.php"); exit; }
?>
<?php include "../shared/header.php"; ?>

<div class="payment-success-page">
  <div class="success-container">
    <div class="success-icon">
      <svg width="64" height="64" class="text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: var(--color-green);">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
    </div>
    <h1 class="success-title">ชำระเงินสำเร็จ!</h1>
    <div class="success-card">
      <div class="success-info-grid">
        <div><span class="info-label">แพ็กเกจ</span><div class="info-value"><?=htmlspecialchars($mem['package_name'])?></div></div>
        <div><span class="info-label">จำนวนเงิน</span><div class="info-value info-price"><?=number_format($mem['price'], 0)?> บาท</div></div>
        <div><span class="info-label">วันเริ่มสมาชิก</span><div class="info-value"><?=htmlspecialchars($mem['start_date'])?></div></div>
        <div><span class="info-label">วันหมดอายุ</span><div class="info-value"><?=htmlspecialchars($mem['end_date'])?></div></div>
      </div>
    </div>
    <div class="success-actions">
      <a href="/kos_fitness/member/card.php" class="btn btn-primary">ไปยังบัตรสมาชิกทันที</a>
      <a href="/kos_fitness/home.php" class="btn btn-secondary">กลับไปหน้าหลัก</a>
    </div>
    <div class="countdown-timer">
      จะนำทางอัตโนมัติใน <span id="countdown">3</span> วินาที
    </div>
  </div>
</div>

<?php include "../shared/footer.php"; ?>