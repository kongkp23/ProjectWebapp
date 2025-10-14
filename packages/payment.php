<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_login();

$membership_id = intval($_GET['mid'] ?? 0);
if (!$membership_id) {
  header("Location: /kos_fitness/packages/select_package.php");
  exit;
}

$uid = $_SESSION['user']['id'];
$sql = "SELECT m.*, p.name AS package_name, p.price
        FROM memberships m
        JOIN packages p ON p.id=m.package_id
        WHERE m.id=? AND m.user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $membership_id, $uid);
$stmt->execute();
$mem = $stmt->get_result()->fetch_assoc();

if (!$mem) {
  header("Location: /kos_fitness/home.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $payment_method = $_POST['payment_method'] ?? '';

  if (!in_array($payment_method, ['credit', 'promptpay', 'bank'])) {
    $err = 'กรุณาเลือกช่องทางการชำระเงิน';
  } else {
    // อัพเดตสถานะการชำระเงิน
    $sql_pay = "UPDATE memberships SET status='active' WHERE id=?";
    $stmt_pay = $conn->prepare($sql_pay);
    $stmt_pay->bind_param("i", $membership_id);
    $stmt_pay->execute();

    $transaction_ref = 'TXN-' . date('YmdHis') . '-' . rand(1000, 9999);
    header("Location: /kos_fitness/packages/payment_success.php?txn=" . urlencode($transaction_ref) . "&mid=" . $membership_id);
    exit;
  }
}
?>

<?php include "../shared/header.php"; ?>

<div class="max-w-2xl mx-auto">
  <h1 class="text-3xl font-extrabold mb-6">ชำระเงินสมาชิก</h1>

  <!-- สรุปรายการ -->
  <div class="border border-white/10 rounded-2xl p-6 bg-[#0b0b0c] mb-6">
    <h2 class="text-xl font-bold mb-4">สรุปรายการ</h2>
    <div class="space-y-2 text-gray-300">
      <div class="flex justify-between"><span>แพ็กเกจ:</span><span class="font-semibold"><?=htmlspecialchars($mem['package_name'])?></span></div>
      <div class="flex justify-between"><span>ราคา:</span><span class="font-semibold"><?=number_format($mem['price'], 0)?> บาท</span></div>
      <div class="flex justify-between"><span>ระยะเวลา:</span><span class="font-semibold">30 วัน</span></div>
      <div class="border-t border-white/10 mt-3 pt-3 flex justify-between text-lg">
        <span class="font-bold">รวมทั้งสิ้น:</span>
        <span class="font-bold text-orange-400"><?=number_format($mem['price'], 0)?> บาท</span>
      </div>
    </div>
  </div>

  <!-- ช่องทางการชำระเงิน -->
  <div class="border border-white/10 rounded-2xl p-6 bg-[#0b0b0c]">
    <h2 class="text-xl font-bold mb-4">เลือกช่องทางการชำระเงิน</h2>

    <?php if (!empty($err)): ?>
      <div class="mb-4 p-3 rounded bg-red-500/20 border border-red-500/30 text-red-300">
        <?=htmlspecialchars($err)?>
      </div>
    <?php endif; ?>

    <form method="post" class="space-y-4">
      <label class="flex items-center gap-3 p-3 border border-white/10 rounded cursor-pointer hover:bg-white/5">
        <input type="radio" name="payment_method" value="credit" class="accent-orange-500" required>
        <span>บัตรเครดิต / เดบิต</span>
      </label>

      <label class="flex items-center gap-3 p-3 border border-white/10 rounded cursor-pointer hover:bg-white/5">
        <input type="radio" name="payment_method" value="promptpay" class="accent-orange-500">
        <span>PromptPay / QR Code</span>
      </label>

      <label class="flex items-center gap-3 p-3 border border-white/10 rounded cursor-pointer hover:bg-white/5">
        <input type="radio" name="payment_method" value="bank" class="accent-orange-500">
        <span>โอนผ่านบัญชีธนาคาร</span>
      </label>

      <button type="submit" class="w-full px-6 py-3 rounded-full bg-orange-500 hover:bg-orange-600 font-bold text-white mt-6">
        ชำระเงิน <?=number_format($mem['price'], 0)?> บาท
      </button>

      <a href="/kos_fitness/packages/select_package.php" class="block text-center text-gray-400 hover:text-gray-300 text-sm">
        ยกเลิก
      </a>
    </form>
  </div>
</div>

<?php include "../shared/footer.php"; ?>
