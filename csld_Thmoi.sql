-- phpMyAdmin SQL Dump
-- Version: 5.2.1
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2026 at 08:33 AM
-- MariaDB / MySQL Full Import Script for THTRAVEL

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 1. Tạo mới & reset Database
--
CREATE DATABASE IF NOT EXISTS `thtravel_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `thtravel_db`;

--
-- 2. Xóa các bảng cũ nếu đã tồn tại (CHO PHÉP GHI ĐÈ BẢN CŨ)
--
DROP TABLE IF EXISTS `tour_images`;
DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `cart`;
DROP TABLE IF EXISTS `flash_sales`;
DROP TABLE IF EXISTS `destinations`;
DROP TABLE IF EXISTS `tours`;
DROP TABLE IF EXISTS `users`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `status` enum('active','banned') DEFAULT 'active',
  `avatar` varchar(255) DEFAULT NULL,
  `joined` datetime DEFAULT current_timestamp(),
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `password`, `role`, `status`, `avatar`, `joined`, `reset_token`, `reset_expiry`) VALUES
(19, 'banhbaongon23', 'quachthienphuc231@Gmail.com', '09323923123', '$2y$10$GPRwYuO7f8CK1v58yJ4c2OHtoMEqHfWX2laiXA00tt8huztB5LBlS', 'customer', 'active', NULL, '2026-02-10 17:50:25', NULL, NULL),
(20, 'phucdeptraihihi', 'trandan@gmail.com', '09841239213', '$2y$10$3fuGjY9IxT4uu19yPb7M7O7Q0a73v.PG5QzJJQsJJxdeR7h9zCUVe', 'customer', 'active', NULL, '2026-10-02 15:41:51', NULL, NULL),
(21, 'admin', 'admin@thtravel.vn', NULL, '$2y$10$e8m4Yp8rVwO3h9xJgS7Dpe3IqO.xZb4fJ5u4G8K1vQ2W3X4Y5Z6a7', 'admin', 'active', NULL, '2026-10-05 15:13:47', NULL, NULL),
(22, 'phucdz102', 'phucdz1023@gmail.com', '12321312312', '$2y$10$Ha4TWkMIWBDYAVD424DZGO4tWSqngaGA/AlyZp0x1yduc9OjU.pXi', 'customer', 'active', NULL, '2026-10-05 15:32:36', NULL, NULL),
(23, 'phucdz102342', 'phucdz132023@gmail.com', '12321312312', '$2y$10$hp8yzqLVMzj.TIfHIiIzVueahHqGCpnCt/O8ehaXU3VUandyAyY/O', 'customer', 'active', NULL, '2026-10-05 15:33:20', NULL, NULL),
(24, 'phucdz1023', 'phucdz10233@gmail.com', '12321312312', '$2y$10$uioGP1N/VWrAJJC1DqfeGuovGfRfhlOXjAuqTyp2gBIgJSQxARdJq', 'customer', 'active', NULL, '2026-10-05 15:35:14', NULL, NULL),
(25, 'phucdz1021', 'phucdz102337@gmail.com', '12321312312', '$2y$10$dazAC9IcJNAnZFFCLwD3keSzY0WijosORf7VtvVC.bbqh29mDSibS', 'customer', 'active', NULL, '2026-10-05 15:45:15', NULL, NULL),
(26, 'phucne', 'quachdaigia123223@gmail.com', '2313123123', '$2y$10$8rrVGfxDSaAzGN0oHnuFceRyl1ERvaf28S80SWnxzWanrSmdJtZDG', 'customer', 'active', NULL, '2026-10-05 15:45:56', NULL, NULL),
(27, 'nguyenhung1', 'nguyenhung1@gmail.com', '12321312312', '$2y$10$M4EK5TIhtqNznVZdEUgYB.jlmgo94KjKqtlIXcyGSKofUyWy9zNL.', 'customer', 'active', NULL, '2026-10-06 08:58:35', 'd9bbe47c85af0d992150f0d3c3e723ab7e123f7aa4a0a82ef87e55adb5958874', '2026-10-06 04:58:50'),
(28, 'phuchi', 'quachphucd@gmail.com', '0123123121', '$2y$10$XnNfnYxL7q9LzOOcN5IXzOw6MPLEXkecL5xtAAbcvx6E96D/wxUQK', 'customer', 'active', NULL, '2026-10-14 17:58:30', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--
CREATE TABLE `tours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `schedule` text DEFAULT NULL,
  `price` decimal(12,0) DEFAULT 0,
  `duration` varchar(100) DEFAULT NULL,
  `departure_from` varchar(100) DEFAULT 'TP. Hồ Chí Minh',
  `available_seats` int(11) DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tours` (`id`, `slug`, `title`, `subtitle`, `main_image`, `images`, `description`, `schedule`, `price`, `duration`, `departure_from`, `available_seats`, `start_date`, `code`, `is_active`, `created_at`) VALUES
(5, 'mui-ca-mau', 'Mũi Cà Mau – Điểm cực Nam Tổ quốc', 'Tour cao cấp khám phá vùng đất cuối cùng của Tổ quốc – 3N2Đ từ TP.HCM', 'anhsale/1.png', NULL, 'Mô tả tour đầy đủ ở đây...\r\n- <strong>Cà Mau</strong> mảnh đất nằm ở điểm cuối cùng của bản đồ Việt Nam...', '<div class=\"bg-white p-5 rounded-4 shadow mb-5\">\r\n    <h4 class=\"mb-4\"><i class=\"bi bi-calendar-week text-success me-2\"></i>Lịch trình chi tiết</h4>...</div>', 5990000, '3 Ngày 2 Đêm', 'TP. Hồ Chí Minh', 3, '2026-01-23', 'CMTR2026001', 1, '2026-02-09 15:38:35'),
(6, 'canh-dong-gio-bac-lieu', 'Cánh đồng gió Bạc Liêu – Thư giãn, loại bỏ mọi lo âu', 'Tour thư giãn 3N2Đ – Ngắm cánh đồng điện gió, biển xanh, nghỉ dưỡng yên bình từ TP.HCM', 'anhtuordep/canhdonggio1.png', '[\"anhtourdep/canhdonggio2.png\", \"anhtourdep/canhdonggio3.png\", \"anhtourdep/canhdonggio4.png\"]', '- Cánh đồng điện gió Bạc Liêu...', '...', 1890000, '3 Ngày 2 Đêm', 'TP. Hồ Chí Minh', 12, '2026-02-15', 'BDGL2026002', 1, '2026-02-09 18:35:03'),
(7, 'vuon-quoc-gia-u-minh-ha', 'Vườn Quốc gia U Minh Hạ - Hoà mình với thiên nhiên', 'Tour khám phá rừng tràm nguyên sinh 3N2Đ – Thư giãn, tái tạo năng lượng từ TP.HCM', 'anhsale/3.png', NULL, '- Cà Mau mảnh đất...', '...', 3990000, '3 Ngày 2 Đêm', 'TP. Hồ Chí Minh', 12, '2026-03-01', 'UMH2026003', 1, '2026-02-09 18:59:27'),
(8, 'hon-da-bac', 'Hòn Đá Bạc - độc đáo với vẻ đẹp hoang sơ giữa biển trời', 'Tour khám phá cụm đảo cổ 180 triệu năm – Di tích lịch sử & thiên nhiên kỳ vĩ 3N2Đ từ TP.HCM', 'anhsale/4.png', '[\"anhsale/4.png\"]', '- Hòn Đá Bạc...', '...', 4990000, '3 Ngày 2 Đêm', 'TP. Hồ Chí Minh', 10, '2026-03-15', 'HDB2026004', 1, '2026-02-09 19:11:42'),
(9, 'nha-hat-cao-van-lau', 'Nhà hát Cao Văn Lầu - văn hóa gắn liền với nghệ thuật Đờn ca tài tử', 'Tour trải nghiệm đờn ca tài tử Nam Bộ', 'anhsale/5.png', '[\"anhsale/5.png\"]', '- Nhà hát Cao Văn Lầu...', '...', 3290000, '3 Ngày 2 Đêm', 'TP. Hồ Chí Minh', 14, '2026-03-20', 'CVL2026005', 1, '2026-02-09 19:15:18'),
(10, 'bien-dat-mui', 'Biển Đất Mũi - duy nhất Việt Nam nhìn ra cả biển Đông và biển Tây', 'Tour check-in cực Nam Tổ quốc', 'anhsale/6.png', '[\"anhsale/6.png\"]', '- Biển Đất Mũi...', '...', 3290000, '3 Ngày 2 Đêm', 'TP. Hồ Chí Minh', 12, '2026-04-01', 'BDM2026006', 1, '2026-02-09 19:17:29'),
(11, 'canh-dong-muoi-bac-lieu', 'Cánh đồng muối Bạc Liêu - Nét đẹp lao động mộc mạc của diêm dân', 'Tour trải nghiệm nghề làm muối truyền thống', 'anhsale/7.png', '[\"anhsale/7.png\"]', '- Cánh đồng muối Bạc Liêu...', '...', 1290000, '3 Ngày 2 Đêm', 'TP. Hồ Chí Minh', 15, '2026-03-10', 'CDM2026007', 1, '2026-02-09 19:26:32'),
(12, 'bai-bien-khai-long', 'Bãi biển Khai Long - nét đẹp hoang sơ hùng vĩ cực nam tổ quốc', 'Tour sinh thái nghỉ dưỡng bãi biển cát vàng độc đáo', 'anhsale/8.png', '[\"anhsale/8.png\"]', '- Bãi biển Khai Long...', '...', 3290000, '3 Ngày 2 Đêm', 'TP. Hồ Chí Minh', 10, '2026-04-15', 'KHL2026008', 1, '2026-02-09 19:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tour_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(12,0) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `tour_id` (`tour_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--
CREATE TABLE `destinations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `province` varchar(100) DEFAULT NULL,
  `short_desc` varchar(500) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `highlights` text DEFAULT NULL,
  `activities` text DEFAULT NULL,
  `image_cover` varchar(500) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `start_location` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `remaining_seats` int(11) DEFAULT NULL,
  `original_price` decimal(15,0) DEFAULT NULL,
  `sale_price` decimal(15,0) DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flash_sales`
--
CREATE TABLE `flash_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tour_code` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `original_price` decimal(12,0) NOT NULL,
  `sale_price` decimal(12,0) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` datetime NOT NULL,
  `departure` varchar(100) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `available_seats` int(11) NOT NULL DEFAULT 0,
  `code_tour` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(12,0) NOT NULL,
  `status` enum('pending','confirmed','paid','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(12,0) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `tour_id` (`tour_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_images`
--
CREATE TABLE `tour_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tour_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `tour_id` (`tour_id`),
  CONSTRAINT `tour_images_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;