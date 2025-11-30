-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 30, 2025 lúc 04:13 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `love-app`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `anniversaries`
--

CREATE TABLE `anniversaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `is_recurring` tinyint(1) DEFAULT 1,
  `reminder_days_before` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `anniversaries`
--

INSERT INTO `anniversaries` (`id`, `couple_id`, `title`, `date`, `is_recurring`, `reminder_days_before`, `created_at`) VALUES
(1, 2, 'Kỷ niệm 1 năm hẹn hò', '2025-11-14', 1, 1, '2025-11-14 01:02:42'),
(3, 2, 'Sinh nhật người ấy', '2025-12-06', 1, 1, '2025-11-14 01:56:48'),
(4, 2, 'Sinh nhật tôi', '2025-07-01', 1, 1, '2025-11-14 01:57:09'),
(5, 2, 'Ngày Valentine', '2025-02-14', 1, 1, '2025-11-14 01:57:33'),
(6, 2, 'Kỷ niệm 1 năm hẹn hò', '2025-10-07', 1, 1, '2025-11-14 01:57:54'),
(7, 2, 'Ngày cưới', '2022-06-05', 0, 3, '2025-11-14 02:04:04'),
(8, 2, 'Lần đầu gặp nhau', '2025-08-12', 1, 1, '2025-11-14 02:04:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `color` varchar(30) DEFAULT 'pink',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `color`, `created_at`) VALUES
(3, 'Công Nghệ', 'cong-nghe', '#27904c', '2025-11-17 11:45:55'),
(4, 'Yêu Xa', 'yeu-xa', '#9333ea', '2025-11-17 17:33:15'),
(5, 'Yêu Gần', 'yeu-gan', '#f472b6', '2025-11-17 17:33:28'),
(6, 'Kỷ Niệm', 'ky-niem', '#e6cf3d', '2025-11-24 15:05:43'),
(7, 'Thử Thách', 'thu-thach', '#e43f3f', '2025-11-24 15:06:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `challenges`
--

CREATE TABLE `challenges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `points` int(11) DEFAULT 0,
  `is_offline` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `challenges`
--

INSERT INTO `challenges` (`id`, `title`, `description`, `points`, `is_offline`, `created_at`) VALUES
(3, 'Hẹn hò cuối tuần', 'Hai bạn hãy cùng nhau lên kế hoạch cho buổi hẹn cuối tuần thật đặc biệt 💕', 80, 1, '2025-11-09 08:33:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `challenge_instances`
--

CREATE TABLE `challenge_instances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `challenge_id` bigint(20) UNSIGNED NOT NULL,
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','completed','failed') DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `challenge_instances`
--

INSERT INTO `challenge_instances` (`id`, `couple_id`, `challenge_id`, `started_at`, `completed_at`, `status`, `created_by`) VALUES
(9, 2, 3, '2025-11-13 09:44:28', '2025-11-13 13:08:48', 'completed', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `challenge_participants`
--

CREATE TABLE `challenge_participants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instance_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `completed_tasks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`completed_tasks`)),
  `score_awarded` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `challenge_participants`
--

INSERT INTO `challenge_participants` (`id`, `instance_id`, `user_id`, `completed_tasks`, `score_awarded`) VALUES
(4, 9, 3, '[1,2,3]', 80);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `challenge_tasks`
--

CREATE TABLE `challenge_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `challenge_id` bigint(20) UNSIGNED NOT NULL,
  `seq` int(11) NOT NULL DEFAULT 0,
  `text` varchar(500) DEFAULT NULL,
  `requirement` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`requirement`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `challenge_tasks`
--

INSERT INTO `challenge_tasks` (`id`, `challenge_id`, `seq`, `text`, `requirement`) VALUES
(1, 3, 0, 'Chọn địa điểm hẹn', NULL),
(2, 3, 1, 'Chuẩn bị quà nhỏ', NULL),
(3, 3, 2, 'Chụp ảnh cùng nhau', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `checkins`
--

CREATE TABLE `checkins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lat` decimal(9,6) DEFAULT NULL,
  `lng` decimal(9,6) DEFAULT NULL,
  `method` enum('nfc','qr','manual') DEFAULT 'manual',
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `checkins`
--

INSERT INTO `checkins` (`id`, `couple_id`, `user_id`, `location_id`, `lat`, `lng`, `method`, `note`, `created_at`) VALUES
(3, 2, 3, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 09:33:07'),
(4, 2, 4, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 09:33:07'),
(5, 2, 3, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 09:54:10'),
(6, 2, 4, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 09:54:10'),
(7, 2, 3, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 09:58:48'),
(8, 2, 4, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 09:58:48'),
(9, 2, 3, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 09:58:56'),
(10, 2, 4, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 09:58:56'),
(11, 2, 3, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 09:58:58'),
(12, 2, 4, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 09:58:58'),
(13, 2, 3, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 09:59:29'),
(14, 2, 4, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 09:59:29'),
(15, 2, 3, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 10:02:16'),
(16, 2, 4, NULL, 21.440959, 105.955547, 'qr', NULL, '2025-11-06 10:02:16'),
(17, 2, 3, 13, 21.440959, 105.955547, 'nfc', NULL, '2025-11-07 08:32:29'),
(18, 2, 4, 13, 21.440959, 105.955547, 'nfc', NULL, '2025-11-07 08:32:29'),
(19, 2, 3, 14, 21.440959, 105.955547, 'nfc', NULL, '2025-11-07 08:57:48'),
(20, 2, 4, 14, 21.440959, 105.955547, 'nfc', NULL, '2025-11-07 08:57:48'),
(21, 2, 3, 15, 21.440959, 105.955547, 'nfc', NULL, '2025-11-09 00:28:58'),
(22, 2, 4, 15, 21.440959, 105.955547, 'nfc', NULL, '2025-11-09 00:28:58'),
(23, 2, 3, 16, 21.440959, 105.955547, 'nfc', NULL, '2025-11-09 00:29:22'),
(24, 2, 4, 16, 21.440959, 105.955547, 'nfc', NULL, '2025-11-09 00:29:22'),
(25, 2, 3, 17, 21.029600, 105.855300, 'nfc', NULL, '2025-11-09 01:06:46'),
(26, 2, 4, 17, 21.029600, 105.855300, 'nfc', NULL, '2025-11-09 01:06:46'),
(27, 2, 3, 18, 21.440959, 105.955547, 'nfc', NULL, '2025-11-09 01:31:55'),
(28, 2, 4, 18, 21.440959, 105.955547, 'nfc', NULL, '2025-11-09 01:31:55'),
(29, 2, 3, 19, 21.440959, 105.955547, 'nfc', NULL, '2025-11-09 10:05:00'),
(30, 2, 4, 19, 21.440959, 105.955547, 'nfc', NULL, '2025-11-09 10:05:00'),
(31, 2, 3, 20, 21.440959, 105.955547, 'nfc', NULL, '2025-11-09 10:31:03'),
(32, 2, 4, 20, 21.440959, 105.955547, 'nfc', NULL, '2025-11-09 10:31:03'),
(33, 2, 3, 21, 21.440957, 105.955546, 'nfc', NULL, '2025-11-12 03:58:01'),
(34, 2, 4, 21, 21.440957, 105.955546, 'nfc', NULL, '2025-11-12 03:58:01'),
(35, 2, 3, 22, 21.440957, 105.955546, 'nfc', NULL, '2025-11-12 14:15:10'),
(36, 2, 4, 22, 21.440957, 105.955546, 'nfc', NULL, '2025-11-12 14:15:10'),
(37, 2, 3, 23, 21.440957, 105.955546, 'nfc', NULL, '2025-11-14 02:49:25'),
(38, 2, 4, 23, 21.440957, 105.955546, 'nfc', NULL, '2025-11-14 02:49:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `couples`
--

CREATE TABLE `couples` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_score` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `couples`
--

INSERT INTO `couples` (`id`, `uuid`, `title`, `created_by`, `created_at`, `updated_at`, `total_score`) VALUES
(1, '35bb04ed35058f459d99b306358382cb', 'Nguyễn Văn Bông & Nguyễn Thi C', 1, '2025-10-19 12:01:09', '2025-10-19 12:01:09', 0),
(2, '4b57f4a9c32730c27814dfc18aa5ac85', 'Nguyễn Văn A & Nguyễn Thi B', 3, '2025-10-20 03:49:38', '2025-11-13 13:08:48', 80);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `couple_members`
--

CREATE TABLE `couple_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('partner','admin') DEFAULT 'partner',
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_seen_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `couple_members`
--

INSERT INTO `couple_members` (`id`, `couple_id`, `user_id`, `role`, `joined_at`, `last_seen_at`) VALUES
(1, 1, 1, 'partner', '2025-10-19 12:01:09', NULL),
(2, 1, 2, 'partner', '2025-10-19 12:01:09', NULL),
(3, 2, 3, 'partner', '2025-10-20 03:49:38', NULL),
(4, 2, 4, 'partner', '2025-10-20 03:49:38', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `couple_streaks`
--

CREATE TABLE `couple_streaks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `last_checkin_date` date DEFAULT NULL,
  `current_streak` int(10) UNSIGNED DEFAULT 0,
  `best_streak` int(10) UNSIGNED DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `couple_streaks`
--

INSERT INTO `couple_streaks` (`id`, `couple_id`, `last_checkin_date`, `current_streak`, `best_streak`, `updated_at`) VALUES
(1, 2, '2025-11-14', 1, 2, '2025-11-14 02:49:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `game_sessions`
--

CREATE TABLE `game_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `host_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ended_at` timestamp NULL DEFAULT NULL,
  `result` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`result`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `heartbeat_signals`
--

CREATE TABLE `heartbeat_signals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `heartbeat_signals`
--

INSERT INTO `heartbeat_signals` (`id`, `couple_id`, `sender_id`, `note`, `created_at`) VALUES
(1, 2, 3, '💓', '2025-10-20 11:23:06'),
(2, 2, 4, '💓', '2025-10-20 13:12:57'),
(3, 2, 4, '💓', '2025-10-20 13:14:06'),
(4, 2, 4, '💓', '2025-10-20 13:15:35'),
(5, 2, 3, '💓', '2025-10-20 13:55:41'),
(6, 2, 3, '💓', '2025-10-20 14:30:17'),
(7, 2, 3, '💓', '2025-10-20 14:32:44'),
(8, 2, 3, '💓', '2025-10-20 14:33:18'),
(9, 2, 3, '💓', '2025-10-20 14:43:47'),
(10, 2, 4, '💓', '2025-10-20 14:44:55'),
(11, 2, 3, '💓', '2025-10-20 14:45:24'),
(12, 2, 4, '💓', '2025-10-20 14:45:34'),
(13, 2, 4, '💓', '2025-10-20 14:45:38'),
(14, 2, 4, '💓', '2025-10-20 14:45:40'),
(15, 2, 4, '💓', '2025-10-20 14:49:49'),
(16, 2, 3, '💓', '2025-10-20 14:51:56'),
(17, 2, 3, '💓', '2025-10-20 14:52:52'),
(18, 2, 3, '💓', '2025-10-20 14:53:22'),
(19, 2, 3, '💓', '2025-10-20 14:54:20'),
(20, 2, 4, '💓', '2025-10-23 15:54:48'),
(21, 2, 4, '💓', '2025-10-23 15:55:20'),
(22, 2, 4, '💓', '2025-10-23 16:01:08'),
(23, 2, 4, '💓', '2025-10-24 00:31:41'),
(24, 2, 4, '💓', '2025-10-24 00:33:40'),
(25, 2, 3, '💓', '2025-10-24 00:34:57'),
(26, 2, 3, '💓', '2025-10-24 00:35:11'),
(27, 2, 4, '💓', '2025-10-24 00:35:36'),
(28, 2, 3, '💓', '2025-10-24 00:39:02'),
(29, 2, 3, '💓', '2025-10-24 00:39:58'),
(30, 2, 3, '💓', '2025-10-24 00:43:13'),
(31, 2, 3, '💓', '2025-10-24 00:45:03'),
(32, 2, 3, '💓', '2025-10-24 00:45:37'),
(33, 2, 3, '💓', '2025-10-24 00:46:01'),
(34, 2, 3, '💓', '2025-10-24 01:21:59'),
(35, 2, 4, '💓', '2025-10-24 01:34:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `position` point NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `locations`
--

INSERT INTO `locations` (`id`, `couple_id`, `name`, `address`, `position`, `created_at`) VALUES
(13, 2, 'Bong Baby', NULL, 0x0000000001010000007ae063b0e27035409eb29aae277d5a40, '2025-11-07 08:32:29'),
(14, 2, 'Bong Baby', NULL, 0x0000000001010000007ae063b0e27035409eb29aae277d5a40, '2025-11-07 08:57:48'),
(15, 2, 'Quán cà phê kỷ niệm', NULL, 0x0000000001010000007ae063b0e27035409eb29aae277d5a40, '2025-11-09 00:28:58'),
(16, 2, 'Quán cà phê kỷ niệm', NULL, 0x0000000001010000007ae063b0e27035409eb29aae277d5a40, '2025-11-09 00:29:22'),
(17, 2, 'Nhà Bông Baby', NULL, 0x0000000001010000002bf697dd930735403411363cbd765a40, '2025-11-09 01:06:46'),
(18, 2, 'Nhà Bông Baby', NULL, 0x0000000001010000007ae063b0e27035409eb29aae277d5a40, '2025-11-09 01:31:55'),
(19, 2, 'Quán cà phê kỷ niệm', NULL, 0x0000000001010000007ae063b0e27035409eb29aae277d5a40, '2025-11-09 10:05:00'),
(20, 2, 'Nhà Bông Baby', NULL, 0x0000000001010000007ae063b0e27035409eb29aae277d5a40, '2025-11-09 10:31:03'),
(21, 2, 'Vị trí không tên', NULL, 0x00000000010100000039f1d58ee2703540b6f468aa277d5a40, '2025-11-12 03:58:01'),
(22, 2, 'Vị trí không tên', NULL, 0x00000000010100000039f1d58ee2703540b6f468aa277d5a40, '2025-11-12 14:15:10'),
(23, 2, 'Vị trí không tên', NULL, 0x00000000010100000039f1d58ee2703540b6f468aa277d5a40, '2025-11-14 02:49:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `love_diaries`
--

CREATE TABLE `love_diaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `visibility` enum('both','private_to_author') DEFAULT 'both',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `love_diaries`
--

INSERT INTO `love_diaries` (`id`, `couple_id`, `author_id`, `title`, `content`, `visibility`, `created_at`) VALUES
(2, 2, 4, 'Buổi sáng ngọt ngào', 'Sáng nay anh gửi em tin nhắn chúc buổi sáng tốt lành và nhận được nụ cười từ em. 💖', 'both', '2025-10-25 08:04:14'),
(3, 2, 3, 'Ngày bận rộn', 'Hôm nay em bận rộn suốt cả ngày nhưng luôn nghĩ về anh. Mong được gặp anh sớm. 🌸', 'both', '2025-10-25 08:05:09'),
(4, 2, 3, 'Kỷ niệm đặc biệt', 'Nhớ lại lần đầu gặp nhau, tim anh vẫn rung lên mỗi khi nghĩ về em. 💌', 'both', '2025-10-25 08:11:20'),
(5, 2, 3, 'Kỷ niệm đặc biệt', 'heheheheheh455454', 'both', '2025-11-09 09:52:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `love_map_points`
--

CREATE TABLE `love_map_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `position` point NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `love_map_points`
--

INSERT INTO `love_map_points` (`id`, `couple_id`, `position`, `label`, `created_at`) VALUES
(4, 2, 0x0000000001010000009eb29aae277d5a407ae063b0e2703540, 'Nhà Bông Baby', '2025-11-09 01:31:55'),
(5, 2, 0x0000000001010000009eb29aae277d5a407ae063b0e2703540, 'Quán cà phê kỷ niệm', '2025-11-09 10:05:00'),
(6, 2, 0x0000000001010000009eb29aae277d5a407ae063b0e2703540, 'Nhà Bông Baby', '2025-11-09 10:31:03'),
(7, 2, 0x000000000101000000b6f468aa277d5a4039f1d58ee2703540, NULL, '2025-11-12 03:58:01'),
(8, 2, 0x000000000101000000b6f468aa277d5a4039f1d58ee2703540, 'Quán cà phê kỷ niệm', '2025-11-12 14:15:11'),
(9, 2, 0x000000000101000000b6f468aa277d5a4039f1d58ee2703540, NULL, '2025-11-14 02:49:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `love_score_logs`
--

CREATE TABLE `love_score_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `changed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `delta` int(11) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `love_score_logs`
--

INSERT INTO `love_score_logs` (`id`, `couple_id`, `changed_by`, `delta`, `reason`, `meta`, `created_at`) VALUES
(1, 2, NULL, 80, 'Hoàn thành task 1', '{\"task_id\":1,\"instance_id\":\"9\",\"timestamp\":\"2025-11-13 10:44:28\"}', '2025-11-13 09:44:28'),
(2, 2, NULL, 80, 'Hoàn thành task 2', '{\"task_id\":2,\"instance_id\":9,\"timestamp\":\"2025-11-13 10:53:20\"}', '2025-11-13 09:53:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `memories`
--

CREATE TABLE `memories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `memories`
--

INSERT INTO `memories` (`id`, `couple_id`, `title`, `description`, `event_date`, `created_by`, `created_at`) VALUES
(1, 2, 'Buổi hẹn đầu tiên ở quán cà phê', 'Ngày hôm đó trời mưa nhẹ, nhưng cả hai vẫn cùng nhau đến quán cà phê nhỏ ở góc phố. Mình vẫn nhớ ánh mắt của em khi nhìn ra ngoài cửa kính — bình yên và ấm áp.Ngày hôm đó trời mưa nhẹ, nhưng cả hai vẫn cùng nhau đến quán cà phê nhỏ ở góc phố. Mình vẫn nhớ ánh mắt của em khi nhìn ra ngoài cửa kính — bình yên và ấm áp', '2025-11-07', 3, '2025-11-07 10:05:15'),
(2, 2, 'Chiều hoàng hôn trên cầu Tình Yêu', 'Lần đầu cùng nhau đi biển, tay nắm tay đi trên cát, tiếng sóng hòa cùng tiếng cười của hai đứa. Một ngày thật đáng nhớ.', '2025-11-29', 3, '2025-11-08 02:45:10'),
(3, 2, 'Sinh nhật em – ấm áp và ngọt ngào', 'Sinh nhật em năm nay thật đặc biệt, vì lần đầu tiên anh tự tay làm bánh. Em cười nhiều lắm, còn anh thì… run tay suýt cháy bánh 😅🎂', '2025-11-20', 3, '2025-11-08 08:11:34'),
(4, 2, 'Hẹn hò lần đầu 💐', 'Ngày hôm đó thật đáng nhớ, chúng mình cùng nhau đi dạo và chụp những bức ảnh tuyệt đẹp.', '2025-11-14', 3, '2025-11-13 03:52:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `memory_photos`
--

CREATE TABLE `memory_photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `memory_id` bigint(20) UNSIGNED NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `media_url` varchar(1000) NOT NULL,
  `thumb_url` varchar(1000) DEFAULT NULL,
  `caption` text DEFAULT NULL,
  `taken_at` timestamp NULL DEFAULT NULL,
  `location_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `memory_photos`
--

INSERT INTO `memory_photos` (`id`, `memory_id`, `uploaded_by`, `media_url`, `thumb_url`, `caption`, `taken_at`, `location_id`, `created_at`) VALUES
(1, 1, 3, 'uploads/memories/690dc45bcdbb3_ip1.jpg', NULL, NULL, NULL, NULL, '2025-11-07 10:05:15'),
(2, 2, 3, 'uploads/memories/690eaeb614133_ip9.jpg', NULL, NULL, NULL, NULL, '2025-11-08 02:45:10'),
(3, 3, 3, 'uploads/memories/690efb369e597_ip1.1.jpg', NULL, NULL, NULL, NULL, '2025-11-08 08:11:34'),
(4, 4, 3, 'uploads/memories/691555f0baebf_ip1.6.jpg', NULL, NULL, NULL, NULL, '2025-11-13 03:52:16'),
(5, 4, 3, 'uploads/memories/691555f0bd0fc_ip1.jpg', NULL, NULL, NULL, NULL, '2025-11-13 03:52:16'),
(6, 4, 3, 'uploads/memories/691555f0be47b_ip2.1.jpg', NULL, NULL, NULL, NULL, '2025-11-13 03:52:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `body` text DEFAULT NULL,
  `message_type` enum('text','image','voice','video','system') DEFAULT 'text',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivered_at` timestamp NULL DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id`, `couple_id`, `sender_id`, `body`, `message_type`, `created_at`, `delivered_at`, `read_at`) VALUES
(25, 1, 1, '{\"text\":\"hehehe\",\"images\":[]}', '', '2025-10-19 15:34:24', NULL, NULL),
(26, 1, 1, '/uploads/68f58cbad2ac7.jpg', 'image', '2025-10-20 01:13:30', NULL, NULL),
(27, 1, 1, '{\"text\":\"fdf\",\"images\":[]}', '', '2025-10-20 01:13:45', NULL, NULL),
(28, 1, 1, '{\"text\":\"hehehe\",\"images\":[\"\\/uploads\\/68f58e30ec897.jpg\"]}', '', '2025-10-20 01:19:44', NULL, NULL),
(29, 1, 1, '{\"text\":\"\",\"images\":[\"\\/uploads\\/68f58fb5b8c74.jpg\",\"\\/uploads\\/68f58fb5b8f19.jpg\",\"\\/uploads\\/68f58fb5b9133.jpg\",\"\\/uploads\\/68f58fb5b92fb.jpg\"]}', '', '2025-10-20 01:26:13', NULL, NULL),
(30, 1, 1, '{\"text\":\"heheh\",\"images\":[\"\\/uploads\\/68f59123a5225.jpg\"]}', '', '2025-10-20 01:32:19', NULL, NULL),
(31, 1, 1, '{\"text\":\"hehehe\",\"images\":[\"\\/uploads\\/68f591d52f907.webp\"]}', '', '2025-10-20 01:35:17', NULL, NULL),
(32, 1, 1, '{\"text\":\"hehehe\",\"images\":[\"\\/uploads\\/68f59230a0d2c.webp\"]}', '', '2025-10-20 01:36:48', NULL, NULL),
(33, 1, 2, '{\"text\":\"đẹp\",\"images\":[]}', '', '2025-10-20 02:32:54', NULL, NULL),
(34, 1, 1, '{\"text\":\"hehehe\",\"images\":[]}', '', '2025-10-20 02:33:22', NULL, NULL),
(35, 1, 2, '{\"text\":\"ồ\",\"images\":[]}', '', '2025-10-20 02:33:37', NULL, NULL),
(36, 1, 2, '{\"text\":\"ok\",\"images\":[]}', '', '2025-10-20 02:35:12', NULL, NULL),
(37, 1, 1, '{\"text\":\"hehehhe\",\"images\":[\"\\/uploads\\/68f59fe964847.jpg\"]}', '', '2025-10-20 02:35:21', NULL, NULL),
(38, 1, 1, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/68f5a2b271241.webm\"}', '', '2025-10-20 02:47:14', NULL, NULL),
(39, 1, 1, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/68f5a2ddd607a.webm\"}', '', '2025-10-20 02:47:57', NULL, NULL),
(40, 1, 1, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/68f5a2e04ba7f.webm\"}', '', '2025-10-20 02:48:00', NULL, NULL),
(41, 1, 1, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/68f5a2f7ee65c.webm\"}', '', '2025-10-20 02:48:23', NULL, NULL),
(42, 1, 2, '{\"text\":\"hehe\",\"images\":[],\"voice\":\"\"}', '', '2025-10-20 02:56:30', NULL, NULL),
(43, 1, 1, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/68f5a4ea84386.webm\"}', '', '2025-10-20 02:56:42', NULL, NULL),
(44, 1, 1, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/68f5a52677425.webm\"}', '', '2025-10-20 02:57:42', NULL, NULL),
(45, 1, 1, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/68f5a58db6b6d.webm\"}', '', '2025-10-20 02:59:25', NULL, NULL),
(46, 1, 1, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/voice_68f5a9e404668.webm\"}', '', '2025-10-20 03:17:56', NULL, NULL),
(47, 1, 1, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/voice_68f5aa051512b.webm\"}', '', '2025-10-20 03:18:29', NULL, NULL),
(48, 1, 1, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/voice_68f5aa2cd5444.webm\"}', '', '2025-10-20 03:19:08', NULL, NULL),
(49, 1, 1, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/voice_68f5aa30e4a82.webm\"}', '', '2025-10-20 03:19:12', NULL, NULL),
(50, 1, 1, '{\"text\":\"hghg\",\"images\":[],\"voice\":\"\"}', '', '2025-10-20 03:19:41', NULL, NULL),
(51, 1, 2, '{\"text\":\"hêh\",\"images\":[],\"voice\":\"\"}', '', '2025-10-20 03:19:44', NULL, NULL),
(52, 1, 1, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/voice_68f5aa53eaeb2.webm\"}', '', '2025-10-20 03:19:47', NULL, NULL),
(53, 1, 2, '{\"text\":\"nè\",\"images\":[\"\\/uploads\\/img_68f5aa5e1b6f9.webp\"],\"voice\":\"\"}', '', '2025-10-20 03:19:58', NULL, NULL),
(54, 2, 4, '{\"text\":\"hi\",\"images\":[],\"voice\":\"\"}', '', '2025-10-20 03:50:56', NULL, NULL),
(55, 2, 3, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/voice_68f5b1e754fa6.webm\"}', '', '2025-10-20 03:52:07', NULL, NULL),
(56, 2, 3, '{\"text\":\"hi\",\"images\":[],\"voice\":\"\"}', '', '2025-10-22 13:34:08', NULL, NULL),
(57, 2, 4, '{\"text\":\"đ\",\"images\":[],\"voice\":\"\"}', '', '2025-10-22 13:34:18', NULL, NULL),
(58, 2, 3, '{\"text\":\"df\",\"images\":[],\"voice\":\"\"}', '', '2025-10-22 13:35:54', NULL, NULL),
(59, 2, 3, '{\"text\":\"heheheh\",\"images\":[],\"voice\":\"\"}', '', '2025-11-09 09:48:52', NULL, NULL),
(60, 2, 4, '{\"text\":\"jhaghjashja\",\"images\":[],\"voice\":\"\"}', '', '2025-11-09 09:48:59', NULL, NULL),
(61, 2, 3, '{\"text\":\"\",\"images\":[\"\\/uploads\\/img_6910639449c11.jpg\"],\"voice\":\"\"}', '', '2025-11-09 09:49:08', NULL, NULL),
(62, 2, 4, '{\"text\":\"hehehe\",\"images\":[\"\\/uploads\\/img_691063c26cee6.jpg\",\"\\/uploads\\/img_691063c26d0c2.jpg\",\"\\/uploads\\/img_691063c26d28d.jpg\"],\"voice\":\"\"}', '', '2025-11-09 09:49:54', NULL, NULL),
(63, 2, 4, '{\"text\":\"hehehe\",\"images\":[\"\\/uploads\\/img_6917468f7d43e.jpg\"],\"voice\":\"\"}', '', '2025-11-14 15:11:11', NULL, NULL),
(64, 2, 4, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/voice_6917484ed75ed.webm\"}', '', '2025-11-14 15:18:38', NULL, NULL),
(65, 2, 4, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/voice_6917485541371.webm\"}', '', '2025-11-14 15:18:45', NULL, NULL),
(66, 2, 4, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/voice_6917486763e03.webm\"}', '', '2025-11-14 15:19:03', NULL, NULL),
(67, 2, 4, '{\"text\":\"\",\"images\":[],\"voice\":\"\\/uploads\\/voice_691748685514e.webm\"}', '', '2025-11-14 15:19:04', NULL, NULL),
(68, 2, 4, '{\"text\":\"dfgdfdf\",\"images\":[],\"voice\":\"\"}', '', '2025-11-14 15:43:36', NULL, NULL),
(69, 2, 4, '{\"text\":\"fdf\",\"images\":[],\"voice\":\"\"}', '', '2025-11-14 15:45:21', NULL, NULL),
(71, 2, 4, '{\"text\":\"\",\"images\":[\"\\/uploads\\/img_69174f56b11ad.jpg\",\"\\/uploads\\/img_69174f56b140e.jpg\"],\"voice\":\"\"}', '', '2025-11-14 15:48:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mini_games`
--

CREATE TABLE `mini_games` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mood_entries`
--

CREATE TABLE `mood_entries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mood` enum('very_happy','happy','neutral','sad','very_sad') DEFAULT 'neutral',
  `mood_score` tinyint(4) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` date DEFAULT curdate(),
  `created_at_ts` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `mood_entries`
--

INSERT INTO `mood_entries` (`id`, `couple_id`, `user_id`, `mood`, `mood_score`, `note`, `created_at`, `created_at_ts`) VALUES
(1, 2, 3, 'happy', NULL, '', '2025-10-25', '2025-10-25 06:55:03'),
(7, 2, 4, 'very_sad', NULL, 'hazz', '2025-10-25', '2025-10-25 06:08:06'),
(11, 2, 4, 'very_happy', NULL, 'hazz', '2025-11-09', '2025-11-09 09:50:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nfc_scan_logs`
--

CREATE TABLE `nfc_scan_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_uid` varchar(128) NOT NULL,
  `couple_id` bigint(20) UNSIGNED DEFAULT NULL,
  `scanned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `location` varchar(255) DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nfc_scan_logs`
--

INSERT INTO `nfc_scan_logs` (`id`, `tag_uid`, `couple_id`, `scanned_at`, `location`, `location_name`) VALUES
(1, 'CE065E99', NULL, '2025-10-19 12:02:44', '21.441077,105.955588', NULL),
(2, '71F6CE12', 1, '2025-10-19 12:03:31', '21.441077,105.955588', NULL),
(3, '1A2CD3AF', 1, '2025-10-19 12:03:55', '21.441077,105.955588', NULL),
(4, '71F6CE12', 1, '2025-10-19 12:08:48', '21.441077,105.955588', NULL),
(5, '1A2CD3AF', 1, '2025-10-19 12:09:14', '21.441077,105.955588', NULL),
(6, '1A2CD3AF', 1, '2025-10-20 02:32:08', '21.441077,105.955588', NULL),
(7, '5E61CD6E', 2, '2025-10-20 03:49:57', '21.441077,105.955588', NULL),
(8, '2C852B16', 2, '2025-10-20 03:50:35', '21.441077,105.955588', NULL),
(9, '2C852B16', 2, '2025-10-20 07:16:16', '21.441077,105.955588', NULL),
(10, '5E61CD6E', 2, '2025-10-20 08:04:27', '21.441077,105.955588', NULL),
(11, '2C852B16', 2, '2025-10-20 13:11:54', '21.441077,105.955588', NULL),
(12, '5E61CD6E', 2, '2025-10-20 14:29:35', '21.441077,105.955588', NULL),
(13, '2C852B16', 2, '2025-10-20 14:44:30', '21.441077,105.955588', NULL),
(14, '5E61CD6E', 2, '2025-10-20 15:27:59', '21.441077,105.955588', NULL),
(15, '2C852B16', 2, '2025-10-22 09:33:28', '21.441077,105.955588', NULL),
(16, '5E61CD6E', 2, '2025-10-23 09:54:24', '21.441077,105.955588', NULL),
(17, '2C852B16', 2, '2025-10-23 15:54:37', '21.441077,105.955588', NULL),
(18, '2C852B16', 2, '2025-10-23 15:59:46', '21.449933,105.958605', NULL),
(20, '5E61CD6E', 2, '2025-10-25 05:35:45', '21.441077,105.955588', NULL),
(21, '2C852B16', 2, '2025-10-25 06:07:40', '21.441077,105.955588', NULL),
(22, '2C852B16', 2, '2025-10-25 08:03:24', '21.441077,105.955588', NULL),
(23, '71F6CE12', 1, '2025-10-25 08:41:49', '21.441077,105.955588', NULL),
(24, '2C852B16', 2, '2025-10-25 12:33:54', '21.441077,105.955590', NULL),
(25, '2C852B16', 2, '2025-10-26 06:16:11', '21.584604,105.809613', NULL),
(26, '2C852B16', 2, '2025-10-26 06:16:25', '21.584451,105.809597', NULL),
(27, '5E61CD6E', 2, '2025-10-26 06:38:12', '21.584437,105.809566', NULL),
(28, '2C852B16', 2, '2025-10-26 06:39:24', '21.584433,105.809579', NULL),
(29, '5E61CD6E', 2, '2025-10-27 09:25:51', '21.584498,105.809594', NULL),
(30, '5E61CD6E', 2, '2025-10-27 09:46:18', '21.584467,105.809571', NULL),
(31, '5E61CD6E', 2, '2025-10-27 09:47:13', '21.584450,105.809574', NULL),
(32, '2C852B16', 2, '2025-10-27 09:47:13', '21.584450,105.809574', NULL),
(33, '5E61CD6E', 2, '2025-10-27 09:49:07', '21.584454,105.809572', NULL),
(34, '71F6CE12', 1, '2025-10-27 09:49:07', '21.584454,105.809572', NULL),
(35, '5E61CD6E', 2, '2025-11-03 05:38:06', '21.029600,105.855300', NULL),
(36, '2C852B16', 2, '2025-11-03 05:38:06', '21.029600,105.855300', NULL),
(37, '5E61CD6E', 2, '2025-11-03 05:40:22', '21.029600,105.855300', NULL),
(38, '2C852B16', 2, '2025-11-03 05:41:39', '21.029600,105.855300', NULL),
(39, '5E61CD6E', 2, '2025-11-03 09:43:53', '21.029600,105.855300', NULL),
(40, '5E61CD6E', 2, '2025-11-03 09:45:39', '21.029600,105.855300', NULL),
(41, '2C852B16', 2, '2025-11-03 09:45:39', '21.029600,105.855300', NULL),
(42, '5E61CD6E', 2, '2025-11-03 09:49:17', '21.029600,105.855300', NULL),
(43, '2C852B16', 2, '2025-11-03 09:49:17', '21.029600,105.855300', NULL),
(44, '5E61CD6E', 2, '2025-11-05 03:10:56', '21.440959,105.955547', NULL),
(45, '2C852B16', 2, '2025-11-05 03:10:56', '21.440959,105.955547', NULL),
(46, '5E61CD6E', 2, '2025-11-05 03:18:44', '21.440959,105.955547', NULL),
(47, '5E61CD6E', 2, '2025-11-06 09:07:11', '21.440959,105.955547', NULL),
(48, '2C852B16', 2, '2025-11-06 09:07:11', '21.440959,105.955547', NULL),
(49, '5E61CD6E', 2, '2025-11-06 09:09:11', '21.440959,105.955547', NULL),
(50, '2C852B16', 2, '2025-11-06 09:09:11', '21.440959,105.955547', NULL),
(51, '5E61CD6E', 2, '2025-11-06 09:09:12', '21.440959,105.955547', NULL),
(52, '2C852B16', 2, '2025-11-06 09:09:12', '21.440959,105.955547', NULL),
(53, '5E61CD6E', 2, '2025-11-06 09:33:07', '21.440959,105.955547', NULL),
(54, '2C852B16', 2, '2025-11-06 09:33:07', '21.440959,105.955547', NULL),
(55, '5E61CD6E', 2, '2025-11-06 09:54:10', '21.440959,105.955547', NULL),
(56, '2C852B16', 2, '2025-11-06 09:54:10', '21.440959,105.955547', NULL),
(57, '5E61CD6E', 2, '2025-11-06 09:58:48', '21.440959,105.955547', NULL),
(58, '2C852B16', 2, '2025-11-06 09:58:48', '21.440959,105.955547', NULL),
(59, '5E61CD6E', 2, '2025-11-06 09:58:56', '21.440959,105.955547', NULL),
(60, '2C852B16', 2, '2025-11-06 09:58:56', '21.440959,105.955547', NULL),
(61, '5E61CD6E', 2, '2025-11-06 09:58:58', '21.440959,105.955547', NULL),
(62, '2C852B16', 2, '2025-11-06 09:58:58', '21.440959,105.955547', NULL),
(63, '5E61CD6E', 2, '2025-11-06 09:59:29', '21.440959,105.955547', NULL),
(64, '2C852B16', 2, '2025-11-06 09:59:29', '21.440959,105.955547', NULL),
(65, '5E61CD6E', 2, '2025-11-06 10:02:16', '21.440959,105.955547', 'Nhà Bông Baby'),
(66, '2C852B16', 2, '2025-11-06 10:02:16', '21.440959,105.955547', 'Nhà Bông Baby'),
(67, '5E61CD6E', 2, '2025-11-07 08:25:09', '21.440959,105.955547', 'Bong Baby'),
(68, '2C852B16', 2, '2025-11-07 08:25:09', '21.440959,105.955547', 'Bong Baby'),
(69, '5E61CD6E', 2, '2025-11-07 08:32:29', '21.440959,105.955547', 'Bong Baby'),
(70, '2C852B16', 2, '2025-11-07 08:32:29', '21.440959,105.955547', 'Bong Baby'),
(71, '5E61CD6E', 2, '2025-11-07 08:57:48', '21.440959,105.955547', 'Bong Baby'),
(72, '2C852B16', 2, '2025-11-07 08:57:48', '21.440959,105.955547', 'Bong Baby'),
(73, '5E61CD6E', 2, '2025-11-09 00:28:58', '21.440959,105.955547', 'Quán cà phê kỷ niệm'),
(74, '2C852B16', 2, '2025-11-09 00:28:58', '21.440959,105.955547', 'Quán cà phê kỷ niệm'),
(75, '5E61CD6E', 2, '2025-11-09 00:29:22', '21.440959,105.955547', 'Quán cà phê kỷ niệm'),
(76, '2C852B16', 2, '2025-11-09 00:29:22', '21.440959,105.955547', 'Quán cà phê kỷ niệm'),
(77, '5E61CD6E', 2, '2025-11-09 01:06:46', '21.029600,105.855300', 'Nhà Bông Baby'),
(78, '2C852B16', 2, '2025-11-09 01:06:46', '21.029600,105.855300', 'Nhà Bông Baby'),
(79, '5E61CD6E', 2, '2025-11-09 01:31:55', '21.440959,105.955547', 'Nhà Bông Baby'),
(80, '2C852B16', 2, '2025-11-09 01:31:55', '21.440959,105.955547', 'Nhà Bông Baby'),
(81, '5E61CD6E', 2, '2025-11-09 09:37:53', '21.440959,105.955547', NULL),
(82, '2C852B16', 2, '2025-11-09 09:48:40', '21.029600,105.855300', NULL),
(83, '5E61CD6E', 2, '2025-11-09 10:05:00', '21.440959,105.955547', 'Quán cà phê kỷ niệm'),
(84, '2C852B16', 2, '2025-11-09 10:05:00', '21.440959,105.955547', 'Quán cà phê kỷ niệm'),
(85, '5E61CD6E', 2, '2025-11-09 10:11:48', '21.440959,105.955547', NULL),
(86, '5E61CD6E', 2, '2025-11-09 10:31:02', '21.440959,105.955547', 'Nhà Bông Baby'),
(87, '2C852B16', 2, '2025-11-09 10:31:02', '21.440959,105.955547', 'Nhà Bông Baby'),
(88, '5E61CD6E', 2, '2025-11-09 10:32:10', '21.440959,105.955547', NULL),
(89, '5E61CD6E', 2, '2025-11-12 03:58:01', '21.440957,105.955546', NULL),
(90, '2C852B16', 2, '2025-11-12 03:58:01', '21.440957,105.955546', NULL),
(91, '5E61CD6E', 2, '2025-11-12 14:15:10', '21.440957,105.955546', NULL),
(92, '2C852B16', 2, '2025-11-12 14:15:10', '21.440957,105.955546', NULL),
(93, '5E61CD6E', 2, '2025-11-14 02:49:25', '21.440957,105.955546', NULL),
(94, '2C852B16', 2, '2025-11-14 02:49:25', '21.440957,105.955546', NULL),
(95, '2C852B16', 2, '2025-11-14 03:15:22', '21.440957,105.955546', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nfc_tags`
--

CREATE TABLE `nfc_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_uid` varchar(128) NOT NULL,
  `couple_id` bigint(20) UNSIGNED DEFAULT NULL,
  `owner_gender` enum('male','female') DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nfc_tags`
--

INSERT INTO `nfc_tags` (`id`, `tag_uid`, `couple_id`, `owner_gender`, `assigned_at`, `created_at`) VALUES
(1, '71F6CE12', 1, 'male', '2025-10-19 12:01:08', '2025-10-19 12:01:08'),
(2, '1A2CD3AF', 1, 'female', '2025-10-19 12:01:08', '2025-10-19 12:01:08'),
(3, '5E61CD6E', 2, 'male', '2025-10-20 03:49:38', '2025-10-20 03:49:38'),
(4, '2C852B16', 2, 'female', '2025-10-20 03:49:38', '2025-10-20 03:49:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `receiver_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiver_email` varchar(255) DEFAULT NULL,
  `receiver_address` varchar(500) DEFAULT NULL,
  `receiver_phone` varchar(20) DEFAULT NULL,
  `male_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `male_dob` date DEFAULT NULL,
  `male_tag_uid` varchar(20) DEFAULT NULL,
  `female_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `female_dob` date DEFAULT NULL,
  `female_tag_uid` varchar(20) DEFAULT NULL,
  `anniversary` date DEFAULT NULL,
  `printed` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `male_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `female_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `couple_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `receiver_name`, `receiver_email`, `receiver_address`, `receiver_phone`, `male_name`, `male_dob`, `male_tag_uid`, `female_name`, `female_dob`, `female_tag_uid`, `anniversary`, `printed`, `created_at`, `male_user_id`, `female_user_id`, `couple_id`) VALUES
(4, 'Nguyen Bong', 'bongtham01@gmail.com', 'Thái Nguyên', '0973564344', 'Nguyễn Văn Bông', '2025-10-23', '71F6CE12', 'Nguyễn Thi C', '2025-10-16', '1A2CD3AF', '2025-10-16', 1, '2025-10-19 12:01:09', 1, 2, 1),
(5, 'Nguyen Bong', 'bongtham01@gmail.com', 'Thái Nguyên', '0973564344', 'Nguyễn Văn A', '2025-10-23', '5E61CD6E', 'Nguyễn Thi B', '2025-10-16', '2C852B16', '2025-10-16', 1, '2025-10-20 03:49:38', 3, 4, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `read_time` varchar(50) DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `excerpt`, `content`, `thumbnail`, `read_time`, `post_date`, `category_id`, `meta_title`, `meta_description`, `meta_keywords`, `status`, `created_at`, `updated_at`) VALUES
(1, '5 Bí Quyết Giữ Lửa Tình Yêu Lâu Dài', '5-bi-quyet-giu-lua-tinh-yeu-lau-dai', 'Khám phá 5 bí quyết giúp các cặp đôi duy trì tình cảm bền lâu, đầy hạnh phúc và ngọt ngào.', '<ol><li>Giao tiếp thường xuyên<br>Giao tiếp là chìa khóa giúp hiểu và đồng cảm với đối phương. Hãy dành thời gian trò chuyện mỗi ngày, dù chỉ vài phút, để chia sẻ cảm xúc và lắng nghe nhau.</li><li>Dành thời gian cho nhau<br>Dù bận rộn, hãy lên kế hoạch hẹn hò hoặc các hoạt động chung như đi dạo, nấu ăn cùng nhau. Những khoảnh khắc này giúp tăng sự gắn kết và gần gũi.</li><li>Tôn trọng sự khác biệt<br>Mỗi người có cá tính riêng. Học cách chấp nhận và tôn trọng sẽ giúp mối quan hệ bền vững hơn, tránh những tranh cãi không đáng có.</li><li>Thể hiện sự quan tâm<br>Những cử chỉ nhỏ như nhắn tin hỏi thăm, tặng quà bất ngờ hay khen ngợi đối phương đều giúp tăng sự yêu thương và hạnh phúc trong mối quan hệ.</li><li>Giải quyết mâu thuẫn khéo léo<br>Khi có xung đột, hãy bình tĩnh, lắng nghe và thảo luận để tìm giải pháp. Tránh trách móc hay cáu giận sẽ giúp mối quan hệ bền chặt hơn.</li></ol>', '/uploads/posts/1763950115_cam1.png', '15', '2025-11-12', 4, '5 Bí Quyết Giữ Lửa Tình Yêu Lâu Dài – LoveApp', 'Tìm hiểu 5 bí quyết giúp các cặp đôi duy trì tình yêu lâu dài, hạnh phúc và ngọt ngào. Áp dụng ngay để giữ lửa tình yêu bền vững.', 'tình yêu, bí quyết tình yêu, giữ lửa tình yêu, hạnh phúc đôi lứa, LoveApp', 'draft', '2025-11-24 00:00:29', '2025-11-24 10:08:55'),
(2, 'Cách duy trì hạnh phúc trong tình yêu', 'cach-duy-tri-hanh-phuc-trong-tinh-yeu', 'Bài viết chia sẻ những bí quyết giúp bạn và người thương duy trì mối quan hệ lâu dài và hạnh phúc.', '<p>Trong cuộc sống hiện đại, việc duy trì một mối quan hệ bền vững không hề dễ dàng. Hãy cùng tìm hiểu các bí quyết để giữ gìn hạnh phúc trong tình yêu:</p><ul><li>Luôn lắng nghe và thấu hiểu cảm xúc của đối phương.</li><li>Dành thời gian chất lượng bên nhau, dù bận rộn.</li><li>Giao tiếp trung thực và tôn trọng nhau.</li><li>Chia sẻ sở thích, mục tiêu và ước mơ.</li><li>Biết tha thứ và bỏ qua những lỗi lầm nhỏ nhặt.</li></ul><p>Những hành động nhỏ nhưng đều đặn này sẽ giúp mối quan hệ trở nên gắn kết và hạnh phúc hơn theo thời gian.</p>', '/uploads/posts/1763951104_t1.png', '5 phút đọc', '2025-11-12', 4, 'Duy trì hạnh phúc trong tình yêu', 'Hướng dẫn các cách duy trì mối quan hệ tình yêu bền vững và hạnh phúc.', 'tình yêu, hạnh phúc, mối quan hệ, bí quyết yêu', 'published', '2025-11-24 09:25:04', '2025-11-24 09:25:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `push_subscriptions`
--

CREATE TABLE `push_subscriptions` (
  `user_id` int(11) NOT NULL,
  `subscription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `push_subscriptions`
--

INSERT INTO `push_subscriptions` (`user_id`, `subscription`) VALUES
(3, '{\"endpoint\":\"https://wns2-pn1p.notify.windows.com/w/?token=BQYAAAAdhyfHQ3Y9%2fUC3TB1H9gFi6gB8VLuUwsQRgEDR2cIyLLXsrz3Sqx6RVYs0kO%2bt3Fqrci8y7gFprm%2fJVcpn9V1zYEtypibiiYdQtCtSvccRX8%2bnBjx3CGi65l%2fjfAVhoNWRRABlQ8Oi2qFG4b7eiyttN98zARjCJtcsPnTxNoQ7i8lLRq6jwS6FOF2NB7Hv9fCxp%2fQ3RGUrGJsrpM1Re3EnMtKnjvMkab8GhKDQh4AIhLIKrjj8I9C%2fyFJ3O8%2fe6fKHdD0DtJKadLPk6pR8MALyUWsJsfwM9KwR69WxY9xGFPf2zrswnz1%2fMTMj6LJx3as%3d\",\"expirationTime\":null,\"keys\":{\"p256dh\":\"BGW0z5bjmKXW4euViBMvxfsnVruR5uXWl6WJ00oXR2iQoS80xGRa9HJoMCTMHuN0H_Fv_AuUOC5JrOIYye8whp4\",\"auth\":\"WN-9GltVHlEe0EFTgsGLEQ\"}}'),
(4, '{\"endpoint\":\"https://wns2-pn1p.notify.windows.com/w/?token=BQYAAAARPg3UcbnwoTSCDNzLnx6Kqts%2bvxl%2bvY5n8qWgdZHrsIp9%2bZKkS%2fgZvsSdsymmT3BX%2b%2fBlYqv1KpEj19fWthARSomg5Abb8vPCOToD%2ftEGjDundZtJM9U04coEiPTZBSqPYlxpaPPkSDyDJ7wkNA3cwRS0wohD3pI6%2b9TMLQ9QiFkjLfkSETSTDMGrpgTE8js9S38V6dYTeGuDnGPFZARoAoN5Qs5kO8jN9VwwcyaIWVOWcm1nQTY7pPbFJ6IImsySWICBg5qR6kUJwKiqdjhtB7StHC4dAclm%2fsxQxz8Z9pedSXDwyMmKSQcmv9%2bkVLQ%3d\",\"expirationTime\":null,\"keys\":{\"p256dh\":\"BF7-niGcdwyGS8gDpiT8lW2-EpJCPMgnlJIWBepHYQU1ROX5Slft5f707ZulrS2QUGZKuv4ViOWaZwYea6dtYY8\",\"auth\":\"qa83p3tnbCEnu2ApubIkEg\"}}');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `secret_letters`
--

CREATE TABLE `secret_letters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `couple_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `unlock_at` datetime DEFAULT NULL,
  `is_opened` tinyint(1) DEFAULT 0,
  `opened_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `secret_letters`
--

INSERT INTO `secret_letters` (`id`, `couple_id`, `sender_id`, `title`, `body`, `attachments`, `unlock_at`, `is_opened`, `opened_at`, `created_at`) VALUES
(1, 2, 3, 'Thư từ Anh 💌', 'dfdffd', NULL, '2025-10-20 00:00:00', 1, '2025-10-20 14:56:45', '2025-10-20 04:46:02'),
(2, 2, 3, 'Thư từ Anh 💌', 'dfdfdf', NULL, '2025-10-20 00:00:00', 1, '2025-10-20 14:58:24', '2025-10-20 04:46:54'),
(3, 2, 3, 'Thư từ Anh 💌', 'dfdfdf', NULL, '2025-10-20 00:00:00', 1, '2025-10-20 14:58:25', '2025-10-20 04:47:17'),
(4, 2, 4, 'Thư từ Em 💌', 'Anh yêu à 💕  \nEm biết dạo này anh bận lắm, nhưng nhớ giữ sức khỏe nha.  \nEm không cần anh nhắn tin mỗi giờ, chỉ cần biết anh vẫn ổn là đủ rồi.  \nKhi mở thư này, hy vọng anh đang mỉm cười thật tươi như mọi khi 😚  \n— Em thương —', NULL, '2025-10-20 00:00:00', 1, '2025-10-20 14:55:32', '2025-10-20 07:28:45'),
(5, 2, 3, 'Thư từ Anh 💌', 'Này cô bé đáng yêu 😝  \nNếu em mở thư này sớm hơn ngày anh chọn… thì anh biết hết đó nha!  \nNhưng nếu đúng ngày rồi, thì... TADA 🎉 Anh chỉ muốn nói:  \nAnh nhớ em nhiều lắm, và đang chuẩn bị một bất ngờ nhỏ dành riêng cho em 💫  \nĐợi anh nhé!', NULL, '2025-10-20 00:00:00', 1, '2025-10-20 14:58:31', '2025-10-20 07:33:37'),
(6, 2, 3, 'Thư từ Anh 💌', 'Này cô bé đáng yêu 😝  \nNếu em mở thư này sớm hơn ngày anh chọn… thì anh biết hết đó nha!  \nNhưng nếu đúng ngày rồi, thì... TADA 🎉 Anh chỉ muốn nói:  \nAnh nhớ em nhiều lắm, và đang chuẩn bị một bất ngờ nhỏ dành riêng cho em 💫  \nĐợi anh nhé!', NULL, '2025-10-20 00:00:00', 1, '2025-10-20 14:58:33', '2025-10-20 07:33:59'),
(7, 2, 3, 'Thư từ Anh 💌', 'Này cô bé đáng yêu 😝  \nNếu em mở thư này sớm hơn ngày anh chọn… thì anh biết hết đó nha!  \nNhưng nếu đúng ngày rồi, thì... TADA 🎉 Anh chỉ muốn nói:  \nAnh nhớ em nhiều lắm, và đang chuẩn bị một bất ngờ nhỏ dành riêng cho em 💫  \nĐợi anh nhé!', NULL, '2025-10-20 00:00:00', 1, '2025-10-23 22:55:16', '2025-10-20 07:34:00'),
(8, 2, 3, 'Thư từ Anh 💌', 'Em thương,  \nCó những điều anh chẳng thể nói hết bằng lời, nên anh viết ra đây.  \nCảm ơn em vì đã cùng anh đi qua những ngày bình yên và cả những ngày bão tố.  \nAnh chỉ mong khi em đọc thư này, em biết rằng — em là phần đẹp nhất trong cuộc sống của anh.  \nMãi thương 💌', NULL, '2025-10-20 00:00:00', 1, '2025-10-20 15:08:22', '2025-10-20 08:07:40'),
(9, 2, 4, 'Thư từ Em 💌', 'Anh yêu à 💕  \nEm biết dạo này anh bận lắm, nhưng nhớ giữ sức khỏe nha.  \nEm không cần anh nhắn tin mỗi giờ, chỉ cần biết anh vẫn ổn là đủ rồi.  \nKhi mở thư này, hy vọng anh đang mỉm cười thật tươi như mọi khi 😚  \n— Em thương —', NULL, '2025-10-20 00:00:00', 1, '2025-10-20 15:46:09', '2025-10-20 08:10:26'),
(10, 2, 3, 'Thư từ Anh 💌', '💫 Gửi đến em của tương lai 💫  \nAnh không biết khi em mở thư này, mình đang ở đâu, đang làm gì...  \nNhưng anh tin một điều: tình cảm này vẫn nguyên vẹn như ngày đầu.  \nThư này chỉ là một lời nhắc nhẹ rằng — có một người vẫn luôn nhớ, luôn thương, và luôn chờ.', NULL, '2025-10-20 00:00:00', 1, '2025-10-20 15:12:01', '2025-10-20 08:11:31'),
(11, 2, 3, 'Thư từ Anh 💌', 'hehehehe', NULL, '2025-11-20 00:00:00', 0, NULL, '2025-10-25 12:33:35'),
(12, 2, 4, 'Thư từ Em 💌', 'hazz', NULL, '2025-10-25 00:00:00', 1, '2025-10-25 19:34:33', '2025-10-25 12:34:22'),
(13, 2, 4, 'Thư từ Em 💌', 'fdđf', NULL, '2025-10-25 00:00:00', 1, '2025-10-25 19:36:17', '2025-10-25 12:36:06'),
(14, 2, 3, 'Thư video từ Anh 💌', NULL, '{\"file\":\"\\/uploads\\/1761455618350_pixel-song-21-72593.mp3\",\"type\":\"audio\",\"size\":false,\"uploaded_at\":\"2025-10-26 06:13:38\"}', '2025-10-26 00:00:00', 1, '2025-10-26 13:42:38', '2025-10-26 05:13:38'),
(15, 2, 3, 'Thư video từ Anh 💌', NULL, '{\"file\":\"\\/uploads\\/1761455727514_pixel-song-21-72593.mp3\",\"type\":\"audio\",\"size\":1930135,\"uploaded_at\":\"2025-10-26 06:15:27\"}', '2025-10-26 00:00:00', 1, '2025-10-26 13:42:48', '2025-10-26 05:15:27'),
(16, 2, 3, 'Thư video từ Anh 💌', NULL, '{\"file\":\"\\/uploads\\/1761458832443_pixel-song-21-72593.mp3\",\"type\":\"audio\",\"size\":1930135,\"uploaded_at\":\"2025-10-26 07:07:12\"}', '2025-10-26 00:00:00', 1, '2025-10-26 13:59:17', '2025-10-26 06:07:12'),
(17, 2, 4, 'Thư từ Em 💌', 'Này cô bé đáng yêu 😝  \nNếu em mở thư này sớm hơn ngày anh chọn… thì anh biết hết đó nha!  \nNhưng nếu đúng ngày rồi, thì... TADA 🎉 Anh chỉ muốn nói:  \nAnh nhớ em nhiều lắm, và đang chuẩn bị một bất ngờ nhỏ dành riêng cho em 💫  \nĐợi anh nhé!', NULL, '2025-10-26 00:00:00', 1, '2025-10-26 13:38:35', '2025-10-26 06:35:12'),
(18, 2, 3, 'Thư từ Anh 💌', 'Này cô bé đáng yêu 😝  \nNếu em mở thư này sớm hơn ngày anh chọn… thì anh biết hết đó nha!  \nNhưng nếu đúng ngày rồi, thì... TADA 🎉 Anh chỉ muốn nói:  \nAnh nhớ em nhiều lắm, và đang chuẩn bị một bất ngờ nhỏ dành riêng cho em 💫  \nĐợi anh nhé!', NULL, '2025-10-26 00:00:00', 1, '2025-10-26 13:44:31', '2025-10-26 06:38:50'),
(19, 2, 3, 'Thư từ Anh 💌', 'Này cô bé đáng yêu 😝  \nNếu em mở thư này sớm hơn ngày anh chọn… thì anh biết hết đó nha!  \nNhưng nếu đúng ngày rồi, thì... TADA 🎉 Anh chỉ muốn nói:  \nAnh nhớ em nhiều lắm, và đang chuẩn bị một bất ngờ nhỏ dành riêng cho em 💫  \nĐợi anh nhé!', NULL, '2025-10-26 00:00:00', 1, '2025-11-09 16:57:40', '2025-10-26 06:45:44'),
(20, 2, 3, 'Thư từ Anh 💌', NULL, '{\"file\":\"\\/uploads\\/1761464528496_14484191_3840_2160_25fps.mp4\",\"type\":\"video\",\"size\":51182598,\"uploaded_at\":\"2025-10-26 08:42:09\"}', '2025-10-26 00:00:00', 1, '2025-10-26 14:45:43', '2025-10-26 07:42:09'),
(21, 2, 3, 'Thư từ Anh 💌', NULL, '{\"file\":\"\\/uploads\\/1761464762955_14484191_3840_2160_25fps.mp4\",\"type\":\"video\",\"size\":51182598,\"uploaded_at\":\"2025-10-26 08:46:03\"}', '2025-10-31 00:00:00', 1, '2025-11-09 17:02:48', '2025-10-26 07:46:03'),
(22, 2, 3, 'Thư từ Anh 💌', NULL, '{\"file\":\"\\/uploads\\/1761464903618_pixel-song-21-72593.mp3\",\"type\":\"audio\",\"size\":1930135,\"uploaded_at\":\"2025-10-26 08:48:23\"}', '2025-10-26 00:00:00', 1, '2025-10-26 14:53:32', '2025-10-26 07:48:23'),
(23, 2, 3, 'Thư từ Anh 💌', '💫 Gửi đến em của tương lai 💫  \nAnh không biết khi em mở thư này, mình đang ở đâu, đang làm gì...  \nNhưng anh tin một điều: tình cảm này vẫn nguyên vẹn như ngày đầu.  \nThư này chỉ là một lời nhắc nhẹ rằng — có một người vẫn luôn nhớ, luôn thương, và luôn chờ.', NULL, '2025-11-09 00:00:00', 1, '2025-11-09 16:59:03', '2025-11-09 09:57:05'),
(24, 2, 3, 'Thư từ Anh 💌', NULL, '{\"file\":\"\\/uploads\\/1762682555126_14484191_3840_2160_25fps.mp4\",\"type\":\"video\",\"size\":51182598,\"uploaded_at\":\"2025-11-09 11:02:35\"}', '2025-11-09 00:00:00', 1, '2025-11-09 17:03:26', '2025-11-09 10:02:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `seo_config`
--

CREATE TABLE `seo_config` (
  `id` int(11) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `seo_config`
--

INSERT INTO `seo_config` (`id`, `meta_title`, `meta_description`, `keywords`, `og_image`, `updated_at`) VALUES
(1, 'Love App - Kết Nối & Hẹn Hò Online An Toàn', '<p>Love App giúp bạn kết nối, tìm kiếm và hẹn hò trực tuyến dễ dàng và an toàn. Khám phá hàng ngàn hồ sơ, trò chuyện, và tìm người phù hợp với bạn ngay hôm nay. Tận hưởng trải nghiệm hẹn hò hiện đại, đáng tin cậy và hoàn toàn miễn phí.</p>', 'Love App, hẹn hò online, kết nối người độc thân, tìm bạn đời, chat trực tuyến, ứng dụng hẹn hò', '', '2025-11-23 14:48:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `hotline` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `contact_email`, `hotline`, `address`, `updated_at`) VALUES
(1, 'Love App - Ứng Dụng Hẹn Hò & Kết Nối', 'contact@loveapp.com', '0901 234 567', 'Tầng 12, Tòa Nhà ABC, 123 Đường Lê Lợi, Quận 1, TP.HCM, Việt Nam', '2025-11-23 15:11:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `display_name` varchar(100) DEFAULT NULL,
  `avatar_url` varchar(500) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT 'other',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `uuid`, `email`, `password_hash`, `display_name`, `avatar_url`, `dob`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'd4991e9bc27d74cd8127a7f5a46a97e9', NULL, NULL, 'Nguyễn Văn Bông', NULL, '2025-10-23', 'male', '2025-10-19 12:01:08', '2025-10-19 12:01:08'),
(2, 'cf26f64b179d24d7b32fdbed6b816538', NULL, NULL, 'Nguyễn Thi C', NULL, '2025-10-16', 'female', '2025-10-19 12:01:08', '2025-10-19 12:01:08'),
(3, '915df1c47a06bcbc6a3ca517e095aff1', 'dtc2154802010602@ictu.edu.vn', '$2y$10$3qvMB.lAlK/NZVdUC2qLvuyj6cVcbtx1dFeXtJ0PTe51rqV0sVz/C', 'Nguyễn Văn A', 'uploads/avatars/avatar_69145388027cd.jpg', '2025-10-17', 'male', '2025-10-20 03:49:38', '2025-11-14 02:47:45'),
(4, 'afe03df64d902e8d9a816e7e56a57c5d', NULL, '$2y$10$MsZRsUUI.I3N9BKkWuZnDue/BCnRmnXm3i9MsVhInHeXbhHRsUcva', 'Nguyễn Thi B', NULL, '2025-10-16', 'female', '2025-10-20 03:49:38', '2025-11-03 09:23:28');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `anniversaries`
--
ALTER TABLE `anniversaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `couple_id` (`couple_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `slug_2` (`slug`);

--
-- Chỉ mục cho bảng `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `challenge_instances`
--
ALTER TABLE `challenge_instances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `couple_id` (`couple_id`),
  ADD KEY `challenge_id` (`challenge_id`);

--
-- Chỉ mục cho bảng `challenge_participants`
--
ALTER TABLE `challenge_participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instance_id` (`instance_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `challenge_tasks`
--
ALTER TABLE `challenge_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `challenge_id` (`challenge_id`);

--
-- Chỉ mục cho bảng `checkins`
--
ALTER TABLE `checkins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `couple_id` (`couple_id`,`created_at`),
  ADD KEY `user_id` (`user_id`,`created_at`);

--
-- Chỉ mục cho bảng `couples`
--
ALTER TABLE `couples`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `created_by` (`created_by`);

--
-- Chỉ mục cho bảng `couple_members`
--
ALTER TABLE `couple_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `couple_id` (`couple_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `couple_streaks`
--
ALTER TABLE `couple_streaks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `couple_id` (`couple_id`);

--
-- Chỉ mục cho bảng `game_sessions`
--
ALTER TABLE `game_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `couple_id` (`couple_id`);

--
-- Chỉ mục cho bảng `heartbeat_signals`
--
ALTER TABLE `heartbeat_signals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `couple_id` (`couple_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Chỉ mục cho bảng `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `couple_id` (`couple_id`),
  ADD SPATIAL KEY `position` (`position`);

--
-- Chỉ mục cho bảng `love_diaries`
--
ALTER TABLE `love_diaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `couple_id` (`couple_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Chỉ mục cho bảng `love_map_points`
--
ALTER TABLE `love_map_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `couple_id` (`couple_id`),
  ADD SPATIAL KEY `position` (`position`);

--
-- Chỉ mục cho bảng `love_score_logs`
--
ALTER TABLE `love_score_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `couple_id` (`couple_id`),
  ADD KEY `changed_by` (`changed_by`);

--
-- Chỉ mục cho bảng `memories`
--
ALTER TABLE `memories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `couple_id` (`couple_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Chỉ mục cho bảng `memory_photos`
--
ALTER TABLE `memory_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `memory_id` (`memory_id`),
  ADD KEY `uploaded_by` (`uploaded_by`),
  ADD KEY `location_id` (`location_id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `couple_id` (`couple_id`,`created_at`);

--
-- Chỉ mục cho bảng `mini_games`
--
ALTER TABLE `mini_games`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `mood_entries`
--
ALTER TABLE `mood_entries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `couple_id` (`couple_id`,`user_id`,`created_at`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `nfc_scan_logs`
--
ALTER TABLE `nfc_scan_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `couple_id` (`couple_id`);

--
-- Chỉ mục cho bảng `nfc_tags`
--
ALTER TABLE `nfc_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag_uid` (`tag_uid`),
  ADD KEY `couple_id` (`couple_id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `secret_letters`
--
ALTER TABLE `secret_letters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `couple_id` (`couple_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Chỉ mục cho bảng `seo_config`
--
ALTER TABLE `seo_config`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `anniversaries`
--
ALTER TABLE `anniversaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `challenges`
--
ALTER TABLE `challenges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `challenge_instances`
--
ALTER TABLE `challenge_instances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `challenge_participants`
--
ALTER TABLE `challenge_participants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `challenge_tasks`
--
ALTER TABLE `challenge_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `checkins`
--
ALTER TABLE `checkins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `couples`
--
ALTER TABLE `couples`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `couple_members`
--
ALTER TABLE `couple_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `couple_streaks`
--
ALTER TABLE `couple_streaks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `game_sessions`
--
ALTER TABLE `game_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `heartbeat_signals`
--
ALTER TABLE `heartbeat_signals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `love_diaries`
--
ALTER TABLE `love_diaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `love_map_points`
--
ALTER TABLE `love_map_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `love_score_logs`
--
ALTER TABLE `love_score_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `memories`
--
ALTER TABLE `memories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `memory_photos`
--
ALTER TABLE `memory_photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT cho bảng `mini_games`
--
ALTER TABLE `mini_games`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `mood_entries`
--
ALTER TABLE `mood_entries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `nfc_scan_logs`
--
ALTER TABLE `nfc_scan_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT cho bảng `nfc_tags`
--
ALTER TABLE `nfc_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `secret_letters`
--
ALTER TABLE `secret_letters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `seo_config`
--
ALTER TABLE `seo_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `anniversaries`
--
ALTER TABLE `anniversaries`
  ADD CONSTRAINT `anniversaries_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `challenge_instances`
--
ALTER TABLE `challenge_instances`
  ADD CONSTRAINT `challenge_instances_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `challenge_instances_ibfk_2` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `challenge_participants`
--
ALTER TABLE `challenge_participants`
  ADD CONSTRAINT `challenge_participants_ibfk_1` FOREIGN KEY (`instance_id`) REFERENCES `challenge_instances` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `challenge_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `challenge_tasks`
--
ALTER TABLE `challenge_tasks`
  ADD CONSTRAINT `challenge_tasks_ibfk_1` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `checkins`
--
ALTER TABLE `checkins`
  ADD CONSTRAINT `checkins_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checkins_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `checkins_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `couples`
--
ALTER TABLE `couples`
  ADD CONSTRAINT `couples_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `couple_members`
--
ALTER TABLE `couple_members`
  ADD CONSTRAINT `couple_members_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `couple_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `couple_streaks`
--
ALTER TABLE `couple_streaks`
  ADD CONSTRAINT `couple_streaks_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `game_sessions`
--
ALTER TABLE `game_sessions`
  ADD CONSTRAINT `game_sessions_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `mini_games` (`id`),
  ADD CONSTRAINT `game_sessions_ibfk_2` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`);

--
-- Các ràng buộc cho bảng `heartbeat_signals`
--
ALTER TABLE `heartbeat_signals`
  ADD CONSTRAINT `heartbeat_signals_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `heartbeat_signals_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `love_diaries`
--
ALTER TABLE `love_diaries`
  ADD CONSTRAINT `love_diaries_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `love_diaries_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `love_map_points`
--
ALTER TABLE `love_map_points`
  ADD CONSTRAINT `love_map_points_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `love_score_logs`
--
ALTER TABLE `love_score_logs`
  ADD CONSTRAINT `love_score_logs_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `love_score_logs_ibfk_2` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `memories`
--
ALTER TABLE `memories`
  ADD CONSTRAINT `memories_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `memories_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `memory_photos`
--
ALTER TABLE `memory_photos`
  ADD CONSTRAINT `memory_photos_ibfk_1` FOREIGN KEY (`memory_id`) REFERENCES `memories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `memory_photos_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `memory_photos_ibfk_3` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `mood_entries`
--
ALTER TABLE `mood_entries`
  ADD CONSTRAINT `mood_entries_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mood_entries_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `nfc_scan_logs`
--
ALTER TABLE `nfc_scan_logs`
  ADD CONSTRAINT `nfc_scan_logs_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `nfc_tags`
--
ALTER TABLE `nfc_tags`
  ADD CONSTRAINT `nfc_tags_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `secret_letters`
--
ALTER TABLE `secret_letters`
  ADD CONSTRAINT `secret_letters_ibfk_1` FOREIGN KEY (`couple_id`) REFERENCES `couples` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `secret_letters_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
