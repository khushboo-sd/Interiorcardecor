-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 09, 2025 at 02:33 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstoredb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`) VALUES
(5, 1, 'thar', 500, 1, 'Mahindra Thar crosses 20,000 booking mark, waiting period ranges between 5-7 months.jpg'),
(6, 4, 'premium seat cover', 300, 12, 'AutoNeo, accesorii auto de calitate pentru tine si masina ta.jpg'),
(7, 4, 'thar', 500, 5, 'Mahindra Thar crosses 20,000 booking mark, waiting period ranges between 5-7 months.jpg'),
(8, 7, 'thar', 500, 1, 'Mahindra Thar crosses 20,000 booking mark, waiting period ranges between 5-7 months.jpg'),
(9, 10, 'premium seat cover', 300, 1, 'AutoNeo, accesorii auto de calitate pentru tine si masina ta.jpg'),
(10, 11, 'thar', 500, 1, 'Mahindra Thar crosses 20,000 booking mark, waiting period ranges between 5-7 months.jpg'),
(11, 11, 'car honda', 500, 1, 'Range Rover - New.jpg'),
(12, 11, 'honda cover', 350, 1, 'Suzuki Swift modified.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(20) NOT NULL,
  `number` int NOT NULL,
  `message` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(2, 11, 'Pavan Kumar', 'dsfsd@gmail.com', 2147483647, 'Very Good and nice work. I appreciate you .');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `total_price` int NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(12, 1, 'khushi', 2147483647, 'dsfsd@gmail.com', 'cash on delivery', 'surya gujarat', ' premium seat cover (1) ', 300, '21-Aug-2025', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(1, 'premium seat cover', 300, 'AutoNeo, accesorii auto de calitate pentru tine si masina ta.jpg'),
(2, 'thar', 500, 'Mahindra Thar crosses 20,000 booking mark, waiting period ranges between 5-7 months.jpg'),
(5, 'car honda', 500, 'Range Rover - New.jpg'),
(6, 'armrest', 4500, 'download (4).jpg'),
(4, 'honda cover', 350, 'Suzuki Swift modified.jpg'),
(9, 'Extra  Folding Seat', 3500, 'extra seat.jpg'),
(8, 'Car ', 5000, 'download (3).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

DROP TABLE IF EXISTS `register`;
CREATE TABLE IF NOT EXISTS `register` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(1, 'khushboo', 'dsfsd@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'user'),
(3, 'babita', 'krishnashikha1821@gmail.com', '$2y$10$G8cTQWC/UrZIQQlUqycMjumgrgtT9XrxM.vUYH7jq1waS/E2raV9C', 'user'),
(4, 'kanha', 'khvaish12@gmail.com', '$2y$10$ycthxN4OzoloMP4GFhUuz.6jScDW0JgUqO1du2oyk6NXt7PipXDe.', 'user'),
(5, 'neha', 'harijankhawaish@gmail.com', '$2y$10$56qYHdZQtithNYapOJ7NmOvkHtsSkQLpns0BZWte7MAJXheFv8oBy', 'user'),
(6, 'shreya', 'bhatishikha1841@gmail.com', '$2y$10$CjIxvsDM9MpESG3UjJQfcO/OEvWXxgCZofh4JXAZAi4YcNt75617K', 'admin'),
(7, 'shreya', 'shreya@gmail.com', '$2y$10$gubTQE0Xeuqc2AqJXZdNHev2GAq8dgtKmuqza3fdpFh9xzBZWLc7W', 'user'),
(8, 'khushboo', 'rohitharijan17967@gmail.com', '$2y$10$KjFyT1jiYExqwOtejUcp2O6zH8pdkb66U/8Dpdlf6njAlcFGBzCLS', 'user'),
(9, 'khushi', 'abc@gmail.com', '$2y$10$/sWzOzelOww5R/wB5YFw9.vsLdzIAyWXD8KeReXUxnVkg8bbfbtRC', 'admin'),
(10, 'komal', 'komal@gmail.com', '$2y$10$5BNm1pj6j4hbW/7A61hx6eeZKJ25FibeAM9YbERznE3cMwjxIZjOm', 'user'),
(11, 'khushi', 'khushi@gmail.com', '$2y$10$qLBN49HNSRkcbY2n7psUou6wC27WKPyV6UBmIVfOa7qwAdlzAD3j6', 'user'),
(12, 'Khvaish', 'harijan@gmail.com', '$2y$10$POz7qmgfp6UvuUTZafsGDOhiNGDNo86u8aFJNOBQ.e8rWZ44B8x3a', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
