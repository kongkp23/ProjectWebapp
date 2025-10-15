<?php require_once "../includes/conn.php"; ?>
<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php include "../shared/header.php"; ?>

<div class="form-container" style="margin: 2rem auto;">
    <h1 class="page-title">เข้าสู่ระบบ</h1>
    <?php if(!empty($_SESSION['error'])): ?>
        <div class="error-message"><?=htmlspecialchars($_SESSION['error'])?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form method="post" action="login_process.php">
        <div class="form-group">
            <input class="form-input" type="email" name="email" placeholder="อีเมล" required>
        </div>
        <div class="form-group">
            <input class="form-input" type="password" name="password" placeholder="รหัสผ่าน" required>
        </div>
        <button class="btn btn-primary">เข้าสู่ระบบ</button>
    </form>
    <p style="margin-top: 1rem;" class="text-muted">ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
</div>

<?php include "../shared/footer.php"; ?>