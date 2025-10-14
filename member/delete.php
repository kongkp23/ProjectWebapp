<?php
require_once "../includes/conn.php"; require_once "../includes/auth.php"; require_admin();
$id = intval($_GET['id'] ?? 0);
$conn->query("DELETE FROM users WHERE id={$id}");
header("Location: list.php");
