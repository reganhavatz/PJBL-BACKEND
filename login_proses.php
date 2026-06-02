<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    

    $stmt = $conn->prepare("SELECT * FROM tb_akun WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if ($data) {
        if (password_verify($password, $data['password'])) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['level'] = $data['level'];
            $_SESSION['email']    = $data['email'];
           $_SESSION['foto'] = $data['image'];
        
            if($data['level'] == "admin") {
                header("location: admin/dashboard.php");
            } else if ($data['level'] == "user") {
                header("location: user/LandingPage.php");
            }
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.location='Login.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location='Login.php';</script>";
    }
}
?>