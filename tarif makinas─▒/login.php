<?php
session_start();

// Veritabanı bağlantısı
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "tarif_makinesi";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Form gönderildiyse
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kullanıcıyı veritabanında ara
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Şifre kontrolü
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username; // Oturum başlat
            header("Location: index.php"); // Ana sayfaya yönlendir
            exit;
        } else {
            $error = "Hatalı şifre!";
        }
    } else {
        $error = "Kullanıcı bulunamadı!";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4, #fbc2eb);
        }

        .container {
            background: white;
            padding: 30px;
            width: 400px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 0.8s ease;
        }

        h2 {
            color: #ff6f61;
            font-weight: 700;
            margin-bottom: 20px;
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: border 0.3s ease;
        }

        input:focus {
            border-color: #ff6f61;
            outline: none;
        }

        button {
            background: #ff6f61;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background: #ff6f61;
            transform: scale(1.05);
        }

        p.error {
            color: red;
            font-size: 0.9rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Giriş Yap</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Kullanıcı Adı" required><br>
            <input type="password" name="password" placeholder="Şifre" required><br>
            <button type="submit">Giriş Yap</button>
        </form>
        <p style="margin-top: 10px;">Hesabınız yok mu? <a href="register.php" style="color: #66a6ff;">Kayıt Ol</a></p>
    </div>
</body>
</html>
