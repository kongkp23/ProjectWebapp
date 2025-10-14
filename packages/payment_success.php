<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_login();

$txn = $_GET['txn'] ?? 'N/A';
$mid = intval($_GET['mid'] ?? 0);

$uid = $_SESSION['user']['id'];
$sql = "SELECT m.*, p.name AS package_name, p.price
        FROM memberships m
        JOIN packages p ON p.id=m.package_id
        WHERE m.id=? AND m.user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mid, $uid);
$stmt->execute();
$mem = $stmt->get_result()->fetch_assoc();

if (!$mem) {
  header("Location: /kos_fitness/home.php");
  exit;
}
?>
<?php include "../shared/header.php"; ?>

<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  @keyframes slideIn {
    from { opacity: 0; transform: translateX(-30px); }
    to { opacity: 1; transform: translateX(0); }
  }
  .success-container {
    animation: fadeIn 0.6s ease-out;
  }
  .success-icon {
    animation: slideIn 0.8s ease-out 0.2s backwards;
  }
  .redirect-timer {
    font-weight: bold;
    color: #F97316;
  }
</style>

<div class="flex items-center justify-center min-h-screen px-4">
  <div class="success-container max-w-xl w-full">
    <!-- ไอคอน Success -->
    <div class="text-center mb-6">
      <div class="success-icon inline-block p-6 rounded-full bg-green-500/20 border-2 border-green-500 mb-4">
        <svg class="w-16 h-16 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
      </div>
      <h1 class="text-3xl md:text-4xl font-extrabold text-green-400">ชำระเงินสำเร็จ!</h1>
    </div>

    <!-- การ์ดข้อมูล -->
    <div class="border border-green-500/30 rounded-2xl p-6 bg-green-500/10 mb-6">
      <div class="space-y-3 text-gray-200">
        <div>
          <span class="text-gray-400 text-sm">แพ็กเกจ</span>
          <div class="text-lg font-semibold"><?=htmlspecialchars($mem['package_name'])?></div>
        </div>
        <div>
          <span class="text-gray-400 text-sm">จำนวนเงิน</span>
          <div class="text-2xl font-bold text-orange-400"><?=number_format($mem['price'], 0)?> บาท</div>
        </div>
        <div>
          <span class="text-gray-400 text-sm">วันเริ่มสมาชิก</span>
          <div class="text-lg"><?=htmlspecialchars($mem['start_date'])?></div>
        </div>
        <div>
          <span class="text-gray-400 text-sm">วันหมดอายุ</span>
          <div class="text-lg"><?=htmlspecialchars($mem['end_date'])?></div>
        </div>
      </div>
    </div>

    <!-- ปุ่มทำเอง + ตัวจับเวลา -->
    <div class="flex flex-col gap-3">
      <a href="/kos_fitness/member/card.php" 
         class="block text-center px-6 py-3 rounded-full bg-orange-500 hover:bg-orange-600 font-bold text-white transition-colors">
        ไปยังบัตรสมาชิกทันที
      </a>
      <a href="/kos_fitness/home.php" 
         class="block text-center px-6 py-2 rounded-full bg-gray-700 hover:bg-gray-600 text-gray-200">
        กลับไปหน้าหลัก
      </a>
    </div>

    <!-- Countdown -->
    <div class="text-center mt-6 text-gray-400">
      เพิ่มเติม: <span class="redirect-timer" id="countdown">3</span> วินาที
    </div>
  </div>
</div>

<script>
  let timeLeft = 3;
  const countdownEl = document.getElementById('countdown');
  
  function redirect() {
    window.location.href = '/kos_fitness/member/card.php';
  }
  
  const interval = setInterval(() => {
    timeLeft--;
    countdownEl.textContent = timeLeft;
    
    if (timeLeft <= 0) {
      clearInterval(interval);
      redirect();
    }
  }, 1000);
</script>

<?php include "../shared/footer.php"; ?>