-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 10, 2021 at 10:59 AM
-- Server version: 8.0.21
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pressbooks`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `subject_id` int NOT NULL,
  `title` varchar(2083) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(2083) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `language` enum('AR','EN','ES','FR','ZH') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `word_count` mediumint NOT NULL,
  `is_original` tinyint(1) NOT NULL,
  `based_on` varchar(2083) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `subject_id`, `title`, `url`, `language`, `word_count`, `is_original`, `based_on`) VALUES
(1, 1, '20th Century Costume Pattern Design', 'https://ufl.pb.unizin.org/20thcenturypatterndesign/', 'EN', 1806, 1, ''),
(2, 2, '12 Key Ideas: An Introduction to Teaching Online', 'https://ecampusontario.pressbooks.pub/onlineteaching/', 'EN', 23332, 1, ''),
(3, 1, '21st Century Queer Fashion Brands', 'https://iastate.pressbooks.pub/queerfashionbrands/', 'EN', 210353, 1, ''),
(4, 3, '2019-2020 Family Medicine Clerkship', 'https://tuftsmedicine.pressbooks.pub/familymedicineclerkship/', 'EN', 266565, 1, ''),
(5, 4, '1, 2, 3 Write!', 'https://mhcc.pressbooks.pub/monteverde/', 'EN', 39949, 0, 'https://open.lib.umn.edu/writingforsuccess');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int NOT NULL,
  `identifier` int(3) UNSIGNED ZEROFILL NOT NULL,
  `name` varchar(2083) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `identifier`, `name`) VALUES
(1, 001, 'Fashion & textiles'),
(2, 002, 'Education'),
(3, 003, 'Health'),
(4, 004, 'Language learning'),
(5, 005, 'Publishing & book trade'),
(6, 006, 'Comparative literature');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
