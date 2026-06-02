<?php
include "../koneksi.php";

$username = $_POST['username'];
$email = $_POST['email'];
$isi = $_POST['isi'];
$status = "pending"; 

$sql = "INSERT INTO tb_laporan (username, email, isi, status) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $email, $isi, $status);

if ($stmt->execute()) {
    echo "<script>alert('Pesan berhasil terkirim!'); window.location='contact.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}
?>