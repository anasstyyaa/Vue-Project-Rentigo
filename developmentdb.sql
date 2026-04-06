-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Apr 06, 2026 at 02:44 PM
-- Server version: 12.0.2-MariaDB-ubu2404
-- PHP Version: 8.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `developmentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `CarImages`
--

CREATE TABLE `CarImages` (
  `ImageId` int(11) NOT NULL,
  `CarId` int(11) NOT NULL,
  `ImageUrl` varchar(255) NOT NULL,
  `IsMainImage` tinyint(1) NOT NULL DEFAULT 0,
  `UploadedAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `CarImages`
--

INSERT INTO `CarImages` (`ImageId`, `CarId`, `ImageUrl`, `IsMainImage`, `UploadedAt`) VALUES
(9, 3, 'uploads/cars/1774863234_2020 Audi A4 45 TFSI Quattro S-Line (B9).jfif', 0, '2026-03-30 09:33:54'),
(10, 3, 'uploads/cars/1774863234_download (1).jfif', 0, '2026-03-30 09:33:54'),
(11, 3, 'uploads/cars/1774863234_download.jfif', 0, '2026-03-30 09:33:54'),
(12, 3, 'uploads/cars/1774863234_El Audi A4 vuelve a México con rostro renovado y sólo como mild-hybrid_ estos son sus precios.jfif', 1, '2026-03-30 09:33:54'),
(13, 2, 'uploads/cars/1774863715_autooo.jfif', 0, '2026-03-30 09:41:55'),
(14, 2, 'uploads/cars/1774863715_AUTOS.jfif', 0, '2026-03-30 09:41:55'),
(15, 2, 'uploads/cars/1774863715_bmw.jfif', 1, '2026-03-30 09:41:55'),
(16, 2, 'uploads/cars/1774863715_download (2).jfif', 0, '2026-03-30 09:41:55'),
(17, 1, 'uploads/cars/1775046318_Tesla Model 3.jfif', 0, '2026-04-01 12:25:18'),
(18, 1, 'uploads/cars/1775046318_teslamodel3.jfif', 1, '2026-04-01 12:25:18'),
(19, 1, 'uploads/cars/1775046318_teslamodel3car.jfif', 0, '2026-04-01 12:25:18'),
(20, 1, 'uploads/cars/1775046365_carteslamodel3.jfif', 0, '2026-04-01 12:26:05'),
(21, 4, 'uploads/cars/1775047901_2022 Mercedes-Benz C-Class_ A Baby S-Class, Complete With The Screens.jfif', 1, '2026-04-01 12:51:41'),
(22, 4, 'uploads/cars/1775047901_Mercedes Benz Classe C 2022 - Elle adopte un nouveau look.jfif', 0, '2026-04-01 12:51:41'),
(23, 4, 'uploads/cars/1775047901_Mercedes-Benz C-Class - Side 2022.jfif', 0, '2026-04-01 12:51:41'),
(24, 7, 'uploads/cars/1775127136_Toyota RAV4 2_5 VX AT_ All grown up and going places (1).jfif', 1, '2026-04-02 10:52:16'),
(25, 7, 'uploads/cars/1775127136_Toyota RAV4 2_5 VX AT_ All grown up and going places.jfif', 0, '2026-04-02 10:52:16'),
(26, 7, 'uploads/cars/1775127136_Toyota RAV4.jfif', 0, '2026-04-02 10:52:16'),
(27, 7, 'uploads/cars/1775127136_toyota2.jfif', 0, '2026-04-02 10:52:16'),
(28, 5, 'uploads/cars/1775127317_2021 Golf GTI.jfif', 1, '2026-04-02 10:55:17'),
(29, 5, 'uploads/cars/1775127317_2021 Volkswagen GTI First Drive Review_ Still The___.jfif', 0, '2026-04-02 10:55:17'),
(30, 5, 'uploads/cars/1775127317_How Quick Is the Volkswagen Golf GTI in Our___.jfif', 0, '2026-04-02 10:55:17'),
(31, 5, 'uploads/cars/1775127317_The Volkswagen Golf GTI _ R Is the 2026 MotorTrend Car of the Year.jfif', 0, '2026-04-02 10:55:17'),
(32, 9, 'uploads/cars/1775128087_https___t_me_ivankovsh (1).jfif', 0, '2026-04-02 11:08:07'),
(33, 9, 'uploads/cars/1775128087_https___t_me_ivankovsh.jfif', 0, '2026-04-02 11:08:07'),
(34, 9, 'uploads/cars/1775128087_Land Rover Defender (1).jfif', 0, '2026-04-02 11:08:07'),
(35, 9, 'uploads/cars/1775128087_Land Rover Defender.jfif', 1, '2026-04-02 11:08:07'),
(36, 6, 'uploads/cars/1775128319_2022 Ford Mustang GT California Special Gets More___.jfif', 0, '2026-04-02 11:11:59'),
(37, 6, 'uploads/cars/1775128319_2023 Ford Mustang.jfif', 1, '2026-04-02 11:11:59'),
(39, 6, 'uploads/cars/1775128362_Ford Mustang.jfif', 0, '2026-04-02 11:12:42'),
(41, 8, 'uploads/cars/1775128568_2019 Porsche 911 Speedster_ 4 Things You Get, 4 Things You Don’t — MOTORTREND.jfif', 1, '2026-04-02 11:16:08'),
(42, 8, 'uploads/cars/1775128568_krytayamachinaporche.jfif', 0, '2026-04-02 11:16:08'),
(43, 8, 'uploads/cars/1775128568_mashinaporshe.jfif', 0, '2026-04-02 11:16:08'),
(44, 8, 'uploads/cars/1775128568_porshe.jfif', 0, '2026-04-02 11:16:08');

-- --------------------------------------------------------

--
-- Table structure for table `Cars`
--

CREATE TABLE `Cars` (
  `CarId` int(11) NOT NULL,
  `Brand` varchar(100) NOT NULL,
  `Model` varchar(100) NOT NULL,
  `Year` int(11) NOT NULL,
  `PricePerDay` decimal(10,2) NOT NULL,
  `Transmission` varchar(50) NOT NULL,
  `FuelType` varchar(50) NOT NULL,
  `Seats` int(11) NOT NULL,
  `Color` varchar(50) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `IsAvailable` tinyint(1) NOT NULL DEFAULT 1,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `IsDeleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Cars`
--

INSERT INTO `Cars` (`CarId`, `Brand`, `Model`, `Year`, `PricePerDay`, `Transmission`, `FuelType`, `Seats`, `Color`, `Description`, `IsAvailable`, `CreatedAt`, `IsDeleted`) VALUES
(1, 'Tesla', 'Model 3', 2023, 125.00, 'Automatic', 'Electric', 5, 'Pearl White', 'High-performance electric sedan with Autopilot features.', 1, '2026-02-16 11:24:56', 0),
(2, 'BMW', 'X5', 2022, 150.00, 'Automatic', 'Diesel', 5, 'Black Sapphire', 'Luxury SUV perfect for family trips and long drives.', 1, '2026-02-16 11:24:56', 0),
(3, 'Audi', 'A4', 2021, 95.00, 'Automatic', 'Petrol', 5, 'Ibis White', 'Elegant executive sedan with premium interior.', 1, '2026-02-16 11:24:56', 0),
(4, 'Mercedes-Benz', 'C-Class', 2023, 130.00, 'Automatic', 'Petrol', 5, 'Silver Metallic', 'Comfortable and stylish, the ultimate driving experience.', 1, '2026-02-16 11:24:56', 0),
(5, 'Volkswagen', 'Golf GTI', 2022, 85.00, 'Manual', 'Petrol', 5, 'Tornado Red', 'Sporty hatchback with great handling and speed.', 1, '2026-02-16 11:24:56', 0),
(6, 'Ford', 'Mustang GT', 2021, 200.00, 'Manual', 'Petrol', 4, 'Grabber Blue', 'Classic American muscle car with a powerful V8 engine.', 1, '2026-02-16 11:24:56', 0),
(7, 'Toyota', 'Rav4', 2023, 75.00, 'Automatic', 'Hybrid', 5, 'Lunar Rock', 'Reliable and fuel-efficient hybrid SUV for all terrains.', 1, '2026-02-16 11:24:56', 0),
(8, 'Porsche', '911 Carrera', 2022, 350.00, 'Automatic', 'Petrol', 2, 'Guards Red', 'Iconic sports car for those who love speed and luxury.', 1, '2026-02-16 11:24:56', 0),
(9, 'Land Rover', 'Defender', 2023, 180.00, 'Automatic', 'Diesel', 7, 'Pangea Green', 'Rugged off-roader with 7 seats for group adventures.', 1, '2026-02-16 11:24:56', 0),
(11, 'Tesla', 'Model 3', 2024, 85.50, 'Automatic', 'Electric', 5, 'Pink', 'Brand new electric sedan with long range.', 1, '2026-02-28 15:34:01', 1),
(12, 'Tesla', 'Model 3', 2023, 85.50, 'Automatic', 'Electric', 5, 'Pink', 'Brand new electric sedan with long range.', 1, '2026-02-28 15:34:51', 1),
(13, 'Tesla', 'Model X', 1999, 101.60, 'Manual', 'Diesel', 5, 'Black', NULL, 1, '2026-02-28 15:39:57', 1),
(14, 'f', 's', 2000, 1.00, 'Manual', 'Diesel', 2, NULL, NULL, 1, '2026-03-16 14:44:48', 1),
(15, 'BMW', 'M4', 2026, 100.00, 'Automatic', 'Petrol', 4, NULL, NULL, 1, '2026-03-29 18:48:00', 1),
(16, '', '', 0, 0.00, '', '', 0, NULL, NULL, 1, '2026-03-29 19:43:25', 1),
(17, 'BMW', 'M4', 2024, 110.00, 'Automatic', 'Petrol', 5, 'Pangea Green', 'Best car in the world ', 1, '2026-04-02 11:05:19', 1),
(18, 'BMW', 'X5', 2026, 120.00, 'Manual', 'Hybrid', 5, 'Pangea Green', NULL, 1, '2026-04-06 12:48:47', 1),
(19, 'Land Rover', 'Mustang GT', 2000, 123.00, 'Manual', 'Petrol', 4, 'Pearl White', NULL, 1, '2026-04-06 12:53:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Rentals`
--

CREATE TABLE `Rentals` (
  `RentalId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `CarId` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `PricePerDayAtBooking` decimal(10,2) NOT NULL,
  `TotalPrice` decimal(10,2) NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'Booked',
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `CancelledAt` datetime DEFAULT NULL,
  `CancellationReason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Rentals`
--

INSERT INTO `Rentals` (`RentalId`, `UserId`, `CarId`, `StartDate`, `EndDate`, `PricePerDayAtBooking`, `TotalPrice`, `Status`, `CreatedAt`, `CancelledAt`, `CancellationReason`) VALUES
(15, 30, 7, '2026-04-03', '2026-04-05', 75.00, 225.00, 'Booked', '2026-04-03 10:12:44', NULL, NULL),
(16, 31, 5, '2026-04-06', '2026-04-13', 85.00, 595.00, 'Cancelled', '2026-04-06 13:18:13', '2026-04-06 13:18:30', 'i dont like this car '),
(17, 30, 4, '2026-04-06', '2026-05-26', 130.00, 6500.00, 'Booked', '2026-04-06 13:40:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Reviews`
--

CREATE TABLE `Reviews` (
  `ReviewId` int(11) NOT NULL,
  `RentalId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `CarId` int(11) NOT NULL,
  `Rating` int(11) NOT NULL,
  `Comment` text DEFAULT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `Reviews`
--

INSERT INTO `Reviews` (`ReviewId`, `RentalId`, `UserId`, `CarId`, `Rating`, `Comment`, `CreatedAt`) VALUES
(3, 15, 30, 7, 5, 'cool car ', '2026-04-06 13:47:42');

-- --------------------------------------------------------

--
-- Table structure for table `Roles`
--

CREATE TABLE `Roles` (
  `RoleId` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Roles`
--

INSERT INTO `Roles` (`RoleId`, `RoleName`) VALUES
(2, 'Admin'),
(1, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `UserId` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `ProfilePicture` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(30) DEFAULT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `IsActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserId`, `Username`, `RoleId`, `FirstName`, `LastName`, `Email`, `ProfilePicture`, `PhoneNumber`, `PasswordHash`, `CreatedAt`, `IsActive`) VALUES
(30, 'adminimportant', 2, 'admin', 'important', 'admin@gmail.com', NULL, '0621397511', '$2y$12$41qAeors5ChkXgniAJra0esc4BjPdQY.MfUaUvUAGhuYqUmjrfEji', '2026-04-03 09:50:12', 1),
(31, 'alina1', 1, 'Alina ', 'M', 'alina@gmail.com', NULL, '0531412901', '$2y$12$7V6C2MkgHkhIeBFQk/9MieYX5jecqniNPcK1motQKJTkMqz/VCCN2', '2026-04-06 13:16:10', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CarImages`
--
ALTER TABLE `CarImages`
  ADD PRIMARY KEY (`ImageId`),
  ADD KEY `CarId` (`CarId`);

--
-- Indexes for table `Cars`
--
ALTER TABLE `Cars`
  ADD PRIMARY KEY (`CarId`);

--
-- Indexes for table `Rentals`
--
ALTER TABLE `Rentals`
  ADD PRIMARY KEY (`RentalId`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `CarId` (`CarId`);

--
-- Indexes for table `Reviews`
--
ALTER TABLE `Reviews`
  ADD PRIMARY KEY (`ReviewId`),
  ADD UNIQUE KEY `RentalId` (`RentalId`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `CarId` (`CarId`);

--
-- Indexes for table `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`RoleId`),
  ADD UNIQUE KEY `RoleName` (`RoleName`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `UNIQUE_username` (`Username`),
  ADD KEY `RoleId` (`RoleId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `CarImages`
--
ALTER TABLE `CarImages`
  MODIFY `ImageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `Cars`
--
ALTER TABLE `Cars`
  MODIFY `CarId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `Rentals`
--
ALTER TABLE `Rentals`
  MODIFY `RentalId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `Reviews`
--
ALTER TABLE `Reviews`
  MODIFY `ReviewId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Roles`
--
ALTER TABLE `Roles`
  MODIFY `RoleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `CarImages`
--
ALTER TABLE `CarImages`
  ADD CONSTRAINT `CarImages_ibfk_1` FOREIGN KEY (`CarId`) REFERENCES `Cars` (`CarId`) ON DELETE CASCADE;

--
-- Constraints for table `Rentals`
--
ALTER TABLE `Rentals`
  ADD CONSTRAINT `Rentals_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `Users` (`UserId`) ON DELETE CASCADE,
  ADD CONSTRAINT `Rentals_ibfk_2` FOREIGN KEY (`CarId`) REFERENCES `Cars` (`CarId`) ON DELETE CASCADE;

--
-- Constraints for table `Reviews`
--
ALTER TABLE `Reviews`
  ADD CONSTRAINT `Reviews_ibfk_1` FOREIGN KEY (`RentalId`) REFERENCES `Rentals` (`RentalId`) ON DELETE CASCADE,
  ADD CONSTRAINT `Reviews_ibfk_2` FOREIGN KEY (`UserId`) REFERENCES `Users` (`UserId`) ON DELETE CASCADE,
  ADD CONSTRAINT `Reviews_ibfk_3` FOREIGN KEY (`CarId`) REFERENCES `Cars` (`CarId`) ON DELETE CASCADE;

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`RoleId`) REFERENCES `Roles` (`RoleId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
