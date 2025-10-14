<?php require_once "../includes/conn.php"; ?>
<?php include "../shared/header.php"; ?>
<h1 class="text-3xl font-bold mb-6">เข้าสู่ระบบ</h1>
<form class="max-w-md space-y-4" method="post" action="login_process.php">
  <input class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" type="email" name="email" placeholder="อีเมล" required>
  <input class="w-full px-4 py-2 rounded bg-[#0b0b0c] border border-white/10" type="password" name="password" placeholder="รหัสผ่าน" required>
  <button class="px-6 py-2 rounded bg-orange-500 hover:bg-orange-600">เข้าสู่ระบบ</button>
</form>
<p class="mt-4 text-gray-300">ยังไม่มีบัญชี? <a class="text-orange-400 underline" href="register.php">สมัครสมาชิก</a></p>
<?php include "../shared/footer.php"; ?>
