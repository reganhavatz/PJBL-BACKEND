<?php
include "../koneksi.php";
if (isset($_POST['simpan'])) {
$isi = $_POST['catatan'] ?? "";
$stmt = $conn->prepare("INSERT INTO tb_notes (isi) VALUES (?)");
$stmt->bind_param("s",$isi);

if($stmt->execute()) { ?>
    <script language="javascript">document.location.href="dashboard.php";</script>
<?php }
}
?>