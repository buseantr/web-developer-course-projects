<?php
session_start();

// Kullanıcı oturumu kontrolü
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

// Tarif ID'si kontrolü
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recipe_id'])) {
    $recipe_id = intval($_POST['recipe_id']);
    $username = $_SESSION['username'];

    // Kullanıcı ID'sini al
    $user_query = "SELECT id FROM users WHERE username = '$username'";
    $user_result = $conn->query($user_query);

    if ($user_result && $user_result->num_rows > 0) {
        $user_id = $user_result->fetch_assoc()['id'];

        // Favoriden çıkar
        $delete_query = "DELETE FROM favorites WHERE user_id = $user_id AND recipe_id = $recipe_id";
        if ($conn->query($delete_query) === TRUE) {
            echo "<script>
                alert('Tarif favorilerden çıkarıldı!');
                window.location.href = 'my_recipes.php';
            </script>";
        } else {
            echo "Hata: " . $conn->error;
        }
    } else {
        echo "Kullanıcı bulunamadı!";
    }
}

$conn->close();
?>
