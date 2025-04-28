-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 08:43 PM
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
-- Database: `skyhigh`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `aemail` varchar(255) NOT NULL,
  `apassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `aemail`, `apassword`) VALUES
(1, 'admin@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(2, 'Muffler'),
(3, 'Wheel'),
(4, 'Engine'),
(5, 'Engine2'),
(6, 'Engine1');

-- --------------------------------------------------------

--
-- Table structure for table `emp_login`
--

CREATE TABLE `emp_login` (
  `empid` int(100) NOT NULL,
  `Emp_Email` varchar(50) NOT NULL,
  `Emp_Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emp_login`
--

INSERT INTO `emp_login` (`empid`, `Emp_Email`, `Emp_Password`) VALUES
(1, 'Admin@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `delivered_to` varchar(150) NOT NULL,
  `phone_no` varchar(10) NOT NULL,
  `deliver_address` varchar(255) NOT NULL,
  `pay_method` varchar(50) NOT NULL,
  `pay_status` int(11) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT 0,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_size_variation`
--

CREATE TABLE `product_size_variation` (
  `variation_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `quantity_in_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_size_variation`
--

INSERT INTO `product_size_variation` (`variation_id`, `product_id`, `size_id`, `quantity_in_stock`) VALUES
(1, 2, 9, 4),
(2, 3, 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `review_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `UserID` int(100) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`UserID`, `Username`, `Email`, `Password`) VALUES
(1, 'asdasd', 'duranmarkjoshua31@gmai.com', '123123'),
(2, 'williewonka', 'williewonka@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`size_id`, `size_name`) VALUES
(2, '125 CC'),
(3, '150 CC'),
(4, '200 CC'),
(5, '400 CC'),
(6, '650 CC'),
(7, '1000 CC'),
(8, '680 MM'),
(9, '670 MM'),
(10, '660 MM'),
(11, 'samplesize');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointments`
--

CREATE TABLE `tbl_appointments` (
  `a_id` int(255) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `vehicle` varchar(255) NOT NULL,
  `service` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_appointments`
--

INSERT INTO `tbl_appointments` (`a_id`, `name`, `username`, `address`, `contact`, `vehicle`, `service`, `date`, `time`, `status`) VALUES
(14, 'Amiel Carhyl Lapid', 'amiellapid06@gmail.com', 'emoz sabana', '09940576781', 'qweqwewq', 'sss', '2025-04-30', '18:13', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_carts`
--

CREATE TABLE `tbl_carts` (
  `c_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,0) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `transID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_carts`
--

INSERT INTO `tbl_carts` (`c_id`, `user_id`, `product_id`, `product_name`, `product_price`, `quantity`, `status`, `transID`) VALUES
(13, 37, 2, 'Sample product', 23, 26, 'Paid', 'pi_RhEcjbn7VBeSkEcXg1LX2T64'),
(14, 37, 3, 'hehehez', 32, 5, 'Paid', 'pi_Vg5ocvgXYaGnT8NCADF61cGw'),
(15, 37, 4, 'zxczxczx', 22, 2, 'Paid', 'pi_Vg5ocvgXYaGnT8NCADF61cGw'),
(16, 37, 4, 'zxczxczx', 22, 2, 'Paid', 'pi_NKx6cNFxJETCQaPwb912a3jt'),
(17, 37, 3, 'hehehez', 32, 4, 'Paid', 'pi_qHrzPWRGeWxbAk5t1zTYL43r'),
(18, 37, 4, 'zxczxczx', 22, 2, 'Paid', 'pi_ffLVvNriQeP7pgxEuYe9Must'),
(19, 37, 3, 'hehehez', 32, 4, 'Paid', 'pi_ffLVvNriQeP7pgxEuYe9Must');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messages`
--

CREATE TABLE `tbl_messages` (
  `msg_id` int(11) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_desc` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `product_category` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `image` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`product_id`, `product_name`, `product_desc`, `price`, `product_category`, `stock`, `status`, `image`) VALUES
(2, 'Sample product', 'Hahaha ferrari circus show', 23, 'Ferrari', 0, 'available', '67dc082511b097.52235573.png'),
(3, 'hehehez', 'zxczxc', 32, 'zxczxc', 5, 'available', '67f80cf341e256.31740933.png'),
(4, 'zxczxczx', 'czxczxczxcxz', 22, 'eqqeq', 27, 'available', '67f80d15bda346.30392593.png'),
(5, '23213123', 'zxczxczcz', 22, '3zxc', 32, 'unavailable', '67f80d2e7c5599.95652078.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transactions`
--

CREATE TABLE `tbl_transactions` (
  `t_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total` decimal(10,0) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `uuid` varchar(255) NOT NULL,
  `payment_intent_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_transactions`
--

INSERT INTO `tbl_transactions` (`t_id`, `user_id`, `date`, `total`, `status`, `uuid`, `payment_intent_id`) VALUES
(8, 37, '2025-04-24 12:34:03', 6900, 'Ready for Pickup', 'txn_67f80b4aa1f1e1.79995092', 'pi_5Waz9PGdUyjZJmuTBgDqFCgk'),
(21, 37, '2025-04-11 04:22:14', 24400, 'Completed', 'txn_67f879d401f246.76424737', 'pi_Vg5ocvgXYaGnT8NCADF61cGw'),
(22, 37, '2025-04-24 16:14:29', 28900, 'Completed', 'txn_680a2c3d572820.72356948', 'pi_NKx6cNFxJETCQaPwb912a3jt'),
(23, 37, '2025-04-24 15:52:19', 80400, 'Paid', 'txn_680a5e2f3d1010.79702092', 'pi_qHrzPWRGeWxbAk5t1zTYL43r'),
(24, 37, '2025-04-24 15:54:09', 80400, 'Paid', 'txn_680a5e9dc0d8d4.87989130', 'pi_RhEcjbn7VBeSkEcXg1LX2T64'),
(25, 37, '2025-04-24 15:54:32', 114600, 'Paid', 'txn_680a5eb49abc26.86443678', 'pi_ffLVvNriQeP7pgxEuYe9Must');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `uID` int(255) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `verified` varchar(255) NOT NULL DEFAULT 'false',
  `otp` int(6) NOT NULL,
  `otp_expiry` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`uID`, `username`, `name`, `password`, `role`, `contact`, `address`, `verified`, `otp`, `otp_expiry`) VALUES
(37, 'amiellapid06@gmail.com', 'Amiel Carhyl Lapid', '$2y$10$QtHhKU7wzgEaTMP.L0TbyefFjsxpTWULMuvlYBkidp023TDi4Drwi', 'customer', '09940576781', 'emoz sabana', 'true', 223575, '2025-02-21 02:22:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aemail` (`aemail`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `emp_login`
--
ALTER TABLE `emp_login`
  ADD PRIMARY KEY (`empid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`);

--
-- Indexes for table `product_size_variation`
--
ALTER TABLE `product_size_variation`
  ADD PRIMARY KEY (`variation_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `tbl_appointments`
--
ALTER TABLE `tbl_appointments`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `tbl_carts`
--
ALTER TABLE `tbl_carts`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`uID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `emp_login`
--
ALTER TABLE `emp_login`
  MODIFY `empid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_size_variation`
--
ALTER TABLE `product_size_variation`
  MODIFY `variation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `UserID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_appointments`
--
ALTER TABLE `tbl_appointments`
  MODIFY `a_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_carts`
--
ALTER TABLE `tbl_carts`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `uID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
