<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../Login.php");
    exit();
}

include "../koneksi.php";

$query_artikel = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_konten");
$data_artikel = mysqli_fetch_assoc($query_artikel);
$jumlah_artikel = $data_artikel['total'];

$query_user = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_akun");
$data_user = mysqli_fetch_assoc($query_user);
$jumlah_user = $data_user['total'];

$query_populer = mysqli_query($conn, "SELECT * FROM tb_konten ORDER BY views DESC LIMIT 5");

if (!isset($_SESSION['sudah_dihitung'])) {
    $today = date('Y-m-d');
    $cek = mysqli_query($conn, "SELECT id FROM tb_statistik WHERE tanggal = '$today'");
    
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE tb_statistik SET jumlah = jumlah + 1 WHERE tanggal = '$today'");
    } else {
        mysqli_query($conn, "INSERT INTO tb_statistik (tanggal, jumlah) VALUES ('$today', 1)");
    }
    $_SESSION['sudah_dihitung'] = true;
}

$data_grafik = [];
$labels = [];

for ($i = 6; $i >= 0; $i--) {
    $tgl = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('D', strtotime($tgl)); 
    
    $query_stat = mysqli_query($conn, "SELECT jumlah FROM tb_statistik WHERE tanggal = '$tgl'");
    $d_stat = mysqli_fetch_assoc($query_stat);
    $data_grafik[] = $d_stat['jumlah'] ?? 0;
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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


        .main {
            display: flex;
            flex-direction: row;
            flex: 1;
        }

        .main-container {
            flex: 1;
            padding: 10px 35px;
            height: calc(100vh - 30px);
            display: flex;
            flex-direction: row;
            gap: 30px;
            overflow-y: auto;
        }

        .content-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 25px;
            justify-content: flex-start;
        }

        .content-right {
            width: 320px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .page-title {
            font-size: 32px;
            font-weight: bold;
            color: #111;
            margin: 0;
            padding-bottom: 5px;
        }

        .chart-container {
            display: flex;
            flex-direction: row;
            gap: 25px;
            align-items: stretch;
            width: 100%;
            margin-top: -20px;
        }

        .statistik {
            flex: 1;
            background-color: white;
            padding: 20px;
            border-radius: 25px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
            height: 290px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .catatan-card-unified {
            width: 310px;
            background-color: white;
            border-radius: 28px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: 290px;
            flex-shrink: 0;
        }

        .catatan-main-title {
            font-size: 16px;
            font-weight: 700;
            color: #554138;
            text-align: center;
            margin: 0 0 12px 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .catatan-list-wrapper {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 12px;
            padding-right: 4px;
        }

        .catatan-list-wrapper::-webkit-scrollbar {
            width: 4px;
        }

        .catatan-list-wrapper::-webkit-scrollbar-thumb {
            background-color: #ddd;
            border-radius: 10px;
        }

        .catatan-table {
            width: 100%;
            border-collapse: collapse;
        }

        .catatan-table td {
            padding: 8px 2px;
            font-size: 13px;
            border-bottom: 1px dashed #eee;
            vertical-align: top;
        }

        .catatan-nomor {
            width: 8%;
            font-weight: 600;
            color: #554138;
            text-align: left;
            padding-top: 8px;
        }

        .catatan-teks {
            width: 52%;
            color: #333;
            word-break: break-word;
            line-height: 1.4;
        }

        .catatan-tanggal {
            width: 25%;
            font-size: 11px !important;
            color: #888;
            text-align: center;
            padding-top: 10px !important;
        }

        .catatan-aksi {
            width: 15%;
            text-align: right;
            padding-top: 9px !important;
        }

        .btn-selesai {
            color: #28a745 !important;
            font-weight: bold;
            text-decoration: none;
            font-size: 12px;
        }

        .btn-selesai:hover {
            text-decoration: underline;
        }

        .catatan-form {
            display: flex;
            flex-direction: row;
            gap: 8px;
            border-top: 1px solid #f3f3f3;
            padding-top: 12px;
            align-items: center;
        }

        .catatan-form input[type="text"] {
            flex: 1;
            padding: 10px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 13px;
            outline: none;
            background-color: #fafafa;
            transition: border 0.2s;
        }

        .catatan-form input[type="text"]:focus {
            border-color: #554138;
            background-color: #fff;
        }

        .catatan-form input[type="submit"] {
            background-color: #554138;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            text-transform: lowercase;
            box-shadow: 0 4px 6px rgba(85, 65, 56, 0.15);
            transition: background 0.2s;
            flex-shrink: 0;
        }

        .catatan-form input[type="submit"]:hover {
            background-color: #3d2f28;
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

        .stats-wrapper {
            display: flex;
            gap: 25px;
            width: 100%;
        }

        .card {
            background-color: white;
            flex: 1;
            height: 180px;
            border-radius: 25px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin-top: 20px;
        }

        .card-icon {
            width: 45px;
            height: 45px;
            background-color: #554138;
            border-radius: 12px;
            position: absolute;
            top: -22px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 16px;
        }

        .card-title {
            font-size: 15px;
            font-weight: bold;
            color: #554138;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        .card-value {
            font-size: 42px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .card-indicator {
            width: 50px;
            height: 4px;
            background-color: #28a745;
            border-radius: 2px;
            margin-top: 10px;
        }

        .populer {
            background-color: #ffffff;
            border-radius: 24px;
            padding: 24px;
            width: 100%;
            height: 495px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            box-sizing: border-box;
            margin-top: 55px;
        }

        .populer .tks {
            font-size: 20px;
            font-weight: 700;
            color: #333333;
            margin: 0 0 20px 0;
            text-align: center;
        }

        .populer .isi-populer {
            display: flex;
            flex-direction: column;
            gap: 16px;
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
        <a href="../logout.php" class="tombol-logout" style="text-decoration:none;"
            onclick="return confirm('Keluar?')">❌</a>
    </div>

    <div class="main">
        <div class="main-container">

            <div class="content-left">
                <h1 class="page-title">Dashboard</h1>

                <div class="chart-container">
                    <div class="statistik">
                        <canvas id="simpleChart"></canvas>
                    </div>

                    <div class="catatan-card-unified">
                        <div class="catatan-main-title">Catatan</div>

                        <div class="catatan-list-wrapper">
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM tb_notes");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $no = 1; // Variabel inisialisasi nomor urut
                            ?>
                            <table class="catatan-table">
                                <?php while ($data = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td class="catatan-nomor"><?php echo $no++; ?>.</td>
                                        <td class="catatan-teks">
                                            <?php echo htmlspecialchars($data['isi']); ?>
                                        </td>
                                        <td class="catatan-tanggal">
                                            <?php echo $data['tanggal']; ?>
                                        </td>
                                        <td class="catatan-aksi">
                                            <a href="delete_catatan.php?id=<?php echo $data['id']; ?>"
                                                onclick="return confirm('Selesaikan catatan ini?')" class="btn-selesai">
                                                Selesai
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>

                        <form action="isi_catatan.php" method="post" class="catatan-form">
                            <input type="text" name="catatan" placeholder="Tambah catatan..." required>
                            <input type="submit" name="simpan" value="simpan">
                        </form>
                    </div>
                </div>

                <div class="stats-wrapper">
                    <div class="card">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="currentColor"
                                    d="M12 2a3 3 0 1 0 0 6a3 3 0 1 0 0-6M2 9v9.88c0 .27.11.53.31.72s.46.3.73.28c.04 0 3.93-.11 8.46 1.99V9.78C7.48 8.03 3.19 7.99 3 7.99c-.55 0-1 .45-1 1Zm19-1c-.19 0-4.48.03-8.5 1.79v12.09c4.51-2.09 8.43-2 8.47-1.99c.27.02.53-.09.73-.28c.19-.19.3-.45.3-.72V9.01c0-.55-.45-1-1-1Z" />
                            </svg>
                        </div>
                        <p class="card-title">Jumlah Artikel</p>
                        <h1 class="card-value"><?php echo $jumlah_artikel; ?></h1>
                        <div class="card-indicator"></div>
                    </div>

                    <div class="card">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="currentColor"
                                    d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                            </svg>
                        </div>
                        <p class="card-title">Jumlah User</p>
                        <h1 class="card-value"><?php echo $jumlah_user; ?></h1>
                        <div class="card-indicator"></div>
                    </div>

                    <div class="card">
                        <div class="card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="currentColor"
                                    d="M6 8c0-2.21 1.79-4 4-4s4 1.79 4 4s-1.79 4-4 4s-4-1.79-4-4m3.14 11.75L8.85 19l.29-.75c.7-1.75 1.94-3.11 3.47-4.03c-.82-.14-1.69-.22-2.61-.22c-4.42 0-8 1.79-8 4v2h7.27c-.04-.09-.09-.17-.13-.25M17 18c-.56 0-1 .44-1 1s.44 1 1 1s1-.44 1-1s-.44-1-1-1m6 1c-.94 2.34-3.27 4-6 4s-5.06-1.66-6-4c.94-2.34 3.27-4 6-4s5.06 1.66 6 4m-3.5 0a2.5 2.5 0 0 0-5 0a2.5 2.5 0 0 0 5 0" />
                            </svg>
                        </div>
                        <p class="card-title">Total Views</p>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM tb_views");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $data = $result->fetch_assoc();
                        ?>
                        <h1 class="card-value"><?php echo $data['views'] ?? "" ?></h1>
                        <div class="card-indicator"></div>
                    </div>
                </div>
            </div>

            <div class="populer">
                <h1 class="tks">Populer</h1>
                <div class="isi-populer">
                    <?php while ($row = mysqli_fetch_assoc($query_populer)) { ?>
                        <div
                            style="display: flex; align-items: center; gap: 10px; padding: 5px; border-bottom: 1px solid #eee;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; font-size: 14px;">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </div>
                                <div style="font-size: 12px; color: #888;"><?php echo $row['views']; ?> kali dilihat
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>

    <script>
        const ctxLine = document.getElementById('simpleChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Pengguna Aktif',
                    data: <?php echo json_encode($data_grafik); ?>,
                    borderColor: '#4244DB',
                    backgroundColor: 'rgba(66, 68, 219, 0.15)',
                    tension: 0.4,
                    borderWidth: 3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: '#666' }, grid: { display: false } },
                    y: { 
                        beginAtZero: true,
                        ticks: { color: '#666', stepSize: 1 }, 
                        grid: { color: 'rgba(0,0,0,0.05)' } 
                    }
                }
            }
        });
    </script>

</body>



</html>
