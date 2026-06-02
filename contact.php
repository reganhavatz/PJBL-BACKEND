<?php
session_start();
include "../koneksi.php";

if (!isset($conn) && isset($koneksi)) {
  $conn = $koneksi;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.cdnfonts.com/css/ftf-indonesiana-serif-hijauwana" rel="stylesheet">
  <title>Contact Person - Culturenesia</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      overflow-y: auto;
    }

    header {
      background: #56463E;
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
      color: #fff;
      padding: 0 50px;
      width: 100%;
      height: 60px;
      position: fixed;
      top: 0;
      z-index: 100;
      font-family: 'Poppins', sans-serif;
      background-color: #56463E;
    }

    .logo {
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 15px;
      flex: 1;
      height: 100%;
    }

    .logo-navbar-baru {
      height: 65px;
      width: 65px;
      object-fit: contain;
      display: block;
    }

    header h1 {
      color: #fff;
      font-size: 26px;
      font-family: "FTF Indonesiana Serif";
      margin: 0;
      white-space: nowrap;
    }

    .navbar-menu-center {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 35px;
      flex: 1;
    }

    .navbar-menu-center a {
      color: #fff;
      text-decoration: none;
      font-family: 'Poppins', sans-serif;
      font-size: 15px;
      font-weight: 500;
      transition: 0.3s;
      position: relative;
      padding: 5px 0;
    }

    .navbar-menu-center a::before {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0%;
      height: 3px;
      background-color: #fff;
      transition: all .5s;
    }

    .navbar-menu-center a:hover::before {
      width: 100%;
    }

    .navbar-menu-right {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      flex: 1;
    }

    .navbar-menu-right .login-btn {
      color: #fff;
      text-decoration: none;
      font-family: 'Poppins', sans-serif;
      font-size: 15px;
      font-weight: 600;
      transition: 0.3s;
    }

    .account-menu {
      position: relative;
      display: inline-block;
      cursor: pointer;
      padding: 10px;
    }

    .account-menu svg {
      width: 26px !important;
      height: 26px !important;
      display: block;
      fill: currentColor;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      top: 100%;
      right: 0;
      background-color: #56463E;
      min-width: 150px;
      box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
      border-radius: 8px;
      padding: 10px 0;
      z-index: 999;
    }

    .dropdown-content a {
      color: #fff;
      padding: 10px 16px;
      text-decoration: none;
      display: block;
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
    }

    .dropdown-content a:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .account-menu:hover .dropdown-content {
      display: block;
    }

    header.scrolled {
      background: #56463E;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
      height: 60px;
    }

    header.scrolled h1,
    header.scrolled .navbar-menu-center a,
    header.scrolled .navbar-menu-right .login-btn,
    header.scrolled .account-menu svg {
      color: #fff;
      fill: #fff;
    }

    header.scrolled .navbar-menu-center a::before {
      background-color: #fff;
    }

    header.scrolled .logo-navbar-baru {
      height: 55px;
      width: 55px;
    }

    .profile-pic-round {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #fff;
      display: block;
    }

    .account-menu svg {
      width: 30px;
      height: 30px;
      display: block;
    }


    .main-content {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding-top: 130px;
      padding-bottom: 50px;
      padding-left: 20px;
      padding-right: 20px;
    }

    .contact-wrapper {
      display: flex;
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
      overflow: hidden;
      max-width: 820px;
      width: 100%;
      border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .gambar-landing {
      width: 45%;
      object-fit: cover;
      display: block;
    }

    .Container {
      padding: 30px 35px;
      width: 55%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #ffffff;
    }

    .Container h1 {
      font-size: 24px;
      color: #56463E;
      margin-bottom: 4px;
      font-weight: 700;
    }

    .Container p.sub-title {
      color: #7f8c8d;
      font-size: 13px;
      margin-bottom: 20px;
    }

    .Container input,
    .Container textarea {
      width: 100%;
      padding: 10px 14px;
      margin-bottom: 12px;
      border: 1px solid #dcdde1;
      border-radius: 8px;
      font-size: 13px;
      color: #2f3640;
      background-color: #f5f6fa;
      outline: none;
      transition: all 0.2s ease;
    }

    .Container input:focus,
    .Container textarea:focus {
      border-color: #56463E;
      background-color: #fff;
      box-shadow: 0 0 0 3px rgba(86, 70, 62, 0.12);
    }

    .button-group {
      display: flex;
      gap: 10px;
      margin-top: 4px;
    }

    .Container button {
      flex: 1;
      padding: 10px;
      border: none;
      border-radius: 8px;
      font-size: 13.5px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .btn-submit {
      background-color: #56463E;
      color: #fff;
    }

    .btn-submit:hover {
      background-color: #433630;
    }

    .btn-clear {
      background-color: #f1f2f6;
      color: #718093;
    }

    .btn-clear:hover {
      background-color: #e1e2e6;
      color: #2f3640;
    }

    footer {
      background-color: #56463E;
      padding: 60px 0;
      text-align: center;
      border-top: 1px solid #eee;
      width: 100%;
    }

    .footer-logo {
      margin-top: -30px;
      margin-bottom: 10px;
    }

    .footer-logo img {
      width: 75px;
      height: 75px;
    }

    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
    }

    .footer-nav {
      margin-bottom: 15px;
    }

    .nav-link {
      color: #fff;
      text-decoration: none;
      font-size: 14px;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      font-family: Arial, sans-serif;
      margin: 0 10px;
    }

    .nav-link:hover {
      color: #777777;
    }

    .nav-separator {
      color: #fff;
      font-size: 14px;
    }

    .footer-garis {
      border-bottom: 2px solid #fff;
      margin-bottom: 50px;
      padding-bottom: 20px;
      width: 80%;
      margin: 0 auto;
    }
  </style>
</head>

<body>

  <header>
    <div class="logo">
      <?php
      $query = "SELECT * FROM tb_konten WHERE id = 15";
      $sql = mysqli_query($conn, $query);

      if ($sql && $row = mysqli_fetch_array($sql)) {
        $nama_file_gambar = !empty($row['image']) ? $row['image'] : $row['gambar'];
        ?>
        <img src="../admin/upload/<?php echo $nama_file_gambar; ?>" alt="<?php echo $row['title']; ?>"
          class="logo-navbar-baru">
        <?php
      } else {
        echo '<img src="../admin/upload/google.png" alt="Fallback" class="logo-navbar-baru">';
      }
      ?>
      <h1>Culturenesia</h1>
    </div>

    <div class="navbar-menu-center">
      <a href="LandingPage.php">Home</a>
      <a href="aboutus.php">About Us</a>
      <a href="contact.php">Contact</a>
    </div>

    <div class="navbar-menu-right">
    <?php
    if (isset($_SESSION['login'])) {
        ?>
        <div class="account-menu">
            <a href="profile.php" title="Profil Saya">
                <?php 
                if (!empty($_SESSION['foto'])): 
                    if (strpos($_SESSION['foto'], 'http') === 0): ?>
                        <img src="<?php echo $_SESSION['foto']; ?>" class="profile-pic-round">
                    <?php else: ?>
                        <img src="../admin/upload/<?php echo $_SESSION['foto']; ?>" class="profile-pic-round">
                    <?php endif; ?>
                <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                        <path d="M0 0h16v16H0z" fill="none" />
                        <path fill="currentColor"
                            d="M6 5a2 2 0 1 1 4 0a2 2 0 0 1-4 0m-.5 3h5A1.5 1.5 0 0 1 12 9.5c0 1.116-.459 2.01-1.212 2.615C10.047 12.71 9.053 13 8 13s-2.047-.29-2.788-.885C4.46 11.51 4 10.616 4 9.5A1.5 1.5 0 0 1 5.5 8M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M1 8a7 7 0 1 1 14 0A7 7 0 0 1 1 8" />
                    </svg>
                <?php endif; ?>
            </a>
            <div class="dropdown-content">
                <a href="profile.php">Edit Profil</a>
                <a href="riwayat.php">Riwayat Laporan</a>
                <a href="../Logout.php">Logout</a>
            </div>
        </div>
        <?php
    } else {
        ?>
        <a href="../Login.php" class="login-btn">Login</a>
        <?php
    }
    ?>
</div>
  </header>


  <div class="main-content">
    <div class="contact-wrapper">

      <?php
      $query = "SELECT * FROM tb_konten WHERE id = 14";
      $sql = mysqli_query($conn, $query);

      if ($sql && $row = mysqli_fetch_array($sql)) {
        $nama_file_gambar = !empty($row['image']) ? $row['image'] : $row['gambar'];
        ?>
        <img src="../admin/upload/<?php echo $nama_file_gambar; ?>" alt="<?php echo $row['title']; ?>"
          class="gambar-landing">
        <?php
      } else {
        echo '<img src="../admin/upload/google.png" alt="Fallback" class="gambar-landing">';
      }
      ?>


      <form action="proses_lapor.php" method="POST" class="Container">
        <h1>Contact Person</h1>

        <input type="text" name="username" value="<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>"
          readonly>
        <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" readonly>
        <textarea name="isi" placeholder="Tuliskan pesan Anda..." rows="4" required></textarea>

        <div class="button-group">
          <button type="submit" name="submit" class="btn-submit">Submit</button>
          <button type="reset" class="btn-clear">Clear</button>
        </div>
      </form>

    </div>
  </div>


  <footer>
    <div class="footer-content">
      <div class="footer-logo">
        <?php
        $query = "SELECT * FROM tb_konten WHERE id = 15";
        $sql = mysqli_query($conn, $query);

        if ($sql && $row = mysqli_fetch_array($sql)) {
          $nama_file_gambar = !empty($row['image']) ? $row['image'] : $row['gambar'];
          ?>
          <img src="../admin/upload/<?php echo $nama_file_gambar; ?>" alt="<?php echo $row['title']; ?>">
          <?php
        } else {
          echo '<img src="../admin/upload/google.png" alt="Fallback">';
        }
        ?>
      </div>
      <nav class="footer-nav">
        <a href="#" class="nav-link">ABOUT US</a>
        <span class="nav-separator">|</span>
        <a href="#" class="nav-link">HOME</a>
        <span class="nav-separator">|</span>
        <a href="#" class="nav-link">CONTACTS</a>
      </nav>
      <div class="footer-garis"></div>
    </div>
  </footer>

</body>
<script>
  const headerEl = document.querySelector('header');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      headerEl.classList.add('scrolled');
    } else {
      headerEl.classList.remove('scrolled');
    }
  });
</script>

</html>