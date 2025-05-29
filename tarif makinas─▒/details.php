<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Veritabanı bağlantısı
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "tarif_makinesi";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}

// Tarif ID'sini al ve kontrol et
if (isset($_GET['id'])) {
    $tarif_id = intval($_GET['id']);

    // Tarif bilgilerini çek
    $sql = "SELECT * FROM tarifler WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tarif_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $tarif = $result->fetch_assoc();
    } else {
        die("<h1 style='text-align: center; color: red;'>Tarif bulunamadı!</h1>");
    }
} else {
    die("<h1 style='text-align: center; color: red;'>Geçersiz tarif isteği!</h1>");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tarif['isim']); ?> - Tarif Detayları</title>
    <style>
        /* Genel Ayarlar */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .tarif-img {
            width: 100%;
            height: auto;
            border-radius: 12px;
        }

        h1 {
            text-align: center;
            color: #ff6f61;
            margin: 20px 0;
            font-size: 2.5rem;
        }

        .tarif-aciklama {
            text-align: center;
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 20px;
        }

        .malzemeler, .yapilis {
            margin: 20px 0;
        }

        .malzemeler h2, .yapilis h2 {
            color: #ff6f61;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .malzemeler ul {
            list-style-type: disc;
            margin-left: 20px;
        }

        .malzemeler ul li {
            font-size: 1rem;
            color: #333;
            margin-bottom: 5px;
        }

        .yapilis p {
            font-size: 1.1rem;
            color: #666;
            line-height: 1.8;
        }

        .back-btn {
            display: block;
            text-align: center;
            margin: 30px auto;
            padding: 10px 20px;
            background-color: #ff6f61;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: bold;
            transition: all 0.3s ease;
            max-width: 200px;
        }

        .back-btn:hover {
            background-color: #ff3e3e;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <img class="tarif-img" src="<?php echo htmlspecialchars($tarif['resim']); ?>" alt="<?php echo htmlspecialchars($tarif['isim']); ?>">
        <h1><?php echo htmlspecialchars($tarif['isim']); ?></h1>
        <p class="tarif-aciklama"><?php echo htmlspecialchars($tarif['aciklama']); ?></p>

        <div class="malzemeler">
            <h2>Malzemeler:</h2>
            <ul>
                <?php
                $malzemeler = explode(",", $tarif['malzemeler']);
                foreach ($malzemeler as $malzeme) {
                    echo "<li>" . htmlspecialchars($malzeme) . "</li>";
                }
                ?>
            </ul>
        </div>

        <div class="yapilis">
            <h2>Yapılışı:</h2>
            <p><?php echo nl2br(htmlspecialchars($tarif['yapilis'])); ?></p>
        </div>

        <a href="index.php" class="back-btn">← Ana Sayfaya Dön</a>
    </div>

    <footer>
        <p>&copy; 2024 Tarif Makinası | Tüm Hakları Saklıdır</p>
    </footer>
</body>
</html>
