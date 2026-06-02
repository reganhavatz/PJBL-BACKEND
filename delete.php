<?php
include "../koneksi.php";

$id = $_GET['id'];

$query_gambar = mysqli_query($conn, "SELECT image FROM tb_konten WHERE id='$id'");
$data_berita = mysqli_fetch_array($query_gambar);
$nama_gambar = $data_berita['image'];

$query_hapus = "DELETE FROM tb_konten WHERE id='$id'";
$hasil = mysqli_query($conn, $query_hapus);

if ($hasil) {
    $jalur_gambar = "pages/upload/" . $nama_gambar;
    if (file_exists($jalur_gambar) && !empty($nama_gambar)) {
        unlink($jalur_gambar);
    }
    ?>
    <script language="javascript">
        alert("Berita berhasil dihapus!");
        document.location.href = "list_berita.php?page=berita";
    </script>
    <?php
} else {
    echo "Gagal hapus data berita: " . mysqli_error($conn);
}
?>


