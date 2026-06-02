<?php
require 'vendor/autoload.php';

use Kreait\Firebase\Factory;

$serviceAccountPath = __DIR__ . '/serviceAccountKey.json';

if (!file_exists($serviceAccountPath)) {
    die("Error: File serviceAccountKey.json tidak ditemukan di " . $serviceAccountPath);
}

try {
    $factory = (new Factory)->withServiceAccount($serviceAccountPath);
    $auth = $factory->createAuth();

    if (isset($_GET['token'])) {
        $idToken = $_GET['token'];
        $verifiedIdToken = $auth->verifyIdToken($idToken);
        $email = $verifiedIdToken->claims()->get('email');

        $nama = $verifiedIdToken->claims()->get('name'); 
        $foto = $verifiedIdToken->claims()->get('picture');

        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $nama; 
        $_SESSION['foto'] = $foto;     
        $_SESSION['login'] = true;

        header("Location: user/LandingPage.php");
        exit();
    }
} catch (Exception $e) {
    echo "Verifikasi gagal: " . $e->getMessage();
}
?>