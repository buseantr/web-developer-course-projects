<?php
if (!function_exists('showNotification')) {
    function showNotification() {
        if (isset($_SESSION['notification'])) {
            echo '<div id="notification" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #ff6f61;
                color: white;
                padding: 10px 20px;
                border-radius: 5px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                z-index: 1000;
                font-size: 1rem;
                opacity: 1;
                transition: opacity 1s ease-out;">
                ' . htmlspecialchars($_SESSION['notification']) . '
            </div>';

            unset($_SESSION['notification']);
        }
    }
}
?>
