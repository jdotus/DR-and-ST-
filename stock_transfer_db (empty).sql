-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 01:35 AM
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
-- Database: `stock_transfer_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `multipleserial_transfers`
--

CREATE TABLE `multipleserial_transfers` (
  `id` int(11) NOT NULL,
  `stock_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `account_name` varchar(100) DEFAULT NULL,
  `from_location` varchar(100) DEFAULT NULL,
  `to_location` varchar(255) DEFAULT NULL,
  `quantity` text DEFAULT NULL,
  `unit` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `model` text DEFAULT NULL,
  `serial_no` text DEFAULT NULL,
  `mr` text DEFAULT NULL,
  `delivered_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfers`
--

CREATE TABLE `stock_transfers` (
  `id` int(11) NOT NULL,
  `stock_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `account_name` varchar(100) DEFAULT NULL,
  `from_location` varchar(100) DEFAULT NULL,
  `to_location` varchar(255) DEFAULT NULL,
  `quantity` text DEFAULT NULL,
  `unit` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `mr` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `serial_no` varchar(100) DEFAULT NULL,
  `tech` varchar(100) DEFAULT NULL,
  `prno` varchar(100) DEFAULT NULL,
  `delivered_by` varchar(100) DEFAULT NULL,
  `received_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `multipleserial_transfers`
--
ALTER TABLE `multipleserial_transfers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_no` (`stock_no`);

--
-- Indexes for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `multipleserial_transfers`
--
ALTER TABLE `multipleserial_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
