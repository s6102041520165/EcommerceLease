-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2020 at 08:39 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `quantity`) VALUES
(30, 4, 3, 1585809011, 3, 1585809011, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sub_category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `sub_category`) VALUES
(1, 'กล้อง', NULL),
(2, 'กล้องฟิล์ม', 1),
(3, 'กล้อง DSLR', 1),
(4, 'กล้องMirrorless ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lease`
--

CREATE TABLE `lease` (
  `id` int(11) NOT NULL,
  `lease_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `lease_time` time NOT NULL,
  `due_time` time NOT NULL,
  `description` text DEFAULT NULL,
  `grand_total` double NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 8
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lease`
--

INSERT INTO `lease` (`id`, `lease_date`, `due_date`, `lease_time`, `due_time`, `description`, `grand_total`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(1, '2020-04-01', '2020-04-04', '00:00:00', '00:00:00', 'ttttttttttttttttttt', 6000, 1585753619, 3, 1585755385, 3, 8),
(2, '2020-04-02', '2020-04-08', '00:00:00', '00:00:00', '', 2000, 1585769821, 3, 1585769821, 3, 8),
(3, '2020-04-02', '2020-04-04', '00:00:00', '00:00:00', '', 6000, 1585770165, 3, 1585770165, 3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `lease_detail`
--

CREATE TABLE `lease_detail` (
  `id` int(11) NOT NULL,
  `lease_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lease_detail`
--

INSERT INTO `lease_detail` (`id`, `lease_id`, `product_id`, `qty`) VALUES
(1, 1, 3, 3),
(2, 2, 2, 1),
(3, 3, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1584418695),
('m130524_201442_init', 1585669283),
('m190124_110200_add_verification_token_column_to_user_table', 1585669283),
('m200317_041912_create_profile_table', 1585669283),
('m200317_041935_create_category_table', 1585669283),
('m200317_041947_create_product_table', 1585669283),
('m200317_042001_create_orders_table', 1585669283),
('m200317_042027_create_order_detail_table', 1585669283),
('m200317_042041_create_lease_table', 1585669283),
('m200317_042049_create_lease_detail_table', 1585669283),
('m200317_042050_create_bank_table', 1585669283),
('m200317_042100_create_payment_table', 1585669284),
('m200401_064507_create_cart_table', 1585723585);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `grand_total` double NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `grand_total`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(17, 400000, 9, 1585771788, 1585772270, 3, 3),
(18, 1000000, 8, 1585777883, 1585777883, 3, 3),
(19, 800000, 9, 1585778172, 1585778185, 3, 3),
(20, 1000000, 9, 1585779945, 1585779966, 3, 3),
(21, 800000, 9, 1585804540, 1585804561, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `qty`) VALUES
(8, 17, 2, 2),
(9, 18, 3, 3),
(10, 18, 5, 2),
(11, 19, 2, 2),
(12, 19, 5, 2),
(13, 20, 5, 5),
(14, 21, 4, 2),
(15, 21, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `receipt_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `source_bank` varchar(255) NOT NULL,
  `destination_bank` int(11) NOT NULL,
  `slip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `picture` text DEFAULT NULL,
  `price_for_order` double DEFAULT NULL,
  `price_for_lease` double DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `unit_name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `picture`, `price_for_order`, `price_for_lease`, `stock`, `unit_name`, `category_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'Class aptent taciti sociosqu', 'Sed lectus. Praesent nec nisl a purus blandit viverra. Fusce pharetra convallis urna. Maecenas nec odio et ante tincidunt tempus. Morbi mollis tellus ac sapien.\r\n\r\nProin faucibus arcu quis ante. In ac felis quis tortor malesuada pretium. Vestibulum eu odio. Aenean vulputate eleifend tellus. Cras dapibus.\r\n\r\nProin magna. Vestibulum suscipit nulla quis orci. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Fusce neque. Curabitur at lacus ac velit ornare lobortis.', 'product/1585702660_1949261748.jpg', 200000, 2000, 16, 'เครื่อง', 3, 3, 3, 1585702371, 1585778172),
(3, 'น้ำดื่มคริสตัล 1.5 ', 'Suspendisse nisl elit, rhoncus eget, elementum ac, condimentum eget, diam. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros.', 'product/1585703055_1659638989.png', 200000, 2000, 16, 'เครื่อง', 4, 3, 3, 1585703055, 1585777883),
(4, 'Praesent ac massa at ligula', 'Nulla neque dolor sagittis egetQuisque id mi. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Maecenas egestas arcu quis ligula mattis placerat. Nullam nulla eros, ultricies sit amet, nonummy id, imperdiet feugiat, pede. Ut id nisl quis enim dignissim sagittis.\r\n\r\nCurabitur nisi. Curabitur nisi. Suspendisse eu ligula. Phasellus viverra nulla ut metus varius laoreet. Aliquam lobortis.\r\n\r\nAenean imperdiet. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus dolor. Fusce vulputate eleifend sapien. Quisque rutrum.', 'product/1585703358_1867859645.png', 200000, 2000, 17, 'เครื่อง', 4, 3, 3, 1585703358, 1585804540),
(5, 'น้ำดื่มคริสตัล 1.5 ', 'jjjjjjjjjjj', 'product/1585703483_4359328432.png,product/1585703483_1898249199.png', 200000, 2000, 189, 'เครื่อง', 1, 3, 3, 1585703483, 1585804540);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `picture` varchar(50) DEFAULT NULL,
  `dob` date NOT NULL,
  `address` text DEFAULT NULL,
  `subdistrict` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `zipcode` varchar(6) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `f_name`, `l_name`, `picture`, `dob`, `address`, `subdistrict`, `district`, `province`, `zipcode`, `user_id`) VALUES
(4, 'วีรชัย', 'ปลอดแก้ว', 'profile/1585746557_5162375637.png', '1997-02-09', 'aaaaaaaaa', 'นาโหนด', 'อำเภอ', 'พัทลุง', '93000', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(3, 'clkeen157', 'AwlBdHCYLtTCyjO_j_ejMq0-rC1pb7DH', '$2y$13$KP5L4mZhHzd6HAGK/BaoX.OKOuf/7CLUlDCqC7i5ixIeM1I7kCUOO', NULL, 'clkeen157@gmail.com', 10, 1585670092, 1585779859, 'gYkQXgfHe-SDmo-87YOJddbeYDPAL0ld_1585670092');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_number` (`account_number`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-cart-product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `lease`
--
ALTER TABLE `lease`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lease_detail`
--
ALTER TABLE `lease_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-lease_detail-lease_id` (`lease_id`),
  ADD KEY `fk-lease_detail-product_id` (`product_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-order_detail-order_id` (`order_id`),
  ADD KEY `fk-order_detail-product_id` (`product_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-payment-destination_bank` (`destination_bank`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-product-category_id` (`category_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lease`
--
ALTER TABLE `lease`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lease_detail`
--
ALTER TABLE `lease_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk-cart-product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lease_detail`
--
ALTER TABLE `lease_detail`
  ADD CONSTRAINT `fk-lease_detail-lease_id` FOREIGN KEY (`lease_id`) REFERENCES `lease` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-lease_detail-product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk-order_detail-order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-order_detail-product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk-payment-destination_bank` FOREIGN KEY (`destination_bank`) REFERENCES `bank` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk-product-category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk-profile-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
