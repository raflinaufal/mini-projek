-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Nov 2024 pada 07.52
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tes_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`, `created_at`, `updated_at`) VALUES
(19, 'das', '1.00', 'd', '57dd20d073dfe94236ffdda3f88eebdd.png', '2024-11-22 00:01:06', '2024-11-22 00:25:17'),
(24, 'jakarta', '323.00', 'bjh', 'de67806419f79ca8fdb898d9462d142b.png', '2024-11-22 00:34:32', '2024-11-22 00:34:32'),
(25, 'Rumah', '12121212.00', 'dasd', '4c28d5f3371f61924f52c4e9c75473e8.png', '2024-11-22 00:58:19', '2024-11-22 00:58:19'),
(26, 'dasd', '2323.00', '2323', 'e2b337f1d9a7055ea350e11c75b6c9c4.png', '2024-11-22 00:58:32', '2024-11-22 00:58:32'),
(27, 'testing', '20000.00', 'hjghghjg', 'ea94d135ad60297a1b2d396dd32ec75f.png', '2024-11-22 01:16:53', '2024-11-22 01:16:53'),
(28, 'tanah', '99999999.99', 'kwkwkwkwk', '7f5e81a5cfd994a2ece2c6d7452fbf0f.png', '2024-11-22 03:24:27', '2024-11-22 03:24:27'),
(29, 'dsad', '111.00', 'sadsad', '2dcae5db3c78dc537ab41428df479507.png', '2024-11-22 03:25:47', '2024-11-22 03:25:47'),
(30, 'dasd', '23412.00', 'dasda', '3c46f12c1e0b0ea1e9b68e21db260abd.png', '2024-11-22 03:26:16', '2024-11-22 03:26:16'),
(31, 'asdasd', '1212.00', 'dasdasd', '5ec5254830cb8d4dc7609f0b3278780f.png', '2024-11-22 03:26:49', '2024-11-22 03:26:49'),
(32, 'kemplang', '121323.00', 'vsdvdsf', 'f86dcd3f5ad6a61f7e85d939860a6167.png', '2024-11-22 03:27:23', '2024-11-22 03:27:23'),
(33, 'dasd', '23123.00', 'vsvdvsdv', 'ed168289eb73b5fc94838213448be49b.png', '2024-11-22 03:27:38', '2024-11-22 03:27:38');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
