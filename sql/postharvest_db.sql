-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 08:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `postharvest_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `loss_reports`
--

CREATE TABLE `loss_reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `crop_type` varchar(100) NOT NULL,
  `loss_stage` varchar(100) NOT NULL,
  `loss_amount` varchar(50) NOT NULL,
  `loss_reason` varchar(100) NOT NULL,
  `date_submitted` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loss_reports`
--

INSERT INTO `loss_reports` (`id`, `user_id`, `crop_type`, `loss_stage`, `loss_amount`, `loss_reason`, `date_submitted`) VALUES
(1, 5, 'Banana', 'postharvest storage', '25 kg', 'rot', '2025-05-03'),
(2, 5, 'Citrus', 'harvesting', '60 kg', 'insect damage', '2025-05-03'),
(3, 5, 'Citrus', 'harvesting', '60 kg', 'insect damage', '2025-05-03');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `sustainability_rating` int(11) NOT NULL,
  `source_provider` varchar(100) NOT NULL,
  `recommended_by` varchar(100) NOT NULL,
  `date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `category`, `description`, `sustainability_rating`, `source_provider`, `recommended_by`, `date_added`) VALUES
(1, 'Solar-powered cold storage', 'Equipment', 'Storage unit to reduce spoilage, portable and solar-powered', 5, 'Agritech Solar Solutions', 'DA Research Unit', '2025-05-04'),
(2, 'Bacillus subtilis-based Biofungicide', 'Biological control agent (Bacteria)', 'Rhizobacteria, naturally occurring, suppresses fungal pathogens (e.g. Fusarium, Botrytis): applied as foliar spray or seed treatment', 4, 'BIOTECH, private biopesticide suppliers like BioAgriTech', 'DA Research Unit', '2025-05-04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'farmer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'Angelo', '$2y$10$Fb3uBfymb/bXKwDxgjatdeBQ.SwKj4LnjPLBpLOYlc5OYghrqk.vS', 'farmer'),
(2, 'Angelo', '$2y$10$FHZPW1d7WgPFXlF3hvmxFOAXuuAkYbhyfH0HRBSNIFHA7rLd7jAVm', 'farmer'),
(3, 'Angelo', '$2y$10$2pBBMAKZj9OAF.oYp5zplOEQq31mbhn2s.LanfDyb0Y.IxoZng9V2', 'farmer'),
(4, 'Angelo', '$2y$10$K.plxSTt2aVrfatTpeB1HuI9EFZ71YcqB.ihgFQZkQHBxhWWc25aC', 'farmer'),
(5, 'Gloria', '$2y$10$GCv3B/NOI6ztkmC6QzaBV.aR2I0zWbVWGBskJUYAb3ScSnQcA2.Ru', 'farmer'),
(6, 'Banjo', '$2y$10$H0..ALISfAptmwbXXKS9lu.7xY0.pxCQ1aw7dkZJSdWf2J5kZa.8.', 'farmer'),
(7, 'Mang Ensiong', '$2y$10$gX.f9cHpw60JMZUSlDoI7OkwKzS0HXWzte/YNtROQtOQgPsVqsVMW', 'researcher'),
(8, 'Densio', '$2y$10$jkAUNtw6e7C.px0cDEstbeRdrMFb8aTOjP.1Gcdz/Kci/uSpuvF0y', 'farmer'),
(9, 'Jackie', '$2y$10$WXnuTmFx2yp.nq50SruLh.p0J8YmR.yH25gbiVe36PGTL3rS1B0p.', 'researcher'),
(10, 'Dongdeveloper', '$2y$10$gaQVvvNtnDgx3bNwlCR4ueI5snkVJ1WjamZT8G4RAgy2UZIXSNPEO', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loss_reports`
--
ALTER TABLE `loss_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `loss_reports`
--
ALTER TABLE `loss_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loss_reports`
--
ALTER TABLE `loss_reports`
  ADD CONSTRAINT `loss_reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
