-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 24, 2017 at 01:05 PM
-- Server version: 5.6.31-log
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

CREATE TABLE `account_type` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` (`id`, `name`, `description`) VALUES
(1, 'asset accounts', 'for later'),
(2, 'liability accounts', 'for later'),
(3, 'equity accounts', 'for later'),
(4, 'revenue accounts', 'for later'),
(5, 'expense accounts', 'for later');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT '1',
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'cat 3', '2017-11-08 00:33:48', '2017-11-21 22:33:59', NULL, NULL),
(2, 'cat2', '2017-11-08 00:33:57', '0000-00-00 00:00:00', NULL, NULL),
(3, 'dfaf', '2017-11-21 19:24:53', NULL, 1, NULL),
(4, 'New Cat', '2017-11-21 22:28:03', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `client_name` varchar(45) NOT NULL,
  `phone` int(11) NOT NULL,
  `address` text NOT NULL,
  `account_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `client_name`, `phone`, `address`, `account_id`) VALUES
(3, 'Mohammed Taha', 987654321, '', 8),
(4, 'Ahmed Taha', 98283848, '', 9),
(5, 'Cash', 987654321, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `client_account`
--

CREATE TABLE `client_account` (
  `id` int(11) NOT NULL,
  `account_no` varchar(45) NOT NULL,
  `client_account_name` varchar(45) NOT NULL,
  `system_account_id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `opening_balance` decimal(18,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(18,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `entry`
--

CREATE TABLE `entry` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `is_depit` enum('yes','no') NOT NULL DEFAULT 'yes',
  `amount` float(18,2) NOT NULL,
  `description` varchar(100) NOT NULL DEFAULT 'Entry Description',
  `date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `balance` decimal(18,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `entry`
--

INSERT INTO `entry` (`id`, `transaction_id`, `account_id`, `is_depit`, `amount`, `description`, `date`, `timestamp`, `balance`) VALUES
(17, 6, 1, 'yes', 222.00, 'Cash Increased because of selling products in this invoice', '2017-11-14', '2017-11-14 20:32:04', '222.00'),
(18, 6, 5, 'no', 222.00, 'Revenue is been counted for this sale', '2017-11-14', '2017-11-14 20:32:04', '222.00'),
(19, 6, 7, 'yes', 166.00, 'Cost is been counted for this sale', '2017-11-14', '2017-11-14 20:32:04', '166.00'),
(20, 6, 11, 'no', 166.00, 'Cost of products for this sale', '2017-11-14', '2017-11-14 20:32:05', '834.00'),
(21, 8, 1, 'yes', 50.00, 'Cash Increased because of selling products in this invoice', '2017-11-14', '2017-11-14 20:51:16', '272.00'),
(22, 8, 8, 'yes', 24.00, 'recievable Cash Increased because of selling products in this invoice', '2017-11-14', '2017-11-14 20:51:16', '24.00'),
(23, 8, 5, 'no', 74.00, 'Revenue is been counted for this sale', '2017-11-14', '2017-11-14 20:51:17', '296.00'),
(24, 8, 7, 'yes', 62.00, 'Cost is been counted for this sale', '2017-11-14', '2017-11-14 20:51:17', '228.00'),
(25, 8, 11, 'no', 62.00, 'Cost of products for this sale', '2017-11-14', '2017-11-14 20:51:17', '772.00'),
(26, 9, 9, 'yes', 14.00, 'recievable Cash Increased because of selling products in this invoice', '2017-11-14', '2017-11-14 20:55:46', '14.00'),
(27, 9, 5, 'no', 14.00, 'Revenue is been counted for this sale', '2017-11-14', '2017-11-14 20:55:46', '310.00'),
(28, 9, 7, 'yes', 12.00, 'Cost is been counted for this sale', '2017-11-14', '2017-11-14 20:55:47', '240.00'),
(29, 9, 11, 'no', 12.00, 'Cost of products for this sale', '2017-11-14', '2017-11-14 20:55:47', '760.00'),
(30, 10, 1, 'yes', 14.00, 'Cash Increased because of selling products in this invoice', '2017-11-14', '2017-11-14 20:58:06', '286.00'),
(31, 10, 5, 'no', 14.00, 'Revenue is been counted for this sale', '2017-11-14', '2017-11-14 20:58:06', '324.00'),
(32, 10, 7, 'yes', 12.00, 'Cost is been counted for this sale', '2017-11-14', '2017-11-14 20:58:07', '252.00'),
(33, 10, 11, 'no', 12.00, 'Cost of products for this sale', '2017-11-14', '2017-11-14 20:58:07', '748.00'),
(34, 11, 2, 'yes', 1.00, 'Cash Increased because of selling products in this invoice', '2017-11-17', '2017-11-17 13:59:44', '1.00'),
(35, 11, 9, 'no', 1.00, 'recievable Amount decreased for paying this invoice', '2017-11-17', '2017-11-17 13:59:44', '13.00'),
(36, 12, 1, 'yes', 6.00, 'Cash Increased because of selling products in this invoice', '2017-11-17', '2017-11-17 14:01:45', '292.00'),
(37, 12, 9, 'no', 6.00, 'recievable Amount decreased for paying this invoice', '2017-11-17', '2017-11-17 14:01:46', '7.00'),
(38, 13, 1, 'yes', 1.00, 'Cash Increased because of selling products in this invoice', '2017-11-17', '2017-11-17 14:13:32', '293.00'),
(39, 13, 9, 'no', 1.00, 'recievable Amount decreased for paying this invoice', '2017-11-17', '2017-11-17 14:13:32', '6.00'),
(40, 14, 1, 'yes', 1.00, 'Cash Increased because of selling products in this invoice', '2017-11-17', '2017-11-17 14:41:39', '294.00'),
(41, 14, 9, 'no', 1.00, 'recievable Amount decreased for paying this invoice', '2017-11-17', '2017-11-17 14:41:39', '5.00'),
(42, 15, 1, 'yes', 2.00, 'Cash Increased because of selling products in this invoice', '2017-11-17', '2017-11-17 16:51:46', '296.00'),
(43, 15, 9, 'no', 2.00, 'recievable Amount decreased for paying this invoice', '2017-11-17', '2017-11-17 16:51:46', '3.00'),
(44, 16, 1, 'yes', 3.00, 'Cash Increased because of paying for this invoice', '2017-11-19', '2017-11-19 20:37:50', '299.00'),
(45, 16, 9, 'no', 3.00, 'recievable amount decreased because of paying this invoice', '2017-11-19', '2017-11-19 20:37:51', '0.00'),
(46, 17, 1, 'yes', 2.00, 'Cash Increased because of selling products in this invoice', '2017-11-19', '2017-11-19 20:41:27', '301.00'),
(47, 17, 9, 'no', 2.00, 'recievable Amount decreased for paying this invoice', '2017-11-19', '2017-11-19 20:41:27', '-2.00'),
(48, 18, 1, 'yes', 3.00, 'Cash Increased because of selling products in this invoice', '2017-11-19', '2017-11-19 20:41:35', '304.00'),
(49, 18, 9, 'no', 3.00, 'recievable Amount decreased for paying this invoice', '2017-11-19', '2017-11-19 20:41:35', '-5.00'),
(50, 19, 12, 'yes', 1.00, 'Cash Increased because of selling products in this invoice', '2017-11-19', '2017-11-19 20:42:53', '1.00'),
(51, 19, 9, 'no', 1.00, 'recievable Amount decreased for paying this invoice', '2017-11-19', '2017-11-19 20:42:53', '-6.00'),
(52, 20, 1, 'yes', 3.00, 'Cash Increased because of paying for this invoice', '2017-11-19', '2017-11-19 20:52:29', '307.00'),
(53, 20, 8, 'no', 3.00, 'recievable amount decreased because of paying this invoice', '2017-11-19', '2017-11-19 20:52:29', '21.00'),
(54, 21, 1, 'yes', 208.00, 'Cash Increased because of selling products in this invoice', '2017-11-19', '2017-11-20 01:58:24', '515.00'),
(55, 21, 5, 'no', 208.00, 'Revenue is been counted for this sale', '2017-11-19', '2017-11-20 01:58:24', '532.00'),
(56, 21, 7, 'yes', 114.00, 'Cost is been counted for this sale', '2017-11-19', '2017-11-20 01:58:24', '366.00'),
(57, 21, 11, 'no', 114.00, 'Cost of products for this sale', '2017-11-19', '2017-11-20 01:58:24', '634.00'),
(58, 22, 1, 'yes', 120.00, 'Cash Increased because of selling products in this invoice', '2017-11-19', '2017-11-20 04:43:13', '635.00'),
(59, 22, 5, 'no', 120.00, 'Revenue is been counted for this sale', '2017-11-19', '2017-11-20 04:43:14', '652.00'),
(60, 22, 7, 'yes', 60.00, 'Cost is been counted for this sale', '2017-11-19', '2017-11-20 04:43:14', '426.00'),
(61, 22, 11, 'no', 60.00, 'Cost of products for this sale', '2017-11-19', '2017-11-20 04:43:14', '574.00'),
(62, 23, 1, 'yes', 120.00, 'Cash Increased because of selling products in this invoice', '2017-11-19', '2017-11-20 04:45:20', '755.00'),
(63, 23, 5, 'no', 120.00, 'Revenue is been counted for this sale', '2017-11-19', '2017-11-20 04:45:20', '772.00'),
(64, 23, 7, 'yes', 80.00, 'Cost is been counted for this sale', '2017-11-19', '2017-11-20 04:45:20', '506.00'),
(65, 23, 11, 'no', 80.00, 'Cost of products for this sale', '2017-11-19', '2017-11-20 04:45:20', '494.00'),
(66, 24, 1, 'yes', 60.00, 'Cash Increased because of selling products in this invoice', '2017-11-19', '2017-11-20 04:49:29', '815.00'),
(67, 24, 5, 'no', 60.00, 'Revenue is been counted for this sale', '2017-11-19', '2017-11-20 04:49:29', '832.00'),
(68, 24, 7, 'yes', 30.00, 'Cost is been counted for this sale', '2017-11-19', '2017-11-20 04:49:29', '536.00'),
(69, 24, 11, 'no', 30.00, 'Cost of products for this sale', '2017-11-19', '2017-11-20 04:49:29', '464.00'),
(70, 25, 1, 'yes', 1.00, 'Cash Increased because of paying for this invoice', '2017-11-21', '2017-11-21 19:36:48', '816.00'),
(71, 25, 8, 'no', 1.00, 'recievable amount decreased because of paying this invoice', '2017-11-21', '2017-11-21 19:36:48', '20.00'),
(72, 28, 17, 'yes', 55.00, 'inventory Value Increased', '2017-11-23', '2017-11-23 23:51:21', '55.00'),
(73, 28, 19, 'no', 55.00, 'payable Account Increased', '2017-11-23', '2017-11-23 23:51:21', '55.00'),
(74, 29, 17, 'yes', 1000.00, 'inventory Value Increased', '2017-11-23', '2017-11-23 23:56:24', '1055.00'),
(75, 29, 19, 'no', 1000.00, 'payable Account Increased', '2017-11-23', '2017-11-23 23:56:24', '1055.00'),
(76, 31, 13, 'yes', 225.00, 'inventory Value Increased', '2017-11-23', '2017-11-24 00:03:26', '225.00'),
(77, 31, 19, 'no', 225.00, 'payable Account Increased', '2017-11-23', '2017-11-24 00:03:26', '1280.00'),
(78, 32, 17, 'yes', 225.00, 'inventory Value Increased', '2017-11-23', '2017-11-24 00:09:14', '1280.00'),
(79, 32, 19, 'no', 225.00, 'payable Account Increased', '2017-11-23', '2017-11-24 00:09:14', '1505.00'),
(80, 33, 13, 'yes', 27.50, 'inventory Value Increased', '2017-11-23', '2017-11-24 00:13:15', '252.50'),
(81, 33, 19, 'no', 27.50, 'payable Account Increased', '2017-11-23', '2017-11-24 00:13:15', '1532.50'),
(82, 34, 1, 'yes', 198.00, 'Cash Increased because of selling products in this invoice', '2017-11-24', '2017-11-24 19:08:40', '1014.00'),
(83, 34, 5, 'no', 198.00, 'Revenue is been counted for this sale', '2017-11-24', '2017-11-24 19:08:40', '1030.00'),
(84, 34, 14, 'yes', 5.00, 'Cost is been counted for this sale', '2017-11-24', '2017-11-24 19:08:40', '5.00'),
(85, 34, 13, 'no', 5.00, 'Cost of products for this sale', '2017-11-24', '2017-11-24 19:08:40', '247.50'),
(86, 35, 1, 'yes', 10.00, 'Cash Increased because of selling products in this invoice', '2017-11-24', '2017-11-24 19:12:55', '1024.00'),
(87, 35, 9, 'yes', 485.00, 'recievable Cash Increased because of selling products in this invoice', '2017-11-24', '2017-11-24 19:12:55', '479.00'),
(88, 35, 5, 'no', 495.00, 'Revenue is been counted for this sale', '2017-11-24', '2017-11-24 19:12:56', '1525.00'),
(89, 35, 14, 'yes', 12.50, 'Cost is been counted for this sale', '2017-11-24', '2017-11-24 19:12:56', '17.50'),
(90, 35, 13, 'no', 12.50, 'Cost of products for this sale', '2017-11-24', '2017-11-24 19:12:56', '235.00'),
(91, 36, 1, 'yes', 990.00, 'Cash Increased because of selling products in this invoice', '2017-11-24', '2017-11-24 19:14:29', '2014.00'),
(92, 36, 5, 'no', 990.00, 'Revenue is been counted for this sale', '2017-11-24', '2017-11-24 19:14:29', '2515.00'),
(93, 36, 14, 'yes', 25.00, 'Cost is been counted for this sale', '2017-11-24', '2017-11-24 19:14:29', '42.50'),
(94, 36, 13, 'no', 25.00, 'Cost of products for this sale', '2017-11-24', '2017-11-24 19:14:29', '210.00'),
(95, 37, 1, 'yes', 1485.00, 'Cash Increased because of selling products in this invoice', '2017-11-24', '2017-11-24 19:16:49', '3499.00'),
(96, 37, 5, 'no', 1485.00, 'Revenue is been counted for this sale', '2017-11-24', '2017-11-24 19:16:49', '4000.00'),
(97, 37, 14, 'yes', 37.50, 'Cost is been counted for this sale', '2017-11-24', '2017-11-24 19:16:49', '80.00'),
(98, 37, 13, 'no', 37.50, 'Cost of products for this sale', '2017-11-24', '2017-11-24 19:16:49', '172.50'),
(99, 38, 1, 'yes', 1980.00, 'Cash Increased because of selling products in this invoice', '2017-11-24', '2017-11-24 20:05:44', '5479.00'),
(100, 38, 5, 'no', 1980.00, 'Revenue is been counted for this sale', '2017-11-24', '2017-11-24 20:05:44', '5980.00'),
(101, 38, 14, 'yes', 50.00, 'Cost is been counted for this sale', '2017-11-24', '2017-11-24 20:05:44', '130.00'),
(102, 38, 13, 'no', 50.00, 'Cost of products for this sale', '2017-11-24', '2017-11-24 20:05:44', '122.50'),
(103, 39, 1, 'yes', 5148.00, 'Cash Increased because of selling products in this invoice', '2017-11-24', '2017-11-24 20:08:18', '10627.00'),
(104, 39, 5, 'no', 5148.00, 'Revenue is been counted for this sale', '2017-11-24', '2017-11-24 20:08:18', '11128.00'),
(105, 39, 14, 'yes', 130.00, 'Cost is been counted for this sale', '2017-11-24', '2017-11-24 20:08:18', '260.00'),
(106, 39, 13, 'no', 130.00, 'Cost of products for this sale', '2017-11-24', '2017-11-24 20:08:18', '-7.50'),
(107, 40, 1, 'yes', 297.00, 'Cash Increased because of selling products in this invoice', '2017-11-24', '2017-11-24 20:10:13', '10924.00'),
(108, 40, 5, 'no', 297.00, 'Revenue is been counted for this sale', '2017-11-24', '2017-11-24 20:10:13', '11425.00'),
(109, 40, 14, 'yes', 7.50, 'Cost is been counted for this sale', '2017-11-24', '2017-11-24 20:10:13', '267.50'),
(110, 40, 13, 'no', 7.50, 'Cost of products for this sale', '2017-11-24', '2017-11-24 20:10:13', '-15.00'),
(111, 41, 17, 'yes', 55.00, 'inventory Value Increased', '2017-11-24', '2017-11-24 20:11:12', '1335.00'),
(112, 41, 19, 'no', 55.00, 'payable Account Increased', '2017-11-24', '2017-11-24 20:11:12', '1587.50'),
(113, 42, 17, 'yes', 109.20, 'inventory Value Increased', '2017-11-24', '2017-11-24 20:12:45', '1444.20'),
(114, 42, 19, 'no', 109.20, 'payable Account Increased', '2017-11-24', '2017-11-24 20:12:45', '1696.70'),
(115, 43, 1, 'yes', 1980.00, 'Cash Increased because of selling products in this invoice', '2017-11-24', '2017-11-24 20:14:55', '12904.00'),
(116, 43, 5, 'no', 1980.00, 'Revenue is been counted for this sale', '2017-11-24', '2017-11-24 20:14:56', '13405.00'),
(117, 43, 18, 'yes', 69.81, 'Cost is been counted for this sale', '2017-11-24', '2017-11-24 20:14:56', '69.81'),
(118, 43, 17, 'no', 69.81, 'Cost of products for this sale', '2017-11-24', '2017-11-24 20:14:56', '1374.39');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `alias` varchar(45) NOT NULL,
  `address` text NOT NULL,
  `phone_no` int(10) NOT NULL,
  `asset_account_id` int(11) NOT NULL,
  `expense_account_id` int(11) NOT NULL,
  `color_class` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT '1',
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `name`, `alias`, `address`, `phone_no`, `asset_account_id`, `expense_account_id`, `color_class`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(23, 'test', 'dfs', 'sfa', 911066609, 13, 14, 'bg-purple', '2017-11-21 21:19:07', NULL, 1, NULL),
(24, 'testfaf', 'dfs', 'sfa', 911066609, 15, 16, 'bg-purple', '2017-11-21 21:23:38', NULL, 1, NULL),
(25, 'TRY', 'TRS', 'FASDFASF', 2147483642, 17, 18, 'bg-purple', '2017-11-22 01:19:19', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_account`
--

CREATE TABLE `inventory_account` (
  `id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `system_account_id` int(11) NOT NULL,
  `opening_balance` decimal(18,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(18,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL,
  `cost` decimal(18,2) NOT NULL,
  `method` enum('cash','credit','undefined','cheque') NOT NULL DEFAULT 'undefined',
  `date` date NOT NULL,
  `status` enum('paid','partially','unpaid') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `client_id`, `transaction_id`, `amount`, `cost`, `method`, `date`, `status`, `created_at`) VALUES
(42, 3, 0, '28.00', '0.00', 'cash', '2017-11-14', 'partially', '2017-11-20 00:47:03'),
(44, 3, 0, '2.00', '0.00', 'credit', '2017-11-14', 'partially', '2017-11-21 19:36:47'),
(45, 4, 0, '42.00', '0.00', 'credit', '2017-11-14', 'partially', '2017-11-20 00:54:30'),
(46, 5, 0, '14.00', '0.00', 'cash', '2017-11-14', 'paid', '2017-11-14 20:58:06'),
(48, 3, 21, '208.00', '0.00', 'cash', '2017-11-19', 'paid', '2017-11-20 01:58:24'),
(49, 3, 22, '120.00', '0.00', 'cash', '2017-11-19', 'paid', '2017-11-20 04:43:14'),
(50, 5, 23, '120.00', '0.00', 'cash', '2017-11-19', 'paid', '2017-11-20 04:45:20'),
(51, 5, 24, '60.00', '0.00', 'cash', '2017-11-19', 'paid', '2017-11-20 04:49:29'),
(53, 3, 34, '198.00', '0.00', 'cash', '2017-11-24', 'paid', '2017-11-24 19:08:40'),
(54, 4, 35, '495.00', '0.00', 'credit', '2017-11-24', 'partially', '2017-11-24 19:12:56'),
(55, 4, 36, '990.00', '0.00', 'cash', '2017-11-24', 'paid', '2017-11-24 19:14:29'),
(56, 4, 37, '1485.00', '0.00', 'cash', '2017-11-24', 'paid', '2017-11-24 19:16:50'),
(57, 4, 38, '1980.00', '0.00', 'cash', '2017-11-24', 'paid', '2017-11-24 20:05:44'),
(58, 4, 39, '5148.00', '0.00', 'cash', '2017-11-24', 'paid', '2017-11-24 20:08:18'),
(59, 4, 40, '297.00', '0.00', 'cash', '2017-11-24', 'paid', '2017-11-24 20:10:13'),
(60, 3, 43, '1980.00', '0.00', 'cash', '2017-11-24', 'paid', '2017-11-24 20:14:56');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_product`
--

CREATE TABLE `invoice_product` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `buying_rate` int(11) NOT NULL,
  `selling_rate` int(11) NOT NULL,
  `d_rate` varchar(45) NOT NULL,
  `stoking_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice_product`
--

INSERT INTO `invoice_product` (`id`, `invoice_id`, `product_id`, `quantity`, `buying_rate`, `selling_rate`, `d_rate`, `stoking_id`, `created_at`) VALUES
(33, 42, 3, 3, 28, 14, '', 0, '2017-11-24 15:46:04'),
(37, 44, 3, 1, 2, 14, '', 0, '2017-11-24 15:46:04'),
(38, 45, 3, 1, 42, 14, '', 0, '2017-11-24 15:46:04'),
(39, 46, 3, 1, 12, 14, '', 0, '2017-11-24 15:46:04'),
(40, 48, 1, 3, 30, 60, '', 0, '2017-11-24 15:46:04'),
(41, 48, 3, 2, 12, 14, '', 0, '2017-11-24 15:46:04'),
(42, 49, 1, 2, 30, 60, '', 0, '2017-11-24 15:46:04'),
(43, 50, 1, 1, 30, 60, '', 0, '2017-11-24 15:46:04'),
(44, 50, 2, 1, 50, 60, '', 0, '2017-11-24 15:46:04'),
(45, 51, 1, 1, 30, 60, '', 0, '2017-11-24 15:46:04'),
(46, 53, 7, 2, 2, 4, '22', 0, '2017-11-24 19:08:40'),
(47, 54, 7, 5, 2, 4, '22', 0, '2017-11-24 19:12:55'),
(48, 55, 7, 10, 2, 4, '22', 0, '2017-11-24 19:14:28'),
(49, 56, 7, 15, 2, 4, '22', 0, '2017-11-24 19:16:49'),
(50, 57, 7, 20, 2, 4, '22', 0, '2017-11-24 20:05:44'),
(51, 58, 7, 52, 2, 4, '22', 0, '2017-11-24 20:08:18'),
(52, 59, 7, 3, 2, 4, '22', 0, '2017-11-24 20:10:13'),
(53, 60, 7, 30, 1, 3, '22', 0, '2017-11-24 20:14:55');

-- --------------------------------------------------------

--
-- Table structure for table `minimal`
--

CREATE TABLE `minimal` (
  `id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `outstanding`
--

CREATE TABLE `outstanding` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `type` enum('cheque','promise') NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `due_date` date DEFAULT NULL,
  `bank` varchar(45) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `cheque_no` int(16) DEFAULT NULL,
  `status` enum('clear','outstanding') NOT NULL DEFAULT 'outstanding',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `outstanding`
--

INSERT INTO `outstanding` (`id`, `invoice_id`, `client_id`, `payment_id`, `type`, `amount`, `due_date`, `bank`, `cheque_date`, `cheque_no`, `status`, `created_at`) VALUES
(7, 45, 4, 12, 'cheque', '2.00', NULL, 'Khartoum', '2017-11-23', 2147483647, 'clear', '2017-11-17 16:51:46'),
(8, 45, 4, 15, 'cheque', '3.00', NULL, 'Khartoum', '2017-11-24', 2147483647, 'clear', '2017-11-19 20:41:35'),
(10, 45, 4, 14, 'cheque', '2.00', NULL, 'Khartoum', '2017-11-14', 2147483647, 'clear', '2017-11-19 20:41:26'),
(11, 45, 4, 16, 'promise', '1.00', '2017-11-20', NULL, NULL, NULL, 'clear', '2017-11-19 20:42:52'),
(12, 45, 4, NULL, 'promise', '1.00', '2017-11-21', NULL, NULL, NULL, 'outstanding', '2017-11-19 20:43:10'),
(13, 45, 4, NULL, 'promise', '1.00', '2017-11-06', NULL, NULL, NULL, 'outstanding', '2017-11-19 20:43:31'),
(14, 42, 3, NULL, 'promise', '39.00', '2017-11-08', NULL, NULL, NULL, 'outstanding', '2017-11-19 20:52:23'),
(15, 42, 3, NULL, 'cheque', '6.00', NULL, 'Khartoum', '2017-11-22', 2147483647, 'outstanding', '2017-11-19 20:52:46'),
(16, 54, 4, NULL, 'cheque', '51.00', NULL, 'Khartoum', '2017-11-30', 2147483647, 'outstanding', '2017-11-24 20:56:35');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `system_account_id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL,
  `mode` enum('cash','cheque','credit') NOT NULL DEFAULT 'cash',
  `bank_name` varchar(45) DEFAULT NULL,
  `cheque_no` int(45) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `invoice_id`, `system_account_id`, `transaction_id`, `amount`, `mode`, `bank_name`, `cheque_no`, `cheque_date`, `created_at`) VALUES
(11, 45, 1, 14, '1.00', 'cash', NULL, NULL, NULL, '2017-11-17 14:41:39'),
(12, 45, 1, 15, '2.00', 'cheque', 'Khartoum', 2147483647, '2017-11-23', '2017-11-17 16:51:46'),
(13, 45, 1, 16, '3.00', 'cash', NULL, NULL, NULL, '2017-11-19 20:37:51'),
(14, 45, 1, 17, '2.00', 'cheque', 'Khartoum', 2147483647, '2017-11-14', '2017-11-19 20:41:27'),
(15, 45, 1, 18, '3.00', 'cheque', 'Khartoum', 2147483647, '2017-11-24', '2017-11-19 20:41:35'),
(16, 45, 12, 19, '1.00', 'cash', NULL, NULL, NULL, '2017-11-19 20:42:53'),
(17, 42, 1, 20, '3.00', 'cash', NULL, NULL, NULL, '2017-11-19 20:52:29'),
(19, 48, 1, 21, '208.00', 'cash', NULL, NULL, NULL, '2017-11-20 01:58:24'),
(20, 49, 1, 22, '120.00', 'cash', NULL, NULL, NULL, '2017-11-20 04:43:14'),
(21, 50, 1, 23, '120.00', 'cash', NULL, NULL, NULL, '2017-11-20 04:45:20'),
(22, 51, 1, 24, '60.00', 'cash', NULL, NULL, NULL, '2017-11-20 04:49:29'),
(23, 44, 1, 25, '1.00', 'cash', NULL, NULL, NULL, '2017-11-21 19:36:48'),
(25, 53, 1, 34, '198.00', 'cash', NULL, NULL, NULL, '2017-11-24 19:08:40'),
(26, 54, 1, 35, '10.00', 'cash', NULL, NULL, NULL, '2017-11-24 19:12:56'),
(27, 55, 1, 36, '990.00', 'cash', NULL, NULL, NULL, '2017-11-24 19:14:29'),
(28, 56, 1, 37, '1485.00', 'cash', NULL, NULL, NULL, '2017-11-24 19:16:50'),
(29, 57, 1, 38, '1980.00', 'cash', NULL, NULL, NULL, '2017-11-24 20:05:44'),
(30, 58, 1, 39, '5148.00', 'cash', NULL, NULL, NULL, '2017-11-24 20:08:18'),
(31, 59, 1, 40, '297.00', 'cash', NULL, NULL, NULL, '2017-11-24 20:10:13'),
(32, 60, 1, 43, '1980.00', 'cash', NULL, NULL, NULL, '2017-11-24 20:14:56');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `no` int(11) NOT NULL,
  `product_name` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL,
  `buying_price` varchar(45) NOT NULL,
  `selling_price` varchar(45) NOT NULL,
  `percentage` int(2) NOT NULL,
  `minimum` int(11) NOT NULL,
  `active` enum('percentage','selling_price') NOT NULL DEFAULT 'selling_price',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL DEFAULT '1',
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `no`, `product_name`, `description`, `buying_price`, `selling_price`, `percentage`, `minimum`, `active`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 2222, 'product 2', 'fafa', '0.5', '1', 100, 40, 'selling_price', '2017-11-22 08:03:25', '2017-11-24 01:56:24', 1, NULL),
(2, 2, 33434, 'product 3', 'some data', '50', '60', 0, 50, 'selling_price', '2017-11-22 08:03:25', NULL, 1, NULL),
(3, 1, 334342, 'اسم بالعربي', 'وصف', '12', '14', 0, 34, 'selling_price', '2017-11-22 08:03:25', NULL, 1, NULL),
(5, 1, 33434, 'kj;klj', 'jjkhk', '20', '70', 250, 90, 'selling_price', '2017-11-22 20:48:46', NULL, 1, NULL),
(6, 1, 343, 'fasdf', 'jjkhk', '1', '5', 400, 33, 'selling_price', '2017-11-23 01:56:30', NULL, 1, NULL),
(7, 1, 2222, 'new prod', 'fafa', '1.95', '3', 53, 34, 'selling_price', '2017-11-23 01:58:14', '2017-11-24 22:12:45', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(45) NOT NULL,
  `quantity` int(11) NOT NULL,
  `highest_rate` varchar(45) NOT NULL,
  `avg_cost` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `inventory_id`, `product_id`, `product_name`, `quantity`, `highest_rate`, `avg_cost`, `created_at`) VALUES
(20, 25, 7, 'new prod', 438, '22', '2.3269662921348', '2017-11-24 20:14:55'),
(21, 25, 1, 'product 2', 2000, '22', '0.5', '2017-11-23 23:56:24'),
(22, 23, 7, 'new prod', 106, '22', '2.5', '2017-11-24 20:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `stocking`
--

CREATE TABLE `stocking` (
  `id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `buying_price` varchar(10) NOT NULL,
  `selling_price` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `transaction` enum('in','out','transfere') NOT NULL DEFAULT 'in',
  `rate` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stocking`
--

INSERT INTO `stocking` (`id`, `inventory_id`, `product_id`, `buying_price`, `selling_price`, `quantity`, `transaction`, `rate`, `created_at`) VALUES
(62, 25, 7, '2.5', '4.5', 100, 'in', 21, '2017-11-24 20:02:59'),
(73, 23, 7, '2.5', '4.5', 3, 'out', 22, '2017-11-24 20:08:18'),
(74, 23, 7, '2.5', '4.5', 15, 'out', 22, '2017-11-24 19:16:49'),
(75, 23, 7, '2.5', '4.5', 20, 'out', 22, '2017-11-24 20:05:44'),
(76, 23, 7, '2.5', '4.5', 52, 'out', 22, '2017-11-24 20:08:18'),
(77, 23, 7, '2.5', '4.5', 3, 'out', 22, '2017-11-24 20:10:13'),
(79, 25, 7, '1.95', '3', 48, 'in', 22, '2017-11-24 20:14:55'),
(80, 25, 7, '2.32696629', '3', 30, 'out', 22, '2017-11-24 20:14:55');

-- --------------------------------------------------------

--
-- Table structure for table `system_account`
--

CREATE TABLE `system_account` (
  `id` int(11) NOT NULL,
  `account_no` varchar(45) NOT NULL,
  `system_account_name` varchar(45) NOT NULL,
  `account_type_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `opening_balance` decimal(18,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(18,2) NOT NULL DEFAULT '0.00',
  `group` varchar(45) DEFAULT NULL,
  `to_increase` enum('debit','credit') NOT NULL,
  `color_class` varchar(45) NOT NULL DEFAULT 'bg-aqua',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL DEFAULT '1',
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_account`
--

INSERT INTO `system_account` (`id`, `account_no`, `system_account_name`, `account_type_id`, `description`, `opening_balance`, `balance`, `group`, `to_increase`, `color_class`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, '101', 'cash', 1, 'This is the Cash account', '0.00', '12904.00', 'cash', 'debit', 'bg-yellow', '0000-00-00 00:00:00', NULL, 1, NULL),
(2, '102', 'Bank 1 Account', 1, 'This is the Bank of Khartoum account', '0.00', '1.00', 'cash bank', '', 'bg-navy', '0000-00-00 00:00:00', NULL, 1, NULL),
(3, '103', 'Recievable Account', 1, 'This is the Account to record Clients owed amount to Us', '0.00', '0.00', '3', '', 'bg-black', '0000-00-00 00:00:00', NULL, 1, NULL),
(4, '104', 'inventory', 1, 'This is the total value on our Inventories Stock', '0.00', '5792.00', 'inventory', '', 'bg-red', '0000-00-00 00:00:00', NULL, 1, NULL),
(5, '401', 'sales', 4, 'Sales account', '0.00', '13405.00', 'revenue', 'credit', 'bg-navy', '0000-00-00 00:00:00', NULL, 1, NULL),
(6, '402', 'sales return', 4, 'Sales Return account', '0.00', '0.00', 'revenue', 'credit', 'bg-navy', '0000-00-00 00:00:00', NULL, 1, NULL),
(7, '501', 'sales expenses', 5, 'Cost of Goods Sold', '0.00', '536.00', 'expenses', '', 'bg-purple', '0000-00-00 00:00:00', NULL, 1, NULL),
(8, '1110987654321', 'Mohammed Taha', 1, 'Client Mohammed Taha Recievable account', '0.00', '20.00', 'client', '', 'bg-aqua', '0000-00-00 00:00:00', NULL, 1, NULL),
(9, '111098283848', 'Ahmed Taha', 1, 'Client Ahmed Taha Recievable account', '0.00', '479.00', 'client', '', 'bg-aqua', '0000-00-00 00:00:00', NULL, 1, NULL),
(11, '106', 'inventor 1', 1, 'This is the total value on our Inventories Stock', '0.00', '464.00', 'inventory', '', '', '0000-00-00 00:00:00', NULL, 1, NULL),
(12, '105', 'bank of khartoum', 1, 'Asset account bank', '0.00', '1.00', 'cash bank', '', 'bg-maroon', '0000-00-00 00:00:00', NULL, 1, NULL),
(13, '107', 'test Value', 1, 'test', '0.00', '-15.00', 'inventory', 'debit', 'bg-purple', '2017-11-21 21:19:07', NULL, 1, NULL),
(14, '5140', 'test Cost', 5, 'test Cost Of Goods Sold', '0.00', '267.50', 'inventory expense', 'debit', 'bg-purple', '2017-11-21 21:19:07', NULL, 1, NULL),
(15, '108', 'testfaf Value', 1, 'testfaf', '0.00', '0.00', 'inventory', 'debit', 'bg-purple', '2017-11-21 21:23:38', NULL, 1, NULL),
(16, '5141', 'testfaf Cost', 5, 'testfaf Cost Of Goods Sold', '0.00', '0.00', 'inventory expense', 'debit', 'bg-purple', '2017-11-21 21:23:38', NULL, 1, NULL),
(17, '109', 'TRS Value', 1, 'TRY', '0.00', '1374.39', 'inventory', 'debit', 'bg-purple', '2017-11-22 01:19:19', NULL, 1, NULL),
(18, '5142', 'TRS Cost', 5, 'TRY Cost Of Goods Sold', '0.00', '69.81', 'inventory expense', 'debit', 'bg-purple', '2017-11-22 01:19:19', NULL, 1, NULL),
(19, '2000', 'inventoiesPayable', 2, 'Use to reserve purchases cost', '0.00', '1696.70', 'payable', 'credit', 'bg-yello', '2017-11-24 08:00:00', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `reference` int(11) NOT NULL DEFAULT '0',
  `reference_type` varchar(45) NOT NULL DEFAULT 'default',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `description`, `reference`, `reference_type`, `timestamp`) VALUES
(6, 'Selling Products', 42, 'Invoices', '2017-11-14 20:32:04'),
(7, 'Selling Products', 43, 'Invoices', '2017-11-14 20:46:41'),
(8, 'Selling Products', 44, 'Invoices', '2017-11-14 20:51:16'),
(9, 'Selling Products', 45, 'Invoices', '2017-11-14 20:55:46'),
(10, 'Selling Products', 46, 'Invoices', '2017-11-14 20:58:06'),
(11, 'Reconciling payment for invoice 45', 45, 'Invoices', '2017-11-17 13:59:44'),
(12, 'Reconciling payment for invoice 45', 45, 'Invoices', '2017-11-17 14:01:45'),
(13, 'Reconciling payment for invoice 45', 45, 'Invoices', '2017-11-17 14:13:32'),
(14, 'Reconciling payment for invoice 45', 45, 'Invoices', '2017-11-17 14:41:39'),
(15, 'Reconciling payment for invoice 45', 45, 'Invoices', '2017-11-17 16:51:46'),
(16, 'Paying for invoice 45', 45, 'Invoices', '2017-11-19 20:37:50'),
(17, 'Reconciling payment for invoice 45', 45, 'Invoices', '2017-11-19 20:41:27'),
(18, 'Reconciling payment for invoice 45', 45, 'Invoices', '2017-11-19 20:41:35'),
(19, 'Reconciling payment for invoice 45', 45, 'Invoices', '2017-11-19 20:42:53'),
(20, 'Paying for invoice 42', 42, 'Invoices', '2017-11-19 20:52:29'),
(21, 'Selling Products', 48, 'Invoices', '2017-11-20 01:58:24'),
(22, 'Selling Products', 49, 'Invoices', '2017-11-20 04:43:13'),
(23, 'Selling Products', 50, 'Invoices', '2017-11-20 04:45:20'),
(24, 'Selling Products', 51, 'Invoices', '2017-11-20 04:49:29'),
(25, 'Paying for invoice 44', 44, 'Invoices', '2017-11-21 19:36:48'),
(26, 'Stocking Product ', 20, 'Stock', '2017-11-23 23:47:53'),
(27, 'Stocking Product ', 20, 'Stock', '2017-11-23 23:49:49'),
(28, 'Stocking Product ', 20, 'Stock', '2017-11-23 23:51:21'),
(29, 'Stocking Product ', 21, 'Stock', '2017-11-23 23:56:24'),
(30, 'Stocking Product ', 22, 'Stock', '2017-11-24 00:01:27'),
(31, 'Stocking Product ', 22, 'Stock', '2017-11-24 00:03:26'),
(32, 'Stocking Product ', 20, 'Stock', '2017-11-24 00:09:14'),
(33, 'Stocking Product ', 22, 'Stock', '2017-11-24 00:13:15'),
(34, 'Selling Products', 53, 'Invoices', '2017-11-24 19:08:40'),
(35, 'Selling Products', 54, 'Invoices', '2017-11-24 19:12:55'),
(36, 'Selling Products', 55, 'Invoices', '2017-11-24 19:14:29'),
(37, 'Selling Products', 56, 'Invoices', '2017-11-24 19:16:49'),
(38, 'Selling Products', 57, 'Invoices', '2017-11-24 20:05:44'),
(39, 'Selling Products', 58, 'Invoices', '2017-11-24 20:08:18'),
(40, 'Selling Products', 59, 'Invoices', '2017-11-24 20:10:13'),
(41, 'Stocking Product ', 20, 'Stock', '2017-11-24 20:11:12'),
(42, 'Stocking Product ', 20, 'Stock', '2017-11-24 20:12:45'),
(43, 'Selling Products', 60, 'Invoices', '2017-11-24 20:14:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_type`
--
ALTER TABLE `account_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `client_account`
--
ALTER TABLE `client_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Reflect on` (`system_account_id`);

--
-- Indexes for table `entry`
--
ALTER TABLE `entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_account_id` (`asset_account_id`) USING BTREE;

--
-- Indexes for table `inventory_account`
--
ALTER TABLE `inventory_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_id` (`inventory_id`),
  ADD KEY `system_account_id` (`system_account_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `invoice_product`
--
ALTER TABLE `invoice_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `minimal`
--
ALTER TABLE `minimal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outstanding`
--
ALTER TABLE `outstanding`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `account_id` (`system_account_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_id` (`inventory_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `stocking`
--
ALTER TABLE `stocking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_id` (`inventory_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `system_account`
--
ALTER TABLE `system_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type of the account` (`account_type_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_type`
--
ALTER TABLE `account_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `client_account`
--
ALTER TABLE `client_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `entry`
--
ALTER TABLE `entry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `inventory_account`
--
ALTER TABLE `inventory_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `invoice_product`
--
ALTER TABLE `invoice_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `minimal`
--
ALTER TABLE `minimal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `outstanding`
--
ALTER TABLE `outstanding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `stocking`
--
ALTER TABLE `stocking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `system_account`
--
ALTER TABLE `system_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `client_account`
--
ALTER TABLE `client_account`
  ADD CONSTRAINT `sysaccounts_ibfk_1` FOREIGN KEY (`system_account_id`) REFERENCES `system_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `entry`
--
ALTER TABLE `entry`
  ADD CONSTRAINT `entry_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory_account`
--
ALTER TABLE `inventory_account`
  ADD CONSTRAINT `refer_to_inventory` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `refer_to_systemAccount` FOREIGN KEY (`system_account_id`) REFERENCES `system_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice_product`
--
ALTER TABLE `invoice_product`
  ADD CONSTRAINT `initem_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `initem_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`system_account_id`) REFERENCES `system_account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `inventory_link` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_link` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stocking`
--
ALTER TABLE `stocking`
  ADD CONSTRAINT `inventory_stocking_link` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_stocking_link` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
