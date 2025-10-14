<?php
require_once "../includes/conn.php"; require_once "../includes/auth.php"; require_admin();
$id = intval($_GET['id'] ?? 0);
if($_SERVER['REQUEST_METHOD']==='POST'){
  $full=$_POST['full_name']??''; $email=$_POST['email']??''; $phone=$_POST['phone']??''; $role=$_POST['role']??'user';
  $sql="UPDATE users SET full_name=?, email=?, phone=?, role=? WHERE id=?";
  $stmt=$conn->prepare($sql); $stmt->bind_param("ssssi",$full,$email,$phone,$role,$id);
  if($stmt->execute()){ header("Location: list.php"); exit; } else $err=$conn->error;
}
$u = $conn->query("SELECT * FROM users WHERE id={$id}")->fetch_assoc();
?>
<?php include "../shared/header.php"; ?>
<h1 class="text-2xl font-bold mb-4">แก้ไขสมาชิก #<?=$id?></h1>
<?php if(!$u):?><p>ไม่พบข้อมูล</p><?php include "../shared/footer.php"; exit; endif;?>
<?php if(!empty($err)):?><div class="text-red-400 mb-3"><?=htmlspecialchars($err)?></div><?php endif;?>
<form method="post" class="max-w-md space-y-3">
  <input class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" name="full_name" value="<?=htmlspecialchars($u['full_name'])?>" required>
  <input class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" type="email" name="email" value="<?=htmlspecialchars($u['email'])?>" required>
  <input class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" name="phone" value="<?=htmlspecialchars($u['phone'])?>">
  <select class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" name="role">
    <option <?=$u['role']=='user'?'selected':''?>>user</option>
    <option <?=$u['role']=='admin'?'selected':''?>>admin</option>
  </select>
  <button class="px-5 py-2 rounded bg-orange-500 hover:bg-orange-600">บันทึก</button>
</form>
<?php include "../shared/footer.php"; ?>
