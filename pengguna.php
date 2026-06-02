<?php
include '../koneksi.php';

$query = "SELECT * FROM tb_akun";
$hasil = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan & Pengguna</title>
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
            overflow: hidden;
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
            flex-shrink: 0;
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

        .main-container {
            flex: 1;
            padding: 10px 30px;
            height: calc(100vh - 30px);
            overflow-y: auto;
        }

        h2 {
            color: #554138;
            margin-top: 10px;
            margin-bottom: 25px;
            font-size: 24px;
        }

        .table-box {
            background-color: white;
            border-radius: 20px;
            padding: 0;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background-color: #e5e5e5;
            border-bottom: 2px solid #ccc;
        }

        th {
            padding: 18px 20px;
            text-align: left;
            color: #554138;
            font-weight: bold;
            font-size: 15px;
        }

        tbody tr {
            border-bottom: 1px solid #ddd;
        }

        td {
            padding: 15px 20px;
            color: #333;
            font-size: 15px;
            vertical-align: middle;
        }

        .col-id {
            width: 10%;
        }

        .btn-delete {
            display: inline-block;
            background-color: #ff0066;
            color: white;
            padding: 8px 20px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
            text-align: center;
            border: none;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: #cc0052;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <a href="dashboard.php" class="sidebar-icon" title="Dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none" />
                <path fill="currentColor"
                    d="m21.66 10.25l-9-8a1 1 0 0 0-1.32 0l-9 8a1 1 0 0 0-.27 1.11A1 1 0 0 0 3 12h1v9a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-9h1a1 1 0 0 0 .93-.64a1 1 0 0 0-.27-1.11M13 20h-2v-3a1 1 0 0 1 2 0Zm5 0h-3v-3a3 3 0 0 0-6 0v3H6v-8h12ZM5.63 10L12 4.34L18.37 10Z" />
            </svg>
        </a>
        <a href="pengguna.php" class="sidebar-icon" title="List User">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none" />
                <path fill="currentColor"
                    d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 2a2 2 0 0 0-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2m0 7c2.67 0 8 1.33 8 4v3H4v-3c0-2.67 5.33-4 8-4m0 1.9c-2.97 0-6.1 1.46-6.1 2.1v1.1h12.2V17c0-.64-3.13-2.1-6.1-2.1" />
            </svg>
        </a>
        <a href="laporan.php" class="sidebar-icon" title="Laporan User">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none" />
                <path fill="currentColor"
                    d="M20 12V7h2v6h-2m0 4h2v-2h-2m-10-2c2.67 0 8 1.34 8 4v3H2v-3c0-2.66 5.33-4 8-4m0-9a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10.9c-2.97 0-6.1 1.46-6.1 2.1v1.1h12.2V17c0-.64-3.13-2.1-6.1-2.1m0-9A2.1 2.1 0 0 0 7.9 8a2.1 2.1 0 0 0 2.1 2.1A2.1 2.1 0 0 0 12.1 8A2.1 2.1 0 0 0 10 5.9" />
            </svg>
        </a>
        <a href="list_berita.php" class="sidebar-icon" title="List Artikel">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                <path d="M0 0h16v16H0z" fill="none" />
                <path fill="none" stroke="currentColor" stroke-linejoin="round"
                    d="M4 8h6M4 5.5h6m1 0h1M11 8h1m-1 2.5h1m-8 0h6m-7.5-8h11v11h-11z" />
            </svg>
        </a>
        <div class="divider"></div>
        <a href="../logout.php" onclick="return confirm('Keluar?')">❌</a>
    </div>

    <div class="main-container">
        <h2>Daftar Pengguna</h2>
        <div class="table-box">
            <table>
                <thead>
                    <tr>
                        <th class="col-id">No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th style="text-align: right; padding-right: 35px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($data = mysqli_fetch_array($hasil)) {
                        ?>
                        <tr>
                            <td class="col-id"><?php echo sprintf("%02d.", $no); ?></td>
                            <td><?php echo htmlspecialchars($data['username']); ?></td>
                            <td><?php echo htmlspecialchars($data['tanggal']); ?></td>
                            <td style="text-align: right;">
                                <a href="delete_user.php?id=<?php echo $data['id']; ?>" class="btn-delete"
                                    onclick="return confirm('Yakin ingin menghapus?')">Delete</a>
                            </td>
                        </tr>
                        <?php
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>