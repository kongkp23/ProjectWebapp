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
      'id'=>$stmt->insert_id,'full_name'=>$full,'email'=>$email,'phone'=>$phone,'password'=>$pass,'role'=>'user'
    ];
    header("Location: /kos_fitness/packages/select_package.php");
    exit;
  } else {
    $err = $conn->error;
  }
}
?>
<?php include "../shared/header.php"; ?>
<h1 class="text-3xl font-bold mb-6">สมัครสมาชิก</h1>
<?php if(!empty($err)): ?>
  <div class="mb-4 text-red-400"><?=htmlspecialchars($err)?></div>
<?php endif; ?>
<form class="max-w-md space-y-4" method="post">
  <input class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" name="full_name" placeholder="ชื่อ-สกุล" required>
  <input class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" type="email" name="email" placeholder="อีเมล" required>
  <input class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" name="phone" placeholder="เบอร์โทร">
  <input class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" type="password" name="password" placeholder="รหัสผ่าน" required>
  <button class="px-6 py-2 rounded bg-orange-500 hover:bg-orange-600">สมัคร</button>
</form>
<?php include "../shared/footer.php"; ?>
