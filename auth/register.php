<?php
require_once "../includes/conn.php";
if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full = $_POST['full_name'] ?? '';
  $email= $_POST['email'] ?? '';
  $phone= $_POST['phone'] ?? '';
  $pass = $_POST['password'] ?? '';

  $sql = "INSERT INTO users(full_name,email,phone,password,role) VALUES(?,?,?,?, 'user')";
  $stmt= $conn->prepare($sql);
  $stmt->bind_param("ssss", $full,$email,$phone,$pass);
  if ($stmt->execute()) {
    $_SESSION['user'] = [
      'id'=>$stmt->insert_id,'full_name'=>$full,'email'=>$email,'phone'=>$phone,'role'=>'user'
    ];
    header("Location: /kos_fitness/packages/select_package.php");
    exit;
  } else {
    $err = $conn->error;
  }
}
?>
<?php include "../shared/header.php"; ?>
<div class="form-container" style="margin: 2rem auto;">
    <h1 class="page-title">สมัครสมาชิก</h1>
    <?php if(!empty($err)): ?>
      <div class="error-message"><?=htmlspecialchars($err)?></div>
    <?php endif; ?>
    <form method="post">
      <div class="form-group">
        <input class="form-input" name="full_name" placeholder="ชื่อ-สกุล" required>
      </div>
      <div class="form-group">
        <input class="form-input" type="email" name="email" placeholder="อีเมล" required>
      </div>
      <div class="form-group">
        <input class="form-input" name="phone" placeholder="เบอร์โทร">
      </div>
      <div class="form-group">
        <input class="form-input" type="password" name="password" placeholder="รหัสผ่าน" required>
      </div>
      <button class="btn btn-primary">สมัคร</button>
    </form>
    <p style="margin-top: 1rem;" class="text-muted">มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
</div>
<?php include "../shared/footer.php"; ?>