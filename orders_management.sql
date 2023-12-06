-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2023 at 07:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orders_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_type` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_area` decimal(10,2) NOT NULL,
  `a4_needed` int(11) DEFAULT NULL,
  `total_supply` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_type`, `size`, `quantity`, `total_area`, `a4_needed`, `total_supply`, `created_at`) VALUES
(43, 'Sticker Printing', '5x5', 1, 25.00, 1, 10, '2023-12-04 17:20:25'),
(44, 'Label Printing', 'Small', 1, 10.00, 1, 10, '2023-12-04 17:29:59'),
(45, 'Sticker Printing', '10x7', 20, 1400.00, 3, 10, '2023-12-04 20:52:09'),
(46, 'Proof Reading', 'Advanced', 1, 40.00, 1, 10, '2023-12-04 20:53:38'),
(56, 'Sticker Printing', '5x5', 1, 25.00, 1, 69, '2023-12-06 16:40:17'),
(57, 'Sticker Printing', '5x5', 1, 25.00, 1, 70, '2023-12-06 21:00:51'),
(58, 'Sticker Printing', '5x5', 6, 150.00, 1, 70, '2023-12-07 01:21:02'),
(59, 'Sticker Printing', '5x5', 1, 25.00, 1, 70, '2023-12-07 01:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `supplies`
--

CREATE TABLE `supplies` (
  `supply_id` int(11) NOT NULL,
  `supply_name` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `purchase_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplies`
--

INSERT INTO `supplies` (`supply_id`, `supply_name`, `quantity`, `purchase_date`) VALUES
(9, 'Sticker Paper', 70, '2023-12-05'),
(10, 'Photo Paper', 18, '2023-12-05'),
(26, 'Laminated Paper', 5, '2023-12-06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `supplies`
--
ALTER TABLE `supplies`
  ADD PRIMARY KEY (`supply_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `supplies`
--
ALTER TABLE `supplies`
  MODIFY `supply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
