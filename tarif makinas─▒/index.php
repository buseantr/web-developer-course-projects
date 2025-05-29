

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'functions.php'; // Bildirim fonksiyonunu ekle
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php


// Kullanıcı oturumu kontrolü
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: login.php"); // Giriş yapılmadıysa giriş sayfasına yönlendir
    exit;
}

?>
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
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<header style="
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    padding: 20px 50px; 
    background: linear-gradient(to right, #ff6f61, #ff9463); 
    color: white; 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <div>
        <h1 style="margin: 0; font-size: 1.8rem;">Tarif Makinası</h1>
    </div>
    <div style="text-align: right;">
        <p style="margin: 0; font-size: 1.1rem; font-weight: 500;">
            Hoş geldin, <span style="font-weight: bold;"><?php echo htmlspecialchars($username); ?></span>!
        </p>
        <a href="logout.php" style="
            display: inline-block; 
            margin-top: 5px; 
            padding: 8px 15px; 
            background-color: #ff3e3e; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s ease;">
            Çıkış Yap
        </a>
    </div>
</header>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarif Makinası</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Dark Mode Teması */
body.dark-mode {
    background-color: #121212;
    color: #f5f5f5;
}

.dark-mode header {
    background: linear-gradient(to right, #333, #444);
}

.dark-mode nav {
    background-color: #222;
}

.dark-mode nav a {
    color: #f5f5f5;
}

.dark-mode .hero {
    background: linear-gradient(to right, #333, #444);
}

.dark-mode .tarif-kutusu {
    background: #1e1e1e;
    color: #f5f5f5;
    border: 1px solid #444;
}

.dark-mode button {
    background-color: #555;
    color: white;
}

        /* Switch Butonu Stili */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 30px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 30px;
}

.slider:before {
    position: absolute;
    content: "☀️"; /* Varsayılan: Güneş */
    font-size: 14px;
    line-height: 30px;
    text-align: center;
    height: 24px;
    width: 24px;
    left: 4px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
    color: #333;
}

input:checked + .slider {
    background-color: #555; /* Dark mode için arka plan */
}

input:checked + .slider:before {
    transform: translateX(28px);
    content: "🌙"; /* Dark Mode: Ay */
    color: #fff; /* Ay sembolü beyaz olacak */
}

        /* Genel Ayarlar */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #f9f9f9, #f1f1f1);
            color: #333;
        }

        /* Navbar */
        nav {
            background-color: #ff6f61;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        nav a {
            text-decoration: none;
            color: white;
            font-weight: 600;
            margin: 0 1rem;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #ffe8e2;
        }

        /* Hero Bölümü */
        .hero {
            text-align: center;
            padding: 5rem 2rem;
            background: linear-gradient(to right, #ff6f61, #ff9463);
            color: white;
        }

        .hero h1 {
            margin: 0;
            font-size: 3.5rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.2rem;
            margin-top: 1rem;
        }

        /* Tarif Kartları */
        .tarifler {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 2rem;
        }

        .tarif-kutusu {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 300px;
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
            margin: 5px 10px 15px;
            color: #666;
            font-size: 1rem;
        }

        .tarif-kutusu:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem 0;
            font-size: 0.9rem;
        }
        
    </style>
</head>
<body>
<?php showNotification(); ?>

    <!-- Navbar -->
     
    <nav>
        
    <div>
        <a href="index.php">Ana Sayfa</a>
        <a href="my_recipes.php">Tariflerim</a>
        <a href="support.php">Destek Talep</a>

    </div>
    <div style="text-align: right; margin-right: 20px;">
    <label class="switch">
        <input type="checkbox" id="themeToggle">
        <span class="slider round"></span>
    </label>
</div>

</nav>


    <!-- Hero Bölümü -->
    <section class="hero">
        <h1>Lezzetli Tarifler Sizi Bekliyor!</h1>
        <p>En popüler yemek tariflerine göz atın ve mutfakta harikalar yaratın.</p>
    </section>
    <div style="text-align: center; margin: 20px;">
    <form method="GET" action="index.php" style="display: inline-block;">
        <input type="text" name="search" placeholder="Tarif ara..." 
            style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; width: 250px; font-size: 1rem;">
        <button type="submit" style="
            padding: 10px 15px; 
            background-color: #ff6f61; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            font-size: 1rem;
            cursor: pointer;">
            Ara
        </button>
    </form>
</div>


    <!-- Tarif Kartları -->
    <section class="tarifler">
    <?php
    
    // Arama kontrolü
    $sql = "SELECT * FROM tarifler"; // Varsayılan tüm tarifleri göster
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $conn->real_escape_string($_GET['search']);
        $sql = "SELECT * FROM tarifler WHERE isim LIKE '%$search%'";
    }

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<a href="details.php?id=' . $row["id"] . '" style="text-decoration: none;">'; // Detay sayfası bağlantısı
            echo '<div class="tarif-kutusu">';
            echo '<img src="' . $row["resim"] . '" alt="Tarif Resmi">';
            echo '<h3>' . htmlspecialchars($row["isim"]) . '</h3>';
            echo '<p>' . htmlspecialchars($row["aciklama"]) . '</p>';
            echo '</div>';
            echo '</a>';
            
            // Beğen Butonu
            echo '<div style="text-align: center; margin-top: 10px;">';
            echo '<form method="POST" action="like.php">';
            echo '<input type="hidden" name="recipe_id" value="' . $row["id"] . '">';
            echo '<button type="submit" style=" 
                background-color: #ff6f61; 
                color: white; 
                border: none; 
                padding: 8px 15px; 
                border-radius: 5px; 
                cursor: pointer; 
                font-weight: bold;
                transition: background 0.3s ease;">
                ❤️ Beğen
                </button>';
            echo '</form>';
            echo '</div>';

            echo '</div>';
        }
    } else {
        echo "<p style='text-align: center; font-size: 1.2rem; color: #666;'>Arama sonucu bulunamadı!</p>";
    }
    ?>
    
</section>





    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Tarif Makinası | Tüm Hakları Saklıdır</p>
    </footer>
    <script>
    // Sayfa yüklendikten sonra bildirimi yavaşça kaybet
    document.addEventListener("DOMContentLoaded", function() {
        const notification = document.getElementById("notification");
        if (notification) {
            setTimeout(() => {
                notification.style.opacity = "0";
            }, 2000); // 3 saniye sonra kaybolmaya başla

            // Bildirim tamamen kaybolunca DOM'dan kaldır
            setTimeout(() => {
                notification.remove();
            }, 4000); // 4 saniye sonra tamamen sil
        }
    });
</script>
<script>
    const themeToggle = document.getElementById("themeToggle"); // Switch butonu
    const body = document.body;

    // Tarayıcıdaki tema tercihini kontrol et
    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("dark-mode");
        themeToggle.checked = true; // Switch butonunu açık konuma getir
    }

    // Tema geçişi ve localStorage kaydı
    themeToggle.addEventListener("change", () => {
        if (themeToggle.checked) {
            body.classList.add("dark-mode");
            localStorage.setItem("theme", "dark");
        } else {
            body.classList.remove("dark-mode");
            localStorage.setItem("theme", "light");
        }
    });
</script>

</body>
</html>
