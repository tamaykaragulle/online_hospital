-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2022 at 04:21 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_hospital_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `doctor_username` varchar(40) NOT NULL,
  `doctor_password` text NOT NULL,
  `doctor_mail` text NOT NULL,
  `doctor_speciality` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `doctor_username`, `doctor_password`, `doctor_mail`, `doctor_speciality`) VALUES
(43, 'tamaydoc6', '$2y$10$.tovLevF2VheuV/4WBRHxuMr2ni6bz9/xXN.qtAoTlOiaeHrDRzBm', 'tamaydoc6@gmail.com', 'Anesthesiology'),
(44, 'tamaydoc1', '$2y$10$uw6dGNyrkNn7eWDAa7XageNyJ.EHrNZnqKwEeXHbznY8.MBAGUxX6', 'tamaydoc1@gmail.com', 'Physical medicine and rehabilitation'),
(45, 'tamaydoc2', '$2y$10$CKIav6LsB8x.XlwXz.CWKOf0N1UL6K3p3PpXujp6yApb.QdTfxc02', 'tamaydoc2@gmail.com', 'Pediatrics');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `patient_username` varchar(30) NOT NULL,
  `patient_password` text NOT NULL,
  `patient_mail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `patient_username`, `patient_password`, `patient_mail`) VALUES
(1, 'tamaypat', '$2y$10$FOZ2vN1ojOqldD13Cmh0LuCLCKzpHyfPl7nD9ulUjCGibXUkStrr2', 'tamaypat1@gmail.com'),
(2, 'tamaypat2', '$2y$10$ipOLrNfu1mPIy3WNKvpAluZ5s/u2QOI67sHRcq8u87clO3V7uSjkG', 'tamaypat2@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
