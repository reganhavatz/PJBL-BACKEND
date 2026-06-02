<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Culturenesia</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/ftf-indonesiana-serif-hijauwana" rel="stylesheet">
</head>
<style>
    body {
        font-family: 'Poppins', Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #56463E;
        min-height: 100vh;
        margin: 0;
        color: white;
    }

    .container-utama {
        display: flex;
        align-items: center;
        gap: 50px;
        padding: 20px;
    }

    .gambar2 img {
        width: 400px;
        height: 500px;
        object-fit: cover;
        border-radius: 20px;
        display: block;
    }

    .login {
        display: flex;
        flex-direction: column;
        width: 350px;
    }

    .login h1,
    .login h5 {
        margin: 5px 0;
        text-align: center;
    }

    .te {
        font-family: "FTF Indonesiana Serif";
        font-size: 2rem;
    }

    .se {
        font-weight: 300;
        font-style: italic;
        margin-bottom: 20px !important;
    }

    .judul-login {
        text-align: center;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .login input {
        padding: 12px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 8px;
        color: #333;
    }


    .btn-login {
        padding: 12px;
        margin-top: 15px;
        border: 1px solid #fff;
        border-radius: 8px;
        background-color: #56463E;
        color: white;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-login:hover {
        background-color: #fff;
        color: #56463E;
    }

    .social-container {
        margin-top: 25px;
        display: flex;
        justify-content: space-around;
        text-align: center;
    }

    .social-item img {
        width: 30px;
        height: auto;
        display: block;
        margin: 0 auto 5px;
    }

    .social-item h5 {
        font-size: 12px;
        font-weight: 400;
    }

    .login {
        display: flex;
        margin-left: 80px;
        font-family: "FTF Indonesiana Serif";
        margin-top: 20px;
    }

    .log {
        display: row;
        color: white;
        font-family: "FTF Indonesiana Serif";
    }
</style>

<body>

    <div class="container-utama">
        <div class="gambar2">
            <?php
            $query = "SELECT * FROM tb_konten WHERE id = 13";
            $sql = mysqli_query($conn, $query);

            if ($sql && $row = mysqli_fetch_array($sql)) {
                $nama_file_gambar = !empty($row['image']) ? $row['image'] : $row['gambar'];
                ?>
                <img src="admin/upload/<?php echo $nama_file_gambar; ?>" alt="<?php echo $row['title']; ?>"
                    class="gambar-landing">
                <?php
            } else {
                echo '<img src="upload/google.png" alt="Fallback" class="gambar-landing">';
            }
            ?>
        </div>

        <form class="login" method="POST" action="register_proses.php">
            <h1 class="te">Selamat Datang!</h1>
            <h5 class="se">"Menjaga warisan, merajut keberagaman."</h5>

            <h2 class="judul-login">Register</h2>

            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="login" class="btn-login">Register</button>


            <div class="login">
                <p>Sudah punya akun? <a href="login.php" class="log">Login</a></p>

            </div>
        </form>
    </div>

</body>

</html>