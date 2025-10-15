<?php
require_once "../includes/conn.php";
if (session_status() === PHP_SESSION_NONE) session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>
<?php include "../shared/header.php"; ?>

<div class="payment-success-page">
    <div class="success-container">
        <div class="success-icon">
            <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: var(--color-green);">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
        </div>
        
        <h1 class="success-title">สมัครสมาชิกสำเร็จ!</h1>
        
        <div class="success-card">
            <div class="success-info-grid">
                <div>
                    <span class="info-label">ชื่อ-สกุล</span>
                    <div class="info-value"><?= htmlspecialchars($user['full_name']) ?></div>
                </div>
                <div>
                    <span class="info-label">อีเมล</span>
                    <div class="info-value"><?= htmlspecialchars($user['email']) ?></div>
                </div>
                <?php if (!empty($user['phone'])): ?>
                <div>
                    <span class="info-label">เบอร์โทร</span>
                    <div class="info-value"><?= htmlspecialchars($user['phone']) ?></div>
                </div>
                <?php endif; ?>
                <div>
                    <span class="info-label">สถานะ</span>
                    <div class="info-value">ลงทะเบียนเรียบร้อยแล้ว</div>
                </div>
            </div>
        </div>

        <div class="success-actions">
            <a href="/kos_fitness/packages/select_package.php" class="btn btn-primary btn-full">เลือกแพ็คเกจ</a>
            <a href="/kos_fitness/member/home.php" class="btn btn-secondary btn-full">ไปหน้าหลัก</a>
        </div>

        <div class="countdown-timer">
            กำลังพาคุณไปเลือกแพ็คเกจใน <span id="countdown-edit">3</span> วินาที...
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const countdownEl = document.getElementById('countdown-edit');
    let timeLeft = 3;
    const interval = setInterval(() => {
        timeLeft--;
        if (countdownEl) {
            countdownEl.textContent = timeLeft;
        }
        if (timeLeft <= 0) {
            clearInterval(interval);
            window.location.href = '/kos_fitness/packages/select_package.php';
        }
    }, 1000);
});
</script>

<?php include "../shared/footerdashboard.php"; ?>