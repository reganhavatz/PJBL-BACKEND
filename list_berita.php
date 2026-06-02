<?php
include '../koneksi.php';

$batas = 5;
$halaman = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

$kata_kunci = isset($_GET['kata_kunci']) ? $_GET['kata_kunci'] : "";
$kategori_dipilih = isset($_GET['kategori']) ? $_GET['kategori'] : "";

if ($kata_kunci != "" && $kategori_dipilih != "") {
    $query_konten = "SELECT * FROM tb_konten WHERE title LIKE '%$kata_kunci%' AND kategori = '$kategori_dipilih' ORDER BY id DESC";
} else if ($kata_kunci != "") {
    $query_konten = "SELECT * FROM tb_konten WHERE title LIKE '%$kata_kunci%' ORDER BY id DESC";
} else if ($kategori_dipilih != "") {
    $query_konten = "SELECT * FROM tb_konten WHERE kategori = '$kategori_dipilih' ORDER BY id DESC";
} else {
    $query_konten = "SELECT * FROM tb_konten ORDER BY id DESC";
}

$sql_total = mysqli_query($conn, $query_konten);
$jumlah_data = mysqli_num_rows($sql_total);
$total_halaman = ceil($jumlah_data / $batas);

$query_limit = $query_konten . " LIMIT $halaman_awal, $batas";
$sql_konten = mysqli_query($conn, $query_limit);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengguna</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #e5e5e5;
            margin: 0;
            padding: 15px;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 70px;
            height: calc(100vh - 30px);
            background-color: #554138;
            border-radius: 35px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 25px 0;
            gap: 30px;
            box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.15);
        }

        .sidebar-icon {
            width: 35px;
            height: 35px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            font-size: 14px;
            text-decoration: none;
        }

        .sidebar-icon:hover {
            background-color: rgba(255, 255, 255, 0.4);
        }

        .divider {
            width: 40px;
            height: 1px;
            background-color: rgba(255, 255, 255, 0.3);
            margin-top: auto;
        }

        .content-area {
            flex: 1;
            margin-left: 20px;
            padding: 10px;
            overflow-y: auto;
            height: calc(100vh - 30px);
        }

        h2 {
            color: #554138;
            margin: 0 0 20px 0;
            font-size: 24px;
        }

        .form-pencarian {
            background-color: white;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .grup-kiri,
        .grup-kanan {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .input-search {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            width: 250px;
            margin-left: -380px;
        }

        .wadah-select-icon {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 2px 2px 2px 10px;
            background-color: white;
        }

        .select-filter {
            border: none;
            font-size: 14px;
            width: 180px;
            height: 32px;
            outline: none;
            background-color: transparent;
        }

        .tombol-cari {
            background-color: #554138;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            font-weight: bold;
        }

        .table-box {
            background-color: white;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background-color: #f5f5f5;
            border-bottom: 2px solid #ddd;
        }

        th {
            padding: 12px 15px;
            text-align: left;
            color: #554138;
            font-size: 14px;
            font-weight: bold;
        }

        td {
            padding: 12px 15px;
            color: #333;
            font-size: 14px;
            vertical-align: top;
            word-wrap: break-word;
            max-width: 250px;
        }

        .badge-kategori {
            background-color: #f0f0f0;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: #555;
            display: inline-block;
        }

        table img {
            border-radius: 6px;
            object-fit: cover;
            width: 100px;
            height: 65px;
        }

        .btn-tambah {
            background-color: #554138;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .pagination {
            margin-top: 15px;
            display: flex;
            gap: 5px;
            list-style: none;
            padding: 0;
            margin-left: 450px;
        }

        .pagination a {
            padding: 5px 12px;
            border: 1px solid #ccc;
            text-decoration: none;
            border-radius: 4px;
            color: #554138;
            font-size: 14px;
        }

        .pagination a.active {
            background-color: #554138;
            color: white;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <a href="dashboard.php" class="sidebar-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none" />
                <path fill="currentColor"
                    d="m21.66 10.25l-9-8a1 1 0 0 0-1.32 0l-9 8a1 1 0 0 0-.27 1.11A1 1 0 0 0 3 12h1v9a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-9h1a1 1 0 0 0 .93-.64a1 1 0 0 0-.27-1.11M13 20h-2v-3a1 1 0 0 1 2 0Zm5 0h-3v-3a3 3 0 0 0-6 0v3H6v-8h12ZM5.63 10L12 4.34L18.37 10Z" />
            </svg></a>
        <a href="pengguna.php" class="sidebar-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none" />
                <path fill="currentColor"
                    d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 2a2 2 0 0 0-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2m0 7c2.67 0 8 1.33 8 4v3H4v-3c0-2.67 5.33-4 8-4m0 1.9c-2.97 0-6.1 1.46-6.1 2.1v1.1h12.2V17c0-.64-3.13-2.1-6.1-2.1" />
            </svg></a>
        <a href="laporan.php" class="sidebar-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none" />
                <path fill="currentColor"
                    d="M20 12V7h2v6h-2m0 4h2v-2h-2m-10-2c2.67 0 8 1.34 8 4v3H2v-3c0-2.66 5.33-4 8-4m0-9a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10.9c-2.97 0-6.1 1.46-6.1 2.1v1.1h12.2V17c0-.64-3.13-2.1-6.1-2.1m0-9A2.1 2.1 0 0 0 7.9 8a2.1 2.1 0 0 0 2.1 2.1A2.1 2.1 0 0 0 12.1 8A2.1 2.1 0 0 0 10 5.9" />
            </svg></a>
        <a href="list_berita.php" class="sidebar-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                viewBox="0 0 16 16">
                <path d="M0 0h16v16H0z" fill="none" />
                <path fill="none" stroke="currentColor" stroke-linejoin="round"
                    d="M4 8h6M4 5.5h6m1 0h1M11 8h1m-1 2.5h1m-8 0h6m-7.5-8h11v11h-11z" />
            </svg></a>
        <div class="divider"></div>
        <a href="../logout.php" onclick="return confirm('Keluar?')">❌</a>
    </div>
    <div class="content-area">
        <h2>Daftar Konten</h2>
        <form action="" method="GET" class="form-pencarian">
            <a href="form_berita.php" class="btn-tambah">Tambah Artikel</a>
            <div class="grup-kiri">
                <input type="text" name="kata_kunci" class="input-search" placeholder="Cari..."
                    value="<?php echo $kata_kunci; ?>">
                <button type="submit" class="tombol-cari">Cari</button>
            </div>
            <div class="grup-kanan">
                <div class="wadah-select-icon">
                    <select name="kategori" class="select-filter" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="Rumah Adat" <?php if ($kategori_dipilih == "Rumah Adat")
                            echo "selected"; ?>>Rumah
                            Adat</option>
                        <option value="Baju Adat" <?php if ($kategori_dipilih == "Baju Adat")
                            echo "selected"; ?>>Baju
                            Adat</option>
                        <option value="Alat Musik Tradisional" <?php if ($kategori_dipilih == "Alat Musik Tradisional")
                            echo "selected"; ?>>Alat Musik Tradisional</option>
                    </select>
                </div>
            </div>
        </form>
        <div class="table-box">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = $halaman_awal + 1;
                    while ($row = mysqli_fetch_array($sql_konten)) {
                        $deskripsi_pendek = substr($row['content'], 0, 80) . "...";
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $deskripsi_pendek; ?></td>
                            <td><span class="badge-kategori"><?php echo $row['kategori']; ?></span></td>
                            <td><img src="upload/<?php echo $row['image']; ?>" alt="Gambar"></td>
                            <td class="action-links">
                                <a href="detail.php?id=<?php echo $row['id']; ?>">Lihat</a> |
                                <a href="edit_konten.php?id=<?php echo $row['id']; ?>">Edit</a> |
                                <a href="delete.php?id=<?php echo $row['id']; ?>"
                                    onclick="return confirm('Hapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_halaman; $i++) { ?>
                    <a href="?halaman=<?php echo $i; ?>&kata_kunci=<?php echo $kata_kunci; ?>&kategori=<?php echo $kategori_dipilih; ?>"
                        class="<?php echo ($i == $halaman) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>