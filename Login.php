<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Register - Culturenesia</title>

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
        justify-content: center;
        gap: 100px;
        padding: 20px;
    }

    .gambar2 img {
        width: 400px;
        height: 500px;
        object-fit: cover;
        border-radius: 20px;
        display: block;
        flex-shrink: 0;
    }

    .login {
        display: flex;
        flex-direction: column;
        width: 350px;
        flex-shrink: 0;
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
        justify-content: center;
        gap: 30px;
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

    .regis {
        display: flex;
        margin-left: 80px;
        font-family: "FTF Indonesiana Serif";
        margin-top: 20px;
    }

    .gister {
        display: column;
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

        <form class="login" method="POST" action="login_proses.php">
            <h1 class="te">Selamat Datang!</h1>
            <h5 class="se">"Menjaga warisan, merajut keberagaman."</h5>

            <h2 class="judul-login">Login</h2>

            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit" name="login" class="btn-login">Login</button>

            <div class="social-container">
                <div class="social-item" id="btn-google" style="cursor:pointer;">
                    <img src="image/google.png" alt="Google">
                    <h5>Google</h5>
                </div>
                <div class="social-item">
                    <img src="image/Facebook.png" alt="Facebook">
                    <h5>Facebook</h5>
                </div>
                <div class="social-item">
                    <img src="image/tiktok.png" alt="Tiktok">
                    <h5>Tiktok</h5>
                </div>
            </div>

            <div class="regis">
                <p>Belum punya akun? <a href="register.php" class="gister">Register</a></p>

            </div>

        </form>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/12.14.0/firebase-app.js";
        import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/12.14.0/firebase-auth.js";

        const firebaseConfig = {
            apiKey: "AIzaSyDli2bjX8q6sIBqb4OHRvHdpIATBkkDylA",
            authDomain: "login-1d166.firebaseapp.com",
            projectId: "login-1d166",
            storageBucket: "login-1d166.firebasestorage.app",
            messagingSenderId: "1078286983239",
            appId: "1:1078286983239:web:40b9d5733623197dd99162",
            measurementId: "G-4DR2JY3E0D"
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth();
        const provider = new GoogleAuthProvider();

       
        document.addEventListener('DOMContentLoaded', () => {
            const btnGoogle = document.getElementById('btn-google');
            if (btnGoogle) {
                btnGoogle.addEventListener('click', () => {
                    signInWithPopup(auth, provider)
                        .then((result) => {
                            result.user.getIdToken().then((idToken) => {
                                window.location.href = "login_proses_firebase.php?token=" + idToken;
                            });
                        })
                        .catch((error) => {
                            console.error("Login gagal:", error);
                            alert("Gagal Login dengan Google: " + error.message);
                        });
                });
            }
        });
    </script>

</body>

</html>