-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2026 at 11:33 AM
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
-- Database: `pet_adoption`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoption_applications`
--

CREATE TABLE `adoption_applications` (
  `application_id` int(11) NOT NULL,
  `pet_id` int(11) DEFAULT NULL,
  `adopter_id` int(11) DEFAULT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Approved','Rejected','Cancelled') DEFAULT 'Pending',
  `notes` text DEFAULT NULL,
  `ic_passport` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `home_type` varchar(100) DEFAULT NULL,
  `ownership` varchar(100) DEFAULT NULL,
  `household_members` int(11) DEFAULT NULL,
  `other_pets` varchar(255) DEFAULT NULL,
  `adopted_before` enum('Yes','No') DEFAULT NULL,
  `pet_care_experience` text DEFAULT NULL,
  `emergency_name` varchar(255) DEFAULT NULL,
  `emergency_phone` varchar(30) DEFAULT NULL,
  `emergency_relationship` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption_applications`
--

INSERT INTO `adoption_applications` (`application_id`, `pet_id`, `adopter_id`, `application_date`, `status`, `notes`, `updated_at`) VALUES
(1, 4, 6, '2026-07-11 16:00:00', 'Pending', 'I love cat', '2026-07-12 15:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `message`, `link`, `is_read`, `created_at`) VALUES
(1, 5, 'Alia  has submitted an application to adopt Bobok.', 'manage_applications.php', 1, '2026-07-12 15:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `pet_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pet_name` varchar(100) NOT NULL,
  `species` varchar(50) NOT NULL,
  `breed` varchar(100) DEFAULT NULL,
  `age` varchar(50) DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `size` enum('Small','Medium','Large') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('Available','Adopted','Pending') DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`pet_id`, `user_id`, `pet_name`, `species`, `breed`, `age`, `gender`, `size`, `description`, `location`, `photo`, `status`, `created_at`) VALUES
(4, 5, 'Bobok', 'cat', 'Kampung', '1 years', 'Male', 'Medium', 'Healthy and active', 'Perak', '1783867302_obok.jpg', 'Pending', '2026-07-12 14:41:42'),
(5, 5, 'Clara', 'dog', 'Mixed Breed', '2', 'Female', 'Small', 'Done Vaccine', 'Selangor', '1783867489_dog1.jpg', 'Available', '2026-07-12 14:44:49'),
(7, 5, 'Lily', 'rabbit', 'Dutch', '2', 'Female', 'Small', 'Healthy and ready for new home', 'Johor', '1783868050_rabbit2.webp', 'Available', '2026-07-12 14:54:10'),
(8, 5, 'Gucci', 'cat', 'Ragdoll', '3', 'Female', 'Medium', 'Done vaccine', 'Melaka', '1783868180_cat 2.jpg', 'Available', '2026-07-12 14:56:20'),
(9, 5, 'Coco', 'cat', 'Tabby', '4', 'Male', 'Medium', 'Asthma ', 'Perlis', '1783868286_cat 3.jpg', 'Available', '2026-07-12 14:58:06'),
(10, 5, 'Amber', 'bird', 'Parrot', '1', 'Male', 'Small', 'Ready for a new home', 'Kedah', '1783868433_bird1.jpg', 'Available', '2026-07-12 15:00:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','shelter','adopter') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone_no`, `address`, `role`, `created_at`) VALUES
(1, 'Damia', 'damiahumaira2004@gmail.com', '$2y$10$18c/wMptzaRjCuJdBXMvfuCTtAemQbAKOZMMfoowIrjdaytg5kMva', '0126782742', 'pt 6743', 'adopter', '2026-06-29 15:38:03'),
(2, 'mia', '2024428402@student.uitm.edu.my', '$2y$10$mDeLMyv2EfWJq1Y/xyQVQOz58CLcsZAsEghX1pmT6wvdXWbGLN8ZK', '012345678', 'pt 6746', 'shelter', '2026-06-29 15:41:20'),
(4, 'Humaira', '2024412492@student.uitm.edu.my', '$2y$10$mGbUxDjxPGPJHRGrz0HDsOQDKtp1TUKzFckDYQmyoQS4eRttAGFRO', '0126782742', 'pt 6743', 'admin', '2026-06-29 15:53:28'),
(5, 'Humaira', 'damia2742@gmail.com', 'mia123', '0126782742', '106 A Kampung Balun Slim River Perak', 'admin', '2026-07-12 14:14:30'),
(6, 'Alia ', 'aliamaisara2001@gmail.com', 'alia123', '0176814156', '107 B Kampung Balun Slim River Perak', 'adopter', '2026-07-12 14:18:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `pet_id` (`pet_id`),
  ADD KEY `adopter_id` (`adopter_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`pet_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  ADD CONSTRAINT `adoption_applications_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `adoption_applications_ibfk_2` FOREIGN KEY (`adopter_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
