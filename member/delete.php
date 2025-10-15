<?php
require_once "../includes/conn.php";
require_once "../includes/auth.php";
require_admin();

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: list.php");
exit;