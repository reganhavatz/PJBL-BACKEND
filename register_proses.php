<?php
include "koneksi.php";

$username = $_POST['username'];
$email    = $_POST['email'];
$password = $_POST['password'];

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO tb_akun (username, email, password, level) 
          VALUES ('$username', '$email', '$password_hash', 'user')";

$simpan = mysqli_query($conn, $query);

if ($simpan) {
    echo "<script>alert('Berhasil Daftar!'); window.location='Login.php';</script>";
} else {
    echo "Gagal Daftar: " . mysqli_error($conn);
}
?>