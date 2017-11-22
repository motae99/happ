-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2017 at 07:21 PM
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
(71, 25, 8, 'no', 1.00, 'recievable amount decreased because of paying this invoice', '2017-11-21', '2017-11-21 19:36:48', '20.00');

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
(12, 'Inventory 1', '', 'Inventory 1', 0, 11, 0, '', '0000-00-00 00:00:00', NULL, 1, 1),
(13, 'Inventory 2', '', 'Inventory 12', 0, 0, 0, '', '0000-00-00 00:00:00', NULL, 1, 1),
(14, 'Inventory 3', '', 'Inventory22', 0, 0, 0, '', '0000-00-00 00:00:00', NULL, 1, 1),
(15, 'name', '', 'adfjakdlfjakl', 0, 0, 0, '', '0000-00-00 00:00:00', NULL, 1, 1),
(16, 'Inventory 1', 'IN1', 'any address', 911066609, 0, 0, 'bg-purple', '2017-11-21 16:16:45', NULL, 1, 1),
(17, 'try flash', 'inf', 'dkfjakl', 2147483647, 0, 0, 'bfjlkdfjal', '2017-11-21 16:26:11', NULL, 1, 1),
(18, 'dfaf', 'dfs', 'asdfaf', 2147483647, 0, 0, 'dfaf', '2017-11-21 16:27:59', NULL, 1, 1),
(19, 'dfadf', 'dff', 'dfaf', 2147483647, 0, 0, 'fdf', '2017-11-21 16:38:44', NULL, 1, 1),
(20, 'jkhjkhjk', 'gfg', 'hgjhgjh', 2147483647, 0, 0, 'hjgjhg', '2017-11-21 16:41:15', NULL, 1, 1),
(21, 'TestAccount', 'dff', 'dfadf', 911066609, 0, 0, 'bg-purple', '2017-11-21 21:15:12', NULL, 1, NULL),
(22, 'TestAccount', 'dff', 'dfadf', 911066609, 0, 0, 'bg-purple', '2017-11-21 21:16:01', NULL, 1, NULL),
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

--
-- Dumping data for table `inventory_account`
--

INSERT INTO `inventory_account` (`id`, `inventory_id`, `system_account_id`, `opening_balance`, `balance`) VALUES
(5, 12, 4, '0.00', '342.00'),
(6, 13, 4, '0.00', '3800.00'),
(7, 14, 4, '0.00', '1650.00'),
(8, 15, 4, '0.00', '0.00');

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
(51, 5, 24, '60.00', '0.00', 'cash', '2017-11-19', 'paid', '2017-11-20 04:49:29');

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
  `selling_rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice_product`
--

INSERT INTO `invoice_product` (`id`, `invoice_id`, `product_id`, `quantity`, `buying_rate`, `selling_rate`) VALUES
(33, 42, 3, 3, 28, 14),
(37, 44, 3, 1, 2, 14),
(38, 45, 3, 1, 42, 14),
(39, 46, 3, 1, 12, 14),
(40, 48, 1, 3, 30, 60),
(41, 48, 3, 2, 12, 14),
(42, 49, 1, 2, 30, 60),
(43, 50, 1, 1, 30, 60),
(44, 50, 2, 1, 50, 60),
(45, 51, 1, 1, 30, 60);

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
(15, 42, 3, NULL, 'cheque', '6.00', NULL, 'Khartoum', '2017-11-22', 2147483647, 'outstanding', '2017-11-19 20:52:46');

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
(23, 44, 1, 25, '1.00', 'cash', NULL, NULL, NULL, '2017-11-21 19:36:48');

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
  `minimum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `no`, `product_name`, `description`, `buying_price`, `selling_price`, `minimum`) VALUES
(1, 1, 2222, 'product 2', 'fafa', '30', '60', 40),
(2, 2, 33434, 'product 3', 'some data', '50', '60', 50),
(3, 1, 334342, 'اسم بالعربي', 'وصف', '12', '14', 34),
(4, 1, 2222, 'new prod', 'some data', '30', '60', 34);

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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `inventory_id`, `product_id`, `product_name`, `quantity`, `created_at`) VALUES
(9, 12, 1, 'product 2', 2, '2017-11-20 04:49:29'),
(10, 12, 2, 'product 3', 3, '2017-11-20 04:45:20'),
(11, 12, 3, 'اسم بالعربي', 11, '2017-11-20 01:58:24'),
(12, 13, 2, 'product 3', 76, '2017-11-12 03:12:15'),
(13, 14, 2, 'product 3', 33, '2017-11-12 00:31:35'),
(14, 13, 1, 'product 2', 0, '2017-11-12 00:38:43');

-- --------------------------------------------------------

--
-- Table structure for table `stocking`
--

CREATE TABLE `stocking` (
  `id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `buying_price` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stocking`
--

INSERT INTO `stocking` (`id`, `inventory_id`, `product_id`, `buying_price`, `selling_price`, `quantity`, `created_at`) VALUES
(21, 12, 2, 50, 60, 10, '2017-11-12 00:16:50'),
(22, 12, 3, 12, 14, 10, '2017-11-12 00:17:10'),
(23, 12, 2, 50, 60, 10, '2017-11-12 00:28:42'),
(24, 12, 1, 20, 50, 10, '2017-11-12 00:29:39'),
(25, 13, 2, 50, 60, 100, '2017-11-12 00:30:14'),
(26, 14, 2, 50, 60, 33, '2017-11-12 00:31:35'),
(28, 12, 3, 12, 14, 1, '2017-11-12 02:43:13'),
(29, 12, 3, 12, 14, 10, '2017-11-12 02:59:47'),
(30, 12, 3, 12, 14, 20, '2017-11-12 08:57:08');

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
(1, '101', 'cash', 1, 'This is the Cash account', '0.00', '816.00', 'cash', 'debit', 'bg-yellow', '0000-00-00 00:00:00', NULL, 1, NULL),
(2, '102', 'Bank 1 Account', 1, 'This is the Bank of Khartoum account', '0.00', '1.00', 'cash bank', '', 'bg-navy', '0000-00-00 00:00:00', NULL, 1, NULL),
(3, '103', 'Recievable Account', 1, 'This is the Account to record Clients owed amount to Us', '0.00', '0.00', '3', '', 'bg-black', '0000-00-00 00:00:00', NULL, 1, NULL),
(4, '104', 'inventory', 1, 'This is the total value on our Inventories Stock', '0.00', '5792.00', 'inventory', '', 'bg-red', '0000-00-00 00:00:00', NULL, 1, NULL),
(5, '401', 'sales', 4, 'Sales account', '0.00', '832.00', 'revenue', 'credit', 'bg-navy', '0000-00-00 00:00:00', NULL, 1, NULL),
(6, '402', 'sales return', 4, 'Sales Return account', '0.00', '0.00', 'revenue', 'credit', 'bg-navy', '0000-00-00 00:00:00', NULL, 1, NULL),
(7, '501', 'sales expenses', 5, 'Cost of Goods Sold', '0.00', '536.00', 'expenses', '', 'bg-purple', '0000-00-00 00:00:00', NULL, 1, NULL),
(8, '1110987654321', 'Mohammed Taha', 1, 'Client Mohammed Taha Recievable account', '0.00', '20.00', 'client', '', 'bg-aqua', '0000-00-00 00:00:00', NULL, 1, NULL),
(9, '111098283848', 'Ahmed Taha', 1, 'Client Ahmed Taha Recievable account', '0.00', '-6.00', 'client', '', 'bg-aqua', '0000-00-00 00:00:00', NULL, 1, NULL),
(11, '106', 'inventor 1', 1, 'This is the total value on our Inventories Stock', '0.00', '464.00', 'inventory', '', '', '0000-00-00 00:00:00', NULL, 1, NULL),
(12, '105', 'bank of khartoum', 1, 'Asset account bank', '0.00', '1.00', 'cash bank', '', 'bg-maroon', '0000-00-00 00:00:00', NULL, 1, NULL),
(13, '107', 'test Value', 1, 'test', '0.00', '0.00', 'inventory', 'debit', 'bg-purple', '2017-11-21 21:19:07', NULL, 1, NULL),
(14, '5140', 'test Cost', 5, 'test Cost Of Goods Sold', '0.00', '0.00', 'inventory expense', 'debit', 'bg-purple', '2017-11-21 21:19:07', NULL, 1, NULL),
(15, '108', 'testfaf Value', 1, 'testfaf', '0.00', '0.00', 'inventory', 'debit', 'bg-purple', '2017-11-21 21:23:38', NULL, 1, NULL),
(16, '5141', 'testfaf Cost', 5, 'testfaf Cost Of Goods Sold', '0.00', '0.00', 'inventory expense', 'debit', 'bg-purple', '2017-11-21 21:23:38', NULL, 1, NULL),
(17, '109', 'TRS Value', 1, 'TRY', '0.00', '0.00', 'inventory', 'debit', 'bg-purple', '2017-11-22 01:19:19', NULL, 1, NULL),
(18, '5142', 'TRS Cost', 5, 'TRY Cost Of Goods Sold', '0.00', '0.00', 'inventory expense', 'debit', 'bg-purple', '2017-11-22 01:19:19', NULL, 1, NULL);

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
(25, 'Paying for invoice 44', 44, 'Invoices', '2017-11-21 19:36:48');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `inventory_account`
--
ALTER TABLE `inventory_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `invoice_product`
--
ALTER TABLE `invoice_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `outstanding`
--
ALTER TABLE `outstanding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `stocking`
--
ALTER TABLE `stocking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `system_account`
--
ALTER TABLE `system_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
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
