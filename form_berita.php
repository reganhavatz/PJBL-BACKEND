<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Berita</title>
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
            gap: 25px;
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

        .tombol-logout {
            font-size: 20px;
            text-decoration: none;
            cursor: pointer;
        }

        .main-container {
            flex: 1;
            padding: 10px 40px;
            height: calc(100vh - 30px);
            display: flex;
            flex-direction: column;
        }

        .page-title {
            font-size: 28px;
            font-weight: bold;
            color: #111;
            margin: 0 0 15px 0;
        }

        form {
            width: 100%;
            height: calc(100% - 60px);
        }

        .form-wrapper {
            display: flex;
            gap: 50px;
            max-width: 1300px;
            height: 100%;
            align-items: flex-start;
        }

        .left-inputs {
            flex: 1.4;
            display: flex;
            flex-direction: column;
            gap: 15px;
            height: 100%;
        }
        
        .right-upload {
            flex: 1;
            max-width: 420px;
            width: 100%;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .input-group label {
            font-size: 16px;
            font-weight: bold;
            color: #554138;
        }

        .input-title,
        .input-content,
        .input-group select {
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 14px;
            background-color: #f5f5f5;
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.02), 0px 4px 8px rgba(0, 0, 0, 0.04);
            outline: none;
            resize: none;
            color: #333;
        }

        .input-title {
            height: 85px;
        }

        .input-content {
            height: 200px;
        }

        .input-group select {
            cursor: pointer;
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 20px;
            padding-right: 40px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 5px;
        }

        .btn {
            padding: 10px 25px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.1s ease;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-submit {
            background-color: #554138;
        }

        .btn-submit:hover {
            background-color: #42322b;
        }

        .btn-clear {
            background-color: #6e574b;
        }

        .btn-clear:hover {
            background-color: #5c483e;
        }

        .upload-area {
            position: relative;
            width: 100%;
            height: 415px;
            background-color: #f5f5f5;
            border-radius: 15px;
            border: 2px dashed #b8afab;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            cursor: pointer;
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.02), 0px 4px 8px rgba(0, 0, 0, 0.04);
        }

        .upload-area:hover {
            background-color: #ececec;
        }

        .file-input-field {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 3;
        }

        .upload-label {
            font-size: 15px;
            font-weight: 600;
            color: #554138;
            z-index: 1;
            text-align: center;
            pointer-events: none;
        }

        .image-preview {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            object-fit: cover;
            display: none;
            z-index: 2;
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
    <div class="main-container">
        <h1 class="page-title">Upload Artikel</h1>

        <form action="proses_upload.php" method="POST" enctype="multipart/form-data">
            <div class="form-wrapper">

                <div class="left-inputs">
                    <div class="input-group">
                        <label>Judul :</label>
                        <textarea name="title" class="input-title" placeholder="Masukkan judul artikel"
                            required></textarea>
                    </div>

                    <div class="input-group">
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

                    <div class="input-group">
                        <label>Isi :</label>
                        <textarea name="content" class="input-content" placeholder="Tuliskan isi/Konten"
                            required></textarea>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-submit">Tambahkan</button>
                        <button type="reset" class="btn btn-clear" id="resetBtn">Clear</button>
                    </div>
                </div>

                <div class="right-upload">
                    <div class="input-group">
                        <label>Gambar :</label>
                        <div class="upload-area">
                            <input type="file" name="image" id="imageInput" class="file-input-field" accept="image/*"
                                required>
                            <span class="upload-label" id="uploadLabel">Tambahkan Gambar</span>
                            <img src="#" alt="Preview Gambar" id="imagePreview" class="image-preview">
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script>
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const uploadLabel = document.getElementById('uploadLabel');
        const resetBtn = document.getElementById('resetBtn');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.addEventListener('load', function () {
                    imagePreview.setAttribute('src', this.result);
                    imagePreview.style.display = 'block';
                    uploadLabel.style.display = 'none';
                });

                reader.readAsDataURL(file);
            }
        });

        resetBtn.addEventListener('click', function () {
            imagePreview.setAttribute('src', '#');
            imagePreview.style.display = 'none';
            uploadLabel.style.display = 'block';
        });
    </script>

</body>

</html>