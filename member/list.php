<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_admin();
echo "<br>";
$q = trim($_GET['q'] ?? '');
$sql = "SELECT u.id, u.full_name, u.email, u.phone, u.role, p.name AS package_name
        FROM users u
        LEFT JOIN (
            SELECT user_id, package_id, ROW_NUMBER() OVER(PARTITION BY user_id ORDER BY start_date DESC) as rn
            FROM memberships
            WHERE status = 'active'
        ) m ON u.id = m.user_id AND m.rn = 1
        LEFT JOIN packages p ON m.package_id = p.id
        WHERE 1";

$params = [];
$bind = '';
if ($q !== '') {
  $sql .= " AND (u.full_name LIKE CONCAT('%',?,'%') OR u.email LIKE CONCAT('%',?,'%'))";
  $params = [$q, $q];
  $bind = "ss";
}
$sql .= " ORDER BY u.id DESC";

$stmt = $conn->prepare($sql);
if ($bind) $stmt->bind_param($bind, ...$params);
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<?php include "../shared/header.php"; ?>
<h1 class="page-title">จัดการสมาชิก</h1>

<form style="margin-bottom: 1rem; display: flex; gap: 0.5rem; align-items: center;">
  <input class="form-input" style="flex: 1;" name="q" value="<?=htmlspecialchars($q)?>" placeholder="ค้นหาด้วยชื่อหรืออีเมล">
  <button class="btn btn-secondary">ค้นหา</button>
  <a class="btn btn-primary" href="add.php">เพิ่มสมาชิก</a>
</form>

<div class="table-wrapper">
<table class="styled-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>ชื่อ-สกุล</th>
      <th>อีเมล</th>
      <th>โทร</th>
      <th class="text-center">สิทธิ์</th>
      <th>แพ็กเกจล่าสุด (Active)</th>
      <th class="text-center">จัดการ</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($users as $u): ?>
    <tr>
      <td><?=$u['id']?></td>
      <td><?=htmlspecialchars($u['full_name'])?></td>
      <td><?=htmlspecialchars($u['email'])?></td>
      <td><?=htmlspecialchars($u['phone'])?></td>
      <td class="text-center"><?=htmlspecialchars($u['role'])?></td>
      <td><?= $u['package_name'] ? htmlspecialchars($u['package_name']) : '<span class="text-muted">-</span>' ?></td>
      <td class="actions">
        <a class="btn btn-secondary" href="edit.php?id=<?=$u['id']?>">แก้ไข</a>
        <a class="btn btn-danger delete-link" href="delete.php?id=<?=$u['id']?>">ลบ</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>

<?php include "../shared/footerhome.php"; ?>