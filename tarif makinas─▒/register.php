<?php
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

    if (empty($username) || empty($password)) {
        $error = "Lütfen tüm alanları doldurun!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            if ($conn->query($sql) === TRUE) {
                echo "<p style='color:green; font-size:1.2rem; text-align:center;'>
                    Kayıt başarılı! Giriş sayfasına yönlendiriliyorsunuz...</p>";
                header("Refresh: 2; url=login.php");
                exit;
            }
            
        } else {
            $error = "Kayıt sırasında bir hata oluştu: " . $conn->error;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Genel Ayarlar */
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
            animation: slideIn 0.8s ease;
        }

        h2 {
            margin-bottom: 20px;
            color: #ff6f61;
            font-weight: 700;
            font-size: 1.8rem;
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
            background: #ff5733;
            transform: scale(1.05);
        }

        p.error {
            color: red;
            font-size: 0.9rem;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h2>Kayıt Ol</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="register.php">
            <input type="text" name="username" placeholder="Kullanıcı Adı" required><br>
            <input type="password" name="password" placeholder="Şifre" required><br>
            <button type="submit">Kayıt Ol</button>
        </form>
    </div>
</body>
</html>

