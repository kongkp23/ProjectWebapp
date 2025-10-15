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
<br>
<div class="form-container">
    <h1 class="page-title">เพิ่มสมาชิก</h1>
    <?php if(!empty($err)):?><div class="error-message"><?=htmlspecialchars($err)?></div><?php endif;?>
    <form method="post">
        <div class="form-group"><input class="form-input" name="full_name" placeholder="ชื่อ-สกุล" required></div>
        <div class="form-group"><input class="form-input" type="email" name="email" placeholder="อีเมล" required></div>
        <div class="form-group"><input class="form-input" name="phone" placeholder="เบอร์โทร"></div>
        <div class="form-group"><input class="form-input" type="password" name="password" placeholder="รหัสผ่าน (ถ้าต้องการตั้งใหม่)"></div>
        <div class="form-group">
            <select class="form-select" name="role">
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select>
        </div>
        <button class="btn btn-primary">บันทึก</button>
    </form>
</div>
<?php include "../shared/footerhome.php"; ?>