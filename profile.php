<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['username'])) {
  header("Location: ../Login.php");
  exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Edit Profil - Culturenesia</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #F0F4EF;
      display: flex;
      justify-content: center;
      padding: 20px;
    }

    .profile-card {
      background: white;
      width: 100%;
      max-width: 400px;
      padding: 20px;
      border-radius: 20px;
    }

    h2 {
      text-align: center;
      font-size: 1.5rem;
      margin-bottom: 25px;
    }

    .profile-img-container {
      position: relative;
      width: 120px;
      margin: 0 auto 25px auto;
    }

    .profile-img-container img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
    }

    label {
      font-weight: 600;
      display: block;
      margin-bottom: 8px;
      font-size: 0.95rem;
    }

    input[type="text"],
    input[type="file"] {
      width: 100%;
      padding: 15px;
      margin-bottom: 20px;
      border: none;
      background-color: #f5f5f5;
      border-radius: 12px;
      box-sizing: border-box;
      font-size: 1rem;
    }

    .simpan {
      width: 100%;
      background: #56463E;
      color: white;
      padding: 15px;
      border: none;
      border-radius: 12px;
      font-weight: bold;
      cursor: pointer;
    }

    .kembali {
  position: absolute;
  top: 20px;
  left: 20px;
}

.btn-back {
  display: inline-block;
  background-color: #56463E;
  color: white;
  padding: 10px 25px;
  text-decoration: none;
  border-radius: 12px;
  font-weight: bold;
  transition: 0.3s;
}

.btn-back:hover {
  background-color: #3e2f27; 
}
  </style>
</head>

<body>

  <div class="kembali">
  <a href="LandingPage.php" class="btn-back">Back</a>
</div>

  <div class="profile-card">
    <h2>Edit Profile</h2>
    <form action="update_profile.php" method="POST" enctype="multipart/form-data">

      <div class="profile-img-container">
        <img src="../admin/upload/<?php echo $_SESSION['foto']; ?>" alt="Profile">
      </div>

      <label>Ganti Foto Profil</label>
      <input type="file" name="foto_baru" accept="image/*">

      <label>Username</label>
      <input type="text" name="username_baru" value="<?php echo htmlspecialchars($username); ?>" required>

      <button type="submit" class="simpan">Simpan</button>
    </form>
  </div>

</body>

</html>