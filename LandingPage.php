<?php
session_start();
include "../koneksi.php";

if (!isset($conn) && isset($koneksi)) {
  $conn = $koneksi;
}

if (!isset($_SESSION['has_visited'])) {
  $conn->query("UPDATE tb_views SET views = views + 1 WHERE id = 1");
  $_SESSION['has_visited'] = true;
}

$query_hero = "SELECT * FROM tb_konten WHERE id = 9";
$sql_hero = mysqli_query($conn, $query_hero);

$background_url = "";
if ($sql_hero && $row_hero = mysqli_fetch_array($sql_hero)) {
  $nama_file_hero = !empty($row_hero['image']) ? $row_hero['image'] : $row_hero['gambar'];
  if (!empty($nama_file_hero)) {
    $background_url = "../admin/upload/" . $nama_file_hero;
  }
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <link href="https://fonts.cdnfonts.com/css/ftf-indonesiana-serif-hijauwana" rel="stylesheet">

  <title>Landing Page - Culturenesia</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      line-height: 1.16;
      color: #333;
      zoom: 0.95;
    }


    header {
      background: transparent;
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
      transition: background 0.4s ease, box-shadow 0.4s ease, height 0.4s ease;
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

    .hero {
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      color: #fff;
      padding: 50px 50px;
      align-items: flex-start;
      padding-left: 83px;
      position: relative;
    }

    .hero.dynamic-bg {
      background-position: center;
      background-size: cover;
      background-repeat: no-repeat;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
      z-index: 1;
    }

    .hero-text {
      position: absolute;
      font-family: "FTF Indonesiana Serif";
      margin-top: 100px;
      z-index: 2;
    }

    .hero h1 {
      font-weight: bold;
      max-width: 500px;
      font-size: 36px;
      margin-bottom: 2px;
      text-align: left;
      left: 120px;
      margin-top: 32%;
    }

    .description {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 50px 80px;
      background-color: #f5f5f5;
    }

    .container {
      display: flex;
      align-items: center;
      gap: 90px;
      max-width: 1100px;
      flex-direction: row-reverse;
    }

    .description2 {
      flex-direction: row;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 60px 80px;
      background-color: #EBEBEB;
    }

    .description2 .container {
      flex-direction: row;
      display: flex;
      align-items: center;
      gap: 90px;
      max-width: 1000px;
    }

    .gambar-landing {
      object-fit: cover;
      width: 265px;
      height: 379px;
      border-radius: 20px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
    }

    .description .text,
    .description2 .text {
      text-align: justify;
      max-width: 500px;
      font-family: Poppins;
    }

    .description h1,
    .description2 h1 {
      text-align: justify;
      font-size: 28px;
      margin-bottom: 15px;
      color: #000;
      font-family: Poppins;
    }

    .description p,
    .description2 p {
      color: #000;
      text-align: justify;
      line-height: 1.6;
      margin-bottom: 20px;
      font-family: Poppins;
    }

    .description button,
    .description2 button {
      background: #56463E;
      color: #fff;
      border: none;
      padding: 10px 16px;
      border-radius: 6px;
      font-family: Poppins;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
      cursor: pointer;
    }

    .description a,
    .description2 a {
      color: #f5f5f5;
      text-decoration: none;
    }

    .description button:hover,
    .description2 button:hover {
      background-color: #f5f5f5;
      color: #56463E;
    }

    .description button:hover a,
    .description2 button:hover a {
      color: #56463E;
    }

    .info-cards {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 50px;
      padding: 40px 20px;
      background-color: #fff;
    }

    .card {
      background: transparent;
      width: 265px;
      height: 370px;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .card img {
      width: 100%;
      height: 400px;
      object-fit: cover;
    }

    .card-text {
      position: absolute;
      bottom: 20px;
      left: 20px;
      right: 20px;
      color: white;
      z-index: 2;
    }

    .card-text h3,
    .card-text p,
    .card-text a {
      color: #fff;
    }

    .card-text h3 {
      font-weight: 600;
    }

    .card-text p {
      font-size: 14px;
      margin-bottom: 15px;
    }

    .card-text button {
      background-color: #56463E;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 5px;
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-text a {
      background-color: #56463E;
      text-decoration: none;
    }

    footer {
      background-color: #56463E;
      padding: 80px 0;
      text-align: center;
      border-top: 1px solid #eee;
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

  <section class="hero dynamic-bg" style="background-image: url('<?php echo $background_url; ?>');">
    <div class="overlay"></div>
  </section>

  <section class="description">
    <div class="container">
      <?php
      $query = "SELECT * FROM tb_konten WHERE id = 10";
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

      <div class="text">
        <h1><?php echo isset($row['title']) ? $row['title'] : 'Konten tidak ditemukan.'; ?></h1>
        <p><?php echo isset($row['content']) ? $row['content'] : 'Konten tidak ditemukan.'; ?></p>
        <button><a href="cardbajuadat.php">Selengkapnya</a></button>
      </div>
    </div>
  </section>

  <section class="description2">
    <div class="container">
      <?php
      $query = "SELECT * FROM tb_konten WHERE id = 8";
      $sql = mysqli_query($conn, $query);

      if ($sql && $row = mysqli_fetch_array($sql)) {
        $nama_file_gambar = !empty($row['image']) ? $row['image'] : $row['gambar'];
        ?>
        <img src="../admin/upload/<?php echo $nama_file_gambar; ?>" alt="<?php echo $row['title']; ?>"
          class="gambar-landing">
        <div class="text">
          <h1><?php echo isset($row['title']) ? $row['title'] : 'Konten tidak ditemukan.'; ?></h1>
          <p><?php echo $row['content']; ?></p>
          <button><a href="cardrumahadat.php">Selengkapnya</a></button>
        </div>
        <?php
      } else {
        ?>
        <img src="../admin/upload/google.png" alt="Fallback" class="gambar-landing">
        <div class="text">
          <h1><?php echo isset($row['title']) ? $row['title'] : 'Konten tidak ditemukan.'; ?></h1>
          <p>tidak ada</p>
          <button><a href="cardrumahadat.php">Selengkapnya</a></button>
        </div>
        <?php
      }
      ?>
    </div>
  </section>

  <section class="description">
    <div class="container">
      <?php
      $query = "SELECT * FROM tb_konten WHERE id = 11";
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
      <div class="text">
        <h1><?php echo isset($row['title']) ? $row['title'] : 'Konten tidak ditemukan.'; ?></h1>
        <p><?php echo isset($row['content']) ? $row['content'] : 'Konten tidak ditemukan.'; ?></p>
        <button><a href="Cardalatmusik.php">Selengkapnya</a></button>
      </div>
    </div>
  </section>

  <section class="info-cards">
    <div class="card">
      <?php
      $query = "SELECT * FROM tb_konten WHERE id = 18";
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
      <div class="card-text">
        <h3><?php echo isset($row['title']) ? $row['title'] : 'Konten tidak ditemukan.'; ?></h3>
        <p><?php echo isset($row['content']) ? $row['content'] : 'Konten tidak ditemukan.'; ?></p>
        <button><a href="cardrumahadat.php">Selengkapnya</a></button>
      </div>
    </div>

    <div class="card">
      <?php
      $query = "SELECT * FROM tb_konten WHERE id = 19";
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
      <div class="card-text">
        <h3><?php echo isset($row['title']) ? $row['title'] : 'Konten tidak ditemukan.'; ?></h3>
        <p><?php echo isset($row['content']) ? $row['content'] : 'Konten tidak ditemukan.'; ?></p>
        <button><a href="cardalatmusik.php">Selengkapnya</a></button>
      </div>
    </div>

    <div class="card">
      <?php
      $query = "SELECT * FROM tb_konten WHERE id = 20";
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
      <div class="card-text">
        <h3><?php echo isset($row['title']) ? $row['title'] : 'Konten tidak ditemukan.'; ?></h3>
        <p><?php echo isset($row['content']) ? $row['content'] : 'Konten tidak ditemukan.'; ?></p>
        <button><a href="cardbajuadat.php">Selengkapnya</a></button>
      </div>
    </div>
  </section>

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
</body>

</html>