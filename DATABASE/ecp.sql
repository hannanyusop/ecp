-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 14, 2020 at 07:02 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecp`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `credit_balance` float(10,2) NOT NULL DEFAULT 0.00,
  `credit_total` float(10,2) NOT NULL DEFAULT 0.00,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `credit_balance`, `credit_total`, `address`) VALUES
(1, 3, 0.00, 0.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `add_on`
--

CREATE TABLE `add_on` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` float(10,2) NOT NULL DEFAULT 0.00,
  `is_active` smallint(1) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `add_on`
--

INSERT INTO `add_on` (`id`, `name`, `description`, `price`, `is_active`, `updated_at`) VALUES
(1, 'BINDING', '', 1.00, 1, NULL),
(2, 'DELIVERY', '', 2.00, 1, NULL),
(3, 'HARD COVER', '', 5.00, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `credit_transaction`
--

CREATE TABLE `credit_transaction` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL DEFAULT 0,
  `staff_id` int(11) UNSIGNED NOT NULL,
  `type` int(11) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `current_balance` double NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `total_page` int(11) NOT NULL DEFAULT 1,
  `printing_mode` int(11) NOT NULL DEFAULT 1,
  `printing_mode_price` double(10,2) NOT NULL DEFAULT 0.00,
  `notes` longtext DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `total_price` double(10,2) NOT NULL DEFAULT 0.00,
  `pickup_code` varchar(50) DEFAULT NULL,
  `pickup_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jobs_has_add_on`
--

CREATE TABLE `jobs_has_add_on` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `add_on_id` int(11) NOT NULL,
  `price` double(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_transaction`
--

CREATE TABLE `job_transaction` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seen` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `messages` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `seen`, `title`, `messages`, `created_at`) VALUES
(1, 3, 0, 'Ttile example', 'This is examople message', '2020-03-14 18:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name`, `value`, `updated_at`) VALUES
(1, 'price_black_and_white', '0.20', '2019-11-15 21:19:28'),
(2, 'price_colour', '0.50', '2019-11-15 21:34:21');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(3, 'customer'),
(1, 'manager'),
(2, 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 3,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `reset_password_key` varchar(255) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `last_ip_address` varchar(50) DEFAULT NULL,
  `is_active` smallint(1) NOT NULL DEFAULT 0,
  `is_confirm` smallint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `email`, `password`, `reset_password_key`, `fullname`, `last_login_at`, `last_ip_address`, `is_active`, `is_confirm`, `created_at`) VALUES
(1, 1, 'admin@ezprint.my', '$2y$12$sAdS7Z4PX.PW0JIG.oSTT.eCm12XjEd8CVKTcyQBY8NosPCtNCK1m', NULL, 'MANAGER EZPRINT', '2019-11-17 13:42:36', '127.0.0.1', 1, 1, '2019-11-17 13:40:59'),
(2, 2, 'staff@ezprint.my', '$2y$10$QVzz61ytFRUnIX0owe.yb.wU4PFKly4HrXcyfwNmIC/tjoqdUBF32', NULL, '', NULL, NULL, 1, 1, '2019-11-17 13:45:56'),
(3, 3, 'customer@test.my', '$2y$10$/ZZMXLD11qhKfhzyaLa.CuuLmuw3pUeMm7JX/p5GQ5mxOdxc7iLzq', NULL, 'CUSTOMER DEFAULT', '2020-03-14 17:23:10', '192.168.64.1', 1, 1, '2019-11-17 14:07:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_accounts_users` (`user_id`);

--
-- Indexes for table `add_on`
--
ALTER TABLE `add_on`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `credit_transaction`
--
ALTER TABLE `credit_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_credit_transaction_users` (`staff_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_has_add_on`
--
ALTER TABLE `jobs_has_add_on`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_transaction`
--
ALTER TABLE `job_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `add_on`
--
ALTER TABLE `add_on`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `credit_transaction`
--
ALTER TABLE `credit_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs_has_add_on`
--
ALTER TABLE `jobs_has_add_on`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_transaction`
--
ALTER TABLE `job_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
