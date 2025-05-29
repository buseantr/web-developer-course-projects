<?php
session_start();

// Kullanıcı giriş yapmamışsa yönlendir
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Veritabanı bağlantısı
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "tarif_makinesi";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Form gönderildiğinde çalışacak kısım
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $konu = $_POST['konu'];
    $mesaj = $_POST['mesaj'];

    // Destek talebini veritabanına ekle
    $stmt = $conn->prepare("INSERT INTO destek_talepleri (username, konu, mesaj) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $konu, $mesaj);

    if ($stmt->execute()) {
        echo "<script>
            alert('Destek talebiniz başarıyla alındı! En kısa sürede dönüş yapılacaktır.');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "Hata: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destek Talep</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Genel Ayarlar */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #ff6f61, #ff9472);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        /* Kart Tasarımı */
        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            animation: fadeIn 1s ease-in-out;
        }

        .container h2 {
            margin: 0 0 15px 0;
            color: #ff6f61;
            font-weight: 700;
            text-align: center;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: border 0.3s ease;
        }

        input:focus, textarea:focus {
            border-color: #ff6f61;
            outline: none;
        }

        button {
            background: #ff6f61;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 8px;
            width: 100%;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        button:hover {
            background: #e64b3b;
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #666;
            font-size: 0.9rem;
        }

        .back-link:hover {
            color: #ff6f61;
        }

        /* Animasyon */
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
        <h2>Destek Talep Formu</h2>
        <form method="POST" action="support.php">
            <input type="text" name="konu" placeholder="Konu" required>
            <textarea name="mesaj" placeholder="Destek talebinizi buraya yazın..." required></textarea>
            <button type="submit">Gönder</button>
        </form>
        <a href="index.php" class="back-link">⬅️ Ana Sayfaya Dön</a>
    </div>
</body>
</html>
