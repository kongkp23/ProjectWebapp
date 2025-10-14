<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_login();

$hint = strtolower($_GET['plan'] ?? '');
$map  = ['standard'=>'Standard Access','premium'=>'Premium Access'];
$pref = $map[$hint] ?? null;

$packages = $conn->query("SELECT * FROM packages ORDER BY price ASC")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $package_id = intval($_POST['package_id']);
  $uid = $_SESSION['user']['id'];
  $start = date('Y-m-d');
  $end   = date('Y-m-d', strtotime('+30 days'));
  // card number ง่าย ๆ
  $card = 'KOS-'.date('Y').'-'.str_pad(rand(1,9999),4,'0',STR_PAD_LEFT);

  $sql = "INSERT INTO memberships(user_id,package_id,start_date,end_date,status,card_number)
          VALUES(?,?,?,?, 'active', ?)";
  $stmt= $conn->prepare($sql);
  $stmt->bind_param("iisss", $uid,$package_id,$start,$end,$card);
  if ($stmt->execute()) {

  header("Location: /kos_fitness/packages/payment.php?mid=" . $stmt->insert_id);
    exit;
  } else $err = $conn->error;
}
?>
<?php include "../shared/header.php"; ?>
<h1 class="text-3xl font-bold mb-6">เลือกแพ็กเกจสมาชิก</h1>
<?php if(!empty($err)): ?><div class="text-red-400 mb-4"><?=htmlspecialchars($err)?></div><?php endif; ?>

<div class="grid md:grid-cols-2 gap-6">
<?php foreach($packages as $p): ?>
  <form method="post" class="border border-white/10 rounded-2xl p-6 bg-[#0b0b0c]">
    <input type="hidden" name="package_id" value="<?=$p['id']?>">
    <h2 class="text-2xl font-extrabold"><?=$p['name']?></h2>
    <p class="text-4xl mt-2"><?=number_format($p['price'],0)?> <span class="text-gray-400 text-base">บาท/เดือน</span></p>
    <?php if(!empty($p['perks'])): ?>
      <ul class="mt-4 list-disc list-inside text-gray-300">
        <?php foreach(explode(';',$p['perks']) as $perk): ?>
          <li><?=htmlspecialchars(trim($perk))?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <button class="mt-6 px-5 py-2 rounded-full bg-orange-500 hover:bg-orange-600">เลือกแพ็กเกจนี้</button>
    <?php if($pref && $p['name']===$pref): ?>
      <div class="mt-2 text-xs text-orange-300">* มาจากปุ่มลัดบนหน้าแรก</div>
    <?php endif; ?>
  </form>
<?php endforeach; ?>
</div>
<?php include "../shared/footer.php"; ?>
