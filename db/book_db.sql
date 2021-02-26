-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 12, 2021 at 05:55 AM
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
(1, 1, '20th Century Costume\'s Pattern Design', 'https://ufl.pb.unizin.org/20thcenturypatterndesign/', 'EN', 1806, 1, NULL),
(2, 2, '12 Key Ideas: An Introduction to Teaching Online', 'https://ecampusontario.pressbooks.pub/onlineteaching/', 'EN', 23332, 1, NULL),
(3, 1, '21st Century Queer Fashion Brands', 'https://iastate.pressbooks.pub/queerfashionbrands/', 'EN', 210353, 1, NULL),
(4, 3, '2019-2020 Family Medicine Clerkship', 'https://tuftsmedicine.pressbooks.pub/familymedicineclerkship/', 'EN', 266565, 1, NULL),
(5, 4, '1, 2, 3 Write!', 'https://mhcc.pressbooks.pub/monteverde/', 'EN', 39949, 0, 'https://open.lib.umn.edu/writingforsuccess'),
(6, 5, 'A Guide to Making Open Textbooks with Students', 'https://csupueblo.pressbooks.pub/makingopentextbookswithstudents/', 'EN', 121515, 1, NULL),
(7, 4, 'A parar bien la oreja: cuaderno de comprensión auditiva', 'https://ecampusontario.pressbooks.pub/slch/', 'ES', 12755, 1, NULL),
(8, 6, 'Antología abierta de literatura hispana', 'https://press.rebus.community/aalh/', 'ES', 69619, 1, NULL),
(9, 6, 'Antología abierta de literatura hispana: edición canadiense', 'https://ecampusontario.pressbooks.pub/aalh/', 'ES', 24236, 0, 'https://press.rebus.community/aalh/'),
(10, 4, 'Español para hablantes nativos', 'https://openoregon.pressbooks.pub/spanishbiliteracy/', 'ES', 24405, 1, NULL),
(11, 5, 'La Trousse d’outils d’accessibilité', 'https://ecampusontario.pressbooks.pub/troussedoutildeaccessibilite/', 'FR', 7675, 0, 'https://opentextbc.ca/accessibilitytoolkit/'),
(12, 8, 'Femmes savantes, femmes de science', 'https://scienceetbiencommun.pressbooks.pub/femmessavantes/', 'FR', 33196, 1, NULL),
(13, 6, 'قصص من الليالي العربية', 'https://pressbooks.uiowa.edu/makur3/', 'AR', 12791, 1, NULL),
(14, 4, 'A Beginner\'s Guide for Transitioning into Colloquial Arabic', 'https://pdx.pressbooks.pub/frommsatoca/', 'AR', 10055, 1, NULL),
(15, 6, 'Tiny Tales from the Sufis', 'https://sufis.pressbooks.com/', 'AR', 25839, 1, NULL),
(16, 6, '三國演義 (Romance of the Three Kingdoms)', 'https://chinesenotes.com/sanguoyanyi.html', 'ZH', 14715, 0, 'https://ctext.org/sanguozhi'),
(17, 6, '三國志 (Records of the Three Kingdoms', 'https://ctext.org/sanguozhi', 'ZH', 84105, 1, NULL),
(18, 6, '紅樓夢 (Dream of the Red Chamber)', 'https://chinesenotes.com/hongloumeng.html', 'ZH', 44932, 1, NULL),
(19, 6, 'The Dream of the Red Chamber: Book I', 'https://librivox.org/the-dream-of-the-red-chamber-book-i-by-xueqin-cao/', 'EN', 24015, 0, 'https://chinesenotes.com/hongloumeng.html'),
(20, 5, 'An Open Approach to Scholarly Reading and Knowledge Management', 'https://press.rebus.community/scholarlyreading/', 'EN', 2324335, 1, NULL),
(21, 2, 'التدريس عبر الإنترنت', 'https://ecampusontario.pressbooks.pub/aqpr/', 'AR', 39949, 0, 'https://ecampusontario.pressbooks.pub/onlineteaching/');

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
(6, 006, 'Comparative literature'),
(8, 007, 'Women in science');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
    ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);
ALTER TABLE `books` ADD FULLTEXT KEY `title_index_fulltext` (`title`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `subject` ADD FULLTEXT KEY `name_index_fulltext` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
