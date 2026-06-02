<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_pjbl";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi Gagal: " .$conn->connect_error);
}
?>