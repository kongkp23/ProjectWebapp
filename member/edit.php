<?php
require_once "../includes/conn.php"; require_once "../includes/auth.php"; require_admin();
$id = intval($_GET['id'] ?? 0);
if($_SERVER['REQUEST_METHOD']==='POST'){
  $full=$_POST['full_name']??''; $email=$_POST['email']??''; $phone=$_POST['phone']??''; $role=$_POST['role']??'user';
  $sql="UPDATE users SET full_name=?, email=?, phone=?, role=? WHERE id=?";
  $stmt=$conn->prepare($sql); $stmt->bind_param("ssssi",$full,$email,$phone,$role,$id);
  if($stmt->execute()){ header("Location: edit_success.php"); exit; } else $err=$conn->error;
}
$u = $conn->query("SELECT * FROM users WHERE id={$id}")->fetch_assoc();
?>
<?php include "../shared/header.php"; ?>
<br>
<div class="form-container">
    <h1 class="page-title">แก้ไขสมาชิก #<?=$id?></h1>
    <?php if(!$u):?><p>ไม่พบข้อมูล</p><?php include "../shared/footer.php"; exit; endif;?>
    <?php if(!empty($err)):?><div class="error-message"><?=htmlspecialchars($err)?></div><?php endif;?>
    <form method="post">
        <div class="form-group"><input class="form-input" name="full_name" value="<?=htmlspecialchars($u['full_name'])?>" required></div>
        <div class="form-group"><input class="form-input" type="email" name="email" value="<?=htmlspecialchars($u['email'])?>" required></div>
        <div class="form-group"><input class="form-input" name="phone" value="<?=htmlspecialchars($u['phone'])?>"></div>
        <div class="form-group">
            <select class="form-select" name="role">
                <option value="user" <?=$u['role']=='user'?'selected':''?>>user</option>
                <option value="admin" <?=$u['role']=='admin'?'selected':''?>>admin</option>
            </select>
        </div>
        <button class="btn btn-primary">บันทึก</button>
    </form>
</div>
<?php include "../shared/footerhome.php"; ?>