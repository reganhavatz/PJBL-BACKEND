<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: ../Login.php");
    exit();
}

$user = $_SESSION['username'];
$query = "SELECT * FROM tb_laporan WHERE username = '$user' ORDER BY id DESC";
$sql = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Laporan - Culturenesia</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding: 40px;
            background-color: #F0F4EF;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;margin-top: 20px;
            border: 1px solid #000;
            border-radius: 10px;
            overflow: hidden;
            background-color: #e5e5e5;
            color: black;
        }

        th,
        td {
            border-bottom: 1px solid #000;
            border-right: 1px solid #000;
            padding: 12px;
            text-align: left;
        }


        th {
            background-color: #56463E;
            color: #e5e5e5;
        }

        .kembali a {
            background-color: #56463E;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="kembali">
        <a href="LandingPage.php">Kembali</a>
    </div>


    <h2>Riwayat Laporan Anda</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Email</th>
            <th>Username</th>
            <th>Isi Laporan</th>
            <th>Status</th>
        </tr>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_array($sql)) {
            echo "<tr>
                <td>$no</td>
                <td>{$row['email']}</td>
                <td>{$row['username']}</td>
                <td>{$row['isi']}</td>
                <td>{$row['status']}</td>
              </tr>";
            $no++;
        }
        ?>
    </table>
    <br>


</body>

</html>