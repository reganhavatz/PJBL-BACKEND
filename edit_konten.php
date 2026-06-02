<?php
include "../koneksi.php";

$id = $_GET['id'] ?? "";

$stmt = $conn->prepare("SELECT * FROM tb_konten WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data artikel tidak ditemukan!");
}

$kategori = $data['kategori'] ?? "";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artikel</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #e5e5e5;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }

        .edit-page {
            width: 100%;
            max-width: 600px;
        }

        .edit-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .edit-title {
            font-size: 24px;
            color: #333;
            margin-top: 0;
            margin-bottom: 25px;
            font-weight: bold;
        }

        .edit-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        .edit-group label {
            font-size: 14px;
            font-weight: bold;
            color: #554138;
        }

        .edit-group input[type="text"],
        .edit-group textarea,
        .edit-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            background-color: #f9f9f9;
        }

        .edit-group textarea {
            height: 150px;
            resize: vertical;
        }

        .edit-preview {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .edit-preview img {
            max-width: 150px;
            border-radius: 8px;
            display: block;
            border: 1px solid #ddd;
        }

        .edit-button {
            width: 100%;
            padding: 13px;
            background-color: #554138;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }

        .edit-button:hover {
            background-color: #42322b;
        }

        .input-simpel {
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 12px 15px;
            margin-top: 10px;
            background-color: #f5f5f5;
            outline: none;
        }
    </style>
</head>

<body>

    <div class="edit-page">
        <div class="edit-card">
            <h1 class="edit-title">Edit Artikel</h1>

            <form method="POST" action="proses_update.php" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

                <div class="edit-group">
                    <label>Judul Artikel</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($data['title']); ?>" required>
                </div>

                <div class="edit-group">
                    <label>Isi Artikel</label>
                    <textarea name="content" required><?php echo htmlspecialchars($data['content']); ?></textarea>
                </div>

                <div class="edit-group">
                    <label>Kategori :</label>
                    <select name="kategori" required>
                        <option value="Rumah Adat">Rumah Adat</option>
                        <option value="Baju Adat">Baju Adat</option>
                        <option value="Alat Musik Tradisional">Alat Musik Tradisional</option>
                        <option value="Landing Page">Landing Page</option>
                        <option value="Card Page">Card Page</option>
                    </select>

                    <input type="text" name="kategori_baru" class="input-simpel"
                        placeholder="Atau ketik kategori baru di sini...">
                </div>

                <div class="edit-group">
                    <label>Gambar Saat Ini</label>
                    <div class="edit-preview">
                        <img src="upload/<?php echo $data['image']; ?>" alt="Gambar Artikel">
                    </div>

                    <label style="margin-top: 10px;">Ganti Gambar Baru (Opsional)</label>
                    <input type="file" name="image" accept="image/*">
                </div>

                <button type="submit" name="update" class="edit-button">Simpan Perubahan</button>
            </form>
        </div>
    </div>

</body>

</html>