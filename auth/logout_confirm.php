<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// ตรวจสอบว่ามีการยืนยันหรือไม่
if (isset($_POST['confirm_logout'])) {
    session_destroy();
    header("Location: /kos_fitness/index.php");
    exit;
}

// ถ้ากดยกเลิก
if (isset($_POST['cancel_logout'])) {
    header("Location: /kos_fitness/home.php");
    exit;
}

include $_SERVER['DOCUMENT_ROOT'] . '/kos_fitness/shared/header.php';
?>

<div style="display: flex; align-items: center; justify-content: center; min-height: calc(100vh - 350px); padding: 1rem;">
    <div style="max-width: 500px; width: 100%;">
        <div class="card" style="text-align: center;">
            <!-- ไอคอนเตือน -->
            <div style="display: inline-block; padding: 1.5rem; border-radius: 9999px; background-color: rgba(251, 146, 60, 0.2); border: 2px solid var(--color-orange); margin-bottom: 1.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-orange);">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </div>

            <!-- หัวข้อ -->
            <h1 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 1rem; color: var(--color-text);">
                ยืนยันการออกจากระบบ
            </h1>

            <!-- ข้อความ -->
            <p style="color: var(--color-text-muted); margin-bottom: 2rem; font-size: 1rem;">
                คุณแน่ใจหรือไม่ว่าต้องการออกจากระบบ?<br>
                คุณจะต้องเข้าสู่ระบบอีกครั้งเพื่อใช้งาน
            </p>

            <!-- แสดงข้อมูลผู้ใช้ที่กำลังจะออกจากระบบ -->
            <?php if (!empty($_SESSION['user'])): ?>
            <div style="background-color: rgba(249, 115, 22, 0.1); border: 1px solid rgba(249, 115, 22, 0.3); border-radius: 0.5rem; padding: 1rem; margin-bottom: 2rem;">
                <p style="margin: 0; color: var(--color-text-muted); font-size: 0.875rem;">
                    กำลังออกจากบัญชี
                </p>
                <p style="margin: 0.5rem 0 0 0; font-weight: 600; font-size: 1.125rem;">
                    <?= htmlspecialchars($_SESSION['user']['full_name']) ?>
                </p>
            </div>
            <?php endif; ?>

            <!-- ปุ่มยืนยัน -->
            <form method="POST" style="display: flex; flex-direction: column; gap: 0.75rem;">
                <button type="submit" name="confirm_logout" class="btn btn-danger btn-full">
                    ยืนยัน ออกจากระบบ
                </button>
                <button type="submit" name="cancel_logout" class="btn btn-secondary btn-full ">
                    ยกเลิก
                </button>
            </form>
        </div>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/kos_fitness/shared/footerhome.php'; ?>