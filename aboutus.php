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
  <title>About Us - Culturenesia</title>
</head>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  body {
    background-color: #f9f9f9;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    color: #333;
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



  .about-container {
    flex: 1;
    max-width: 900px;
    margin: 130px auto 60px auto;
    padding: 0 20px;
  }

  .banner-wrapper {
    width: 100%;
    height: 300px;
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    margin-bottom: 40px;
  }

  .gambar-landing {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .about-section {
    background: #ffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    margin-bottom: 30px;
  }

  .about-section h2 {
    color: #56463E;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 15px;
    position: relative;
    padding-left: 12px;
  }

  .about-section h2::before {
    content: '';
    position: absolute;
    left: 0;
    top: 4px;
    bottom: 4px;
    width: 4px;
    background-color: #56463E;
    border-radius: 2px;
  }

  .about-section p {
    font-size: 14.5px;
    color: #555;
    line-height: 1.7;
    text-align: justify;
    margin-bottom: 15px;
  }

  .about-section .visi-text {
    font-size: 16px;
    font-style: italic;
    color: #433630;
    background-color: #fcfaf8;
    padding: 15px 20px;
    border-left: 3px solid #56463E;
    border-radius: 4px;
    margin: 10px 0;
  }

  .misi-list {
    list-style: none;
    margin-top: 10px;
  }

  .misi-list li {
    font-size: 14.5px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 15px;
    padding-left: 25px;
    position: relative;
  }

  .misi-list li::before {
    content: '✓';
    position: absolute;
    left: 0;
    top: 0;
    color: #56463E;
    font-weight: bold;
    font-size: 14px;
  }

  .misi-list li strong {
    color: #333;
    font-weight: 600;
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

  <div class="about-container">

    <div class="banner-wrapper">
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
    </div>

    <div class="about-section">
      <h2>Latar Belakang Berdirinya Culturenesia</h2>
      <p>
        Culturenesia lahir dari sebuah keresahan sederhana di tengah era digital yang bergerak begitu cepat. Di masa
        sekarang, informasi apa pun bisa diakses dalam hitungan detik, namun sayangnya, informasi mengenai kekayaan
        budaya asli Indonesia mulai dari detail baju adat, detail rumah adat, detail alat musik tradisional sering kali
        tersebar secara terpisah, sulit dicari, atau dikemas dengan tampilan yang kurang menarik bagi generasi muda.
      </p>
      <p>
        Melihat fenomena tersebut, kami berinisiatif untuk mendirikan Culturenesia. Platform ini dirancang bukan hanya
        sebagai sebuah ensiklopedia digital biasa, melainkan sebagai "jembatan visual" yang menghubungkan generasi masa
        kini dengan akar budaya Nusantara.
      </p>
      <p>
        Dengan memanfaatkan teknologi web modern, kami mengumpulkan, merapikan, dan menyajikan kembali kekayaan budaya
        Indonesia dalam kemasan yang interaktif, bersih, dan mudah dipahami oleh siapa saja, kapan saja, dan di mana
        saja. Karena kami percaya, untuk bisa mencintai budaya sendiri, kita harus mengenalnya terlebih dahulu.
      </p>
    </div>

    <div class="about-section">
      <h2>Visi</h2>
      <p class="visi-text">
        "Menjadi platform digital yang interaktif informatif dan mempermudah masyarakat dan generasi muda untuk belajar
        dan mewariskan budaya indonesia"
      </p>

      <h2 style="margin-top: 30px;">Misi</h2>
      <ul class="misi-list">
        <li><strong>Mengumpulkan dan Merapikan Data Budaya:</strong> Menyediakan informasi seputar baju adat, rumah
          adat, hingga alat musik tradisional dari berbagai daerah di Indonesia secara lengkap dan terpusat di satu
          website.</li>
        <li><strong>Mengemas Konten dengan Visual yang Menarik:</strong> Menyajikan edukasi budaya lewat tampilan web
          yang bersih, modern, dan interaktif supaya seru dibaca.</li>
        <li><strong>Menjadi Media Pendukung Pembelajaran:</strong> Membantu mempermudah siswa, maupun masyarakat umum
          dalam mencari informasi tentang kekayaan Nusantara.</li>
        <li><strong>Menumbuhkan Rasa Bangga:</strong> Mengenalkan keunikan budaya lokal agar generasi masa kini merasa
          bangga dan ikut menjaga identitas asli bangsa Indonesia.</li>
      </ul>
    </div>

    <div class="about-section">
      <h2>Tujuan</h2>
      <p>
        Tujuan Culturenesia adalah memperkenalkan dan melestarikan kekayaan budaya Indonesia melalui penyajian informasi
        yang akurat, menarik, dan mudah dipahami. Kami ingin menjadi ruang edukasi yang membantu masyarakat mengenal
        tradisi, seni, kuliner, sejarah, dan berbagai keunikan Nusantara, sekaligus menumbuhkan rasa bangga terhadap
        identitas budaya bangsa.
      </p>
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

</html>