-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2023 at 05:06 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Smartphones'),
(2, 'Laptops'),
(3, 'Tablets'),
(4, 'Smartwatches'),
(5, 'Headphones'),
(6, 'Camera');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_description` text DEFAULT NULL,
  `item_quantity` int(11) DEFAULT 0,
  `item_price` decimal(10,2) DEFAULT 0.00,
  `item_location` varchar(100) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `category_id` int(11) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`item_id`, `item_name`, `item_description`, `item_quantity`, `item_price`, `item_location`, `date_added`, `last_updated`, `category_id`, `manufacturer_id`) VALUES
(1, 'Laptop', 'High-performance laptop with SSD storage', 15, '1200.00', 'Office Room', '2023-08-02', '2023-08-02 04:19:45', 1, 1),
(2, 'Smartphone', 'Android smartphone with great camera', 25, '800.00', 'Living Room', '2023-08-02', '2023-08-02 04:19:45', 2, 2),
(3, 'Tablet', '10-inch tablet with 4G connectivity', 10, '350.00', 'Kitchen', '2023-08-02', '2023-08-02 04:19:45', 3, 3),
(4, 'Headphones', 'Wireless headphones with noise-canceling', 30, '150.00', 'Bedroom', '2023-08-02', '2023-08-02 04:19:45', 5, 5),
(5, 'Camera', 'Mirrorless camera with 4K video recording', 8, '900.00', 'Studio', '2023-08-02', '2023-08-02 04:19:45', 6, 6),
(6, 'Laptop', 'Budget laptop with decent performance', 20, '600.00', 'Living Room', '2023-08-02', '2023-08-02 04:19:45', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_id`, `username`, `password`, `email`, `last_login`) VALUES
(1, 'syazwi', 'syazwi', 'syazwi', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `manufacturer_id` int(11) NOT NULL,
  `manufacturer_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`manufacturer_id`, `manufacturer_name`) VALUES
(1, 'Apple'),
(2, 'Samsung'),
(3, 'Sony'),
(4, 'HP'),
(5, 'Dell'),
(6, 'Lenovo'),
(7, 'Microsoft'),
(8, 'Google'),
(9, 'Bose'),
(10, 'Canon'),
(11, 'Nikon');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_description` text DEFAULT NULL,
  `product_quantity` int(11) DEFAULT 0,
  `product_price` decimal(10,2) DEFAULT 0.00,
  `date_added` date DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `category_id` int(11) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_quantity`, `product_price`, `date_added`, `last_updated`, `category_id`, `manufacturer_id`, `product_image`) VALUES
(2, 'Smartphone S20', 'Flagship smartphone with advanced features', 12, '1000.00', '2023-08-02', '2023-08-09 14:49:16', 1, 2, 'Absolute_Reality_v16_Smartphone_S20_0.jpg'),
(3, 'Tablet Pro', 'Professional-grade tablet with stylus support', 20, '500.00', '2023-08-02', '2023-08-06 13:45:08', 3, 3, 'Absolute_Reality_v16_Tablet_Pro_0.jpg'),
(4, 'Headphones XH800', 'Premium over-ear headphones with Hi-Fi sound', 15, '200.00', '2023-08-02', '2023-08-09 14:49:04', 5, 1, 'Absolute_Reality_v16_Headphones_XH800_0.jpg'),
(5, 'Camera Z50', 'Compact and lightweight camera for travel', 6, '700.00', '2023-08-02', '2023-08-03 09:46:42', 6, 3, 'Absolute_Reality_v16_Camera_Z50_0.jpg'),
(6, 'Laptop L100', 'Affordable laptop for everyday use', 50, '400.00', '2023-08-02', '2023-08-09 15:00:41', 3, 1, 'Absolute_Reality_v16_Laptop_L100_0.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `manufacturer_id` (`manufacturer_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`manufacturer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `manufacturer_id` (`manufacturer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4238;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`manufacturer_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`manufacturer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
