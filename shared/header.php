<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>KOS Fitness</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="/kos_fitness/assets/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body>
<header class="site-header">
  <div class="container header-container">
    <a href="<?= !empty($_SESSION['user']) ? '/kos_fitness/home.php' : '/kos_fitness/index.php' ?>" class="logo">
      KOS <span class="logo-accent">FITNESS</span>
    </a>

    <nav class="main-nav">
      <ul>
        <li><a href="<?= !empty($_SESSION['user']) ? '/kos_fitness/home.php' : '/kos_fitness/index.php' ?>">หน้าแรก</a></li>
        <li><a href="/kos_fitness/packages/select_package.php">แพ็กเกจสมาชิก</a></li>
        <li><a href="/kos_fitness/member/card.php">บัตรสมาชิก</a></li>
        <?php if (!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? 'user') === 'admin'): ?>
          <li><a href="/kos_fitness/member/list.php">จัดการสมาชิก</a></li>
          <li><a href="/kos_fitness/reports/dashboard_report.php">รายงาน</a></li>
        <?php endif; ?>
      </ul>
    </nav>
    <div class="header-actions">
      <?php if(!empty($_SESSION['user'])): ?>
        <span class="header-greeting">สวัสดี, <?=htmlspecialchars($_SESSION['user']['full_name'])?></span>
        <a class="btn btn-secondary" href="/kos_fitness/auth/logout.php">ออกจากระบบ</a>
      <?php else: ?>
        <a class="btn btn-outline" href="/kos_fitness/auth/login.php">เข้าสู่ระบบ</a>
        <a class="btn btn-primary" href="/kos_fitness/auth/register.php">สมัครสมาชิก</a>
      <?php endif; ?>
    </div>
     <button id="mobile-menu-btn" class="mobile-menu-btn" aria-label="เมนู">
        <svg class="icon-menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
        <svg class="icon-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
  </div>
    <div id="mobile-nav" class="mobile-nav">
       <ul>
        <li><a href="<?= !empty($_SESSION['user']) ? '/kos_fitness/home.php' : '/kos_fitness/index.php' ?>">หน้าแรก</a></li>
        <li><a href="/kos_fitness/packages/select_package.php">แพ็กเกจสมาชิก</a></li>
        <li><a href="/kos_fitness/member/card.php">บัตรสมาชิก</a></li>
        <?php if (!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? 'user') === 'admin'): ?>
          <li><a href="/kos_fitness/member/list.php">จัดการสมาชิก</a></li>
          <li><a href="/kos_fitness/reports/dashboard_report.php">รายงาน</a></li>
        <?php endif; ?>
      </ul>
      <div class="mobile-nav-actions">
         <?php if(empty($_SESSION['user'])): ?>
            <a href="/kos_fitness/auth/login.php" class="btn btn-outline btn-full">เข้าสู่ระบบ</a>
            <a href="/kos_fitness/auth/register.php" class="btn btn-primary btn-full">สมัครสมาชิก</a>
         <?php endif; ?>
      </div>
    </div>
</header>
<main class="main-content container">