<?php
include "../koneksi.php";

$title = $_POST['title'];
$content = $_POST['content'];

$kategori_pilih = $_POST['kategori'];
$kategori_ketik = $_POST['kategori_baru'];

$kategori = !empty($kategori_ketik) ? $kategori_ketik : $kategori_pilih;

$image = $_FILES['image']['name'];
$image_baru = time() . '_' . basename($image);
$tmp = $_FILES['image']['tmp_name'];
$target = "upload/" . $image_baru;

if (!is_dir("upload")) {
    mkdir("upload", 0777, true);
}

$ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];

if (!in_array($ext, $allowed)) {
    die("Format gambar tidak valid!");
}

if (move_uploaded_file($tmp, $target)) {
    $sql = "INSERT INTO tb_konten (title, kategori, content, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $title, $kategori, $content, $image_baru);

    if ($stmt->execute()) {
        header("Location: list_berita.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Gagal upload gambar!";
}
?>