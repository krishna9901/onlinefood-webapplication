-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2021 at 10:52 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `foodorder_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_info`
--

CREATE TABLE IF NOT EXISTS `customer_info` (
`cus_id` int(10) unsigned NOT NULL,
  `FirstName` varchar(10) DEFAULT NULL,
  `LastName` varchar(10) NOT NULL,
  `tel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_info`
--

INSERT INTO `customer_info` (`cus_id`, `FirstName`, `LastName`, `tel`) VALUES
(23, 'gokul', 'ramesh', '2547774440'),
(24, 'rajan', 'harish', '5647854410'),
;

-- --------------------------------------------------------

--
-- Table structure for table `food_catalogue`
--

CREATE TABLE IF NOT EXISTS `food_catalogue` (
`food_id` int(10) unsigned NOT NULL,
  `cata_name` varchar(50) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `catalog_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_catalogue`
--

INSERT INTO `food_catalogue` (`food_id`, `cata_name`, `Price`, `catalog_id`) VALUES
(1, 'Sandwiches', NULL, 1),
(2, 'Salads', NULL, 4),
(3, 'Eggs', NULL, 5),
(4, 'Breakfast', NULL, 6),
(5, 'Patisserie', NULL, 7),
(6, 'Coffee', NULL, 8),
(7, 'HotChocolate', NULL, 9),
(8, 'Tea', NULL, 10),
(9, 'Beverage', NULL, 11),
(10, 'Meals', NULL, 3),
(11, 'The Veggie Power', 10, 1),
(12, 'The Parisian', 4, 1),
(13, 'The Ultimate', 12, 1),
(14, 'Croque-Monsieur', 4, 1),
(15, 'Croque-Madame', 5, 1),
(16, 'Bikini Sandwich', 6, 1),
(17, 'Salade Nicoise', 6, 4),
(18, 'Salade Paysanne', 5, 4),
(19, 'Salmon Salad', 9, 4),
(20, 'Carrot Salad', 4, 4),
(21, 'Scrambled/Fried eggs', 7, 5),
(22, 'Red &Rouge Omelette', 10, 5),
(23, 'The Biggy Omelette', 10, 5),
(24, 'English Breakfast', 12, 6),
(25, '2 Pancakes', 10, 6),
(26, 'Bacon & Egg cupcake', 8, 6),
(27, 'Mini Croissant', 4, 7),
(28, 'Cookie', 1, 7),
(29, 'Homemade Cake', 4, 7),
(30, 'Americano', 3, 8),
(31, 'Espresso', 3, 8),
(32, 'Macchiato', 4, 8),
(33, 'Cappuccino', 4, 8),
(34, 'Latte', 3, 8),
(35, 'Mocha latte', 3, 8),
(36, 'Ciobar Hot Chocolate', 6, 9),
(37, 'Dark Chocolate', 5, 9),
(38, 'Milk Chocolate', 5, 9),
(39, 'Orange/cinnamon', 4, 10),
(40, 'Wild berry', 6, 10),
(41, 'Peppermint', 3, 10),
(42, 'Earl grey', 4, 10),
(43, 'Lady grey', 5, 10),
(44, 'Lavender', 5, 10),
(45, 'English breakfast', 7, 10),
(46, 'Harbin', 4, 11),
(47, 'Soft Drinks', 2, 11),
(49, 'Banana Milkshake', 2, 12),
(50, 'Discount', -1, 51),
(51, 'Discounts', NULL, 51);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
`order_id` int(10) unsigned NOT NULL,
  `cus_id` varchar(6) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `payed` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `cus_id`, `Date`, `Time`, `payed`) VALUES
(1, '24', '2019-11-14', '05:00:00', 1),
(4, '55', '2020-03-09', '20:20:46', 1),
(8, '54', '2020-11-26', '20:24:54', 1),
(12, '59', '2020-11-26', '20:46:19', 1),
(17, '60', '2020-11-27', '12:14:51', 1),
(18, '55', '2020-11-27', '12:15:51', 1),
(19, '55', '2020-11-27', '18:30:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_food`
--

CREATE TABLE IF NOT EXISTS `order_food` (
`item_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned DEFAULT NULL,
  `food_id` int(10) unsigned DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_food`
--

INSERT INTO `order_food` (`item_id`, `order_id`, `food_id`, `Quantity`) VALUES
(1, 1, 11, 1),
(2, 1, 13, 4),
(3, 1, 18, 4),
(4, 1, 30, 3),
(7, 4, 11, 1),
(8, 4, 13, 1),
(9, 4, 48, 2),
(10, 4, 50, 1),
(19, 8, 12, 1),
(20, 8, 49, 2),
(25, 12, 12, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_info`
--
ALTER TABLE `customer_info`
 ADD PRIMARY KEY (`cus_id`);

--
-- Indexes for table `food_catalogue`
--
ALTER TABLE `food_catalogue`
 ADD PRIMARY KEY (`food_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`order_id`), ADD KEY `customer_id` (`cus_id`);

--
-- Indexes for table `order_food`
--
ALTER TABLE `order_food`
 ADD PRIMARY KEY (`item_id`), ADD KEY `food_id` (`food_id`), ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_info`
--
ALTER TABLE `customer_info`
MODIFY `cus_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `food_catalogue`
--
ALTER TABLE `food_catalogue`
MODIFY `food_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `order_food`
--
ALTER TABLE `order_food`
MODIFY `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=204;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_food`
--
ALTER TABLE `order_food`
ADD CONSTRAINT `order_food_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
