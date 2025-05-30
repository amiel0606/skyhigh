-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql304.byetcluster.com
-- Generation Time: May 30, 2025 at 06:47 PM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_37529092_skyhigh`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$U8ugTiHuAxbEwCOYoGShHuxmnnLnkk9h9vH1zf9RV2N9YWJ6rIH4q');

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
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `type` varchar(255) NOT NULL DEFAULT 'Online',
  `cancellation_reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tbl_appointments`
--

INSERT INTO `tbl_appointments` (`a_id`, `name`, `username`, `address`, `contact`, `vehicle`, `service`, `date`, `time`, `status`, `type`, `cancellation_reason`) VALUES
(18, 'Regie', 'rdollesin21@gmail.com', 'tierra', '09945385218', 'scooter', 'CVT cleaning', '2025-06-02', '11:54', 'Confirmed', 'Online', ''),
(19, 'willie nelson manalo', 'wilsonmanalo010@gmail.com', '123mcc', '09123456789', 'motorycle', 'change oil', '2025-05-28', '10:00', 'Declined', 'Online', 'secret'),
(20, 'willie nelson manalo', 'wilsonmanalo010@gmail.com', '123mcc', '09123456789', 'motor', 'change oil ', '2025-06-05', '12:00', 'Confirmed', 'Online', ''),
(22, 'Regie', 'rdollesin21@gmail.com', 'tierra', '09945385218', 'scooter', 'CVT cleaning', '2025-05-08', '10:00', 'Confirmed', 'Online', ''),
(23, 'Regie', 'rdollesin21@gmail.com', 'tierra', '09945385218', 'scooter', 'engine refresh', '2025-05-15', '18:01', 'Confirmed', 'Online', 'wala lng'),
(24, 'Ben Barlow', 'benbarlow@gmail.com', 'blk 1 lot 69', '09289703176', 'Motorcycle', 'Change oil', '2025-05-20', '12:00', 'Pending', 'Online', ''),
(25, 'Test1', 'regie0564@gmail.com', 'tierra', '09845732175', 'scooter', 'CVT cleaning', '2025-05-20', '15:00', 'Pending', 'Walk-in', 'o'),
(26, 'Regie', 'rdollesin21@gmail.com', 'tierra', '09945385218', 'Motorcycle', 'Change oil', '2025-05-21', '11:00', 'Pending', 'Online', ''),
(27, 'Kevin paniterce', 'johnkevinpaniterce@gmail.com', 'blk 13 lot 3', '09123456789', 'Motorcycle', 'Change oil', '2025-05-27', '14:00', 'Pending', 'Online', ''),
(28, 'Test1', 'regie0564@gmail.com', 'tierra', '09785432675', 'Motorcycle', 'Replace Shock', '2025-05-21', '16:00', 'Pending', 'Online', ''),
(29, 'Regie', 'rdollesin21@gmail.com', 'tierra', '09945385218', 'Motorcycle', 'Tune up', '2025-05-21', '12:00', 'Pending', 'Online', ''),
(30, 'Regie', 'rdollesin21@gmail.com', 'tierra', '09945385218', 'Motorcycle', 'Replace Shock', '2025-05-21', '14:00', 'Pending', 'Online', 'wala lang'),
(31, 'user', 'usertest0518@gmail.com', 'dasma', '09945846474', 'Motorcycle', 'Change oil', '2025-05-21', '15:00', 'Confirmed', 'Online', ''),
(32, 'Test1', 'regie0564@gmail.com', 'tierra', '09785432675', 'Motorcycle', 'Adjust chain', '2025-05-21', '16:14', 'Pending', 'Online', 'no available mechanics'),
(33, 'Clarence', 'clarky321233@gmail.com', 'Mcc', '09999999999', 'Motorcycle', 'Change oil', '2025-05-28', '10:00', 'Pending', 'Online', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brands`
--

CREATE TABLE `tbl_brands` (
  `b_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_brands`
--

INSERT INTO `tbl_brands` (`b_id`, `brand_name`) VALUES
(5, 'Yamaha genuine'),
(6, 'JVT'),
(7, 'MRTR'),
(8, 'GPC'),
(9, 'Sun Racing'),
(10, '4s1m'),
(11, 'Astra otoparts'),
(12, 'Racing Boy');

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
(20, 39, 12, 'RCB Forged S1 Master Brake Pump', '1234', 1, 'Paid', 'pi_pFb2AnbamZPTAjrzwAL4KBwz'),
(21, 39, 11, 'Aerox v1 Fairings set', '2324', 1, 'Paid', 'pi_rps2gJvJDVWDUpoHgkY5wr5S'),
(22, 39, 11, 'Aerox v1 Fairings set', '2324', 1, 'Paid', 'pi_ojzvrz5ot3mpwmD2CwUFezK1'),
(23, 48, 11, 'Aerox v1 Fairings set', '2324', 2, 'Paid', 'pi_QRiuMdqGuVoF8PX19PfiNRE1'),
(24, 48, 11, 'Aerox v1 Fairings set', '2324', 2, 'Pending', ''),
(25, 48, 12, 'RCB Forged S1 Master Brake Pump', '1234', 3, 'Pending', ''),
(26, 39, 11, 'Aerox v1 Fairings set', '2324', 1, 'Paid', 'pi_duwMvEn9bYcHBviNkru6JvEQ'),
(29, 39, 11, 'Aerox v1 Fairings set', '2324', 1, 'Paid', 'pi_BwfzB5kA5rmmuD51dNohGXiv'),
(30, 39, 20, 'Sun Racing clutch lining', '1500', 1, 'Paid', 'pi_LCh7NYwHeaTfxpXQ3HLCmEaQ'),
(31, 39, 21, 'GPC brake pads', '60', 2, 'Paid', 'pi_VrzVJmMC7N24h5w32y14cyjR'),
(32, 39, 17, 'JVT Pulley set', '2900', 1, 'Paid', 'pi_pAMKp1wnB6kZruzaukaARHEc'),
(33, 49, 21, 'GPC brake pads', '60', 1, 'Paid', 'pi_hf3GZiYhWws7WctUKwQ3YUWH'),
(34, 49, 17, 'JVT Pulley set', '2900', 1, 'Paid', 'pi_hf3GZiYhWws7WctUKwQ3YUWH'),
(35, 39, 17, 'JVT Pulley set', '2900', 1, 'Paid', 'pi_w4qgi93VDKcKiEL3EeKyxgtR'),
(36, 39, 23, '4s1m flyball 12g', '400', 1, 'Paid', 'pi_iB2JitGfGsqe3fePwFRLcoDF'),
(37, 39, 21, 'GPC brake pads', '60', 2, 'Paid', 'pi_T4f21Fi6GWyA58RiqCMFUyt2'),
(38, 49, 16, 'CVT Belt', '650', 1, 'Paid', 'pi_hf3GZiYhWws7WctUKwQ3YUWH'),
(39, 51, 22, '4s1m flyball 12g', '499', 1, 'Paid', 'pi_6wGJM5wx2KdddWe3QvHv1Ecm'),
(41, 39, 19, 'GPC brake pads', '60', 1, 'Paid', 'pi_q1FYM6JGps9vSRc4becNGTgy'),
(42, 39, 21, 'GPC brake pads', '60', 2, 'Paid', 'pi_Go43HvGM3FMa8usQntHzW4tA'),
(43, 39, 23, '4s1m flyball 12g', '400', 1, 'Paid', 'pi_S4JJRpzEr2y8AuGZNhTX6E1Z'),
(48, 37, 16, 'CVT Belt', '650', 1, 'Paid', 'pi_oUx3WHabmzYnzyRJ3C75A9Uj'),
(49, 39, 17, 'JVT Pulley set', '2900', 1, 'Paid', 'pi_DBGeGdfDzkfNdkYZdubU4i4f'),
(50, 37, 19, 'GPC brake pads', '60', 1, 'Paid', 'pi_Natg8Uu6JY2SdKq1sm9bSBsh'),
(51, 37, 20, 'Sun Racing clutch lining', '1500', 1, 'Paid', 'pi_BdsjRMFJ9MtENWya6z3tQurC'),
(52, 37, 20, 'Sun Racing clutch lining', '1500', 1, 'Paid', 'pi_HFSNix2pSsdZJapvu4Dp8L5d'),
(53, 52, 30, 'Sun Racing center spring 1000rpm', '350', 3, 'Paid', 'pi_pwtfiP1Tg2HasKYV5AkMkTj6'),
(54, 53, 1, 'rims', '2000', 1, 'Paid', 'pi_21YAx9CCPeei28T3PNnVdLbt');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messages`
--

CREATE TABLE `tbl_messages` (
  `msg_id` int(11) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` enum('text','image') DEFAULT 'text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_messages`
--

INSERT INTO `tbl_messages` (`msg_id`, `receiver`, `sender`, `message`, `is_seen`, `timestamp`, `type`) VALUES
(36, 'admin', '39', '../uploads/chat/img_68258d82ae618.jpg', 1, '2025-05-15 13:45:22', 'image'),
(37, 'admin', '39', 'WHAT IS THIS', 1, '2025-05-15 13:45:43', 'text'),
(38, 'admin', '39', 'hello', 1, '2025-05-15 13:45:56', 'text'),
(39, 'admin', '53', 'warrup', 0, '2025-05-28 01:39:16', 'text');

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
  `brand` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `image` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`product_id`, `product_name`, `product_desc`, `price`, `product_category`, `brand`, `stock`, `status`, `image`) VALUES
(1, 'rims', 'pang malakasang rims', '2000', 'Wheels', '5', 3, 'Available', '68367d69b64725.25558373.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `s_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`s_id`, `service_name`, `description`) VALUES
(1, 'Change oil', 'any motorcycle');

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
(1, 53, '2025-05-28 03:41:42', '200000', 'Completed', 'txn_68367d816a41d8.32699462', 'pi_21YAx9CCPeei28T3PNnVdLbt');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `uID` int(255) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `verified` varchar(255) NOT NULL DEFAULT 'false',
  `otp` int(6) NOT NULL,
  `otp_expiry` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`uID`, `username`, `name`, `password`, `role`, `contact`, `address`, `verified`, `otp`, `otp_expiry`) VALUES
(53, 'pobleteiyal@gmail.com', 'victor', '$2y$10$rAIWlbwu.TNTlfNdXlpVs.WA7kvsQxh33jmNsLnBeHKmEr0T78ukW', 'customer', '09940403294', 'silang taga kanto', 'true', 327277, '2025-05-27 20:03:12'),
(38, 'willieson3131@gmail.com', 'willie', '$2y$10$0wxOIFHXCw1XJX9fKnDW9.VtoyX.DYKPTsndQ6lT19cantmI1b9VK', 'customer', '09123456789', '123123mcc', 'false', 642726, '2025-05-01 18:34:04'),
(39, 'rdollesin21@gmail.com', 'Regie', '$2y$10$d9gfdhZ0O3rgV7yhJscNs.kToMne.LvWuhwTsbRHGGqGEfhO9ln4e', 'customer', '09945385218', 'tierra', 'true', 190040, '2025-05-01 18:41:42'),
(40, 'willienelsonmanalo9@gmail.com', 'cilsse', '$2y$10$qdDsyQOlZ9alM.D7pJ9S8eobPcoTBgCdcntCBTQtoo/yBrS5Uta7S', 'customer', '09123456734', 'general trias', 'true', 748576, '2025-05-04 04:34:02'),
(41, 'kepmantes1@gmail.com', 'Karl Ernest Philippe Mantes', '$2y$10$msMpQJtPVMizmJyhEprdUOtDT2Hc69PSoyHZJdWC7YlYe26Oq82Qe', 'customer', '09152294669', 'Dasmariñas Cavite', 'true', 691846, '2025-05-04 09:34:01'),
(42, 'msbyshion@gmail.com', 'shion', '$2y$10$miBnMgC2NxJv3weufjYumutQuFbxL7zr8sOKjibYnTc4c/Ep8Leoq', 'customer', '09772537003', 'Imus, Cavite', 'false', 713459, '2025-05-04 10:08:05'),
(43, 'eia.rchive19@gmail.com', 'eia', '$2y$10$B6CBORpgrULafGoM2ALqY.mAFH8ZZx1s4.A3Dj/pfL4bPlJ6dNAgO', 'customer', '09772537003', 'Tanza, Cavite', 'false', 293550, '2025-05-04 10:10:21'),
(44, 'inquiries4mil@gmail.com', 'mil', '$2y$10$OlwcXE.CsIn26iOHT9fiZ.9SKJO8fe8Qz63qmVev7Jpd3z.2mlkFy', 'customer', '09772537003', 'Dasmariñas, Cavite', 'false', 803416, '2025-05-04 10:11:46'),
(45, 'gojonimaxine@gmail.com', 'goji', '$2y$10$TaWRusKb6PO6o8syaqMUNO2a6gJaNXk9lp3qhnDl.1Jm1s.9v69q.', 'customer', '09772537003', 'Bacoor, Cavite', 'false', 915097, '2025-05-04 10:16:07'),
(46, 'koyumi471@gmail.com', 'koi', '$2y$10$H2bLnjo7OyT5TKD0xVlbSOMC5n60bDEJKR3X/QXrXqo18BL/pZU.2', 'customer', '09772537003', 'Cavite', 'false', 272191, '2025-05-04 10:19:27'),
(47, 'ciandra00@gmail.com', 'cia', '$2y$10$I.Igo0V7MtU7ITmWnBxb0enmugxkmsofeTEE2Otq89VqWheSLCi8G', 'customer', '09772537003', 'Camarines Norte', 'false', 352918, '2025-05-04 10:33:01'),
(48, 'wilsonmanalo010@gmail.com', 'willie nelson manalo', '$2y$10$2sTsvfdvLTO9iA.g9JVmEe5uzeYjpPNiRBBsObJo.A/7bTBu78V/S', 'customer', '09123456789', '123mcc', 'true', 720440, '2025-05-04 17:46:37'),
(49, 'johnkevinpaniterce@gmail.com', 'Kevin paniterce', '$2y$10$yz7y2HrIzUluyk4Oc1YJZu/anqUafv18aTNFe36xW16AL7M35RgtK', 'customer', '09123456789', 'blk 13 lot 3', 'true', 875338, '2025-05-17 00:18:41'),
(50, 'ticoyregie44@gmail.com', 'cilsse', '$2y$10$ePgVUbayclApCvxCeyORGONhqF/cQIEGKOX7CKTmFeesK/rcMH1sC', 'customer', '09458223277', 'bahay', 'true', 661298, '2025-05-17 02:37:53'),
(51, 'regie0564@gmail.com', 'Test1', '$2y$10$MWczhXBVb3OMXq5Ho/9CoeNMIghIiiz2Sd4p.23vVc6rx5C4u1iCi', 'customer', '09785432675', 'tierra', 'true', 795094, '2025-05-17 10:46:48'),
(52, 'usertest0518@gmail.com', 'user', '$2y$10$op/.3vmwCzBoGcVe3b/ImON0Q3r3x.rfbXTZzyv/LwLGwcsH6Wnxu', 'customer', '09945846474', 'dasma', 'true', 317825, '2025-05-17 16:59:51');

-- --------------------------------------------------------

--
-- Table structure for table `website_content`
--

CREATE TABLE `website_content` (
  `id` int(11) NOT NULL,
  `about_us` longtext DEFAULT NULL,
  `logo_title` longtext DEFAULT NULL,
  `faq` longtext NOT NULL,
  `logo_subtitle` longtext DEFAULT NULL,
  `logo_picture` longtext DEFAULT NULL,
  `background_picture` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website_content`
--

INSERT INTO `website_content` (`id`, `about_us`, `logo_title`, `faq`, `logo_subtitle`, `logo_picture`, `background_picture`, `created_at`, `updated_at`) VALUES
(1, '<p><span style=\"background-color:hsl(180,75%,60%);color:hsl(210,75%,60%);font-size:30px;\"><strong>ahahahawazxxzxz</strong></span></p>', '<p>SKYHIGH</p>', '', '<p>MOTORCYCLE</p>', 'logo_1748309514_6835160ac2e20.png', 'background_1748309514_6835160ac32c1.png', '2025-05-27 00:53:27', '2025-05-28 02:57:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tbl_appointments`
--
ALTER TABLE `tbl_appointments`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `tbl_brands`
--
ALTER TABLE `tbl_brands`
  ADD PRIMARY KEY (`b_id`);

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
-- Indexes for table `tbl_services`
--
ALTER TABLE `tbl_services`
  ADD PRIMARY KEY (`s_id`);

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
-- Indexes for table `website_content`
--
ALTER TABLE `website_content`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_appointments`
--
ALTER TABLE `tbl_appointments`
  MODIFY `a_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_brands`
--
ALTER TABLE `tbl_brands`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_carts`
--
ALTER TABLE `tbl_carts`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `uID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `website_content`
--
ALTER TABLE `website_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
