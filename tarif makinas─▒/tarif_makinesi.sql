-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 21 Ara 2024, 15:56:39
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `tarif_makinesi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `destek_talepleri`
--

CREATE TABLE `destek_talepleri` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `konu` varchar(100) DEFAULT NULL,
  `mesaj` text DEFAULT NULL,
  `talep_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `destek_talepleri`
--

INSERT INTO `destek_talepleri` (`id`, `username`, `konu`, `mesaj`, `talep_tarihi`) VALUES
(1, 'baba', 'yemek', 'bence daha fazla yemek olabilir', '2024-12-17 01:25:38'),
(2, 'enes', 'allah', 'allah123', '2024-12-17 12:01:09');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `recipe_id`) VALUES
(3, 6, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tarifler`
--

CREATE TABLE `tarifler` (
  `id` int(11) NOT NULL,
  `isim` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `resim` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `tarifler`
--

INSERT INTO `tarifler` (`id`, `isim`, `aciklama`, `resim`) VALUES
(1, 'Tavuklu Pilav', 'Lezzetli ve kolay tarif.', 'images/tavukpilav.jpg'),
(2, 'Karnıyarık', 'Türk mutfağının lezzeti.', 'images/karnıyarık.jpg'),
(3, 'Lazanya', 'İtalyan mutfağından.', 'images/lazanya.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'sedaa', '$2y$10$CdqW30qGgm3QPZqiiuOGVu01MYqGirOJlvZngZff/58cXjFFSCtii'),

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `destek_talepleri`
--
ALTER TABLE `destek_talepleri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Tablo için indeksler `tarifler`
--
ALTER TABLE `tarifler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `destek_talepleri`
--
ALTER TABLE `destek_talepleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Tablo için AUTO_INCREMENT değeri `tarifler`
--
ALTER TABLE `tarifler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `tarifler` (`id`);
COMMIT;
ALTER TABLE tarifler ADD COLUMN malzemeler TEXT AFTER aciklama;
ALTER TABLE tarifler ADD COLUMN yapilis TEXT AFTER malzemeler;
UPDATE tarifler SET 
malzemeler = 'Tavuk, Pirinç, Tereyağı, Tuz, Su', 
yapilis = '1. Pirinci yıkayın ve bekletin.\n2. Tavukları haşlayın ve didikleyin.\n3. Pirinci kavurup üzerine su ekleyerek pişirin.\n4. Tavukları üzerine ekleyerek servis yapın.' 
WHERE id = 1;

UPDATE tarifler SET 
malzemeler = 'Kıyma, Patlıcan, Domates, Soğan, Sarımsak, Baharatlar', 
yapilis = '1. Patlıcanları kesin ve kızartın.\n2. Kıymayı soğan ile kavurun.\n3. Harcı patlıcanların içine doldurun ve fırında pişirin.' 
WHERE id = 2;

UPDATE tarifler SET 
malzemeler = 'Lazanya yaprağı, Kıyma, Domates Sos, Beşamel Sos, Kaşar', 
yapilis = '1. Harcı kıyma ile hazırlayın.\n2. Kat kat lazanya yapraklarını tepsiye dizin.\n3. Harcı ve beşamel sosu ekleyin.\n4. Üzerine kaşar ekleyip fırında pişirin.' 
WHERE id = 3;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
