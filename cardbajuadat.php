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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/ftf-indonesiana-serif-hijauwana" rel="stylesheet">
    <title>Baju Adat - Culturenesia</title>
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background-color: #fcfaf8;
        color: #333;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
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
    }.logo-navbar-baru {
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


    .banner-full {
        width: 1010px;
        height: 400px;
        margin-top: 120px;
        position: relative;
        overflow: hidden;
        align-self: center;
        border-radius: 10px;
    }

    .banner-full .gambar-landing {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .banner-full::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.25);
    }

    .penjelasan {
        display: flex;
        text-align: justify;
        font-size: 14px;
        max-width: 1010px;
        margin-left: 130px;
        margin-top: 40px;
    }

    .container-utama {
        max-width: 1200px;
        margin: 0 auto;
        padding: 50px 20px;
        margin-left: 100px;
    }

    .grid-cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        width: 100%;
        margin-top: 20px;
    }

    .card {
        background: #ffffff;
        width: 100%;
        height: 400px;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
    }

    .card .gambar-box {
        width: 100%;
        height: 210px;
        overflow: hidden;
        background-color: #f0f0f0;
    }

    .card .gambar-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .card .info-box {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex: 1;
        height: 80px;
    }

    .card .info-box h3 {
        font-size: 20px;
        color: #000000;
        margin-bottom: 10px;
        margin-top: -20px;
    }

    .card .info-box p {
        font-size: 13px;
        color: #444444;
        line-height: 1.6;
        margin-bottom: 15px;
        text-align: justify;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card .btn-selengkapnya {
        margin-top: auto;
        background-color: #56463E;
        color: #ffffff;
        padding: 8px 16px;
        font-size: 13px;
        border-radius: 6px;
        text-decoration: none;
        width: fit-content;
    }

    footer {
        background-color: #56463E;
        padding: 40px 0;
        text-align: center;
        width: 100%;
        margin-top: auto;
    }

    .footer-logo {
        margin-bottom: 15px;
    }

    .footer-logo img {
        width: 65px;
        height: 65px;
        object-fit: contain;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer-nav {
        margin-bottom: 20px;
    }

    .nav-link {
        color: #fff;
        text-decoration: none;
        font-size: 13px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin: 0 10px;
    }

    .nav-link:hover {
        color: #ccc;
    }

    .nav-separator {
        color: #fff;
        font-size: 13px;
    }

    .footer-garis {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
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

    <div class="banner-full">
        <?php
        $sql_banner = mysqli_query($conn, "SELECT * FROM tb_konten WHERE id = 27");
        $row_banner = mysqli_fetch_array($sql_banner);

        if ($row_banner) {
            $gambar_banner = $row_banner['image'];
            ?>
            <img src="../admin/upload/<?php echo $gambar_banner; ?>" alt="Banner" class="gambar-landing">
        <?php } else { ?>
            <img src="../admin/upload/google.png" alt="Fallback" class="gambar-landing">
        <?php } ?>
    </div>

    <div class="penjelasan">
        <?php
        $query_bg = mysqli_query($conn, "SELECT * FROM tb_konten WHERE id = 26");
        $row_bg = mysqli_fetch_array($query_bg);

        if ($row_bg) {
            echo "<p>" . str_replace('###', '', $row_bg['content']) . "</p>";
        } else {
            echo "<p>Konten tidak ditemukan.</p>";
        }
        ?>
    </div>

    <div class="container-utama">
        <div class="grid-cards">
            <?php
            $query = "SELECT * FROM tb_konten WHERE kategori = 'Baju Adat'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="card">
                        <div class="gambar-box">
                            <img src="../admin/upload/<?php echo $row['image']; ?>" alt="<?php echo $row['judul']; ?>">
                        </div>
                        <div class="info-box">
                            <h3><?php echo str_replace('###', '', $row['title']); ?></h3>
                            <p><?php echo substr(str_replace('###', '', $row['content']), 0, 100); ?>...</p>
                            <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn-selengkapnya">Selengkapnya</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Belum ada data alat musik tradisional.</p>";
            }
            ?>
        </div>
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