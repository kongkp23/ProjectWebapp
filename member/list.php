<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_admin();

$q = trim($_GET['q'] ?? '');
$sql = "SELECT u.id, u.full_name, u.email, u.phone, u.role,
        p.name AS package_name
        FROM users u
        LEFT JOIN memberships m ON u.id = m.user_id AND m.status = 'active'
        LEFT JOIN packages p ON m.package_id = p.id
        WHERE 1";
$params = [];
$bind   = '';
if ($q !== '') {
  $sql .= " AND (u.full_name LIKE CONCAT('%',?,'%') OR u.email LIKE CONCAT('%',?,'%'))";
  $params = [$q,$q]; $bind = "ss";
}
$sql .= " ORDER BY u.id DESC";

$stmt = $conn->prepare($sql);
if ($bind) $stmt->bind_param($bind, ...$params);
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<?php include "../shared/header.php"; ?>
<h1 class="text-3xl font-extrabold mb-6">จัดการสมาชิก</h1>

<form class="mb-4 flex gap-2">
  <input class="flex-1 px-4 py-2 rounded bg-[#0b0b0c] border border-white/10"
         name="q" value="<?=htmlspecialchars($q)?>" placeholder="ค้นหาด้วยชื่อหรืออีเมล">
  <button class="px-4 py-2 rounded bg-gray-700 hover:bg-gray-600">ค้นหา</button>
  <a class="px-4 py-2 rounded bg-orange-500 hover:bg-orange-600" href="add.php">เพิ่มสมาชิก</a>
</form>

<div class="overflow-x-auto">
<table class="min-w-full border border-white/10 rounded-lg overflow-hidden">
  <thead class="bg-[#0f0f11]">
    <tr>
      <th class="px-3 py-2 text-left">ID</th>
      <th class="px-3 py-2 text-left">ชื่อ-สกุล</th>
      <th class="px-3 py-2 text-left">อีเมล</th>
      <th class="px-3 py-2 text-left">โทร</th>
      <th class="px-3 py-2 text-center">สิทธิ์</th>
      <th class="px-3 py-2 text-left">แพ็กเกจที่ใช้อยู่</th>
      <th class="px-3 py-2 text-center">จัดการ</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($users as $u): ?>
    <tr class="border-t border-white/10">
      <td class="px-3 py-2"><?=$u['id']?></td>
      <td class="px-3 py-2"><?=htmlspecialchars($u['full_name'])?></td>
      <td class="px-3 py-2"><?=htmlspecialchars($u['email'])?></td>
      <td class="px-3 py-2"><?=htmlspecialchars($u['phone'])?></td>
      <td class="px-3 py-2 text-center"><?=htmlspecialchars($u['role'])?></td>
      <td class="px-3 py-2">
        <?= $u['package_name'] ? htmlspecialchars($u['package_name']) : '<span class="text-gray-500">-</span>' ?>
      </td>
      <td class="px-3 py-2 text-center">
        <a class="px-3 py-1 rounded bg-gray-700 hover:bg-gray-600" href="edit.php?id=<?=$u['id']?>">แก้ไข</a>
        <a class="px-3 py-1 rounded bg-red-600 hover:bg-red-700"
           href="delete.php?id=<?=$u['id']?>"
           onclick="return confirm('ลบผู้ใช้นี้?')">ลบ</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>

<?php include "../shared/footer.php"; ?>
