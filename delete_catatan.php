<?php
include "../koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query_hapus = "DELETE FROM tb_notes WHERE id='$id'";
    $hasil = mysqli_query($conn, $query_hapus);

    if ($hasil) {
        ?>
        <script language="javascript">
            document.location.href = "dashboard.php"; 
        </script>
        <?php
    } else {
        echo "Gagal hapus data catatan: " . mysqli_error($conn);
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>