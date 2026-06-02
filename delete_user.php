<?php
include "../koneksi.php";

$id = $_GET['id'];

$query_pengguna = mysqli_query($conn, "SELECT username FROM tb_akun WHERE id='$id'");
$data_user = mysqli_fetch_array($query_pengguna);
$nama_user = $data_user['username'];

$query_hapus = "DELETE FROM tb_akun WHERE id='$id'";
$hasil = mysqli_query($conn, $query_hapus);

if ($hasil) {
    ?>
    <script language="javascript">
        alert("Akun <?php echo $nama_user; ?> berhasil dihapus!");
        document.location.href = "pengguna.php"; 
    </script>
    <?php
} else {
    echo "Gagal hapus data akun: " . mysqli_error($conn);
}
?>