<?php
include "../koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query_hapus = "DELETE FROM tb_laporan WHERE id='$id'";
    $hasil = mysqli_query($conn, $query_hapus);

    if ($hasil) {
        echo "<script>
                alert('Laporan berhasil dihapus!');
                document.location.href = 'list_berita.php';
              </script>";
    } else {
        echo "Gagal hapus data: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak ditemukan.";
}
?>