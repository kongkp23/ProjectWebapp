<?php
require_once "../includes/conn.php";
if (session_status() === PHP_SESSION_NONE) session_start();

$email = $_POST['email'] ?? '';
$pass  = $_POST['password'] ?? '';

$sql = "SELECT * FROM users WHERE email=? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

if ($user && $user['password'] === $pass) { // ไม่มีการ hash รหัสผ่าน
  $_SESSION['user'] = $user;
  header("Location: /kos_fitness/home.php");
} else {
  $_SESSION['error'] = "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
  header("Location: login.php");
}
exit;