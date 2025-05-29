
<?php
session_start();

// Kullanıcı giriş yapmış mı kontrol et
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Veritabanı bağlantısı
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "tarif_makinesi";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Kullanıcının ID'sini al
$username = $_SESSION['username'];
$user_query = "SELECT id FROM users WHERE username = '$username'";
$user_result = $conn->query($user_query);

if ($user_result && $user_result->num_rows > 0) {
    $user_id = $user_result->fetch_assoc()['id'];

    // Kullanıcının favori tariflerini çek
    $sql = "SELECT tarifler.* FROM favorites 
            JOIN tarifler ON favorites.recipe_id = tarifler.id 
            WHERE favorites.user_id = $user_id";

    $result = $conn->query($sql);
} else {
    die("Kullanıcı bilgisi bulunamadı!");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tariflerim</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
            text-align: center;
        }

        h1 {
            color: #ff6f61;
            margin-top: 20px;
            font-size: 2.5rem;
        }

        .description {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 30px;
        }

        .tarifler {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }

        .tarif-kutusu {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 15px;
            overflow: hidden;
            width: 300px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .tarif-kutusu:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .tarif-kutusu img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .tarif-kutusu h3 {
            margin: 15px 10px 5px;
            color: #ff6f61;
            font-size: 1.3rem;
        }

        .tarif-kutusu p {
            color: #666;
            font-size: 0.9rem;
            margin: 10px;
        }

        .empty-message {
            margin-top: 50px;
            font-size: 1.5rem;
            color: #999;
            animation: fadeIn 1.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    
    <!-- Ana Sayfaya Dön Butonu -->
    <div style="text-align: center; margin: 20px;">
        <a href="index.php" style="
            display: inline-block; 
            background: #ff6f61; 
            color: white; 
            text-decoration: none; 
            padding: 10px 20px; 
            border-radius: 8px; 
            font-weight: bold;
            font-size: 1rem;
            transition: background 0.3s ease;">
            ⬅️ Ana Sayfaya Dön
        </a>
    </div>

    <!-- Başlık ve Açıklama -->
    <h1>Favori Tariflerim</h1>
    <p class="description">Favoriye eklediğiniz tarifler burada listelenir. En sevdiğiniz lezzetler bir tık uzağınızda!</p>

    <!-- Tarifler -->
    <section class="tarifler">
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="tarif-kutusu">';
            echo '<img src="' . $row["resim"] . '" alt="Tarif Resmi">';
            echo '<h3>' . htmlspecialchars($row["isim"]) . '</h3>';
            echo '<p>' . htmlspecialchars($row["aciklama"]) . '</p>';

            // Favoriden Çıkar Butonu
            echo '<form method="POST" action="remove_favorite.php" style="margin-top: 10px;">';
            echo '<input type="hidden" name="recipe_id" value="' . $row["id"] . '">';
            echo '<button type="submit" style="
                background-color: #ff3e3e; 
                color: white; 
                border: none; 
                padding: 8px 15px; 
                border-radius: 5px; 
                cursor: pointer; 
                font-weight: bold;
                transition: background 0.3s ease;">';
            echo '❌ Favoriden Çıkar</button>';
            echo '</form>';

            echo '</div>';
        }
    } else {
        echo "<p>Henüz favori tarif eklemediniz!</p>";
    }
    ?>
</section>

</body>
</html>
