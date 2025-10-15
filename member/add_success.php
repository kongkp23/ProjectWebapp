<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_admin();
?>
<?php include "../shared/header.php"; ?>

<div class="payment-success-page">
    <div class="success-container">
        <div class="success-icon">
            <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: var(--color-green);">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <h1 class="success-title">เพิ่มสมาชิกสำเร็จ!</h1>
        
        <div class="success-card">
            <div class="success-info-grid">
                <div>
                    <span class="info-label">สถานะ</span>
                    <div class="info-value">เพิ่มข้อมูลสมาชิกใหม่เรียบร้อยแล้ว</div>
                </div>
            </div>
        </div>

        <div class="success-actions">
            <a href="list.php" class="btn btn-primary btn-full">กลับไปหน้ารายชื่อสมาชิก</a>
            <a href="add.php" class="btn btn-secondary btn-full">เพิ่มสมาชิกอีกคน</a>
        </div>

        <div class="countdown-timer">
            กำลังพาคุณกลับไปหน้ารายชื่อใน <span id="countdown-edit">3</span> วินาที...
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
            window.location.href = 'list.php';
        }
    }, 1000);
});
</script>

<?php include "../shared/footerhome.php"; ?>