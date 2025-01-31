-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 05:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Electronics'),
(2, 'Clothing'),
(3, '123 Home and Garden'),
(4, 'Toys and Games'),
(5, 'Sports and Outdoors 222'),
(6, 'Foooooooodddddd'),
(7, 'Books and Stationery'),
(8, 'joojjo'),
(10, 'haha'),
(12, 'new-tttest'),
(13, 'dhdhdhd'),
(16, 'aabbccdd'),
(19, 'Electronics'),
(20, 'PHP');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `tel` varchar(100) NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `first_name`, `last_name`, `tel`, `email`) VALUES
(1, 'aba djdj', 'jdjd eueu', '9658335', 'djfcbsdhjcn@mail.com'),
(2, 'Bob', 'The Noob', '55533366998', 'bob@mail.com'),
(3, 'hi', 'by', '565656555655', 'hiby@mail.com'),
(4, 'aaa', 'ccc', '888 555 7777 2222', 'jjvkgv@mqfif.com'),
(5, 'cc', 'mm', '00113322556644', 'c-m-c-m@mail.com'),
(6, 'akaka2', 'rororor2', '226322222', '22-hhaaha@mail.com'),
(8, 'a', 'b', '5555555 555555', 'ab@fFf.com'),
(9, 'srg srn', 'frbad', '5511521 5515666', 'zddv@asdg.com'),
(13, 'aha', 'eyeye', '993 88856 555756', 'ahahah@mail.com'),
(16, 'thfn', 'thln', '753 159 258 381', 'ddccdd@mail.com');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `total_order_amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_date`, `total_order_amount`) VALUES
(1, 2, NULL, 314.98),
(2, 5, NULL, 1328.92),
(3, 1, NULL, NULL),
(4, NULL, NULL, NULL),
(5, 4, NULL, 20009.3),
(6, 3, '2023-06-14', 3110),
(7, 5, '2023-06-14', 191.99),
(8, 2, '2023-06-14', 122.99),
(9, 4, '2023-06-14', 10751.44),
(11, 3, '2023-06-15', 13062),
(14, 6, '2023-06-15', 6220),
(17, 13, '2023-07-07', 12360),
(18, 9, '2023-07-07', 5),
(19, 5, '2023-07-07', 1321),
(20, 8, '2023-07-09', 74842),
(24, 5, '2023-07-11', 2238),
(25, 8, '2023-07-12', 1100.95),
(27, 3, '2023-07-12', 5595),
(28, 1, '2024-05-14', 2897.99),
(29, 3, '2024-05-16', 2381.84),
(30, 1, '2024-05-18', 936.98),
(31, 1, '2024-05-18', 490),
(32, 2, '2024-05-18', 400),
(33, 4, '2024-05-19', 250),
(34, 4, '2024-05-19', 720),
(35, 5, '2024-05-19', 350),
(36, 5, '2024-05-19', 9000),
(37, 2, '2024-05-19', 0),
(40, 2, '2024-05-19', 70);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double(10,2) DEFAULT NULL,
  `price_x_quantity` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `product_id`, `quantity`, `price`, `price_x_quantity`) VALUES
(1, 2, 1, 191.99, 191.99),
(1, 1, 1, 122.99, 122.99),
(2, 1, 3, 122.99, 368.97),
(2, 2, 5, 191.99, 959.95),
(5, 1, 40, 122.99, 4919.60),
(5, 2, 30, 191.99, 5759.70),
(5, 4, 15, 622.00, 9330.00),
(6, 4, 5, 622.00, 3110.00),
(7, 2, 1, 191.99, 191.99),
(8, 1, 1, 122.99, 122.99),
(9, 2, 56, 191.99, 10751.44),
(11, 4, 21, 622.00, 13062.00),
(14, 4, 10, 622.00, 6220.00),
(17, 4, 5, 622.00, 3110.00),
(17, 9, 4, 1753.00, 7012.00),
(17, 11, 2, 1119.00, 2238.00),
(18, 5, 3, 222255.00, 666765.00),
(18, 6, 1, 35766.00, 35766.00),
(19, 4, 1, 622.00, 622.00),
(19, 7, 3, 233.00, 699.00),
(20, 8, 10, 331.00, 3310.00),
(20, 6, 2, 35766.00, 71532.00),
(24, 11, 2, 1119.00, 2238.00),
(25, 2, 5, 191.99, 959.95),
(25, 6, 3, 35766.00, 107298.00),
(25, 9, 1, 1753.00, 1753.00),
(27, 11, 5, 1119.00, 5595.00),
(28, 2, 1, 191.99, 191.99),
(28, 4, 1, 622.00, 622.00),
(28, 9, 1, 1753.00, 1753.00),
(28, 8, 1, 331.00, 331.00),
(29, 1, 10, 122.99, 1229.90),
(29, 2, 6, 191.99, 1151.94),
(30, 2, 1, 191.99, 191.99),
(30, 1, 1, 122.99, 122.99),
(30, 4, 1, 622.00, 622.00),
(30, 18, 1, 0.00, 0.00),
(31, 19, 7, NULL, 490.00),
(32, 18, 8, NULL, 400.00),
(33, 2, 6, NULL, 0.00),
(33, 18, 5, NULL, 250.00),
(34, 18, 6, NULL, 300.00),
(34, 19, 6, NULL, 420.00),
(35, 18, 7, NULL, 350.00),
(36, 20, 10, NULL, 9000.00),
(37, 2, 3, NULL, 0.00),
(40, 19, 1, NULL, 70.00);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `description` text NOT NULL,
  `picture` text NOT NULL,
  `price_of_purchase` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `brands` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `category`, `quantity`, `price`, `description`, `picture`, `price_of_purchase`, `sale_price`, `brands`) VALUES
(1, 'aa22', 2, 209, 122.99, '22abcd', 'images/products/pic_648472646a01d.png', 50.00, 60.00, 'sdasd'),
(2, '22bb', 3, 123378, 191.99, 'new dscrp oo 11', 'images/products/pic_64847244eda5e.png', 0.00, 0.00, ''),
(4, '2a', 8, 82, 622, '2dds', 'images/products/pic_648a031271c2b.png', 0.00, 0.00, ''),
(5, 'cxcx5', 3, 112, 222255, 'dcsd sdswd wsqs 2', 'images/products/pic_6491ec8c83d60.png', 0.00, 0.00, ''),
(6, 'vnvgs dhydhd5 5', 3, 5560, 35766, 'fjfj hyfh 66', 'images/products/pic_6491ecf482d8d.png', 0.00, 0.00, ''),
(7, '2dfdfdf', 6, 252, 233, 'gnbn rjrjb bmko', 'images/products/pic_6497e9bb6c216.png', 0.00, 0.00, ''),
(8, 'aaavvvv5', 4, 655, 331, 'ssds efefe bvbvb', 'images/products/pic_649844cb1978e.png', 0.00, 0.00, ''),
(9, 'jjgfyumk', 10, 116, 1753, '1vsxdcvfbgn ertyuio', 'images/products/pic_6497ee12a0064.png', 0.00, 0.00, ''),
(11, '1', 1, 2, 1119, '1 desc', 'images/products/pic_6497f3368d4a6.png', 0.00, 0.00, ''),
(18, 'lohiem', 1, 23, 0, 'lohu problemas', 'images/products/pic_6647782757415.png', 20.00, 50.00, 'nav'),
(19, 'putns', 3, 6, 0, '5000', 'images/products/pic_6648b75be3479.jpg', 50.00, 70.00, 'putni'),
(20, 'dziv', 6, 80, 0, 'ediens', 'images/products/pic_6649eabc684c8.png', 30.00, 900.00, 'suns');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` text NOT NULL,
  `tel` varchar(100) NOT NULL,
  `user_role` varchar(100) NOT NULL,
  `user_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `email`, `password`, `tel`, `user_role`, `user_image`) VALUES
(6, 'adminuser-adminpasssss', 'adminuser-adminpass@mail.com', '$2y$10$kFCKY5XwVfJMKgSv53m1OuEcGVnrRRU33mAZQ4rVRBJz3oK8lnnY6', '8822 6699 7733 0511555', 'user', 'images/users/pic_64aecdb2810ba.png'),
(7, 'useruser', 'useruser@mail.com', '$2y$10$V3jLmG2H.QPm99iHdRz9uO5rFTo24spSPzmakH6LEhzOEnbmjxUMy', '2225 3388 9966 7628', 'user', 'images/users/pic_64aecd71819a4.png'),
(17, 'theuser', 'thenewuser@mail.com', '$2y$10$b1Ntp536uMno9N6F61WNaOUcLchaDJ4yWRt7lcaiYYwwiFc0vB6DW', '158 7896 3578', 'admin', 'images/users/pic_64aec81daf417.png'),
(18, 'Ralfsssss', 'Ralfs@mail.com', '$2y$10$moUZK.7p2dT6F9NnuvZA.uCkAckNrO8E7ANOzzgVFbOdEHBFPQ0xe', '123456789', 'admin', 'images/users/pic_6643308e23b71.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `order_details_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
