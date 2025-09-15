-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 07:57 PM
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
-- Database: `dbhw9`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`) VALUES
(1, 'แบบทั่วไป', 'เสื้อผ้าผู้ใหญ่แบบทางการ', 'uploads/เสื้อขาวผู้ใหญ่3-683x1024.jpg'),
(2, 'เสื้อลายไทย', 'เสื้อลายไทย', 'uploads/หมวด2.jpg'),
(3, 'เสื้อผู้ใหญ่', 'เสื้อผู้ใหญ่', 'uploads/10.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `forename` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `add1` varchar(255) DEFAULT NULL,
  `add2` varchar(255) DEFAULT NULL,
  `add3` varchar(255) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `registered` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_addresses`
--

CREATE TABLE `delivery_addresses` (
  `id` int(11) NOT NULL,
  `forename` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `add1` varchar(255) DEFAULT NULL,
  `add2` varchar(255) DEFAULT NULL,
  `add3` varchar(255) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `delivery_add_id` int(11) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `session` varchar(50) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `cat_id`, `name`, `description`, `image`, `price`, `stock`) VALUES
(1, 1, 'เสื้อขาวผู้ใหญ่ สไตล์คลาสสิก', 'เสื้อขาวลุคสุดคลาสสิก เลือกใช้ผ้าซาตินสีขาวสไตล์จีน ลงตัวกับแพทเทิร์นเสื้อคอจีนติดกระดุมผ่าหน้าแขนยาว', 'uploads/เสื้อขาวผู้ใหญ่3-683x1024.jpg', 129.00, 0),
(2, 1, 'เสื้อขาว เสริมออร่า', 'ผู้ใหญ่ที่อยากใส่เสื้อขาวให้ดูเปล่งประกายเสริมออร่า ต้องเสื้อคอผูกโบว์ดูสวยไฮโซ  ถือว่าเป็นแพทเทิร์นเสื้อที่ฮิตอมตะจริงๆ ใส่แล้วเรียบร้อยสวยงาม', 'uploads/2.jpg', 149.00, 0),
(3, 1, 'เสื้อขาว สวยละมุน', 'เสื้อผ้าฝ้ายสีขาวที่มีดีเทลสวยๆ ทั้งคอเสื้อหยดน้ำมีโบว์ แขนเสื้อทรงทิวลิป มีระบายชายเสื้อ ช่วยเสริมบุคลิกภาพให้ดูอ่อนหวานละมุน', 'uploads/3.jpg', 99.00, 0),
(4, 1, 'เสื้อลำลองผู้ใหญ่ ดูดีมีเสน่ห์', 'แบบเสื้อผู้ใหญ่ ลุคนี้ดูมีเสน่ห์ ใส่ไปเที่ยว ไปทำงาน ใส่ได้หลายโอกาส เสื้อคอปาดสวยๆ กับแขนผ่าจะยาวถึงข้อมือ แต่ตรงระหว่างแขนเสื้อจะมีการผ่าออกจนถึงชายแขนเสื้อ  ทำให้ดูสวยทันสมัย\r\n\r\n', 'uploads/4.jpg', 199.00, 0),
(5, 1, 'เสื้อลำลองผู้ใหญ่ น่ารักสไตล์ญี่ปุ่น', 'เสื้อผู้ใหญ่สไตล์ญี่ปุ่น ลุคน่ารักอบอุ่น ดูมินิมอลด้วยแบบเสื้อคอกลม แขน cap จะเป็นแขนเสื้อที่สั้นโดยล้ำออกมาจากไหล่เพียงเล็กน้อย ทำให้ใส่สบาย แนะนำให้เลือกใช้ผ้าฝ้ายลายสก็อตโทนสีหวาน\r\n\r\n', 'uploads/5.jpg', 299.00, 0),
(6, 1, 'เสื้อลำลองผู้ใหญ่ คอวีมีปกทันสมัยแขนมารี', 'เป็นแบบเสื้อผู้ใญ่ทันสมัยอีกแนว ที่โดดเด่นด้วยการใช้ผ้าชีฟองเย็บแขนเสื้อทรงมารี แขนเสื้อดูโป่งพองเป็นชั้นๆ ลงตัวกับคอวีมีปกใส่แล้วสวยเก๋มากๆ ', 'uploads/6.jpg', 169.00, 0),
(7, 1, 'เสื้อลำลองผู้ใหญ่ แบบเสื้อคลุมเรียบหรู', 'เสื้อคลุมใช้ผ้าทวีต แบบผู้ใหญ่สไตล์เกาหลี เรียบหรู ดูคุณนาย ลุคทางการหน่อยๆ เราจะปรับให้ใส่ไปทำงานได้ ใส่ไปเที่ยวก็เลิศมากค่ะ จะใส่แมตช์กับเดรสหรือกางเกงก็สวยไปหมด ใส่ได้หลายโอกาส  \r\n', 'uploads/7.jpg', 325.00, 0),
(8, 1, 'เสื้อผู้ใหญ่ออกงาน คอกลมผ้าลูกไม้ปักดอกลอย แขนสามส่วน', 'ผู้ใหญ่ที่ต้องการเสื้อออกงานที่สวมใส่สบาย แนะนำเสื้อคอกลมแขนสามส่วน มีระบายที่ชายเสื้อช่วยเสริมบุคลิกให้ดูอ่อนหวาน แนะนำใช้ผ้าลูกไม้ปักดอกลอย3D หรือลูกไม้ผ้าฝ้ายจะได้ใส่สวย ใส่สบายระบายอากาศได้ดี\r\n\r\n', 'uploads/8.jpg', 125.00, 0),
(9, 1, 'เสื้อผู้ใหญ่ออกงาน คอปาดผ้าลูกไม้ แขน lantern', 'เป็นเสื้อลูกไม้คอปาดที่งดงาม ลงตัวกับแขนเสื้อยาวปลายพองทรง lantern เป็นแขนเสื้อสไตล์ผู้ดีอังกฤษ เหมาะสมกับวัยผู้ใหญ่เป็นอย่างยิ่ง สามารถสวมใส่ไปงานเลี้ยง, งานสังสรรค์, งานบวช, งานแต่ง หรือเป็นชุดแม่บ่าวเจ้าสาว\r\n\r\n', 'uploads/9.jpg', 39.00, 0),
(10, 2, 'เสื้อลายไทยสีชมพู่', 'เสื้อผ้าไหมผู้ใหญ่คอฮาวายแขนสามส่วน เนื้อผ้าไหมญี่ปุ่น แต่งด้วยผ้าลายไทยพร้อมลายปักดอกไม้สวยงาม\r\n\r\n', 'uploads/17.jpg', 129.00, 0),
(11, 2, 'เสื้อลายไทยสีเขียว', 'เสื้อผ้าไหมผู้ใหญ่คอฮาวายแขนสามส่วน เนื้อผ้าไหมญี่ปุ่น แต่งด้วยผ้าลายไทยพร้อมลายปักดอกไม้สวยงาม\r\n', 'uploads/18.jpg', 129.00, 0),
(12, 2, 'เสื้อลายไทยสีฟ้า', 'เสื้อผ้าไหมผู้ใหญ่คอฮาวายแขนสามส่วน เนื้อผ้าไหมญี่ปุ่น แต่งด้วยผ้าลายไทยพร้อมลายปักดอกไม้สวยงาม\r\n', 'uploads/19.jpg', 129.00, 0),
(13, 2, 'เสื้อลายไทยสีชมพุ่อ่อน', 'เสื้อผ้าไหมผู้ใหญ่คอฮาวายแขนสามส่วน เนื้อผ้าไหมญี่ปุ่น แต่งด้วยผ้าลายไทยพร้อมลายปักดอกไม้สวยงาม\r\n', 'uploads/20.jpg', 129.00, 0),
(14, 3, 'เสื้อผู้ใหญ่', 'เสื้อผ้าปกเชิ้ตค้อตต้อนผสมผ้าสลาฟ งานแต่งลูกไม้สาปหน้าและปลายแขนพร้อมแต่งลายปักลายดอกไม้และผีเสื้อ\r\n\r\n', 'uploads/10.jpg', 69.00, 0),
(15, 1, 'เสื้อผ้าผู้ใหญ่ปกปีกนก', 'เสื้อผ้าผู้ใหญ่ปกปีกนกแขนสั้นค้อตต้อนผสมผ้าสลาฟ งานแต่งลูกไม้สาปหน้าและบ่า\r\n\r\n', 'uploads/11.jpg', 159.00, 0),
(16, 1, 'เสื้อผ้าผู้ใหญ่ปกปีกนกแขนสีขาว', 'เสื้อผ้าผู้ใหญ่ปกปีกนกแขนสั้นค้อตต้อนผสมผ้าสลาฟ งานแต่งลูกไม้สาปหน้าและบ่า\r\n\r\n', 'uploads/12.jpg', 159.00, 0),
(17, 2, 'เสื้อผ้าไหมผู้ใหญ่', 'เสื้อผ้าไหมผู้ใหญ่คอกล้วยแขนสามส่วน เนื้อผ้าไหมญี่ปุ่น แต่งด้วยผ้าลายไทยพร้อมลายปักดอกไม้สวยงาม\r\n\r\n', 'uploads/13.jpg', 179.00, 0),
(19, 1, 'เสื้อผ้าผู้ใหญ่ปกปีกนกแขนสีขาว', 'เสื้อผ้าผู้ใหญ่ปกปีกนกแขนสั้นค้อตต้อนผสมผ้าสลาฟ งานแต่งลูกไม้สาปหน้าและบ่า\r\n\r\n', 'uploads/12.jpg', 159.00, 0),
(20, 3, 'เสื้อสีฟ้า', 'เสื้อฟ้า', 'uploads/16.jpg', 99.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `age` int(11) NOT NULL,
  `province` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('Admin','Customer','Manager') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `gender`, `age`, `province`, `email`, `role`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Admin', 'User', 'Male', 30, 'Sakeao', 'admin@example.com', 'Admin'),
(2, 'Kittamate', '81dc9bdb52d04dc20036dbd8313ed055', 'Kittamate', 'Srithuam', 'Male', 30, 'ปทุม', 'Kittamateth@gmail.com', 'Customer'),
(4, 'manage', '81dc9bdb52d04dc20036dbd8313ed055', 'manage', 'User', 'Male', 30, 'Sakeao', 'manage@example.com', 'Manager'),
(5, 'Sitin', '$2y$10$rzIcSNQzW.NPbfpZsrA0levfONCRvlHlSxo0U6I9c2R1LGsEuXTRy', 'Siti', 'ครับ', 'Male', 0, '', 'Sitin9@gmail.com', 'Manager');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `delivery_add_id` (`delivery_add_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logins`
--
ALTER TABLE `logins`
  ADD CONSTRAINT `logins_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`delivery_add_id`) REFERENCES `delivery_addresses` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
