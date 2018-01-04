-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 08, 2017 at 05:02 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resturant`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts_setting`
--

CREATE TABLE `accounts_setting` (
  `id` int(11) NOT NULL,
  `sales_tax_percentage` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts_setting`
--

INSERT INTO `accounts_setting` (`id`, `sales_tax_percentage`) VALUES
(1, '0.20');

-- --------------------------------------------------------

--
-- Table structure for table `addon`
--

CREATE TABLE `addon` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `addon`
--

INSERT INTO `addon` (`id`, `item_id`, `name`, `price`) VALUES
(74, 58, 'Extra Chicken', '99.00'),
(75, 58, 'Extra Manchurian', '199.00'),
(76, 59, 'Crispy Crust', '199.00'),
(77, 59, 'Deep Fry', '59.00'),
(78, 59, 'Deep-est Fry', '79.00');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `gen_sales_tax` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `payment_mode` varchar(10) NOT NULL,
  `paid_bill` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `order_id`, `grand_total`, `customer_id`, `sub_total`, `gen_sales_tax`, `discount`, `payment_mode`, `paid_bill`, `balance`) VALUES
(24, 5, '5060.00', NULL, '4400.00', '660.00', '0.00', 'cash', '0.00', '0.00'),
(25, 5, '5060.00', NULL, '4400.00', '660.00', '0.00', 'cash', '0.00', '0.00'),
(26, 6, '5976.55', NULL, '5197.00', '779.55', '0.00', 'cash', '0.00', '0.00'),
(27, 7, '12650.00', NULL, '11000.00', '1650.00', '0.00', 'cash', '12650.00', '0.00'),
(28, 8, '138.00', NULL, '120.00', '18.00', '0.00', 'cash', '138.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `contact_number` varchar(100) NOT NULL,
  `gender` bit(1) DEFAULT NULL,
  `type` varchar(25) NOT NULL,
  `image_url` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `quantity_on_hand` smallint(6) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity_unit` varchar(25) NOT NULL,
  `expiry_date` date NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `name`, `quantity_on_hand`, `unit_price`, `quantity_unit`, `expiry_date`, `category`, `image`) VALUES
(43, 'Chicken', 100, '370.00', 'kg', '2017-08-31', 'meat', 'uploads/5984db62aa8b0.jpg'),
(44, 'Black Pepper', 10, '20.00', 'kg', '2019-12-31', 'sauses', 'uploads/5984dbb436955.jpg'),
(46, 'Coca Cola', 483, '75.00', 'l', '2018-06-01', 'beverages', 'uploads/5984dc0de7bea.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_procurement`
--

CREATE TABLE `inventory_procurement` (
  `inventory_id` int(11) NOT NULL,
  `procurement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  `prepration_time` smallint(6) DEFAULT NULL,
  `category_type_id` int(11) NOT NULL,
  `dist_type_id` int(11) NOT NULL,
  `desc` varchar(500) DEFAULT NULL,
  `image_url` varchar(100) DEFAULT NULL,
  `avaliablity` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `name`, `price_per_unit`, `prepration_time`, `category_type_id`, `dist_type_id`, `desc`, `image_url`, `avaliablity`) VALUES
(58, 'Chicken Manchurian', '2200.00', 30, 29, 3, '*Pakh Pakh Pakh Pakh*', 'uploads/5984e09f5d93a.png', 'Y'),
(59, 'Chicken Fry', '999.00', 50, 30, 4, '*Tali hue Murgi*', 'uploads/5984e14eec6c7.png', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE `item_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `image_url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`id`, `category_name`, `image_url`) VALUES
(29, 'Pakistani', 'uploads/5984daed581ca.jpg'),
(30, 'Italian', 'uploads/5984dafbf3291.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `item_recipes`
--

CREATE TABLE `item_recipes` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `quantity_used` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_recipes`
--

INSERT INTO `item_recipes` (`id`, `item_id`, `inventory_id`, `quantity_used`) VALUES
(68, 58, 43, 1),
(69, 58, 44, 1),
(70, 58, 46, 2),
(71, 59, 43, 2),
(72, 59, 46, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_type`
--

CREATE TABLE `item_type` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `image_url` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_type`
--

INSERT INTO `item_type` (`id`, `name`, `image_url`) VALUES
(3, 'Expensive', 'uploads/5984db102bb87.png'),
(4, 'Cheep', 'uploads/5984db1c4acf0.png');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `check_in_time` datetime NOT NULL,
  `check_out_time` datetime DEFAULT NULL,
  `waiter_id` int(11) DEFAULT NULL,
  `number_of_people` tinyint(4) NOT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `gen_sales_tax` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `paid_bill` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `table_id`, `total_cost`, `check_in_time`, `check_out_time`, `waiter_id`, `number_of_people`, `sub_total`, `gen_sales_tax`, `discount`, `paid_bill`, `balance`) VALUES
(5, 8, '5060.00', '2017-08-05 10:16:47', '2017-08-05 02:50:18', NULL, 2, '4400.00', '660.00', '0.00', NULL, NULL),
(6, 9, '5976.55', '2017-08-05 10:16:47', '2017-08-05 14:28:19', NULL, 4, '5197.00', '779.55', '0.00', NULL, NULL),
(7, 10, '0.00', '2017-08-05 10:16:47', NULL, NULL, 7, '0.00', '0.00', '0.00', NULL, NULL),
(8, 11, '138.00', '2017-08-05 10:16:47', NULL, NULL, 1, '120.00', '18.00', '0.00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `wastage_status` varchar(10) NOT NULL COMMENT 'if wastage then 1 else 0',
  `status` varchar(25) NOT NULL COMMENT 'inkitchen, ready, delivered',
  `notes` varchar(500) NOT NULL,
  `quantity` tinyint(4) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `item_id`, `order_id`, `wastage_status`, `status`, `notes`, `quantity`, `total_price`, `order_time`) VALUES
(4, 58, 5, 'No', 'Checked Out', '*Churan complimentary hai?*', 2, '4400.00', '14:30:00'),
(5, 58, 6, 'No', 'Kitchen', '*Churan complimentary hai?*', 1, '2200.00', '14:30:00'),
(6, 59, 6, 'No', 'Kitchen', '*Churan complimentary hai?*', 3, '2997.00', '14:40:00'),
(7, 58, 7, 'Yes', 'Kitchen', '*Churan complimentary hai?*', 5, '0.00', '16:02:00'),
(8, 58, 8, 'No', 'Kitchen', 'Everything complementary should be on my order.', 7, '120.00', '16:26:00'),
(9, 59, 8, 'No', 'Kitchen', 'Stay hungry, stay foolish. ', 4, '0.00', '15:30:00'),
(11, 59, 8, 'No', 'Kitchen', 'Opportunities multiply when sized.', 4, '0.00', '15:59:00'),
(12, 59, 8, 'No', 'Kitchen', 'Some notes by customer.', 4, '0.00', '15:54:00'),
(32, 59, 8, 'No', 'Kitchen', 'Please put some extra Onions', 4, '0.00', '16:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `procurement`
--

CREATE TABLE `procurement` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `quantity` mediumint(9) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `order_date` date DEFAULT NULL,
  `arival_date` date DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `quantity_unit` varchar(25) NOT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `procurement`
--

INSERT INTO `procurement` (`id`, `name`, `quantity`, `unit_price`, `order_date`, `arival_date`, `status`, `vendor_id`, `expire_date`, `quantity_unit`, `inventory_id`, `image`, `category`) VALUES
(21, 'Coca Cola', 500, '75.00', '2017-08-05', '2017-08-07', 'Yes', NULL, '2018-06-01', 'l', 0, 'uploads/5984dc0de7bea.jpg', 'beverages'),
(22, 'Sprite', 50, '50.00', '2017-08-05', '2017-08-07', 'No', NULL, '2020-03-04', 'l', 0, 'uploads/5984dd15603ed.jpg', 'beverages');

-- --------------------------------------------------------

--
-- Table structure for table `table_status`
--

CREATE TABLE `table_status` (
  `table_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_status`
--

INSERT INTO `table_status` (`table_id`, `name`, `status`) VALUES
(8, 'Table 1', 'Yes'),
(9, 'Table 2', 'Yes'),
(10, 'Table 3', 'Yes'),
(11, 'Table 4', 'Yes'),
(12, 'Table 5', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `type` varchar(50) NOT NULL,
  `image_url` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `password`, `type`, `image_url`) VALUES
(8, 'maviakhan', 'admin123', 'admin', 'uploads/5984dfec91130.jpg'),
(9, 'azeemullah', 'admin123', 'admin', 'uploads/5984e01abbf6f.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `contact_number` varchar(100) NOT NULL,
  `image_url` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `waiter`
--

CREATE TABLE `waiter` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `contact_number` varchar(100) DEFAULT NULL,
  `gender` bit(1) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `hiring_date` date DEFAULT NULL,
  `salary` mediumint(9) DEFAULT NULL,
  `image_url` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wastage`
--

CREATE TABLE `wastage` (
  `id` int(11) NOT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `quantity` smallint(6) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `approved` varchar(10) NOT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'order canceled',
  `image` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wastage`
--

INSERT INTO `wastage` (`id`, `inventory_id`, `order_id`, `quantity`, `cost`, `approved`, `category`, `image`) VALUES
(51, 43, 7, 1, '370.00', 'No', 'order canceled', NULL),
(52, 44, 7, 1, '20.00', 'No', 'order canceled', NULL),
(53, 46, 7, 2, '75.00', 'No', 'order canceled', NULL),
(54, 43, 8, 1, '370.00', 'No', 'order canceled', NULL),
(55, 44, 8, 1, '20.00', 'No', 'order canceled', NULL),
(56, 46, 8, 2, '75.00', 'No', 'order canceled', NULL),
(57, 43, 8, 1, '370.00', 'No', 'order canceled', NULL),
(58, 44, 8, 1, '20.00', 'No', 'order canceled', NULL),
(59, 46, 8, 2, '75.00', 'No', 'order canceled', NULL),
(60, 43, 8, 1, '370.00', 'No', 'order canceled', NULL),
(61, 44, 8, 1, '20.00', 'No', 'order canceled', NULL),
(62, 46, 8, 2, '75.00', 'No', 'order canceled', NULL),
(63, 43, 8, 1, '370.00', 'No', 'order canceled', NULL),
(64, 44, 8, 1, '20.00', 'No', 'order canceled', NULL),
(65, 46, 8, 2, '75.00', 'No', 'order canceled', NULL),
(66, 43, 7, 1, '370.00', 'No', 'order canceled', NULL),
(67, 44, 7, 1, '20.00', 'No', 'order canceled', NULL),
(68, 46, 7, 2, '75.00', 'No', 'order canceled', NULL),
(69, 43, 8, 2, '370.00', 'No', 'order canceled', NULL),
(70, 46, 8, 1, '75.00', 'No', 'order canceled', NULL),
(71, 43, 8, 1, '370.00', 'No', 'order canceled', NULL),
(72, 44, 8, 1, '20.00', 'No', 'order canceled', NULL),
(73, 46, 8, 2, '75.00', 'No', 'order canceled', NULL),
(74, 43, 8, 1, '370.00', 'No', 'order canceled', NULL),
(75, 44, 8, 1, '20.00', 'No', 'order canceled', NULL),
(76, 46, 8, 2, '75.00', 'No', 'order canceled', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts_setting`
--
ALTER TABLE `accounts_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addon`
--
ALTER TABLE `addon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`,`order_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_procurement`
--
ALTER TABLE `inventory_procurement`
  ADD PRIMARY KEY (`inventory_id`,`procurement_id`),
  ADD KEY `inventory_id` (`inventory_id`),
  ADD KEY `procurement_id` (`procurement_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_type_id` (`category_type_id`),
  ADD KEY `dist_type_id` (`dist_type_id`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_recipes`
--
ALTER TABLE `item_recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_id` (`inventory_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `item_type`
--
ALTER TABLE `item_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `table_id` (`table_id`),
  ADD KEY `waiter_id` (`waiter_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `procurement`
--
ALTER TABLE `procurement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `inventory_id` (`inventory_id`);

--
-- Indexes for table `table_status`
--
ALTER TABLE `table_status`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waiter`
--
ALTER TABLE `waiter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wastage`
--
ALTER TABLE `wastage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `inventory_id` (`inventory_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts_setting`
--
ALTER TABLE `accounts_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `addon`
--
ALTER TABLE `addon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `item_recipes`
--
ALTER TABLE `item_recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `item_type`
--
ALTER TABLE `item_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `procurement`
--
ALTER TABLE `procurement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `table_status`
--
ALTER TABLE `table_status`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `waiter`
--
ALTER TABLE `waiter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wastage`
--
ALTER TABLE `wastage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `addon`
--
ALTER TABLE `addon`
  ADD CONSTRAINT `addon_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `bill_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `inventory_procurement`
--
ALTER TABLE `inventory_procurement`
  ADD CONSTRAINT `inventory_procurement_ibfk_1` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`),
  ADD CONSTRAINT `inventory_procurement_ibfk_2` FOREIGN KEY (`procurement_id`) REFERENCES `procurement` (`id`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`category_type_id`) REFERENCES `item_category` (`id`),
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`dist_type_id`) REFERENCES `item_type` (`id`);

--
-- Constraints for table `item_recipes`
--
ALTER TABLE `item_recipes`
  ADD CONSTRAINT `item_recipes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `item_recipes_ibfk_2` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `table_status` (`table_id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`waiter_id`) REFERENCES `waiter` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `procurement`
--
ALTER TABLE `procurement`
  ADD CONSTRAINT `procurement_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`);

--
-- Constraints for table `wastage`
--
ALTER TABLE `wastage`
  ADD CONSTRAINT `wastage_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `wastage_ibfk_3` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
