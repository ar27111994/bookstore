-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2016 at 01:31 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uaarbookstore`
--
CREATE DATABASE IF NOT EXISTS `uaarbookstore` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `uaarbookstore`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `ADMIN_NAME` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ADMIN_PASSWORD` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ADMIN_NAME`, `ADMIN_PASSWORD`) VALUES
('356687b8e771ee6e034e1bce522cb8ec', '7a91087af89542d614a1f7632956b6df');

-- --------------------------------------------------------

--
-- Table structure for table `bookkeywords`
--

CREATE TABLE IF NOT EXISTS `bookkeywords` (
  `Book_id` int(11) NOT NULL,
  `Keyword` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookkeywords`
--

INSERT INTO `bookkeywords` (`Book_id`, `Keyword`) VALUES
(1, 'Textbook'),
(1, 'Encyclopedia'),
(1, 'Oxford'),
(3, 'Textbook'),
(3, 'Engineering'),
(3, 'Information Technology'),
(31, 'Engineering'),
(31, 'Information Technology'),
(31, 'Textbook'),
(32, 'Islam'),
(32, 'Notes'),
(32, 'Textbook'),
(33, 'Engineering'),
(33, 'Notes'),
(33, 'Textbook'),
(34, 'Economics'),
(34, 'Marketing'),
(34, 'Notes'),
(34, 'Textbook');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `Book_id` int(11) NOT NULL,
  `BookName` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Author Name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Edition` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OldPrice` int(5) NOT NULL DEFAULT '0',
  `Price` int(5) NOT NULL,
  `Stock Status` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Book Description` varchar(550) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Number of Pages` int(5) NOT NULL,
  `Publication Date` date NOT NULL,
  `Publisher` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Bar Code` bigint(13) NOT NULL,
  `Featured / Un-Featured Book` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`Book_id`, `BookName`, `Author Name`, `Edition`, `OldPrice`, `Price`, `Stock Status`, `Book Description`, `Number of Pages`, `Publication Date`, `Publisher`, `Bar Code`, `Featured / Un-Featured Book`) VALUES
(1, 'OXFORD URDU-ENGLISH DICTIONARY', 'S.M. SALIMUDDIN', '8th', 0, 999, 'in stock', 'It is the national language of Pakistan and is one of the 23 official languages of India. It has official language status in the Indian states of Andhra Pradesh, Bihar, Jammu and Kashmir, and Uttar Pradesh, and the national capital, Delhi; where it is spoken, learned, and regarded as a language of prestige. It is used in education, literature, office and court business, media, and in religious institutions. Urdu draws much vocabulary from Persian and Arabic.', 1200, '2013-01-11', 'OUP PAKISTAN', 2147483647989, 0),
(3, 'Agile Web Development with Rails', 'Sam Ruby, Dave Thomas, David Heinemeier ', '4th', 1550, 1325, 'in stock', 'Ruby on Rails helps you produce high-quality, beautiful-looking web applications quickly. You concentrate on creating the application, and Rails takes care of the details. Tens of thousands of developers have used this award-winning book to learn Rails. Itâ€™s a broad, far-reaching tutorial and reference thatâ€™s recommended by the Rails core team. If youâ€™re new to Rails, youâ€™ll get step-by-step guidance. If youâ€™re an experienced developer, this book will give you the comprehensive, insider information you need.', 451, '2012-01-01', 'Shroff', 7678984393256, 0),
(31, 'Office 2010: The Missing Manual', 'Matthew MacDonald', '1st', 0, 1598, 'in stock', 'Microsoft Office is the most widely used software suite in the world. The half-dozen programs in Office 2010 are packed with amazing features, but most people just know the basics. This entertaining guide not only gets you started with Office, it reveals all kinds of useful things you didn\\''t know the software could do -- with plenty of power-user tips and tricks when you\\''re ready for more.', 678, '2011-11-01', 'Shroff', 2458537031245, 0),
(32, 'The Islamic Concept of Justice', 'Umar Ahmed Kassir', '1st', 0, 899, 'in stock', 'This book, on the Islamic Concept of Justice, consists essentially of a review and analysis of the basic evidence taken from the Quran and Sunnah on the subject. It seeks to show, in particular, the Quranic aspect of universal justice, which transcends the particular boundaries of any rigid framework that might otherwise have restricted the progress of humanity, as well as the concept of justice within Islam. It explains the fact that the Messengers and Prophets were sent to tech the principle of justice, among other things.', 175, '2011-07-13', 'Al-Firdous Ltd.', 1853903268035, 0),
(33, 'INTRODUCTION TO CHEMICAL ENGINEERING THERMODYNAMIC', 'J M SMITH,H C VAN NESS,MM ABBOTT', '7th', 0, 1350, 'in stock', 'This revised edition provides a comprehensive exposition of the principles of thermodynamics and details their application to chemical processes. The chapters are written in a clear, logically organized manner, and contain an abundance of realistic problems, examples, and illustrations to help students to understand complex concepts.', 1112, '2013-01-31', 'Mc Graw Hill', 2309859056710, 0),
(34, 'Inside Apple: How Americas Most Admired And Secretive Company Really Works', 'Adam Lashinsky', '3rd', 0, 1350, 'in stock', 'In INSIDE APPLE, Adam Lashinsky provides readers with an insight on leadership and innovation. He introduces Apple business concepts like the \\''DRI\\'' (Apple\\''s practice of assigning a Directly Responsible Individual to every task) and the Top 100 (an annual event where that year\\''s top 100 up-and-coming executives are surreptitiously transported to a secret retreat with company founder Steve Jobs).', 388, '2012-03-01', 'Hachetta India', 937900455712234, 0);

-- --------------------------------------------------------

--
-- Table structure for table `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
  `I.D.` int(11) NOT NULL,
  `Keyword` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keywords`
--

INSERT INTO `keywords` (`I.D.`, `Keyword`) VALUES
(13, 'Accounting'),
(14, 'Autobiography'),
(9, 'Biology'),
(12, 'Economics'),
(6, 'Encyclopedia'),
(7, 'Engineering'),
(10, 'Information Technology'),
(15, 'Islam'),
(3, 'Magazine'),
(11, 'Marketing'),
(8, 'Mathematics'),
(4, 'Notes'),
(2, 'Novel'),
(5, 'Oxford'),
(1, 'Textbook');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `Order_Id` int(9) NOT NULL,
  `Product_Id` int(9) NOT NULL,
  `Quantity` int(3) NOT NULL,
  `Order Status` int(1) NOT NULL DEFAULT '0',
  `User Email` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `USERNAME` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Address` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Street Number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `House Number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Storey Number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Phone Number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Order_Id`, `Product_Id`, `Quantity`, `Order Status`, `User Email`, `USERNAME`, `city`, `Address`, `Street Number`, `House Number`, `Storey Number`, `Phone Number`) VALUES
(6833, 1, 2, 0, 'a56fe571ce3815915234f6f03170d1fc', 'Ahmed Rehan', 'Lahore', 'H-8, Islamabad, Islamabad Capital Territory, Pakistan', '3-F', '166', '', '+92-051-4432567'),
(35993, 1, 10, 0, 'a56fe571ce3815915234f6f03170d1fc', 'Ahmed Rehan', 'Islamabad', 'H-12, Islamabad, Islamabad Capital Territory, Pakistan', 'H', '977', '3', '+92-051-4436789'),
(57724, 1, 10, 0, 'a56fe571ce3815915234f6f03170d1fc', 'Ahmed Rehan', 'Islamabad', 'H-12, Islamabad, Islamabad Capital Territory, Pakistan', 'H', '977', '3', '+92-051-4436789'),
(60047, 1, 10, 0, 'a56fe571ce3815915234f6f03170d1fc', 'Ahmed Rehan', 'Rawalpindi', 'Satellite Town, Rawalpindi, Punjab, Pakistan', 'B', '525', '1', '+92-051-4432567'),
(62778, 1, 1, 0, 'a56fe571ce3815915234f6f03170d1fc', 'Ahmed Rehan', 'Lahore', 'Zafarwal, Punjab, Pakistan', '3r', 'yv', '', '+92-057-6669999'),
(62778, 3, 1, 0, 'a56fe571ce3815915234f6f03170d1fc', 'Ahmed Rehan', 'Lahore', 'Zafarwal, Punjab, Pakistan', '3r', 'yv', '', '+92-057-6669999'),
(84778, 1, 10, 0, 'a56fe571ce3815915234f6f03170d1fc', 'Ahmed Rehan', 'Rawalpindi', 'Satellite Town, Rawalpindi, Punjab, Pakistan', 'B', '525', '1', '+92-051-4432567');

-- --------------------------------------------------------

--
-- Table structure for table `reader_registration`
--

CREATE TABLE IF NOT EXISTS `reader_registration` (
  `USERNAME` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `EMAIL` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PASSWORD` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ADDRESS` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `AREA OF INTEREST` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `AREA OF INTEREST 2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `GENDER` text CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL,
  `AGE` int(2) NOT NULL,
  `IMAGE` blob NOT NULL,
  `HASH` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ACCOUNT_STATUS` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reader_registration`
--

INSERT INTO `reader_registration` (`USERNAME`, `EMAIL`, `PASSWORD`, `ADDRESS`, `AREA OF INTEREST`, `AREA OF INTEREST 2`, `GENDER`, `AGE`, `IMAGE`, `HASH`, `ACCOUNT_STATUS`) VALUES
('Ahmed Rehan', 'f55e61d02bde40d35d6553dff8a6ded6', '7a91087af89542d614a1f7632956b6df', '4-D,Satellite Town,Rawalpindi', '123', '159', 'male', 21, 0x63726561746976652d6c696665312e706e67, '0f96613235062963ccde717b18f97592', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE IF NOT EXISTS `subscribers` (
  `Subscription_Email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `HASH` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`Subscription_Email`, `HASH`) VALUES
('4ffd70bad55fbd7177724de3acc9c5f8', 'a5e00132373a7031000fd987a3c9f87b'),
('f55e61d02bde40d35d6553dff8a6ded6', '8e82ab7243b7c66d768f1b8ce1c967eb');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ADMIN_NAME`);

--
-- Indexes for table `bookkeywords`
--
ALTER TABLE `bookkeywords`
  ADD KEY `Book_id` (`Book_id`,`Keyword`(191));

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`Book_id`), ADD KEY `Book I.D.` (`Book_id`);

--
-- Indexes for table `keywords`
--
ALTER TABLE `keywords`
  ADD PRIMARY KEY (`I.D.`), ADD KEY `Keyword` (`Keyword`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_Id`,`Product_Id`,`User Email`), ADD KEY `Product_Id` (`Product_Id`), ADD KEY `User Email` (`User Email`);

--
-- Indexes for table `reader_registration`
--
ALTER TABLE `reader_registration`
  ADD PRIMARY KEY (`EMAIL`), ADD KEY `USERNAME` (`USERNAME`(191),`PASSWORD`(191));

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`Subscription_Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `Book_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `keywords`
--
ALTER TABLE `keywords`
  MODIFY `I.D.` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookkeywords`
--
ALTER TABLE `bookkeywords`
ADD CONSTRAINT `ManyToMany` FOREIGN KEY (`Book_id`) REFERENCES `books` (`Book_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`Product_Id`) REFERENCES `books` (`Book_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
