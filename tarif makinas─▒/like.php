
<?php
session_start();
include 'functions.php'; // Bildirim fonksiyonunu dahil et

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

// Favoriye ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recipe_id'])) {
    $recipe_id = intval($_POST['recipe_id']);
    $username = $_SESSION['username'];

    // Kullanıcının ID'sini al
    $user_query = "SELECT id FROM users WHERE username = '$username'";
    $user_result = $conn->query($user_query);

    if ($user_result && $user_result->num_rows > 0) {
        $user_id = $user_result->fetch_assoc()['id'];

        // Tarifi favorilere ekle
        $check_query = "SELECT * FROM favorites WHERE user_id = $user_id AND recipe_id = $recipe_id";
        $check_result = $conn->query($check_query);

        if ($check_result->num_rows == 0) {
            $insert_query = "INSERT INTO favorites (user_id, recipe_id) VALUES ($user_id, $recipe_id)";
            if ($conn->query($insert_query) === TRUE) {
                $_SESSION['notification'] = "Tarif favorilere eklendi!";
            } else {
                $_SESSION['notification'] = "Bir hata oluştu, lütfen tekrar deneyin.";
            }
        } else {
            $_SESSION['notification'] = "Bu tarifi zaten favorilere eklediniz!";
        }
    }
}

$conn->close();
header("Location: index.php");
exit;
?>
