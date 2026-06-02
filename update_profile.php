<?php
session_start();
include "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username_lama = $_SESSION['username'];
    $username_baru = mysqli_real_escape_string($conn, $_POST['username_baru']);
    
    $query = "UPDATE tb_akun SET username = '$username_baru' WHERE username = '$username_lama'";
    mysqli_query($conn, $query);
    $_SESSION['username'] = $username_baru;

if (isset($_FILES['foto_baru']) && $_FILES['foto_baru']['error'] === 0) {
    $file = $_FILES['foto_baru']['name'];
    $tmp_name = $_FILES['foto_baru']['tmp_name'];
    $folder = "../admin/upload/" . $file;

    if (move_uploaded_file($tmp_name, $folder)) {
        $query_image = "UPDATE tb_akun SET image = '$file' WHERE username = '$username_lama'";
        mysqli_query($conn, $query_image);
        $_SESSION['foto'] = $file; 
    } else {
        echo "Gagal mengupload file. Pastikan folder tujuan ada dan memiliki izin tulis.";
    }
}

    echo "<script>alert('Profil berhasil diperbarui!'); window.location='profile.php';</script>";
}
?>