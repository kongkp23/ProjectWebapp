<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
function require_login() {
  if (empty($_SESSION['user'])) {
    header("Location: /kos_fitness/auth/login.php");
    exit;
  }
}
function require_admin() {
  require_login();
  if ($_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    echo "Forbidden: Admin only";
    exit;
  }
}
