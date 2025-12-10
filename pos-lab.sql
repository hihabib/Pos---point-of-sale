-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 10, 2025 at 11:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos-lab`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `serial` varchar(100) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock_quantity`, `serial`, `unit`, `created_at`, `updated_at`) VALUES
(2, 'Ruchi Chanacur', 95.00, 50, '1', 'piece', '2025-12-10 09:14:45', NULL),
(3, 'Bashmoti chal', 500.00, 144, '2', 'kg', '2025-12-10 09:15:02', '2025-12-10 09:30:30'),
(4, 'Ruchi BBQ Chanachur', 149.00, 100, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(5, 'Ruchi Chanachur Hot', 149.00, 100, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(6, 'Pran UHT Milk 1 L', 100.00, 50, NULL, 'liter', '2025-12-10 09:30:13', NULL),
(7, 'Pran Full Cream Milk Powder 1 kg', 500.00, 30, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(8, 'Pran Mixed Pickle 400 g', 182.00, 40, NULL, 'jar', '2025-12-10 09:30:13', NULL),
(9, 'Pran Mung Dal 1 kg', 183.00, 25, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(10, 'Pran Olive Pickle 400 g', 184.00, 35, NULL, 'jar', '2025-12-10 09:30:13', NULL),
(11, 'Pran Mango Pickle 1 kg', 377.00, 20, NULL, 'jar', '2025-12-10 09:30:13', NULL),
(12, 'Pran Kabab Masala 50 g', 50.00, 60, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(13, 'Pran Litchi Drink 250 ml', 25.00, 200, NULL, 'bottle', '2025-12-10 09:30:13', NULL),
(14, 'Pran Frooto Mango Drink 250 ml', 25.00, 200, NULL, 'bottle', '2025-12-10 09:30:13', NULL),
(15, 'Pran Instant Noodles Beef 5×75 g', 75.00, 80, NULL, 'pack', '2025-12-10 09:30:13', NULL),
(16, 'Pran Instant Noodles Chicken 5×75 g', 75.00, 80, NULL, 'pack', '2025-12-10 09:30:13', NULL),
(17, 'Chicken Eggs Layer 12 pcs', 119.00, 150, NULL, 'dozen', '2025-12-10 09:30:13', NULL),
(18, 'Deshi Peyaj (Onion) 1 kg', 145.00, 40, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(19, 'Badhakopi (Cabbage) 1 kg', 49.00, 30, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(20, 'Fulkopi (Cauliflower) 1 kg', 49.00, 25, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(21, 'Flat Bean (Sheem) 1 kg', 35.00, 20, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(22, 'Mula (Radish) 1 kg', 45.00, 20, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(23, 'Narikel (Coconut) 1 pc', 159.00, 50, NULL, 'piece', '2025-12-10 09:30:13', NULL),
(24, 'Shagor Kola (Banana) 1 kg', 45.00, 50, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(25, 'Guava Premium 1 kg', 119.00, 30, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(26, 'Bangla Kola 1 kg', 39.00, 39, NULL, 'kg', '2025-12-10 09:30:13', '2025-12-10 09:52:50'),
(27, 'Broiler Chicken 1 kg', 269.00, 19, NULL, 'kg', '2025-12-10 09:30:13', '2025-12-10 09:48:32'),
(28, 'Cumin (Jira) 100 g', 85.00, 50, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(29, 'Cardamom (Elachi) 50 g', 139.00, 25, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(30, 'Radhuni Cumin Powder 100 g', 160.00, 30, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(31, 'Radhuni Coriander Powder 100 g', 110.00, 30, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(32, 'Turmeric Powder 100 g', 90.00, 40, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(33, 'Red Chili Powder 100 g', 120.00, 35, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(34, 'Fresh Rice Bran Oil 5 L', 879.00, 15, NULL, 'liter', '2025-12-10 09:30:13', NULL),
(35, 'Buniyadi Mustard Oil 500 ml', 125.00, 40, NULL, 'bottle', '2025-12-10 09:30:13', NULL),
(36, 'Miniket Rice 5 kg', 375.00, 20, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(37, 'Najirshail Rice 5 kg', 360.00, 20, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(38, 'Atta (Flour) 2 kg', 90.00, 24, NULL, 'kg', '2025-12-10 09:30:13', '2025-12-10 09:52:50'),
(39, 'Maida 2 kg', 85.00, 25, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(40, 'Sugar 1 kg', 65.00, 50, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(41, 'Salt Iodized 1 kg', 35.00, 60, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(42, 'Ghee 500 g', 195.00, 15, NULL, 'jar', '2025-12-10 09:30:13', NULL),
(43, 'Semolina (Suji) 1 kg', 75.00, 30, NULL, 'kg', '2025-12-10 09:30:13', NULL),
(44, 'Ispahani Mirzapore Best Leaf 500 g', 270.00, 20, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(45, 'Ispahani Blender’s Choice 200 g', 145.00, 30, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(46, 'Tata Tea Premium 500 g', 149.00, 25, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(47, 'Fresh Tea Dust 400 g', 95.00, 25, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(48, 'STG Premium Tea 1 kg', 350.00, 10, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(49, 'Kazi & Kazi Tea 250 g', 162.00, 15, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(50, 'Danish Tea 500 g', 149.00, 20, NULL, 'packet', '2025-12-10 09:30:13', NULL),
(51, 'Acme Pure Honey 250 g', 180.00, 17, NULL, 'jar', '2025-12-10 09:30:13', '2025-12-10 09:48:32'),
(52, 'Rupchanda Soyabean Oil 5 L', 955.00, 10, NULL, 'liter', '2025-12-10 09:30:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `sale_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `total_amount`, `sale_date`, `created_at`) VALUES
(1, 69500.00, '2025-12-10 09:15:39', '2025-12-10 09:15:39'),
(2, 809.00, '2025-12-10 09:48:32', '2025-12-10 09:48:32'),
(3, 129.00, '2025-12-10 15:52:50', '2025-12-10 09:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `quantity`, `unit_price`, `subtotal`) VALUES
(1, 1, 3, 139, 500.00, 69500.00),
(2, 2, 51, 3, 180.00, 540.00),
(3, 2, 27, 1, 269.00, 269.00),
(4, 3, 38, 1, 90.00, 90.00),
(5, 3, 26, 1, 39.00, 39.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `role` enum('outlet','manager') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'manager', '0795151defba7a4b5dfa89170de46277', 'manager', '2025-12-10 09:13:35'),
(2, 'outlet', '389f85aaf486a20885c42af202b3307f', 'outlet', '2025-12-10 09:13:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sale_items_sale_id` (`sale_id`),
  ADD KEY `idx_sale_items_product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `fk_sale_items_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sale_items_sales` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
