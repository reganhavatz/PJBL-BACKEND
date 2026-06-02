<?php
include "../koneksi.php";

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$kategori = !empty($_POST['kategori_baru']) ? $_POST['kategori_baru'] : $_POST['kategori'];

if (!empty($_FILES['image']['name'])) {
    $img = time() . '_' . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "upload/" . $img);
    
    $sql = $conn->prepare("UPDATE tb_konten SET title=?, kategori=?, content=?, image=? WHERE id=?");
    $sql->bind_param("ssssi", $title, $kategori, $content, $img, $id);
} else {
    $sql = $conn->prepare("UPDATE tb_konten SET title=?, kategori=?, content=? WHERE id=?");
    $sql->bind_param("sssi", $title, $kategori, $content, $id);
}

if ($sql->execute()) {
    header("Location: list_berita.php");
} else {
    echo "Error: " . $sql->error;
}
?>