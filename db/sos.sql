-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3310
-- Generation Time: Jun 05, 2024 at 06:56 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sos`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(55, 4, 8, 1, '2024-05-08 02:30:32'),
(59, 4, 3, 4, '2024-05-08 02:31:19'),
(67, 5, 3, 1, '2024-05-08 03:26:07');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(12,2) NOT NULL,
  `status` enum('Pending','Completed','Cancelled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`) VALUES
(34, 2, '2024-05-08 02:26:08', 105000.00, 'Completed'),
(35, 2, '2024-05-08 02:26:10', 140000.00, 'Completed'),
(36, 4, '2024-05-08 02:30:56', 210000.00, 'Cancelled'),
(37, 4, '2024-05-08 02:30:58', 150000.00, 'Cancelled'),
(38, 4, '2024-05-08 02:31:26', 157000.00, 'Completed'),
(39, 2, '2024-05-08 03:18:23', 471000.00, 'Completed'),
(40, 2, '2024-05-08 03:18:24', 41000.00, 'Cancelled'),
(41, 2, '2024-05-08 03:19:28', 600000.00, 'Cancelled'),
(42, 3, '2024-05-08 03:22:20', 202000.00, 'Completed'),
(43, 3, '2024-05-08 03:22:21', 375000.00, 'Completed'),
(44, 3, '2024-05-08 03:22:22', 82000.00, 'Completed'),
(45, 5, '2024-05-08 03:26:29', 300000.00, 'Completed'),
(46, 5, '2024-05-08 03:26:30', 120000.00, 'Completed'),
(47, 3, '2024-05-08 03:42:43', 202000.00, 'Completed'),
(48, 2, '2024-05-08 05:36:48', 375000.00, 'Completed'),
(49, 3, '2024-05-15 16:51:29', 140000.00, 'Completed'),
(50, 3, '2024-05-15 16:51:29', 157000.00, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(45, 34, 3, 3, 35000.00),
(46, 35, 1, 2, 70000.00),
(47, 36, 1, 3, 70000.00),
(48, 37, 7, 1, 150000.00),
(49, 38, 6, 1, 157000.00),
(50, 39, 6, 3, 157000.00),
(51, 40, 4, 1, 41000.00),
(52, 41, 7, 4, 150000.00),
(53, 42, 2, 2, 101000.00),
(54, 43, 5, 3, 125000.00),
(55, 44, 4, 2, 41000.00),
(56, 45, 7, 2, 150000.00),
(57, 46, 8, 1, 120000.00),
(58, 47, 2, 2, 101000.00),
(59, 48, 5, 3, 125000.00),
(60, 49, 1, 2, 70000.00),
(61, 50, 6, 1, 157000.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('paid','failed') DEFAULT 'paid',
  `payment_method_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `amount`, `payment_date`, `status`, `payment_method_id`) VALUES
(10, 34, 105000.00, '2024-05-08 02:26:18', 'paid', 1),
(11, 35, 140000.00, '2024-05-08 02:26:23', 'paid', 3),
(12, 38, 157000.00, '2024-05-08 02:31:46', 'paid', 2),
(13, 39, 471000.00, '2024-05-08 03:18:38', 'paid', 3),
(14, 42, 202000.00, '2024-05-08 03:22:29', 'paid', 3),
(15, 43, 375000.00, '2024-05-08 03:22:33', 'paid', 1),
(16, 44, 82000.00, '2024-05-08 03:22:40', 'paid', 3),
(17, 45, 300000.00, '2024-05-08 03:26:40', 'paid', 1),
(18, 46, 120000.00, '2024-05-08 03:26:43', 'paid', 3),
(19, 48, 375000.00, '2024-05-08 05:37:09', 'paid', 2),
(20, 49, 140000.00, '2024-05-15 16:51:38', 'paid', 3),
(21, 47, 202000.00, '2024-05-15 16:51:42', 'paid', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `method_id` int(11) NOT NULL,
  `method_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`method_id`, `method_name`) VALUES
(1, 'Credit Card'),
(2, 'Bank Transfer'),
(3, 'E-Wallet');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `region_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `price`, `stock`, `region_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Pie Susu', 'Pie Susu, often known as \"Bali Milk Pie,\" is a traditional Balinese pastry that has gained immense popularity both locally and globally. The pie features a thin, crisp crust filled with a creamy, sweet custard made from milk, sugar, eggs, and vanilla. It is baked to perfection, resulting in a slightly caramelized surface. The pie is usually bite-sized, making it a perfect snack or souvenir. It has a delightful combination of crunchy crust and soft, flavorful custard filling.', 70000.00, 45, 1, 'piesusu.jpg', '2024-05-05 19:36:09', '2024-05-15 16:51:38'),
(2, 'Bali Coffee Beans', 'Bali is renowned for its rich, flavorful coffee beans, primarily Arabica, cultivated in the highland regions such as Kintamani. The fertile volcanic soil and unique climate give the beans distinctive flavors. Balinese coffee often has a fruity aroma with hints of citrus and chocolate. Kintamani coffee, in particular, is known for its balanced acidity, full body, and clean, smooth finish. The traditional Balinese method of processing coffee involves a unique \"wet hulling\" technique.', 101000.00, 46, 1, 'kopibali.jpg', '2024-05-05 19:36:09', '2024-05-15 16:51:42'),
(3, 'Bakpia', 'Bakpia is a popular Indonesian pastry originally inspired by the Chinese \"Tou Sar Piah.\" It consists of a flaky, thin crust filled with sweet or savory fillings. The most famous variant, Bakpia Pathok, is associated with Yogyakarta. Traditional fillings include mung bean paste, but more recent variations include chocolate, cheese, and even durian. The pastries are usually small and round, perfect as snacks or souvenirs.', 35000.00, 47, 2, 'bakpia.jpg', '2024-05-05 19:36:09', '2024-05-15 15:54:55'),
(4, 'Gudeg', 'Gudeg is a traditional Indonesian dish from Yogyakarta made from young jackfruit, slow-cooked in coconut milk, and spices for several hours until it reaches a sweet and savory flavor. It has a distinctive reddish-brown color, usually achieved by adding teak leaves during cooking. Gudeg is often served with rice, boiled eggs, chicken, tofu, and sambal goreng krecek (crispy cattle skin). There are two main types: dry (drier and sweeter) and wet (with more coconut milk).', 41000.00, 48, 2, 'gudeg.jpg', '2024-05-05 19:36:09', '2024-05-15 15:54:55'),
(5, 'Pempek', 'Pempek is a fish cake delicacy originating from Palembang. It is made from ground fish (typically mackerel) and tapioca flour, resulting in a chewy texture. The fish cakes come in various shapes and sizes, with the most popular being Pempek Kapal Selam (submarine-shaped, filled with egg). Pempek is served with a special sweet and sour sauce called \"cuko,\" made from palm sugar, vinegar, and chili, giving it a tangy flavor.', 125000.00, 44, 3, 'pempek.jpg', '2024-05-05 19:36:09', '2024-05-15 15:54:55'),
(6, 'Lapis Legit', 'Lapis Legit, or Spekkoek, is a rich, layered cake influenced by the Dutch during the colonial era. Each layer is meticulously baked one at a time, resulting in a dense and multi-layered structure. It is flavored with spices like cinnamon, cardamom, and nutmeg, reminiscent of Dutch spice cakes. The cake\'s buttery, moist texture and distinctive spice aroma make it a popular festive treat.', 157000.00, 46, 3, 'lapislegit.jpg', '2024-05-05 19:36:09', '2024-05-15 15:54:55'),
(7, 'Bika Ambon', 'Bika Ambon is a traditional Indonesian dessert known for its unique honeycomb-like texture and aromatic flavor. Made from tapioca flour, coconut milk, eggs, sugar, and yeast, it has a chewy, spongy texture. The distinctive flavor comes from the addition of pandan leaves and lemongrass. Despite its name, Bika Ambon did not originate from Ambon but rather Medan. It\'s popular as a gift or souvenir.', 150000.00, 48, 4, 'bikaambon.jpg', '2024-05-05 19:36:09', '2024-05-15 15:54:55'),
(8, 'Bolu Meranti', 'Bolu Meranti is a popular Swiss roll-style cake from Medan. The cake is light and fluffy, with various fillings like chocolate, cheese, blueberry, and pineapple. It was popularized by a bakery called Bolu Meranti in Medan, where people line up to buy the rolls due to their soft, moist texture and generous fillings. The rolls are often packed in gift boxes, making them a favorite souvenir.', 120000.00, 49, 4, 'bolumeranti.jpg', '2024-05-05 19:36:09', '2024-05-15 15:54:55');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`) VALUES
(1, 1, 'piesusu1.jpg'),
(2, 1, 'piesusu2.jpg'),
(3, 1, 'piesusu3.jpg'),
(4, 2, 'kopibali1.jpg'),
(5, 2, 'kopibali2.jpg'),
(6, 2, 'kopibali3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `region_id` int(11) NOT NULL,
  `region_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`region_id`, `region_name`, `description`, `created_at`, `updated_at`, `image`) VALUES
(1, 'Bali', 'The tropical island known for its beautiful beaches and vibrant culture', '2024-05-05 19:30:01', '2024-05-06 17:00:05', 'bali.jpg'),
(2, 'Jogja', 'Yogyakarta, the cultural heart of Java with rich heritage', '2024-05-05 19:30:01', '2024-05-06 17:00:05', 'jogja.jpg'),
(3, 'Palembang', 'A city known for its spicy cuisine and traditional crafts', '2024-05-05 19:30:01', '2024-05-06 17:00:05', 'palembang.jpg'),
(4, 'Medan', 'A melting pot of cultures and culinary delights in Sumatra', '2024-05-05 19:30:01', '2024-05-06 17:00:05', 'medan.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT 'usericon.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `full_name`, `phone`, `role`, `created_at`, `profile_picture`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$VbQvb29.WRE2jzx/ce.WWethkF.AkQ5R779Xx7DQkwjKAxs/AZbTW', NULL, NULL, 'admin', '2024-05-05 18:30:30', 'usericon.png'),
(2, 'johndoe', 'johndoe@gmail.com', '$2y$10$aH3J52vwGhRnBZtjM6cdAejF6Xje.XIxCkPxjMdlLMDDRv8uzLRbG', 'John Doe', '081382734831', 'customer', '2024-05-05 18:37:10', 'usericon.png'),
(3, 'mikarahmat', 'mikarahmatramadhan14@gmail.com', '$2y$10$K0tqRKLzg2s02pdFhpnfiem5M8tqzE5DxqW3iOmXmZw6QKve1gdKe', 'Mika Rahmat Ramadhan', '081283737833', 'customer', '2024-05-05 19:11:38', '3.jpg'),
(4, 'mrsmith', 'smithstones@gmail.com', '$2y$10$QNpVHBPJ.SDWcbqhs31VS.lxvPPezydeqXZo0IsvYLjXurEF9afeq', 'Smith Jones', '0812873267162', 'customer', '2024-05-05 19:22:09', 'usericon.png'),
(5, 'suryakun', 'suryakece@gmail.com', '$2y$10$8WzFNE7aPbFwAfsosGQIVu7V8jHB0Q6MieaJc4baCUwJUPI6eKZw2', 'Suryasyah', '081287847855', 'customer', '2024-05-08 03:25:38', 'usericon.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `fk_payment_method` (`payment_method_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`method_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `region_id` (`region_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`region_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payment_method` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`method_id`),
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `regions` (`region_id`) ON DELETE SET NULL;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
