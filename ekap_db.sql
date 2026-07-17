-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2026 at 06:53 AM
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
-- Database: `ekap_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `club_id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `organiser_type` varchar(100) NOT NULL,
  `program_title` varchar(255) NOT NULL,
  `program_level` varchar(100) NOT NULL,
  `program_category` varchar(100) NOT NULL,
  `venue` varchar(255) NOT NULL,
  `target_group` varchar(255) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `male_participants` int(10) UNSIGNED DEFAULT 0,
  `female_participants` int(10) UNSIGNED DEFAULT 0,
  `total_participants` int(10) UNSIGNED DEFAULT 0,
  `program_description` text NOT NULL,
  `objectives` text NOT NULL,
  `expected_outcomes` text DEFAULT NULL,
  `estimated_budget` decimal(10,2) DEFAULT 0.00,
  `requested_allocation` decimal(10,2) DEFAULT 0.00,
  `approved_amount` decimal(10,2) DEFAULT NULL,
  `funding_source` varchar(255) DEFAULT NULL,
  `has_risk` tinyint(1) NOT NULL DEFAULT 0,
  `risk_level` enum('low','medium','high') DEFAULT NULL,
  `risk_description` text DEFAULT NULL,
  `safety_action` text DEFAULT NULL,
  `person_in_charge` varchar(150) NOT NULL,
  `pic_phone` varchar(30) NOT NULL,
  `pic_email` varchar(150) NOT NULL,
  `status` enum('draft','submitted','under_review','changes_requested','approved','rejected') NOT NULL DEFAULT 'draft',
  `admin_comment` text DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `club_id`, `reference_no`, `organiser_type`, `program_title`, `program_level`, `program_category`, `venue`, `target_group`, `start_datetime`, `end_datetime`, `male_participants`, `female_participants`, `total_participants`, `program_description`, `objectives`, `expected_outcomes`, `estimated_budget`, `requested_allocation`, `approved_amount`, `funding_source`, `has_risk`, `risk_level`, `risk_description`, `safety_action`, `person_in_charge`, `pic_phone`, `pic_email`, `status`, `admin_comment`, `submitted_at`, `created`, `modified`) VALUES
(1, 1, 1, '01', 'Club Faculty', 'Bengkel PHP', 'Faculty', 'Academic ', 'Dewan Seminar ', 'Students', '2026-07-20 11:00:05', '2026-07-20 14:00:20', 50, 50, 100, 'Bengkel for system student ', 'for student to learn how to use php', 'student know how to use php', 500.00, 100.00, NULL, 'Hep', 0, 'low', '', '', 'Sharieza', '01155041244', 'shariezanurul@gmail.com', 'approved', 'Your programme application has been approved by HEP.', '2026-07-16 17:24:01', '2026-07-16 15:03:08', '2026-07-16 17:26:51'),
(2, 3, 1, 'EKAP/2026/0002', 'Club/Society', 'Test Program', 'Club/Student Society', 'Academic', 'Dewan Seminar IM', 'Students', '2026-07-24 08:50:25', '2026-07-24 13:50:39', 50, 50, 100, 'testing sahaja', 'mencuba', 'berjaya', 50.00, 50.00, 50.00, 'Club', 0, '', '', '', 'Ija', '0123456789', 'ija@gmail.com', 'approved', 'Your programme application has been approved by HEP.', '2026-07-16 20:51:06', '2026-07-16 20:50:50', '2026-07-16 21:05:04'),
(3, 3, 1, 'EKAP/2026/0003', 'External Organization', 'test lagi', 'International', 'Academic', 'Meja McD', 'Everyone', '2026-07-18 05:07:22', '2026-07-18 23:07:28', 100, 23, 123, 'nothing', 'none', 'success', 5.00, 5.00, NULL, 'hep', 1, 'high', 'none', 'none', 'ija', '0123456789', 'ija@gmail.com', 'rejected', 'not good', '2026-07-16 21:09:01', '2026-07-16 21:08:56', '2026-07-16 21:09:57'),
(4, 5, 1, 'EKAP/2026/0004', 'Club/Society', 'WEB DESIGN DEVELOPMENT WORKSHOP', 'Faculty', 'Academic', 'Bilik Seminar IM', 'Students', '2026-07-30 09:30:30', '2026-07-30 16:30:30', 30, 50, 80, 'This Workshop is expected to expose students to web design development projects and train them to become better at web developing.', '1. To expose students to advance web design development skills.\r\n2. To expect them to become better.\r\n3. To be successful.', 'Successfully train students these skills.', 50.00, 50.00, NULL, 'HEP Financial Department', 0, '', '', '', 'Muhammad Asyraf bin Wahi Anuar', '0123456789', 'asyraf@student.edu.my', 'under_review', 'Your application is currently being reviewed by HEP.', '2026-07-17 01:31:15', '2026-07-17 01:30:56', '2026-07-17 01:32:21');

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE `clubs` (
  `id` int(10) UNSIGNED NOT NULL,
  `club_name` varchar(150) NOT NULL,
  `registration_no` varchar(50) NOT NULL,
  `faculty` varchar(150) DEFAULT NULL,
  `advisor_name` varchar(150) DEFAULT NULL,
  `advisor_email` varchar(150) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`id`, `club_name`, `registration_no`, `faculty`, `advisor_name`, `advisor_email`, `status`, `created`, `modified`) VALUES
(1, 'Association of Information Management System', 'UiTM-PP-CLUB-001', 'Faculty of Information Science', 'Puan Yanty Rahayu', 'yantyrahayu@edu.my', 'active', '2026-07-16 14:52:13', '2026-07-16 23:40:11'),
(2, 'Generational Library Association', 'UiTM-PP-CLUB-002', 'Faculty of Information Science', 'Dr. Aminudin bin Baki', 'aminudin@edu.my', 'active', '2026-07-16 23:39:29', '2026-07-16 23:39:29'),
(3, 'Others', 'EKAP-OTHER-001', NULL, NULL, NULL, 'active', '2026-07-16 23:42:48', '2026-07-16 23:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_id` int(10) UNSIGNED NOT NULL,
  `document_type` enum('proposal','tentative','budget','risk_form','insurance','banner','other') NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_type` varchar(100) DEFAULT NULL,
  `file_size` int(10) UNSIGNED DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `application_id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `decision` enum('under_review','changes_requested','approved','rejected') NOT NULL,
  `comments` text DEFAULT NULL,
  `internal_notes` text DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `application_id`, `admin_id`, `decision`, `comments`, `internal_notes`, `created`, `modified`) VALUES
(1, 1, 2, 'under_review', 'Your application is currently being reviewed by HEP.', '', '2026-07-16 17:26:20', '2026-07-16 17:26:20'),
(2, 1, 2, 'approved', 'Your programme application has been approved by HEP.', '', '2026-07-16 17:26:51', '2026-07-16 17:26:51'),
(3, 2, 4, 'under_review', 'Wait for approval', 'Please check contents', '2026-07-16 21:03:09', '2026-07-16 21:03:09'),
(4, 2, 2, 'approved', 'Your programme application has been approved by HEP.', '', '2026-07-16 21:05:04', '2026-07-16 21:05:04'),
(5, 3, 2, 'rejected', 'not good', 'very bad', '2026-07-16 21:09:57', '2026-07-16 21:09:57'),
(6, 4, 2, 'under_review', 'Your application is currently being reviewed by HEP.', '', '2026-07-17 01:32:21', '2026-07-17 01:32:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') NOT NULL DEFAULT 'student',
  `student_no` varchar(30) DEFAULT NULL,
  `staff_no` varchar(30) DEFAULT NULL,
  `faculty` varchar(150) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `account_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `student_no`, `staff_no`, `faculty`, `phone`, `account_status`, `created`, `modified`) VALUES
(1, 'Nurul Hidayah', 'nurul123@gmail.com', '$2y$10$uRv4Bf4wrAuTMSof3P.Rc.yaVDVduVhjFzJhiunY3/AUziAHLrP3u', 'student', '2026123456', '', 'Faculty of Information Science', '0193456789', 'active', '2026-07-16 14:54:46', '2026-07-16 15:15:45'),
(2, 'HEP Admin', 'admin@ekap.test', '$2y$10$w.LPuXzASuXScJouauVTjezPgnjFSWRX6cbdEE7PuMpnBrfwwu4ZC', 'admin', '', 'HEP001', 'Faculty of Information Science', '0183456789', 'active', '2026-07-16 14:56:00', '2026-07-16 15:16:42'),
(3, 'Sharieza', 'sharieza@gmail.com', '$2y$10$tG54D4ZUnX9hoSAIsiiF.O5cIcGJwMjwvml2bKpB9WmrTxsFAKUpu', 'student', '2025234567', NULL, 'Faculty of Information Science', '0193456789', 'active', '2026-07-16 20:46:50', '2026-07-16 20:46:50'),
(4, 'Admin Damia', 'damia@ekap.test', '$2y$10$2nmWqFYQD5EicEXCDNE5AurQtzLqrHZOrBCu8IXJqBGBvLLfhRNhG', 'admin', NULL, 'HEP002', 'Faculty of Information Science', '0124567892', 'active', '2026-07-16 20:53:24', '2026-07-16 20:55:42'),
(5, 'Muhammad Asyraf bin Wahi Anuar', 'student@ekap.test', '$2y$10$o9kvhh.oS1pmlq6Swze0LeLmBd4.2ofeXFmYlF3cNlGyv2T3cGr1y', 'student', '2026345678', NULL, 'Faculty of Information Science', '0123456789', 'active', '2026-07-17 01:23:58', '2026-07-17 01:23:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference_no` (`reference_no`),
  ADD KEY `fk_applications_user` (`user_id`),
  ADD KEY `fk_applications_club` (`club_id`);

--
-- Indexes for table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registration_no` (`registration_no`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_documents_application` (`application_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reviews_application` (`application_id`),
  ADD KEY `fk_reviews_admin` (`admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `student_no` (`student_no`),
  ADD UNIQUE KEY `staff_no` (`staff_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `fk_applications_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  ADD CONSTRAINT `fk_applications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `fk_documents_application` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_admin` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_reviews_application` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
