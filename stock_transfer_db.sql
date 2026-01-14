-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2025 at 02:06 AM
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

--
-- Dumping data for table `multipleserial_transfers`
--

INSERT INTO `multipleserial_transfers` (`id`, `stock_no`, `date`, `account_name`, `from_location`, `to_location`, `quantity`, `unit`, `description`, `model`, `serial_no`, `mr`, `delivered_by`, `created_at`) VALUES
(19, '1234', '2025-12-06', 'BSP', 'North-east', 'BSP TOWER', '[\"1\"]', '[\"pc\"]', '[\"Toner\"]', '[\"APIV - C5575\"]', '[\"1234\",\"2222\",\"3333\"]', '[\"1111\",\"2222\",\"1231\"]', 'Jay', '2025-12-02 01:23:32'),
(20, '111222', '2025-12-03', 'BSP', 'North-east', 'BSP', '[\"1\"]', '[\"pc\"]', '[\"Toner\"]', '[\"APIV - C5575\"]', '[\"11\",\"222\",\"321\"]', '[\"111\",\"221\",\"123\"]', 'Jay', '2025-12-03 00:55:55');

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
-- Dumping data for table `stock_transfers`
--

INSERT INTO `stock_transfers` (`id`, `stock_no`, `date`, `account_name`, `from_location`, `to_location`, `quantity`, `unit`, `description`, `mr`, `model`, `serial_no`, `tech`, `prno`, `delivered_by`, `received_by`, `created_at`) VALUES
(11, '1231', '2025-12-09', 'OTUS', 'North-east', 'OTUS TOWER', '[\"1\",\"2\"]', '[\"PC\",\"PC\"]', '[\"Toner Cartridge\",\"DRUM\"]', '2131', '12312', '12312', 'Jay', '1211', '', '', '2025-12-02 01:25:00'),
(12, '123', '2025-12-03', 'Sample', 'North-east', 'Sample Address', '[\"1\",\"1\"]', '[\"pc\",\"pc\"]', '[\"Toner\",\"Toner Cartridge\"]', '123456', 'APV - C5576', '0123123', 'Tech', '', '', '', '2025-12-03 00:19:21'),
(13, '1235', '2025-12-03', 'Sample', 'North-east', 'Sample Address', '[\"1\",\"1\"]', '[\"pc\",\"pc\"]', '[\"Toner\",\"Toner Cartridge\"]', '123456', 'APV - C5576', '0123123', 'Tech', '', '', '', '2025-12-03 00:33:46'),
(14, '222', '2025-12-03', 'Account Sample', 'North-east', 'Sample Address', '[\"1\",\"1\"]', '[\"pc\",\"pc \"]', '[\"Toner\",\"Drum\"]', '1111', '1123', '112233', 'Jay', '', '', '', '2025-12-03 00:34:32'),
(15, '2225', '2025-12-03', 'Account Sample', 'North-east', 'Sample Address', '[\"1\",\"1\"]', '[\"pc\",\"pc \"]', '[\"Toner\",\"Drum\"]', '1111', '1123', '112233', 'Jay', '', '', '', '2025-12-03 00:34:54'),
(16, '22252', '2025-12-03', 'Account Sample', 'North-east', 'Sample Address', '[\"1\",\"1\"]', '[\"pc\",\"pc \"]', '[\"Toner\",\"Drum\"]', '1111', '1123', '112233', 'Jay', '', '', '', '2025-12-03 00:38:03'),
(17, '123132', '2025-12-03', '23213', 'North-east', '1231', '[\"11\"]', '[\"323\"]', '[\"232\"]', '12312', '3213', '21123', '1231', '', '', '', '2025-12-03 00:38:22'),
(18, '1231321', '2025-12-03', '23213', 'North-east', '1231', '[\"11\"]', '[\"323\"]', '[\"232\"]', '12312', '3213', '21123', '1231', '12321', '', '', '2025-12-03 00:38:27'),
(19, '12313213', '2025-12-03', '23213', 'North-east', '1231', '[\"11\"]', '[\"323\"]', '[\"232\"]', '12312', '3213', '21123', '1231', '12321', '', '', '2025-12-03 00:44:07'),
(20, '123132132', '2025-12-03', '23213', 'North-east', '1231', '[\"11\"]', '[\"323\"]', '[\"232\"]', '12312', '3213', '21123', '1231', '12321', '', '', '2025-12-03 00:47:15');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
