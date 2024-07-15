-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2024 at 08:25 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farmrental_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `farms`
--

CREATE TABLE `farms` (
  `farm_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `size` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `document` blob NOT NULL,
  `farm_image` blob NOT NULL,
  `status` tinyint(1) NOT NULL,
  `fertile` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farms`
--

INSERT INTO `farms` (`farm_id`, `user_id`, `size`, `description`, `price`, `document`, `farm_image`, `status`, `fertile`, `created`) VALUES
(31, 28, '2', 'This farm is legal and mine ', '100000.00', 0x52454d41494e444552202e706466, 0x313030303130373438332e6a7067, 1, 'the crops suitable is maize and rice', '2024-06-06 05:27:58'),
(32, 28, '3', 'This farmland is mineand ligely  found Arusha Meru', '300000.00', 0x4d69737365642050726573656e746174696f6e2e706466, 0x313030303130373437382e6a7067, 1, 'the area is suitable for growing crops maize and rice', '2024-06-06 05:37:43'),
(33, 29, '4', ' i ahave been working on this farms but right now Iam Finding for the one to rent this farm is legally', '400000.00', 0x4d69737365642050726573656e746174696f6e2e706466, 0x313030303130373438312e6a7067, 1, 'the soil is siutable for farming crops Rice and maize', '2024-06-06 05:51:18'),
(34, 29, '6', 'This farm is legaly and mine ', '400000.00', 0x524553504f4e53455350442e706466, 0x313030303130373437372e6a7067, 1, 'The soil is ferile forr the farming crops rice and maize only', '2024-06-06 05:53:25');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `farm_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT current_timestamp(),
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `farm_id`, `order_date`, `start_date`, `end_date`, `total_amount`, `status`) VALUES
(106, 30, 32, '2024-06-06', '2024-06-06', '2024-06-29', '300000.00', 1),
(107, 31, 34, '2024-06-06', '2024-06-06', '2024-06-29', '400000.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `descriptions` varchar(255) DEFAULT NULL,
  `created-at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `name`, `descriptions`, `created-at`) VALUES
(4, 'Register', 'Enable users to create an account', '2024-05-17'),
(5, 'Login', 'Enable users to enter in the system after  registration', '2024-05-17'),
(6, 'Logout', 'Enable users to leave out of the System ', '2024-05-17'),
(7, 'Read', 'Permits users to view existing content without making changes', '2024-05-17'),
(8, 'Add', 'Allows users to add new content or  data to the system', '2024-05-17'),
(9, 'Update', ' Grants permission for users to edit and make changes to existing content or data', '2024-05-17'),
(10, 'Delete', 'Provides authority for removing content from the system entirely', '2024-05-17'),
(11, 'ViewDashboard', 'Permission users to view the main dashboard', '2024-05-17'),
(12, 'Rent', 'Permission renter to rent farmland', '2024-05-17'),
(14, 'Postfarm', 'Enable  farmer to post their farm details', '2024-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `rolepermissions`
--

CREATE TABLE `rolepermissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rolepermissions`
--

INSERT INTO `rolepermissions` (`role_id`, `permission_id`, `created_date`) VALUES
(4, 4, '2024-05-29'),
(4, 5, '2024-05-28'),
(4, 6, '2024-05-27'),
(4, 7, '2024-05-27'),
(4, 8, '2024-05-27'),
(4, 9, '2024-05-27'),
(4, 10, '2024-05-29'),
(4, 11, '2024-05-27'),
(5, 5, '2024-05-29'),
(5, 9, '2024-05-29'),
(5, 11, '2024-05-27'),
(6, 4, '2024-05-29'),
(6, 5, '2024-05-28'),
(6, 14, '2024-05-23'),
(7, 4, '2024-05-29'),
(7, 5, '2024-05-28'),
(7, 6, '2024-05-27'),
(7, 10, '2024-05-29'),
(7, 12, '2024-05-28');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `name`, `description`, `created_at`) VALUES
(4, 'Administrator', 'An administrator manages and oversees the operation of the farm rental system ', '2024-05-17'),
(5, 'ExtensionOfficer', 'An extension officer provides farmland  approval  services  to farmers', '2024-05-17'),
(6, 'Farmer', 'A farmer is responsible for posting farmland to extension officers for approvals', '2024-05-17'),
(7, 'Renter', 'A renter has access to rent farmland through lease agreements', '2024-05-17');

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

CREATE TABLE `userroles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userroles`
--

INSERT INTO `userroles` (`user_id`, `role_id`, `created_date`) VALUES
(1, 4, '2024-06-06'),
(26, 5, '2024-06-06'),
(27, 5, '2024-06-06'),
(28, 6, '2024-06-06'),
(29, 6, '2024-06-06'),
(30, 7, '2024-06-06'),
(31, 7, '2024-06-06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `region` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `region`, `district`, `phone`, `email`, `password`, `created_at`) VALUES
(1, 'omary said omollo', 'Pwani', 'Rufiji', '0672488849', 'omarysaid@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-05-17'),
(26, 'Mussa Helman Mussa', 'Arusha', 'Meru', '0678767654', 'mussahelman@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '2024-06-06'),
(27, 'Juma Helma Juma', 'Mbeya', 'Chunya', '0678765654', 'jumahelman@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '2024-06-06'),
(28, 'Said Ally Said', 'Arusha', 'Meru', '0624575041 ', 'saidally@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '2024-06-06'),
(29, 'Omary Ally Omary', 'Mbeya', 'Chunya', '0786765435', 'omaryally@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '2024-06-06'),
(30, 'Othman Juma Othman', 'Dodoma', 'Bahi', '0675876576', 'othmanjuma@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '2024-06-06'),
(31, 'Ozward Juma Ozward', 'Mbeya', 'Chunya', '0765768765', 'ozwardjuma@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', '2024-06-06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `farms`
--
ALTER TABLE `farms`
  ADD PRIMARY KEY (`farm_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `farm_id` (`farm_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `rolepermissions`
--
ALTER TABLE `rolepermissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `userroles`
--
ALTER TABLE `userroles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `farms`
--
ALTER TABLE `farms`
  MODIFY `farm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `farms`
--
ALTER TABLE `farms`
  ADD CONSTRAINT `farms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`farm_id`) REFERENCES `farms` (`farm_id`);

--
-- Constraints for table `rolepermissions`
--
ALTER TABLE `rolepermissions`
  ADD CONSTRAINT `rolepermissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rolepermissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE;

--
-- Constraints for table `userroles`
--
ALTER TABLE `userroles`
  ADD CONSTRAINT `userroles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `userroles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
