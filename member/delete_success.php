<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_admin();
?>
<?php include "../shared/header.php"; ?>

<div class="payment-success-page">
    <div class="success-container">
        <div class="success-icon" style="background-color: rgba(239, 68, 68, 0.2); border-color: var(--color-red);">
            <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: var(--color-red);">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </div>
        
        <h1 class="success-title" style="color: var(--color-red);">ลบสมาชิกสำเร็จ!</h1>
        
        <div class="success-card" style="border-color: rgba(239, 68, 68, 0.3); background-color: rgba(239, 68, 68, 0.1);">
            <div class="success-info-grid">
                <div>
                    <span class="info-label" style="color: #fca5a5;">สถานะ</span>
                    <div class="info-value">ลบข้อมูลสมาชิกออกจากระบบเรียบร้อยแล้ว</div>
                </div>
            </div>
        </div>

        <div class="success-actions">
            <a href="list.php" class="btn btn-primary btn-full">กลับไปหน้ารายชื่อสมาชิก</a>
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