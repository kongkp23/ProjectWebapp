<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <title>KOS Fitness</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600;800&display=swap" rel="stylesheet">
  <style>body{font-family:'Kanit',sans-serif}</style>
</head>
<body class="bg-[#18181b] text-white">
<header class="fixed top-0 left-0 right-0 z-50 bg-[#18181b]/80 backdrop-blur border-b border-white/10">
  <div class="container mx-auto px-4">
    <div class="flex justify-between items-center h-16">
    <a href="<?= !empty($_SESSION['user']) ? '/kos_fitness/home.php' : '/kos_fitness/index.html' ?>" 
        class="text-2xl font-extrabold">
        KOS <span class="text-orange-500">FITNESS</span>
    </a>

      <nav class="hidden md:block">
        <ul class="flex items-center gap-6 text-gray-300">
          <li><a class="hover:text-white" href="<?= !empty($_SESSION['user']) ? '/kos_fitness/home.php' : '/kos_fitness/index.html' ?>">หน้าแรก</a></li>
          <li><a class="hover:text-white" href="/kos_fitness/packages/select_package.php">แพ็กเกจสมาชิก</a></li>
          <li><a class="hover:text-white" href="/kos_fitness/member/card.php">บัตรสมาชิก</a></li>

          <?php if (!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? 'user') === 'admin'): ?>
            <!-- เมนูสำหรับ Admin เท่านั้น -->
            <li><a class="hover:text-white" href="/kos_fitness/member/list.php">จัดการสมาชิก</a></li>
            <li><a class="hover:text-white" href="/kos_fitness/reports/dashboard_report.php">รายงาน</a></li>
            <li class="relative group">
              
              <div class="absolute hidden group-hover:block bg-[#09090b] border border-white/10 rounded-md mt-2">
                <a class="block px-4 py-2 hover:bg-white/5" href="/kos_fitness/reports/members_by_package.php">สมาชิกตามแพ็กเกจ</a>
                <a class="block px-4 py-2 hover:bg-white/5" href="/kos_fitness/reports/revenue_by_month.php">รายได้รายเดือน</a>
              </div>
            </li>
          <?php endif; ?>

        </ul>
      </nav>
      <div class="flex items-center gap-3">
        <?php if(!empty($_SESSION['user'])): ?>
          <span class="text-sm text-gray-300">สวัสดี, <?=htmlspecialchars($_SESSION['user']['full_name'])?></span>
          <a class="px-4 py-1.5 rounded-full bg-gray-700 hover:bg-gray-600" href="/kos_fitness/auth/logout.php">ออกจากระบบ</a>
        <?php else: ?>
          <a class="px-4 py-1.5 rounded-full border border-gray-600 hover:bg-gray-800" href="/kos_fitness/auth/login.php">เข้าสู่ระบบ</a>
          <a class="px-4 py-1.5 rounded-full bg-orange-500 hover:bg-orange-600" href="/kos_fitness/auth/register.php">สมัครสมาชิก</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>
<main class="pt-20 container mx-auto px-4 pb-12">
