-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 17, 2026 at 11:30 AM
-- Server version: 10.11.11-MariaDB-cll-lve
-- PHP Version: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventy_eventy`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'Strategic Briefing',
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `category`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'The Rise of Neural Travel: Predictive Itineraries', 'the-rise-of-neural-travel-predictive-itineraries', 'How AI is transforming the standard vacation into a high-precision execution of personalized desires...', 'Full report on how neural matching engines are revolutionizing the luxury travel sector by predicting user preferences before they are even voiced.', 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=2070&auto=format&fit=crop', 'Strategic Briefing', 1, '2026-01-03 09:09:55', '2026-01-03 09:09:55', '2026-01-03 09:09:55'),
(2, 'Digital Concierge vs Human Touch', 'digital-concierge-vs-human-touch', 'Analyzing the friction points in premium automated service delivery...', 'A deep dive into the balance between AI efficiency and the irreplaceable value of human empathy in the hospitality industry.', 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=2074&auto=format&fit=crop', 'Hospitality Core', 1, '2026-01-03 09:09:56', '2026-01-03 09:09:56', '2026-01-03 09:09:56'),
(3, 'Encryption in Event Logistics', 'encryption-in-event-logistics', 'Securing high-profile client data across fragmented vendor pipelines...', 'Technical specifications for the end-to-end encryption protocols required to protect VIP data during large-scale global events.', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=2070&auto=format&fit=crop', 'Protocol Insight', 1, '2026-01-03 09:09:56', '2026-01-03 09:09:56', '2026-01-03 09:09:56'),
(4, 'The 2026 Luxury Global Calendar', 'the-2026-luxury-global-calendar', 'Previewing the most exclusive events across our priority global nodes...', 'An executive overview of the upcoming year\'s most prestigious summits, galas, and travel benchmarks.', 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=2070&auto=format&fit=crop', 'Global Reach', 1, '2026-01-03 09:09:56', '2026-01-03 09:09:56', '2026-01-03 09:09:56');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `booking_date` datetime NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `total_price` decimal(15,2) DEFAULT NULL,
  `commission_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `vendor_net_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payout_status` varchar(255) NOT NULL DEFAULT 'pending',
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `event_end_date` datetime DEFAULT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `event_address` varchar(255) DEFAULT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `budget` decimal(12,2) DEFAULT NULL,
  `special_requests` text DEFAULT NULL,
  `booking_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`booking_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `service_id`, `vendor_id`, `booking_date`, `status`, `notes`, `total_price`, `commission_fee`, `vendor_net_amount`, `payout_status`, `customer_name`, `customer_phone`, `customer_email`, `event_type`, `event_end_date`, `event_location`, `event_address`, `guest_count`, `budget`, `special_requests`, `booking_data`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 4, '2025-12-30 20:04:00', 'completed', 'sdfasdsdfasdf', NULL, 0.00, 0.00, 'pending', 'sameer', '123123123', 'sameer@gmail.com', 'wedding', '2025-12-31 20:04:00', 'dasdasd', 'dfasdasdas', 123, 5000.00, 'sfasdfasdfsdf', NULL, '2025-12-30 10:05:23', '2025-12-30 10:06:32'),
(2, 8, 8, 7, '2026-01-04 15:42:38', 'completed', NULL, NULL, 0.00, 0.00, 'pending', 'Test Customer', '03001234567', 'testverify_cust@example.com', 'Test Event', NULL, 'Test Venue', NULL, 100, NULL, NULL, NULL, '2025-12-30 10:42:38', '2025-12-30 10:42:38'),
(3, 6, 2, 4, '2026-01-08 00:12:00', 'completed', 'ASDASDASDASCASCD', NULL, 0.00, 0.00, 'pending', 'sameer', '123123', 'sameer@gmail.com', 'wedding', '2026-01-08 22:16:00', 'sdfasdfa', 'asdfsdf', 1000, 50000.00, 'Security, Lighting, Stage Decor, Outdoor, Indoor, Sound System, Valet Parking', NULL, '2025-12-31 12:15:37', '2026-01-01 09:05:31'),
(4, 6, 2, 4, '2026-01-03 12:00:00', 'completed', NULL, 500000.00, 0.00, 0.00, 'pending', 'sameer', '234123123', 'sameer@gmail.com', 'standard', NULL, 'ASDASDASD', 'ASDASDASD', 50, NULL, NULL, '{\"duration_days\":\"1\",\"passengers\":null,\"luggage\":null,\"pickup_location\":null,\"dropoff_location\":null,\"menu_preference\":null,\"coverage_hours\":null,\"package_name\":null,\"selected_addons\":[]}', '2026-01-02 11:24:01', '2026-01-02 11:29:01'),
(5, 6, 5, 4, '2026-01-03 12:00:00', 'pending', NULL, 450000.00, 0.00, 0.00, 'pending', 'sameer', '12312312312', 'sameer@gmail.com', 'standard', NULL, 'SDASDAS', 'SDASDAS', 50, NULL, NULL, '{\"duration_days\":\"15\",\"luggage\":null,\"dropoff_location\":null,\"menu_preference\":null,\"coverage_hours\":null,\"nationality\":null,\"passport_no\":null,\"room_type\":\"Standard\",\"room_count\":\"1\",\"package_name\":null,\"selected_addons\":[]}', '2026-01-02 11:48:56', '2026-01-02 11:48:56'),
(6, 6, 2, 4, '2026-01-10 12:00:00', 'cancelled', NULL, 500000.00, 50000.00, 450000.00, 'pending', 'sameer', '12312312312', 'sameer@gmail.com', 'premium', NULL, 'swdasdasdasd', 'swdasdasdasd', 50, NULL, NULL, '{\"duration_days\":\"1\",\"luggage\":null,\"dropoff_location\":null,\"menu_preference\":null,\"coverage_hours\":null,\"nationality\":null,\"passport_no\":null,\"room_type\":\"Standard\",\"room_count\":\"1\",\"package_name\":null,\"selected_addons\":[]}', '2026-01-03 10:59:28', '2026-01-03 17:19:21'),
(7, 6, 2, 4, '2026-01-10 12:00:00', 'pending', NULL, 500000.00, 50000.00, 450000.00, 'pending', 'sameer', '12312312312', 'sameer@gmail.com', 'premium', NULL, 'swdasdasdasd', 'swdasdasdasd', 50, NULL, NULL, '{\"duration_days\":\"1\",\"luggage\":null,\"dropoff_location\":null,\"menu_preference\":null,\"coverage_hours\":null,\"nationality\":null,\"passport_no\":null,\"room_type\":\"Standard\",\"room_count\":\"1\",\"package_name\":null,\"selected_addons\":[]}', '2026-01-03 11:02:42', '2026-01-03 11:02:42'),
(8, 9, 2, 4, '2026-01-04 12:00:00', 'pending', NULL, 500000.00, 50000.00, 450000.00, 'pending', 'Azam Siddiqui', '2389131239012', 'azam75256@gmail.com', 'premium', NULL, 'karachi', 'karachi', 50000, NULL, NULL, '{\"duration_days\":\"150\",\"luggage\":null,\"dropoff_location\":null,\"menu_preference\":null,\"coverage_hours\":null,\"nationality\":null,\"passport_no\":null,\"room_type\":\"Standard\",\"room_count\":\"1\",\"package_name\":null,\"selected_addons\":[]}', '2026-01-04 04:56:25', '2026-01-04 04:56:25');

-- --------------------------------------------------------

--
-- Table structure for table `budget_requests`
--

CREATE TABLE `budget_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_type` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `guests` int(11) DEFAULT NULL,
  `budget` decimal(12,2) NOT NULL,
  `services_needed` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`services_needed`)),
  `selected_tier` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `budget_requests`
--

INSERT INTO `budget_requests` (`id`, `user_id`, `service_type`, `location`, `guests`, `budget`, `services_needed`, `selected_tier`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, NULL, 'wedding', 'Turkey', 500, 500000.00, '[\"venue\",\"catering\",\"decor\",\"photography\",\"transport\",\"hotel\",\"flights\",\"entertainment\"]', NULL, 'processed', NULL, '2026-01-01 12:55:29', '2026-01-01 12:55:29');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-345170d1b06781bcc43805625722c393', 'i:1;', 1767290189),
('laravel-cache-345170d1b06781bcc43805625722c393:timer', 'i:1767290189;', 1767290189),
('laravel-cache-3884b38ed36aef11771b5b73f07bdb20', 'i:1;', 1767455778),
('laravel-cache-3884b38ed36aef11771b5b73f07bdb20:timer', 'i:1767455778;', 1767455778),
('laravel-cache-5ec0157e241263d6ca7ea4889ce4cdc2', 'i:1;', 1767462920),
('laravel-cache-5ec0157e241263d6ca7ea4889ce4cdc2:timer', 'i:1767462920;', 1767462920),
('laravel-cache-a252d0f4dcb382db5d4cf4f4cbfd38bf', 'i:1;', 1767360906),
('laravel-cache-a252d0f4dcb382db5d4cf4f4cbfd38bf:timer', 'i:1767360906;', 1767360906),
('laravel-cache-b9710f11dd5e0880e9c6838133537f3c', 'i:2;', 1767180119),
('laravel-cache-b9710f11dd5e0880e9c6838133537f3c:timer', 'i:1767180119;', 1767180119),
('laravel-cache-customer@test.com|127.0.0.1', 'i:1;', 1767103225),
('laravel-cache-customer@test.com|127.0.0.1:timer', 'i:1767103225;', 1767103225),
('laravel-cache-e2bf1df015f481944a9cdacc1074a8e2', 'i:2;', 1767455899),
('laravel-cache-e2bf1df015f481944a9cdacc1074a8e2:timer', 'i:1767455899;', 1767455899),
('laravel-cache-sameer@test.com|127.0.0.1', 'i:1;', 1767103229),
('laravel-cache-sameer@test.com|127.0.0.1:timer', 'i:1767103229;', 1767103229),
('laravel-cache-testuser@example.com|127.0.0.1', 'i:1;', 1767103235),
('laravel-cache-testuser@example.com|127.0.0.1:timer', 'i:1767103235;', 1767103235),
('laravel-cache-user@eventy.pk|127.0.0.1', 'i:1;', 1767105976),
('laravel-cache-user@eventy.pk|127.0.0.1:timer', 'i:1767105976;', 1767105976),
('laravel-cache-vendorone@eventy.com|127.0.0.1', 'i:2;', 1767180120),
('laravel-cache-vendorone@eventy.com|127.0.0.1:timer', 'i:1767180120;', 1767180120);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `slug`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Karachi', 'karachi', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(2, 'Lahore', 'lahore', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(3, 'Islamabad', 'islamabad', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(4, 'Rawalpindi', 'rawalpindi', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(5, 'Faisalabad', 'faisalabad', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(6, 'Multan', 'multan', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(7, 'Gujranwala', 'gujranwala', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(8, 'Hyderabad', 'hyderabad', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(9, 'Peshawar', 'peshawar', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(10, 'Quetta', 'quetta', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(11, 'Sialkot', 'sialkot', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(12, 'Bahawalpur', 'bahawalpur', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(13, 'Sargodha', 'sargodha', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(14, 'Sukkur', 'sukkur', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(15, 'Jhang', 'jhang', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(16, 'Shekhupura', 'shekhupura', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(17, 'Rahim Yar Khan', 'rahim-yar-khan', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(18, 'Gujrat', 'gujrat', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(19, 'Kasur', 'kasur', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(20, 'Sahiwal', 'sahiwal', '2025-12-30 10:28:18', '2025-12-30 10:28:18', NULL),
(21, 'Test City', 'test-city', '2025-12-30 10:42:37', '2025-12-30 10:42:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_inquiries`
--

CREATE TABLE `contact_inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` enum('fixed','percent') NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `min_order_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `expires_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `vendor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_packages`
--

CREATE TABLE `custom_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `total_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_package_bookings`
--

CREATE TABLE `custom_package_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `custom_package_id` bigint(20) UNSIGNED NOT NULL,
  `booking_date` datetime NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `total_amount` decimal(15,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `event_address` text DEFAULT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `budget` decimal(15,2) DEFAULT NULL,
  `special_requests` text DEFAULT NULL,
  `booking_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`booking_data`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_package_services`
--

CREATE TABLE `custom_package_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `custom_package_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `service_id`, `created_at`, `updated_at`) VALUES
(2, 6, 2, '2025-12-30 10:50:15', '2025-12-30 10:50:15'),
(4, 6, 5, '2026-01-02 12:35:02', '2026-01-02 12:35:02'),
(5, 6, 4, '2026-01-02 12:35:05', '2026-01-02 12:35:05'),
(6, 6, 7, '2026-01-02 12:35:08', '2026-01-02 12:35:08'),
(7, 6, 6, '2026-01-02 12:35:10', '2026-01-02 12:35:10');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `body`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 6, 4, 'hy', 1, '2025-12-30 10:07:13', '2026-01-02 11:27:13'),
(2, 4, 6, 'hy', 1, '2025-12-30 10:08:50', '2026-01-02 11:47:50'),
(3, 6, 4, 'kia hall hain', 1, '2025-12-30 10:09:24', '2026-01-02 11:27:13'),
(4, 4, 6, 'theak hu', 1, '2025-12-30 10:09:45', '2026-01-02 11:47:50'),
(5, 6, 4, 'ASDFSWDF', 1, '2026-01-02 11:27:01', '2026-01-02 11:27:13'),
(6, 4, 6, 'HAN BY KUCCTAY', 1, '2026-01-02 11:27:23', '2026-01-02 11:47:50'),
(7, 6, 4, 'SASDASD', 1, '2026-01-02 11:27:37', '2026-01-02 11:27:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_09_114601_create_services_table', 2),
(5, '2025_12_09_130401_add_vendor_fields_to_users_table', 3),
(6, '2025_12_09_142840_create_bookings_table', 3),
(7, '2025_12_09_161344_create_contact_inquiries_table', 3),
(8, '2025_12_09_161501_create_budget_requests_table', 3),
(9, '2025_12_09_162112_create_newsletters_table', 3),
(10, '2025_12_09_163832_create_service_categories_table', 3),
(11, '2025_12_09_164729_add_category_id_to_services_table', 3),
(12, '2025_12_09_165652_update_services_table_add_missing_columns', 3),
(13, '2025_12_11_103824_create_notifications_table', 3),
(14, '2025_12_11_124350_add_extra_fields_to_services_table', 3),
(15, '2025_12_11_173358_add_booking_details_to_bookings_table', 3),
(16, '2025_12_11_181709_create_cities_table', 3),
(17, '2025_12_11_181717_add_city_id_to_users_table', 3),
(18, '2025_12_11_182813_create_categories_table', 3),
(19, '2025_12_11_182816_add_category_id_to_users_table', 3),
(20, '2025_12_12_093859_create_testimonials_table', 3),
(21, '2025_12_12_104423_create_features_table', 3),
(22, '2025_12_12_104957_add_is_featured_to_services_table', 3),
(23, '2025_12_20_182311_create_reviews_table', 3),
(24, '2025_12_20_182312_create_review_likes_table', 3),
(25, '2025_12_22_133030_create_custom_packages_table', 4),
(26, '2025_12_22_133031_create_custom_package_services_table', 4),
(27, '2025_12_22_133032_create_custom_package_bookings_table', 5),
(28, '2025_12_22_140847_add_details_to_custom_package_bookings_table', 5),
(29, '2025_12_23_133221_add_selected_tier_to_budget_requests_table', 5),
(30, '2025_12_23_160622_create_service_desk_requests_table', 5),
(31, '2025_12_30_112215_add_multiple_images_to_services_table', 6),
(32, '2025_12_30_114452_add_avatar_to_users_table', 7),
(33, '2025_12_30_132819_add_reply_to_reviews_table', 8),
(34, '2025_12_30_133434_create_messages_table', 9),
(35, '2025_12_30_154529_create_favorites_table', 10),
(36, '2025_12_30_155346_create_service_availability_table', 11),
(43, '2026_01_01_140838_create_vendor_logs_table', 12),
(44, '2026_01_01_150957_create_payments_table', 13),
(45, '2026_01_01_153459_add_cached_rating_to_services_table', 16),
(46, '2026_01_01_152520_add_finance_fields_to_users_table', 17),
(47, '2026_01_01_152520_add_finance_fields_to_users_table', 14),
(48, '2026_01_01_152521_create_withdrawals_table', 15),
(49, '2026_01_01_154436_add_business_metadata_to_users_table', 18),
(50, '2026_01_01_161646_add_packages_and_addons_to_services_table', 19),
(51, '2026_01_01_162020_add_total_price_to_bookings_table', 20),
(52, '2026_01_01_162436_create_coupons_table', 21),
(53, '2026_01_01_163329_add_images_to_reviews_table', 22),
(54, '2026_01_02_170502_add_booking_id_to_reviews_table', 23),
(55, '2026_01_02_171547_add_commission_to_bookings_table', 24),
(56, '2026_01_03_140731_create_blog_posts_table', 25);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT 'purple',
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `icon`, `color`, `link`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 4, 'booking', 'New Booking Request!', 'sameer wants to book \"Premium Wedding Photography\" for wedding with 123 guests on Dec 30, 2025', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/vendor/orders', 1, '2025-12-30 10:05:23', '2025-12-30 10:06:43'),
(2, 6, 'booking', 'Booking Submitted!', 'Your booking for \"Premium Wedding Photography\" has been submitted. The vendor will contact you soon.', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/my-bookings', 1, '2025-12-30 10:05:23', '2025-12-30 10:13:08'),
(3, 6, 'booking', 'Booking Confirmed', 'Great news! Your booking has been confirmed by the vendor. Service: Premium Wedding Photography', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/my-bookings', 1, '2025-12-30 10:06:28', '2025-12-30 10:13:08'),
(4, 6, 'booking', 'Booking Completed', 'Your booking has been marked as completed. Please rate your experience! Service: Premium Wedding Photography', 'fa-check-double', 'blue', 'http://127.0.0.1:8000/my-bookings', 1, '2025-12-30 10:06:32', '2025-12-30 10:13:08'),
(5, 4, 'booking', 'New Booking Request!', 'sameer wants to book \"Royal Marquee Booking\" for wedding with 1000 guests on Jan 08, 2026', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/vendor/orders', 1, '2025-12-31 12:15:37', '2026-01-02 11:13:24'),
(6, 6, 'booking', 'Booking Submitted!', 'Your booking for \"Royal Marquee Booking\" has been submitted. The vendor will contact you soon.', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/my-bookings', 1, '2025-12-31 12:15:37', '2026-01-02 11:01:27'),
(7, 6, 'booking', 'Booking Confirmed', 'Great news! Your booking has been confirmed by the vendor. Service: Royal Marquee Booking', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/my-bookings', 1, '2025-12-31 12:16:19', '2026-01-02 11:01:27'),
(8, 6, 'booking', 'Booking Completed', 'Your booking has been marked as completed. Please rate your experience! Service: Royal Marquee Booking', 'fa-check-double', 'blue', 'http://127.0.0.1:8000/my-bookings', 1, '2026-01-01 09:05:31', '2026-01-02 11:01:27'),
(9, 6, 'booking', 'Booking Completed', 'Your booking has been marked as completed. Please rate your experience! Service: Royal Marquee Booking', 'fa-check-double', 'blue', 'http://127.0.0.1:8000/my-bookings', 1, '2026-01-01 09:05:31', '2026-01-02 11:01:27'),
(10, 4, 'booking', 'New Booking Request!', 'sameer wants to book \"Royal Marquee Booking\" for standard with 50 guests on Jan 03, 2026', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/vendor/orders', 0, '2026-01-02 11:24:02', '2026-01-02 11:24:02'),
(11, 6, 'booking', 'Booking Submitted!', 'Your booking for \"Royal Marquee Booking\" has been submitted. The vendor will contact you soon.', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/my-bookings', 1, '2026-01-02 11:24:02', '2026-01-02 11:51:10'),
(12, 6, 'booking', 'Booking Confirmed', 'Great news! Your booking has been confirmed by the vendor. Service: Royal Marquee Booking', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/my-bookings', 1, '2026-01-02 11:25:41', '2026-01-02 11:51:10'),
(13, 6, 'booking', 'Booking Completed', 'Your booking has been marked as completed. Please rate your experience! Service: Royal Marquee Booking', 'fa-check-double', 'blue', 'http://127.0.0.1:8000/my-bookings', 1, '2026-01-02 11:29:01', '2026-01-02 11:51:10'),
(14, 4, 'booking', 'New Booking Request!', 'sameer wants to book \"15 Days Premium Umrah\" for standard with 50 guests (50 travelers, 15 days) on Jan 03, 2026', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/vendor/orders', 0, '2026-01-02 11:48:56', '2026-01-02 11:48:56'),
(15, 6, 'booking', 'Booking Submitted!', 'Your booking for \"15 Days Premium Umrah\" has been submitted. The vendor will contact you soon.', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/my-bookings', 1, '2026-01-02 11:48:56', '2026-01-02 11:51:10'),
(16, 4, 'booking', 'New Booking Request!', 'sameer wants to book \"Royal Marquee Booking\" for premium with 50 guests on Jan 10, 2026', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/vendor/orders', 0, '2026-01-03 10:59:28', '2026-01-03 10:59:28'),
(17, 6, 'booking', 'Booking Submitted!', 'Your booking for \"Royal Marquee Booking\" has been submitted. The vendor will contact you soon.', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/my-bookings', 0, '2026-01-03 10:59:28', '2026-01-03 10:59:28'),
(18, 4, 'booking', 'New Booking Request!', 'sameer wants to book \"Royal Marquee Booking\" for premium with 50 guests on Jan 10, 2026', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/vendor/orders', 0, '2026-01-03 11:02:42', '2026-01-03 11:02:42'),
(19, 6, 'booking', 'Booking Submitted!', 'Your booking for \"Royal Marquee Booking\" has been submitted. The vendor will contact you soon.', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/my-bookings', 0, '2026-01-03 11:02:42', '2026-01-03 11:02:42'),
(20, 6, 'booking', 'Booking Cancelled', 'Update: Your booking has been cancelled by the vendor. Service: Royal Marquee Booking', 'fa-circle-xmark', 'red', 'http://127.0.0.1:8000/my-bookings', 0, '2026-01-03 17:19:21', '2026-01-03 17:19:21'),
(21, 4, 'booking', 'New Booking Request!', 'Azam Siddiqui wants to book \"Royal Marquee Booking\" for premium with 50000 guests on Jan 04, 2026', 'fa-calendar-check', 'green', 'https://eventy.pk/vendor/orders', 0, '2026-01-04 04:56:25', '2026-01-04 04:56:25'),
(22, 9, 'booking', 'Booking Submitted!', 'Your booking for \"Royal Marquee Booking\" has been submitted. The vendor will contact you soon.', 'fa-calendar-check', 'green', 'https://eventy.pk/my-bookings', 0, '2026-01-04 04:56:25', '2026-01-04 04:56:25');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `stripe_session_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'PKR',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) NOT NULL DEFAULT 'stripe',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `likes_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `service_id`, `booking_id`, `rating`, `comment`, `images`, `reply`, `replied_at`, `likes_count`, `created_at`, `updated_at`) VALUES
(1, 8, 8, NULL, 5, 'Persistence check passed successfully!', NULL, NULL, NULL, 0, '2025-12-30 10:42:38', '2025-12-30 10:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `review_likes`
--

CREATE TABLE `review_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `packages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`packages`)),
  `add_ons` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`add_ons`)),
  `price_type` varchar(255) NOT NULL DEFAULT 'fixed',
  `location` varchar(255) DEFAULT NULL,
  `extra_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extra_data`)),
  `image` varchar(255) DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `featured_image_index` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `cached_rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `reviews_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `user_id`, `name`, `description`, `price`, `packages`, `add_ons`, `price_type`, `location`, `extra_data`, `image`, `images`, `featured_image_index`, `status`, `cached_rating`, `reviews_count`, `created_at`, `updated_at`, `category_id`, `is_featured`) VALUES
(1, 4, 'Premium Wedding Photography', 'Complete coverage of your 3-day wedding event (Mehndi, Barat, Valima) with drone shots and highlights.', 150000.00, NULL, NULL, 'fixed', 'Lahore, Pakistan', NULL, 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80', '[\"services\\/ATPQBdH0gGkxgZovtV3jo0FSaIoZFFPKPJpK5vz2.png\",\"services\\/aSgQ2sVrV3dmHjSKhiXFzK41fiW6mBN46GxnmX0D.png\",\"services\\/t7TxXjCt8IwrhNDJjo2aKwf0zR9tzqgU0EKeV9CO.png\"]', 2, 'active', 0.00, 0, '2025-12-26 08:38:31', '2025-12-30 09:24:27', 2, 1),
(2, 4, 'Royal Marquee Booking', 'Luxurious marquee for 500 guests with catering and decor options included.', 500000.00, NULL, NULL, 'fixed', 'Islamabad, Pakistan', NULL, 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=800&q=80', NULL, 0, 'active', 0.00, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31', 2, 1),
(3, 4, 'Maldives Honeymoon Package', '5 Days, 4 Nights all-inclusive stay at a water villa resort with flights included.', 850000.00, NULL, NULL, 'fixed', 'Maldives', NULL, 'https://images.unsplash.com/photo-1573843981267-be1999ff37cd?auto=format&fit=crop&w=800&q=80', NULL, 0, 'active', 0.00, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31', 7, 1),
(4, 4, 'Annual Corporate Dinner', 'Full event management for 200 employees including venue, food, and sound system.', 300000.00, NULL, NULL, 'fixed', 'Karachi, Pakistan', NULL, 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=800&q=80', NULL, 0, 'active', 0.00, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31', 3, 1),
(5, 4, '15 Days Premium Umrah', '5-star hotels near Haram in Makkah and Madinah, transport included.', 450000.00, NULL, NULL, 'fixed', 'Saudi Arabia', NULL, 'https://images.unsplash.com/photo-1565552629477-0df6011454c6?auto=format&fit=crop&w=800&q=80', '[\"services\\/nZg53LeegLff8vab7ao6RJGRyQcdmFFt9Huo8dm0.jpg\"]', 0, 'active', 0.00, 0, '2025-12-26 08:38:31', '2025-12-31 06:22:47', 10, 1),
(6, 4, 'Toyota Land Cruiser V8 Rental', 'Rent a luxury Land Cruiser V8 for your wedding or protocol duties. Driver included.', 25000.00, NULL, NULL, 'fixed', 'Islamabad', NULL, 'https://images.unsplash.com/photo-1594502184342-2b22f293b679?auto=format&fit=crop&w=800&q=80', '[\"services\\/CUVZOZQHyJIuTkXxwHMQL4DN5IK3QtmGGY3VAiWa.jpg\"]', 0, 'active', 0.00, 0, '2025-12-26 08:38:31', '2025-12-31 06:23:26', 21, 1),
(7, 4, 'Premium Buffet Catering', 'Mutton Kunna, Chicken Roast, Palak Paneer, 3 Types of Rice, 2 Desserts.', 2500.00, NULL, NULL, 'fixed', 'Multan', NULL, 'https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&w=800&q=80', NULL, 0, 'active', 0.00, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31', 16, 1),
(8, 7, 'Test Verification Service', 'A rigorous test service.', 5000.00, NULL, NULL, 'fixed', 'Test Loc', NULL, 'default.jpg', NULL, 0, 'active', 0.00, 0, '2025-12-30 10:42:37', '2025-12-30 10:42:37', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_availability`
--

CREATE TABLE `service_availability` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `unavailable_date` date NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#1e3a5f',
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `slug`, `icon`, `description`, `color`, `parent_id`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Event Management', 'events', 'fa-calendar-check', 'Weddings, Corporate Events, Parties', '#e63946', NULL, 1, 1, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(2, 'Weddings', 'weddings', 'fa-rings-wedding', NULL, '#e63946', 1, 1, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(3, 'Corporate Events', 'corporate-events', 'fa-briefcase', NULL, '#e63946', 1, 1, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(4, 'Birthday Parties', 'birthdays', 'fa-cake-candles', NULL, '#e63946', 1, 1, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(5, 'Concerts', 'concerts', 'fa-microphone', NULL, '#e63946', 1, 1, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(6, 'Travel & Tours', 'travel', 'fa-plane', 'Domestic, International, Religious Tours', '#1e3a5f', NULL, 1, 2, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(7, 'Honeymoon Packages', 'honeymoon', 'fa-heart', NULL, '#1e3a5f', 6, 1, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(8, 'Group Tours', 'group-tours', 'fa-users', NULL, '#1e3a5f', 6, 1, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(9, 'Visa Assistance', 'visa', 'fa-passport', NULL, '#1e3a5f', 6, 1, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(10, 'Umrah Packages', 'umrah', 'fa-kaaba', NULL, '#1e3a5f', 6, 1, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(11, 'Hotels & Stays', 'hotels', 'fa-hotel', 'Luxury, Budget, Resorts', '#6366f1', NULL, 1, 3, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(12, '5 Star Hotels', '5-star', 'fa-star', NULL, '#6366f1', 11, 1, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(13, 'Resorts', 'resorts', 'fa-umbrella-beach', NULL, '#6366f1', 11, 1, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(14, 'Guest Houses', 'guest-houses', 'fa-house', NULL, '#6366f1', 11, 1, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(15, 'Catering & Food', 'catering', 'fa-utensils', 'Buffet, High Tea, Live Stations', '#f59e0b', NULL, 1, 4, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(16, 'Wedding Catering', 'wedding-catering', 'fa-plate-wheat', NULL, '#f59e0b', 15, 1, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(17, 'Corporate Lunch', 'corporate-lunch', 'fa-business-time', NULL, '#f59e0b', 15, 1, 0, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(18, 'Photography & Media', 'media', 'fa-camera', 'Wedding Shoots, Product Photography', '#ec4899', NULL, 1, 5, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(19, 'Venues & Halls', 'venues', 'fa-building', 'Marquees, Banquets, Farmhouses', '#10b981', NULL, 1, 6, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(20, 'Decor & Florals', 'decor', 'fa-wand-magic-sparkles', 'Stage, Floral, Lights', '#8b5cf6', NULL, 1, 7, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(21, 'Transport & Rentals', 'transport', 'fa-car', 'Luxury Cars, Coasters, Jeeps', '#0ea5e9', NULL, 1, 8, '2025-12-26 08:38:31', '2025-12-26 08:38:31'),
(22, 'Wedding Photography', 'wedding-photography', 'fa-camera-retro', NULL, '#ec4899', 18, 1, 0, '2025-12-26 08:48:25', '2025-12-26 08:48:25'),
(23, 'Event Videography', 'event-videography', 'fa-video', NULL, '#ec4899', 18, 1, 0, '2025-12-26 08:48:25', '2025-12-26 08:48:25'),
(24, 'Drone Shoots', 'drone-shoots', 'fa-helicopter', NULL, '#ec4899', 18, 1, 0, '2025-12-26 08:48:25', '2025-12-26 08:48:25'),
(25, 'Wedding Halls', 'wedding-halls', 'fa-synagogue', NULL, '#10b981', 19, 1, 0, '2025-12-26 08:48:25', '2025-12-26 08:48:25'),
(26, 'Marquees', 'marquees', 'fa-tent', NULL, '#10b981', 19, 1, 0, '2025-12-26 08:48:25', '2025-12-26 08:48:25'),
(27, 'Farm Houses', 'farm-houses', 'fa-house-tree', NULL, '#10b981', 19, 1, 0, '2025-12-26 08:48:25', '2025-12-26 08:48:25'),
(28, 'Stage Decor', 'stage-decor', 'fa-couch', NULL, '#8b5cf6', 20, 1, 0, '2025-12-26 08:48:25', '2025-12-26 08:48:25'),
(29, 'Floral Arrangements', 'floral-arrangements', 'fa-seedling', NULL, '#8b5cf6', 20, 1, 0, '2025-12-26 08:48:25', '2025-12-26 08:48:25'),
(30, 'Lighting', 'lighting', 'fa-lightbulb', NULL, '#8b5cf6', 20, 1, 0, '2025-12-26 08:48:25', '2025-12-26 08:48:25'),
(31, 'Luxury Rentals', 'luxury-rentals', 'fa-car-side', NULL, '#0ea5e9', 21, 1, 0, '2025-12-26 08:48:25', '2025-12-26 08:48:25'),
(32, 'Coasters & Buses', 'coasters-buses', 'fa-bus', NULL, '#0ea5e9', 21, 1, 0, '2025-12-26 08:48:25', '2025-12-26 08:48:25'),
(33, 'Protocol Jeeps', 'protocol-jeeps', 'fa-truck-monster', NULL, '#0ea5e9', 21, 1, 0, '2025-12-26 08:48:25', '2025-12-26 08:48:25');

-- --------------------------------------------------------

--
-- Table structure for table `service_desk_requests`
--

CREATE TABLE `service_desk_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `desk_type` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL DEFAULT 'medium',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `event_location` varchar(255) DEFAULT NULL,
  `event_address` varchar(255) DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `quote` text NOT NULL,
  `stars` int(11) NOT NULL DEFAULT 5,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `commission_rate` decimal(5,2) NOT NULL DEFAULT 10.00,
  `bio` text DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `business_hours` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`business_hours`)),
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `vendor_type` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `balance`, `commission_rate`, `bio`, `social_links`, `business_hours`, `email_verified_at`, `password`, `role`, `vendor_type`, `is_verified`, `remember_token`, `created_at`, `updated_at`, `city_id`, `category_id`) VALUES
(2, 'Admin User', 'admin@example.com', NULL, 0.00, 10.00, NULL, NULL, NULL, NULL, '$2y$12$h0t3tqTo6.dJaSEdcSLXMOxPVBZklYEOJI2VNqLQnII1U3f.oqCWq', 'admin', NULL, 1, NULL, '2025-12-25 19:35:00', '2025-12-30 09:50:02', NULL, NULL),
(3, 'Admin User', 'admin@eventy.pk', NULL, 0.00, 10.00, NULL, NULL, NULL, NULL, '$2y$12$a2Qfv3T4FnoyLXIk6OtwDuyO1Mkzwl5GWWH8a7mRbkhTEYXMV13jK', 'admin', NULL, 0, 'Ir5hXcHlvPUBduZSK4GJxzFW75oSYgs15roUYrazZWtA7XBf0k31DOvVmAqP', '2025-12-26 08:38:30', '2025-12-30 09:50:02', NULL, NULL),
(4, 'Vendor One', 'vendor@eventy.pk', 'avatars/3gFZz4hOquCjR1uOreNNwl4dlId9BfFgN2U9DQOS.jpg', 450000.00, 10.00, NULL, '{\"facebook\":null,\"instagram\":null,\"twitter\":null,\"linkedin\":null}', '{\"monday\":\"09:00 AM - 06:00 PM\",\"tuesday\":\"09:00 AM - 06:00 PM\",\"wednesday\":\"09:00 AM - 06:00 PM\",\"thursday\":\"09:00 AM - 06:00 PM\",\"friday\":\"09:00 AM - 06:00 PM\",\"saturday\":\"09:00 AM - 06:00 PM\",\"sunday\":\"09:00 AM - 06:00 PM\"}', NULL, '$2y$12$hHiIlzKd2wuocnlP4jfk2.fIx738F7dKDKKLaDgvuau3rPcxfd9lm', 'vendor', NULL, 1, NULL, '2025-12-26 08:38:30', '2026-01-02 11:29:01', NULL, NULL),
(5, 'Test User', 'user@eventy.pk', NULL, 0.00, 10.00, NULL, NULL, NULL, NULL, '$2y$12$XBymqTWqlTvtKp6Wq.AKJufiXXtiIBQvPs07v3HPplppqvKXuRd7K', 'user', NULL, 0, NULL, '2025-12-26 08:38:31', '2025-12-30 09:50:03', NULL, NULL),
(6, 'sameer', 'sameer@gmail.com', NULL, 0.00, 10.00, NULL, NULL, NULL, NULL, '$2y$12$wINdU5bRd8uuFM/bKoC/4e0etMNYGD5yWZIB9SdpOS3ugJEquDD/2', 'user', NULL, 1, NULL, '2025-12-30 09:03:07', '2025-12-30 09:50:04', NULL, NULL),
(7, 'Test Vendor', 'testverify_vendor@example.com', NULL, 0.00, 10.00, NULL, NULL, NULL, NULL, '$2y$12$.R24WeB7OPS33MScmg/I6eU102O17jcF3UUYmUhbTQd0xX3S4Lyi6', 'vendor', NULL, 1, NULL, '2025-12-30 10:42:37', '2025-12-30 10:42:37', 21, NULL),
(8, 'Test Customer', 'testverify_cust@example.com', NULL, 0.00, 10.00, NULL, NULL, NULL, NULL, '$2y$12$QdRcm4CI50z95wP71A.m4ecv5cXGNM2Utshm8b2rFjZpTHG3NYEmO', 'user', NULL, 0, NULL, '2025-12-30 10:42:38', '2025-12-30 10:42:38', 21, NULL),
(9, 'Azam Siddiqui', 'azam75256@gmail.com', NULL, 0.00, 10.00, NULL, NULL, NULL, NULL, '$2y$12$/EKxeqKThMtAVwz35DXKpuMPnv9NL28MtOCcPnhu/Rmp1uJf6WZlm', 'user', NULL, 1, NULL, '2026-01-04 04:54:20', '2026-01-04 04:54:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_logs`
--

CREATE TABLE `vendor_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_logs`
--

INSERT INTO `vendor_logs` (`id`, `vendor_id`, `booking_id`, `action`, `description`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'received', 'Vendor received a new order (Booking #1)', '2026-01-01 09:36:33', '2026-01-01 09:36:33'),
(2, 4, 1, 'completed', 'Order Completed (Booking #1)', '2026-01-01 09:36:33', '2026-01-01 09:36:33'),
(3, 7, 2, 'received', 'Vendor received a new order (Booking #2)', '2026-01-01 09:36:33', '2026-01-01 09:36:33'),
(4, 7, 2, 'completed', 'Order Completed (Booking #2)', '2026-01-01 09:36:33', '2026-01-01 09:36:33'),
(5, 4, 3, 'received', 'Vendor received a new order (Booking #3)', '2026-01-01 09:36:33', '2026-01-01 09:36:33'),
(6, 4, 3, 'completed', 'Order Completed (Booking #3)', '2026-01-01 09:36:33', '2026-01-01 09:36:33'),
(7, 4, 4, 'received', 'Vendor received a new order (Booking #4)', '2026-01-02 11:24:02', '2026-01-02 11:24:02'),
(8, 4, 4, 'confirmed', 'Order Confirmed (Booking #4)', '2026-01-02 11:25:39', '2026-01-02 11:25:39'),
(9, 4, 4, 'completed', 'Order Completed (Booking #4)', '2026-01-02 11:29:01', '2026-01-02 11:29:01'),
(10, 4, 5, 'received', 'Vendor received a new order (Booking #5)', '2026-01-02 11:48:56', '2026-01-02 11:48:56'),
(11, 4, 6, 'received', 'Vendor received a new order (Booking #6)', '2026-01-03 10:59:28', '2026-01-03 10:59:28'),
(12, 4, 7, 'received', 'Vendor received a new order (Booking #7)', '2026-01-03 11:02:42', '2026-01-03 11:02:42'),
(13, 4, 6, 'cancelled', 'Order Cancelled (Booking #6)', '2026-01-03 17:19:21', '2026-01-03 17:19:21'),
(14, 4, 8, 'received', 'Vendor received a new order (Booking #8)', '2026-01-04 04:56:25', '2026-01-04 04:56:25');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_service_id_foreign` (`service_id`),
  ADD KEY `bookings_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `budget_requests`
--
ALTER TABLE `budget_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budget_requests_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cities_slug_unique` (`slug`);

--
-- Indexes for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`),
  ADD KEY `coupons_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `custom_packages`
--
ALTER TABLE `custom_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_packages_user_id_foreign` (`user_id`);

--
-- Indexes for table `custom_package_bookings`
--
ALTER TABLE `custom_package_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_package_bookings_user_id_foreign` (`user_id`),
  ADD KEY `custom_package_bookings_custom_package_id_foreign` (`custom_package_id`);

--
-- Indexes for table `custom_package_services`
--
ALTER TABLE `custom_package_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_package_services_custom_package_id_foreign` (`custom_package_id`),
  ADD KEY `custom_package_services_service_id_foreign` (`service_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_service_id_unique` (`user_id`,`service_id`),
  ADD KEY `favorites_service_id_foreign` (`service_id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `newsletters_email_unique` (`email`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_booking_id_foreign` (`booking_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_booking_id_unique` (`booking_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_service_id_foreign` (`service_id`);

--
-- Indexes for table `review_likes`
--
ALTER TABLE `review_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `review_likes_user_id_review_id_unique` (`user_id`,`review_id`),
  ADD KEY `review_likes_review_id_foreign` (`review_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_user_id_foreign` (`user_id`),
  ADD KEY `services_category_id_foreign` (`category_id`);

--
-- Indexes for table `service_availability`
--
ALTER TABLE `service_availability`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_availability_service_id_unavailable_date_unique` (`service_id`,`unavailable_date`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_categories_slug_unique` (`slug`),
  ADD KEY `service_categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `service_desk_requests`
--
ALTER TABLE `service_desk_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_desk_requests_reference_unique` (`reference`),
  ADD KEY `service_desk_requests_user_id_foreign` (`user_id`),
  ADD KEY `service_desk_requests_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_city_id_foreign` (`city_id`),
  ADD KEY `users_category_id_foreign` (`category_id`);

--
-- Indexes for table `vendor_logs`
--
ALTER TABLE `vendor_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_logs_vendor_id_foreign` (`vendor_id`),
  ADD KEY `vendor_logs_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawals_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `budget_requests`
--
ALTER TABLE `budget_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_packages`
--
ALTER TABLE `custom_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_package_bookings`
--
ALTER TABLE `custom_package_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_package_services`
--
ALTER TABLE `custom_package_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `review_likes`
--
ALTER TABLE `review_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `service_availability`
--
ALTER TABLE `service_availability`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `service_desk_requests`
--
ALTER TABLE `service_desk_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vendor_logs`
--
ALTER TABLE `vendor_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `budget_requests`
--
ALTER TABLE `budget_requests`
  ADD CONSTRAINT `budget_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_packages`
--
ALTER TABLE `custom_packages`
  ADD CONSTRAINT `custom_packages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_package_bookings`
--
ALTER TABLE `custom_package_bookings`
  ADD CONSTRAINT `custom_package_bookings_custom_package_id_foreign` FOREIGN KEY (`custom_package_id`) REFERENCES `custom_packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_package_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_package_services`
--
ALTER TABLE `custom_package_services`
  ADD CONSTRAINT `custom_package_services_custom_package_id_foreign` FOREIGN KEY (`custom_package_id`) REFERENCES `custom_packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_package_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_likes`
--
ALTER TABLE `review_likes`
  ADD CONSTRAINT `review_likes_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `services_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_availability`
--
ALTER TABLE `service_availability`
  ADD CONSTRAINT `service_availability_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD CONSTRAINT `service_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_desk_requests`
--
ALTER TABLE `service_desk_requests`
  ADD CONSTRAINT `service_desk_requests_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `service_desk_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `vendor_logs`
--
ALTER TABLE `vendor_logs`
  ADD CONSTRAINT `vendor_logs_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vendor_logs_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD CONSTRAINT `withdrawals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
