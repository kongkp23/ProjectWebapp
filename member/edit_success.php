<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_admin();
?>
<?php include "../shared/header.php"; ?>

<div class="payment-success-page">
    <div class="success-container">
        <div class="success-icon" style="background-color: rgba(249, 115, 22, 0.2); border-color: var(--color-orange);">
            <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: var(--color-orange);">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
        </div>
        
        <h1 class="success-title" style="color: var(--color-orange);">แก้ไขข้อมูลสำเร็จ!</h1>
        
        <div class="success-card" style="border-color: rgba(249, 115, 22, 0.3); background-color: rgba(249, 115, 22, 0.1);">
            <div class="success-info-grid">
                <div>
                    <span class="info-label" style="color: #fdba74;">สถานะ</span>
                    <div class="info-value">อัพเดทข้อมูลสมาชิกเรียบร้อยแล้ว</div>
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