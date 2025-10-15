<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_login();

$membership_id = intval($_GET['mid'] ?? 0);
if (!$membership_id) {
  header("Location: /kos_fitness/packages/select_package.php"); exit;
}

$uid = $_SESSION['user']['id'];
$sql = "SELECT m.*, p.name AS package_name, p.price FROM memberships m JOIN packages p ON p.id=m.package_id WHERE m.id=? AND m.user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $membership_id, $uid);
$stmt->execute();
$mem = $stmt->get_result()->fetch_assoc();

if (!$mem) { header("Location: /kos_fitness/home.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $payment_method = $_POST['payment_method'] ?? '';
  if (!in_array($payment_method, ['credit', 'promptpay', 'bank'])) {
    $err = 'กรุณาเลือกช่องทางการชำระเงิน';
  } else {
    $transaction_ref = 'TXN-' . date('YmdHis') . '-' . rand(1000, 9999);
    header("Location: /kos_fitness/packages/payment_success.php?txn=" . urlencode($transaction_ref) . "&mid=" . $membership_id);
    exit;
  }
}
?>

<?php include "../shared/header.php"; ?>

<div style="max-width: 700px; margin: 2rem auto;">
  <h1 class="page-title">ชำระเงินสมาชิก</h1>

  <div class="card" style="margin-bottom: 1.5rem;">
    <h2 class="card-title">สรุปรายการ</h2>
    <div style="display: grid; gap: 0.5rem;">
      <div style="display: flex; justify-content: space-between;"><span>แพ็กเกจ:</span><span style="font-weight: 600;"><?=htmlspecialchars($mem['package_name'])?></span></div>
      <div style="display: flex; justify-content: space-between;"><span>ราคา:</span><span style="font-weight: 600;"><?=number_format($mem['price'], 0)?> บาท</span></div>
      <div style="display: flex; justify-content: space-between;"><span>ระยะเวลา:</span><span style="font-weight: 600;">30 วัน</span></div>
      <hr style="border-color: var(--color-border); margin: 0.5rem 0;">
      <div style="display: flex; justify-content: space-between; font-size: 1.125rem;">
        <span style="font-weight: 700;">รวมทั้งสิ้น:</span>
        <span style="font-weight: 700; color: var(--color-orange);"><?=number_format($mem['price'], 0)?> บาท</span>
      </div>
    </div>
  </div>

  <div class="card">
    <h2 class="card-title">เลือกช่องทางการชำระเงิน</h2>
    <?php if (!empty($err)): ?><div class="error-message"><?=htmlspecialchars($err)?></div><?php endif; ?>

    <form method="post" class="form-radio-group">
      <label><input type="radio" name="payment_method" value="credit" required> บัตรเครดิต / เดบิต</label>
      <label><input type="radio" name="payment_method" value="promptpay"> PromptPay / QR Code</label>
      <label><input type="radio" name="payment_method" value="bank"> โอนผ่านบัญชีธนาคาร</label>
      <button type="submit" class="btn btn-primary btn-full" style="margin-top: 1rem;">
        ชำระเงิน <?=number_format($mem['price'], 0)?> บาท
      </button>
      <a href="/kos_fitness/packages/select_package.php" style="display: block; text-align: center; margin-top: 1rem;" class="text-muted">ยกเลิก</a>
    </form>
  </div>
</div>
<?php include "../shared/footerhome.php"; ?>