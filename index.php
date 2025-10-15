<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="th" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KOS Fitness</title>
  <link rel="stylesheet" href="/kos_fitness/assets/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body class="landing-page">

  <header class="site-header">
    <div class="container header-container">
      <a href="/kos_fitness/index.php" class="logo">KOS <span class="logo-accent">FITNESS</span></a>
      <nav class="main-nav">
        <ul>
          <li><a href="#hero">หน้าแรก</a></li>
          <li><a href="#features">ทำไมต้องเรา</a></li>
          <li><a href="#clubs">คลับ</a></li>
          <li><a href="#pricing">สมาชิก</a></li>
        </ul>
      </nav>
      <div class="header-actions">
        <a href="/kos_fitness/auth/login.php" class="btn btn-outline">เข้าสู่ระบบ</a>
        <a href="/kos_fitness/auth/register.php" class="btn btn-primary">สมัครสมาชิก</a>
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
        <li><a href="#hero">หน้าแรก</a></li>
        <li><a href="#features">ทำไมต้องเรา</a></li>
        <li><a href="#clubs">คลับ</a></li>
        <li><a href="#pricing">สมาชิก</a></li>
      </ul>
      <div class="mobile-nav-actions">
        <a href="/kos_fitness/auth/login.php" class="btn btn-outline btn-full">เข้าสู่ระบบ</a>
        <a href="/kos_fitness/auth/register.php" class="btn btn-primary btn-full">สมัครสมาชิก</a>
      </div>
    </div>
  </header>

  <main>
    <section id="hero" class="hero">
      <div class="hero-bg"></div>
      <div class="hero-overlay"></div>
      <div class="hero-content">
        <h1 class="hero-title">MEMBERSHIP ที่ใช่สำหรับคุณ</h1>
        <p class="hero-subtitle">เริ่มต้นเส้นทางสู่สุขภาพที่ดีกว่ากับ KOS Fitness วันนี้!</p>
        <div class="hero-action">
          <a href="/kos_fitness/auth/register.php" class="btn btn-primary btn-lg">สมัครสมาชิก</a>
        </div>
      </div>
    </section>

    <section id="features" class="features-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">ทำไมต้อง KOS Fitness?</h2>
          <p class="section-subtitle">เรามอบประสบการณ์ฟิตเนสที่เหนือกว่า ให้คุณบรรลุเป้าหมายได้อย่างไร้ขีดจำกัด</p>
        </div>
        <div class="features-grid">
            <div class="feature-card"><i class="fa-regular fa-clock"></i><h3>เปิด 24 ชั่วโมง</h3><p>ออกกำลังกายได้ทุกเวลาที่คุณต้องการ</p></div>
            <div class="feature-card"><i class="fa-regular fa-file-excel"></i><h3>ไม่มีสัญญาผูกมัด</h3><p>อิสระในการเป็นสมาชิกโดยไม่มีสัญญาผูกมัด</p></div>
            <div class="feature-card"><i class="fa-regular fa-thumbs-up"></i><h3>สังคมที่ดี</h3><p>เข้าร่วมฟิตเนสพร้อมเพื่อนๆเพื่อความสนุก</p></div>
            <div class="feature-card"><i class="fa-solid fa-dumbbell"></i><h3>อุปกรณ์ที่ทันสมัย</h3><p>เรามีอุปกรณ์ออกกำลังกายที่ทันสมัยและครบครัน</p></div>
        </div>
      </div>
    </section>

    <section id="clubs" class="clubs-section">
        <div class="container clubs-container">
            <div class="club-info">
                <h2 class="section-title">สาขา คลองหก (RMUTT)</h2>
                <p>ที่ตั้ง: มหาวิทยาลัยเทคโนโลยีราชมงคลธัญบุรี (คลองหก)<br>ฟิตเนสขนาดใหญ่ อุปกรณ์ครบ เปิดบริการ 24 ชั่วโมง มีที่จอดรถสะดวก และเทรนเนอร์มืออาชีพคอยให้คำแนะนำ</p>
                <ul class="checklist">
                    <li>เปิดบริการ 24 ชม.</li>
                    <li>ที่จอดรถสะดวก</li>
                    <li>อุปกรณ์ครบทุกชนิด</li>
                    <li>เทรนเนอร์มืออาชีพ</li>
                </ul>
            </div>
            <div class="club-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3872.934033379893!2d100.72511281532585!3d14.02293309250917!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311d7f5a971a0701%3A0x3f5c1d9326071e2e!2sRajamangala%20University%20of%20Technology%20Thanyaburi!5e0!3m2!1sen!2sth!4v1678886400000!5m2!1sen!2sth" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <section id="pricing" class="pricing-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">เลือก Membership ที่เหมาะกับคุณ</h2>
                <p class="section-subtitle">เรามีแพ็กเกจที่ยืดหยุ่น ตอบโจทย์ทุกไลฟ์สไตล์และเป้าหมายการออกกำลังกายของคุณ</p>
            </div>
            <div class="pricing-grid">
                <div class="pricing-card">
                    <h3>Standard Access</h3>
                    <p class="price">1,600 <span>บาท/เดือน</span></p>
                    <ul class="checklist">
                        <li>เข้าใช้บริการได้ 24 ชั่วโมง</li>
                        <li>ไม่มีสัญญาผูกมัด</li>
                        <li>เข้าใช้บริการได้ทุกสาขาทั่วประเทศ</li>
                    </ul>
                    <a href="/kos_fitness/packages/select_package.php?plan=standard" class="btn btn-secondary btn-full">สมัครเลย</a>
                </div>
                <div class="pricing-card recommended">
                    <span class="badge">คุ้มที่สุด</span>
                    <h3>Premium Access</h3>
                    <p class="price recommended-price">2,400 <span>บาท/เดือน</span></p>
                    <p class="price-strikethrough">จากปกติ 2,800 บาท</p>
                    <ul class="checklist">
                        <li><strong>สิทธิประโยชน์ทั้งหมดของ Standard</strong></li>
                        <li>เครื่องดื่มโปรตีน 2 แก้ว/เดือน</li>
                        <li>สิทธิ์พาเพื่อนมาฟรี 2 ครั้ง/เดือน</li>
                    </ul>
                    <a href="/kos_fitness/packages/select_package.php?plan=premium" class="btn btn-primary btn-full">สมัครแบบ Premium</a>
                </div>
            </div>
        </div>
    </section>
  </main>
  
  <?php include 'shared/footer.php'; ?>
</body>
</html>