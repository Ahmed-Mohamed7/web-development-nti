-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2022 at 09:35 AM
-- Server version: 8.0.27
-- PHP Version: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinestore`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int UNSIGNED NOT NULL,
  `name` char(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(80) NOT NULL,
  `salary` int NOT NULL,
  `birth_date` date NOT NULL,
  `is_manager` tinyint(1) DEFAULT '0',
  `phone_number` char(80) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `salary`, `birth_date`, `is_manager`, `phone_number`, `address`, `gender`) VALUES
(1, 'ahmed2', 'ahmed@gmail.com', '32aa2fd87338e241978c48ab319641bc', 17000, '1980-12-17', 1, '01127010091', '306 street cairo egypt', 'male'),
(8, 'ahmed', 'ahmed2@gmail.com', '32aa2fd87338e241978c48ab319641bc', 12000, '2000-12-10', 0, '01127010092', 'djfkasdjflkdasjflkjasdfkl sadfkdasjfkljasdfkj', 'male');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int UNSIGNED NOT NULL,
  `name` char(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(5, 'clothes'),
(7, 'electronics'),
(4, 'laptops'),
(1, 'phones');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int UNSIGNED NOT NULL,
  `name` char(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(80) NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `phone_number` char(80) NOT NULL,
  `country` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `email`, `password`, `birthdate`, `address`, `gender`, `phone_number`, `country`) VALUES
(2, 'ahmed124', 'ahmed@gmail.com', '32aa2fd87338e241978c48ab319641bc', '2008-11-11', 'maadi', 'male', '01127010091', 'egypt'),
(4, 'ahmed33', 'ahmed5@gmail.com', '32aa2fd87338e241978c48ab319641bc', '2008-11-11', 'maadi', 'male', '01127010091', 'Egypt'),
(5, 'mohamed', 'mohamed1@gmail.com', '32aa2fd87338e241978c48ab319641bc', '2020-09-09', 'maadi cairo', 'male', '0108481531', 'Egypt');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int UNSIGNED NOT NULL,
  `customer_id` int UNSIGNED NOT NULL,
  `totalprice` int NOT NULL,
  `order_date` date NOT NULL,
  `shipped_date` date NOT NULL,
  `is_vouchered` tinyint(1) NOT NULL,
  `order_address` varchar(255) NOT NULL,
  `is_approved` tinyint(1) DEFAULT '0',
  `voucher_id` int UNSIGNED DEFAULT NULL,
  `payment_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `customer_id`, `totalprice`, `order_date`, `shipped_date`, `is_vouchered`, `order_address`, `is_approved`, `voucher_id`, `payment_id`) VALUES
(24, 2, 700, '2022-02-24', '2022-03-03', 1, 'maadi', 0, 1, 1),
(25, 2, 10000, '2022-02-24', '2022-03-03', 1, 'maadi', 0, 1, 1),
(26, 2, 12000, '2022-02-24', '2022-03-03', 1, 'maadi', 0, 1, 1),
(27, 2, 12000, '2022-02-24', '2022-03-03', 1, 'maadi', 0, 1, 1),
(28, 2, 6000, '2022-02-24', '2022-03-03', 1, 'maadi', 0, 1, 1),
(29, 2, 1500, '2022-02-24', '2022-03-03', 1, 'maadi', 0, 1, 1),
(30, 2, 3500, '2022-02-24', '2022-03-03', 1, 'maadi', 0, 1, 1),
(31, 2, 30000, '2022-02-24', '2022-03-03', 1, 'maadi', 0, 1, 1),
(32, 2, 6004, '2022-02-24', '2022-03-03', 1, 'maadi', 0, 1, 1),
(33, 2, 45000, '2022-02-24', '2022-03-03', 1, 'maadi', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderitem`
--

CREATE TABLE `orderitem` (
  `order_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `totalprice` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orderitem`
--

INSERT INTO `orderitem` (`order_id`, `product_id`, `quantity`, `totalprice`) VALUES
(24, 21, 1, 700),
(29, 20, 3, 1500),
(30, 21, 5, 3500),
(32, 25, 1, 6000),
(32, 26, 2, 4),
(33, 15, 3, 45000);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int UNSIGNED NOT NULL,
  `type` char(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `type`) VALUES
(1, 'cash'),
(2, 'visa');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int UNSIGNED NOT NULL,
  `name` char(80) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(255) NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `vendor_id` int UNSIGNED NOT NULL,
  `size` char(80) DEFAULT NULL,
  `color` char(30) DEFAULT NULL,
  `amount_left` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `image`, `description`, `category_id`, `vendor_id`, `size`, `color`, `amount_left`) VALUES
(12, 'Galaxy s7', 7000, '1645694735506775415120903_sd.jpg', 'Samsung Galaxy S7 Android smartphone. Announced Feb 2016. Features 5.1″ display, Exynos 8890 Octa chipset, 12 MP primary camera', 1, 2, '7 inches', 'red', 50),
(13, 'iphone10', 10000, '16456958362051257741iphone.jpg', 'iphone 10 Android smartphone. Announced Feb 2016. Features 5.1″ display, Exynos 8890 Octa chipset, 12 MP primary camera', 1, 2, '7 inches', 'black', 49),
(14, 'iphone11', 12000, '1645696128635728925iphone11.png', 'iphone11 Android smartphone. Announced Feb 2016. Features 5.1″ display, Exynos 8890 Octa chipset, 12 MP primary camera', 1, 2, '7 inches', 'black', 60),
(15, 'Galaxy s20', 15000, '1645696379816897352samsung.jfif', 'Samsung Galaxy S20 Android smartphone. Announced Feb 2016. Features 5.1″ display, Exynos 8890 Octa chipset, 12 MP primary camera', 5, 2, '7 inches', 'blue', 13),
(16, 'xaomi mi 11 pro', 12000, '16456969931056104890Xiaomi-Mi-11-Ultra.jpg', 'xaomi mi 11 pro Android smartphone. Announced Feb 2016. Features 5.1″ display, Exynos 8890 Octa chipset, 12 MP primary camera', 1, 2, '7 inches', 'blue', 39),
(17, 'lenovo y540', 17000, '16456970991118759303lenovoy540.jpg', 'Legion Y540 (15) Laptop  Features  Desktop-caliber gaming on the go · Windows 10 means epic gaming · A new way to experience games · Gaming has a new look', 4, 2, '17 inches', 'black', 10),
(18, 'macbook', 30000, '1645697670939158948mac.jfif', 'macbook Laptop  Features  Desktop-caliber gaming on the go · Windows 10 means epic gaming · A new way to experience games · Gaming has a new look', 4, 2, '17 inches', 'sliver', 60),
(19, 'Dell g5', 17000, '16456977661960679696dellg5.jpg', 'dell g5 Laptop  Features  Desktop-caliber gaming on the go · Windows 10 means epic gaming · A new way to experience games · Gaming has a new look', 4, 2, '17 inches', 'blue', 25),
(20, 'jacket', 500, '16456982881140002684jacket.jpg', 'high quality jacket', 5, 4, 'xl', 'black', 12),
(21, 'sweeter hooded winter men', 700, '1645698388584356626jacket.jpeg', 'Size: M, Length: 66.5cm, Bust: 106cm, Shoulder: 44cm, Sleeve: 63cm Size: L, Length: 67.5cm, Bust: 110cm, Shoulder: 45cm', 5, 4, 'large', 'black', 19),
(22, 'diro men suit', 5000, '16456984661373873697images.jfif', 'Size: M, Length: 66.5cm, Bust: 106cm, Shoulder: 44cm, Sleeve: 63cm Size: L, Length: 67.5cm, Bust: 110cm, Shoulder: 45cm', 5, 4, 'xlarge', 'black', 30),
(23, 'microwave samsung', 3000, '16456986041805511828bb_9.jpg', 'Samsung microwave ovens are famous for their sturdy build and reliable performance. It&#39;s time to ditch the long and tiresome working hours in the kitchen a', 7, 4, '20 inches', 'black', 15),
(24, 'samsung washing machine', 6000, '164569873122655287ww90t534dan1as.jpg', 'Samsung Front Load Automatic Washing Machine, 9 KG, Inverter Motor, Inox- WW90T534DAN1AS', 7, 4, '20 inches', 'sliver', 30),
(25, 'play station5', 6000, '164570285218461076055120903_sd.jpg', 'play station5play station5play station5', 7, 2, '20 inches', 'black', 0),
(26, 'youssef', 2, '16457156241950530611youssef.jpg', '3bet w 3el', 7, 2, '160cm', 'black', 0);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `customer_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `rate` tinyint NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`customer_id`, `product_id`, `rate`, `description`) VALUES
(2, 26, 1, 'byakol kter w msh berf3 el a3da');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int UNSIGNED NOT NULL,
  `name` char(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(80) NOT NULL,
  `phone_number` char(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `image` char(100) DEFAULT NULL,
  `country` char(100) NOT NULL,
  `is_verified` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `name`, `email`, `password`, `phone_number`, `address`, `website_url`, `image`, `country`, `is_verified`) VALUES
(2, 'ahmed58', 'ahmed@gmail.com', '32aa2fd87338e241978c48ab319641bc', '01127010091', '50 street moneb', 'https://www.w3schools.com/php/', '16456391471764723267duck.jpg', 'Egypt', 1),
(4, 'ahmed', 'ahmed1@gmail.com', '32aa2fd87338e241978c48ab319641bc', '01127010091', '01127010091', 'https://www.linkedin.com/feed/', '16456391471764723267duck.jpg', 'Egypt', 1),
(6, 'Deanna Meyers', 'sybetogupo@mailinator.com', '32aa2fd87338e241978c48ab319641bc', '01127010091', '01127010091', 'https://www.xofyl.co.uk', '../../uploads/164539244958431977duck.jpg', 'Aruba', 1),
(7, 'mohamed ahmed', 'mohamed@gmail.com', '32aa2fd87338e241978c48ab319641bc', '01127010092', '01127010092', 'https://www.linkedin.com/feed/', '../../uploads/16453925152096114185WhatsApp Image 2022-02-18 at 7.04.02 PM.jpeg', 'Egypt', 0),
(8, 'mazen', 'mazen@gmail.com', '32aa2fd87338e241978c48ab319641bc', '01127010092', '01127010092', 'https://www.linkedin.com/feed/', '../../uploads/1645396039582482102yossef.jpeg', 'Egypt', 0),
(9, 'Jenna Lynch', 'ruby@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', '18229234703', 'Dolore voluptate rer', 'https://www.getipo.co.uk', '../../uploads/1645397263216671470youssef.jpeg', 'Egypt', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vouchercode`
--

CREATE TABLE `vouchercode` (
  `id` int UNSIGNED NOT NULL,
  `code` char(80) NOT NULL,
  `description` varchar(255) NOT NULL,
  `is_enable` tinyint(1) NOT NULL,
  `discount_percentage` int NOT NULL,
  `admin_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vouchercode`
--

INSERT INTO `vouchercode` (`id`, `code`, `description`, `is_enable`, `discount_percentage`, `admin_id`) VALUES
(1, 'first50', 'gets 50 percent off for your next purchases', 1, 50, 1),
(3, 'first25', 'get 25% off total price', 1, 25, 8),
(4, 'code10', 'get 10% off for next order', 0, 10, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `voucher_id` (`voucher_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`customer_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vouchercode`
--
ALTER TABLE `vouchercode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vouchercode_ibfk_1` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vouchercode`
--
ALTER TABLE `vouchercode`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_3` FOREIGN KEY (`voucher_id`) REFERENCES `vouchercode` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_4` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `orderitem_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderitem_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vouchercode`
--
ALTER TABLE `vouchercode`
  ADD CONSTRAINT `vouchercode_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
