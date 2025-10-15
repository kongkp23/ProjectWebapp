<?php
$host = "localhost";
$user = "root";
$pass = ""; // ใส่รหัสผ่าน MySQL ของคุณ
$db   = "fitness_db";

$conn = new mysqli(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_NAME')
);

if ($conn->connect_error) {
  die("Connection  failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");