<?php
require_once "../includes/conn.php"; require_once "../includes/auth.php"; require_admin();
if ($_SERVER['REQUEST_METHOD']==='POST'){
  $full=$_POST['full_name']??''; $email=$_POST['email']??''; $phone=$_POST['phone']??''; $pass=$_POST['password']??''; $role=$_POST['role']??'user';
  $sql="INSERT INTO users(full_name,email,phone,password,role) VALUES(?,?,?,?,?)";
  $stmt=$conn->prepare($sql); $stmt->bind_param("sssss",$full,$email,$phone,$pass,$role);
  if($stmt->execute()){ header("Location: list.php"); exit; } else $err=$conn->error;
}
?>
<?php include "../shared/header.php"; ?>
<h1 class="text-2xl font-bold mb-4">เพิ่มสมาชิก</h1>
<?php if(!empty($err)):?><div class="text-red-400 mb-3"><?=htmlspecialchars($err)?></div><?php endif;?>
<form method="post" class="max-w-md space-y-3">
  <input class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" name="full_name" placeholder="ชื่อ-สกุล" required>
  <input class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" type="email" name="email" placeholder="อีเมล" required>
  <input class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" name="phone" placeholder="เบอร์โทร">
  <input class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" type="password" name="password" placeholder="รหัสผ่าน">
  <select class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" name="role">
    <option value="user">user</option>
    <option value="admin">admin</option>
  </select>
  <button class="px-5 py-2 rounded bg-orange-500 hover:bg-orange-600">บันทึก</button>
</form>
<?php include "../shared/footer.php"; ?>
