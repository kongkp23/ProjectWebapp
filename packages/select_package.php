<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_login();
echo "<br>";
$packages = $conn->query("SELECT * FROM packages ORDER BY price ASC")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $package_id = intval($_POST['package_id']);
  $uid = $_SESSION['user']['id'];
  $start = date('Y-m-d');
  $end   = date('Y-m-d', strtotime('+30 days'));
  $card = 'KOS-'.date('Y').'-'.str_pad(rand(1,9999),4,'0',STR_PAD_LEFT);

  $sql = "INSERT INTO memberships(user_id,package_id,start_date,end_date,status,card_number) VALUES(?,?,?,?, 'pending', ?)";
  $stmt= $conn->prepare($sql);
  $stmt->bind_param("iisss", $uid,$package_id,$start,$end,$card);
  if ($stmt->execute()) {
    header("Location: /kos_fitness/packages/payment.php?mid=" . $stmt->insert_id);
    exit;
  } else $err = $conn->error;
}
?>
<?php include "../shared/header.php"; ?>
<h1 class="page-title">เลือกแพ็กเกจสมาชิก</h1>
<?php if(!empty($err)): ?><div class="error-message"><?=htmlspecialchars($err)?></div><?php endif; ?>

<div class="grid-2">
<?php foreach($packages as $p): ?>
  <form method="post" class="card">
    <input type="hidden" name="package_id" value="<?=$p['id']?>">
    <h2 class="card-title" style="font-size: 1.5rem;"><?=htmlspecialchars($p['name'])?></h2>
    <p style="font-size: 2.25rem; font-weight: 700; margin: 0.5rem 0;"><?=number_format($p['price'],0)?> <span class="text-muted" style="font-size: 1rem; font-weight: 400;">บาท/เดือน</span></p>
    <?php if(!empty($p['perks'])): ?>
      <ul class="checklist" style="margin: 1.5rem 0;">
        <?php foreach(explode(';',$p['perks']) as $perk): ?>
          <li><?=htmlspecialchars(trim($perk))?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <button class="btn btn-primary" style="margin-top: 1rem;">เลือกแพ็กเกจนี้</button>
  </form>
<?php endforeach; ?>
</div>
<?php include "../shared/footerhome.php"; ?>