-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2023 at 05:59 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinelibrarysystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrower_table`
--

CREATE TABLE `borrower_table` (
  `borrower_id` int(11) NOT NULL,
  `borrower_fname` varchar(100) DEFAULT NULL,
  `borrower_lname` varchar(100) DEFAULT NULL,
  `borrower_address` varchar(100) DEFAULT NULL,
  `borrower_contact` varchar(100) DEFAULT NULL,
  `borrower_email` varchar(100) DEFAULT NULL,
  `borrower_status` varchar(100) DEFAULT NULL,
  `borrowed_books` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `borrower_table`
--

INSERT INTO `borrower_table` (`borrower_id`, `borrower_fname`, `borrower_lname`, `borrower_address`, `borrower_contact`, `borrower_email`, `borrower_status`, `borrowed_books`) VALUES
(26, 'Renzy John', 'Minerva', 'Sta. Monica', '09287412', 'renzyjohnm1@gmail.com', 'accepted', 0),
(27, 'renzy', 'qw', 'qwdqwd', 'qwdqwd', 'renzyjohnm3@gmail.com', 'accepted', 0),
(28, 'renzy', 'qw', 'qwdqwd', 'qwdqwd', 'renzyjohnm2@gmail.com', 'accepted', 0),
(31, 'Renzy', 'asdasd', 'asdasd', 'asdasd', 'berondoangelyn@gmail.com', 'accepted', 0),
(32, 'Jessa Mae', 'Miranda', 'Mars, Iloilo', '09150265384', 'geges23@gmail.com', 'rejected', 0),
(33, 'paolo', 'pabilona', 'Sta Clara Oton, Iloilo', '09093235625', 'paolopabilona7@gmail.com', 'accepted', 0),
(34, 'Renzo', 'Gwapo', 'Poblacion, San Rafael, Iloilo', '09150265384', 'reyjourneylozada@gmail.com', 'accepted', 0),
(36, 'Hannah', 'Diesto', 'Balay nyo', '09123456789', 'secret@gmail.com', 'pending', 0),
(37, 'Paw', 'Low', 'Balay', '09123456789', 'pakta@gmail.com', 'pending', 0),
(38, 'queen', 'hannah', 'balay', '09123456789', 'hannahmaediesto@gmail.com', 'accepted', 0),
(41, 'synergy', 'Hodkiewicz', 'indexing', '08715136', 'ghowell00@yahoo.com', 'pending', 0),
(42, 'Ed', 'Oberbrunner', '39076 Willard Oval', '97200020', 'jana_kerluke99@mailrez.com', 'pending', 0),
(43, 'Lavon', 'Cruickshank', '190 Prohaska Shores', '14546579', 'jamison73@mailrez.com', 'pending', 0),
(44, 'paolo', 'pabilona', 'Sta Clara Oton, Iloilo', '09093235625', 'ashitsu945@gmail.com', 'accepted', 0),
(45, 'Alice', 'Robin', '445 Olivier de Provence', '99333434', 'mohamed82@jephy-webmail.com', 'pending', 0),
(46, 'Alice', 'Robin', '445 Olivier de Provence', 'pauline16', 'gordonb95@yahoo.com', 'pending', 0),
(47, 'XML', 'Robin', 'client-driven', '99333434', 'hugolehmann92@outlook.com', 'pending', 0),
(48, 'Nils', 'Stiedemann', '880 Macejkovic Trace', '37839368', 'marquis.bergstrom15@jephy-webmail.com', 'pending', 0),
(49, 'Raymond', 'Orn', '2871 Ledner Curve', '72593912', 'kamille.hudson7@jephy-webmail.com', 'pending', 0),
(50, 'vince', 'genoveza', 'OTON', '09093235625', 'vincefrancis.genoveza@students.isatu.edu.ph', 'accepted', 0);

-- --------------------------------------------------------

--
-- Table structure for table `catalog_table`
--

CREATE TABLE `catalog_table` (
  `book_id` int(11) NOT NULL,
  `rfid_code` varchar(10) DEFAULT NULL,
  `catalog_number` varchar(30) DEFAULT NULL,
  `catalog_book_title` varchar(50) DEFAULT NULL,
  `catalog_author` varchar(30) DEFAULT NULL,
  `catalog_publisher` varchar(30) DEFAULT NULL,
  `catalog_year` varchar(20) DEFAULT NULL,
  `catalog_date_received` varchar(20) DEFAULT NULL,
  `catalog_class` varchar(20) DEFAULT NULL,
  `catalog_edition` varchar(30) DEFAULT NULL,
  `catalog_volumes` varchar(30) DEFAULT NULL,
  `catalog_pages` varchar(20) DEFAULT NULL,
  `catalog_source_of_fund` varchar(30) DEFAULT NULL,
  `catalog_cost_price` varchar(30) DEFAULT NULL,
  `catalog_location_symbol` varchar(30) DEFAULT NULL,
  `catalog_class_number` varchar(30) DEFAULT NULL,
  `catalog_author_number` varchar(30) DEFAULT NULL,
  `catalog_copyright_date` varchar(20) DEFAULT NULL,
  `catalog_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `catalog_table`
--

INSERT INTO `catalog_table` (`book_id`, `rfid_code`, `catalog_number`, `catalog_book_title`, `catalog_author`, `catalog_publisher`, `catalog_year`, `catalog_date_received`, `catalog_class`, `catalog_edition`, `catalog_volumes`, `catalog_pages`, `catalog_source_of_fund`, `catalog_cost_price`, `catalog_location_symbol`, `catalog_class_number`, `catalog_author_number`, `catalog_copyright_date`, `catalog_status`) VALUES
(5, '93CA3BB7', 'D-2076 CL', 'Falling Into Place', 'Zhang, Amy ', 'Greenwillow Books', '2014', '', '', '', '', '312', 'DO', '', '', '', '', '', 'Available'),
(6, 'C3F722B7', 'D-2075 CL', 'History of Filipino People', 'Agoncillo Teodoro A.', 'GAROTECH PUBLISHING', '1990', 'June 28, 2022', '', '8th', '', '637', 'Anonymous', '', '', '', '', '', 'Unavailable'),
(7, '', 'D-2077 CL', 'The Son of Neptune', 'Riordan, Rick', 'Disney Hyperion Book, New York', '2011', '', '', '', '', '521', 'DO', '', '', '', '', '', 'Unavailable'),
(8, '', 'D-2078 CL', 'The Treasure Map of Boys', 'Lockhart, E', 'Dela Corte Press', '2009', '', '', '', '', '244', 'DO', '', '', '', '', '', 'Unavailable'),
(9, '', 'D-2079 CL', 'The Sky is Everywhere', 'Nelson, Jandy', 'Walker Books', '2010', '', '', '', '', '309', 'DO', '', '', '', '', '', 'Unavailable'),
(10, '', 'D-09284', 'The Sky is Everywhere', 'asd', 'asd', 'asd', '', '', '', '', NULL, '', '', '', '', '', '', 'Available'),
(11, '', 'D-092aa', 'The Sky is Everywhere', 'asd', 'asd', 'asdasd', '', '', '', '', NULL, '', '', '', '', '', '', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `librarian_table`
--

CREATE TABLE `librarian_table` (
  `librarian_id` int(11) NOT NULL,
  `librarian_uname` varchar(100) DEFAULT NULL,
  `librarian_fname` varchar(100) DEFAULT NULL,
  `librarian_lname` varchar(100) DEFAULT NULL,
  `librarian_address` varchar(100) DEFAULT NULL,
  `librarian_contact` varchar(100) DEFAULT NULL,
  `librarian_email` varchar(50) DEFAULT NULL,
  `librarian_password` varchar(255) DEFAULT NULL,
  `librarian_image_name` varchar(255) DEFAULT NULL,
  `librarian_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `librarian_table`
--

INSERT INTO `librarian_table` (`librarian_id`, `librarian_uname`, `librarian_fname`, `librarian_lname`, `librarian_address`, `librarian_contact`, `librarian_email`, `librarian_password`, `librarian_image_name`, `librarian_status`) VALUES
(10, 'admin', 'admin', 'admin', 'admin', 'admin', 'admin@gmail.com', '$2y$10$3VPL8cQFiAfwzwQSmC8Qout4ijFiRvU5qiYXsy.swC152TBFxEBrq', 'Untitled-1.png', 'Activated'),
(11, 'paolo', 'paolo', 'pabilona', 'Sta Clara Oton, Iloilo', '09093235625', 'ashitsu945@gmail.com', '$2y$10$y.N.cKTo.xbTa9n.y5itbu3lsD3H8Bq4jPtT6WQYKakk7dnU8.Sha', 'Untitled-1.png', 'Activated'),
(12, 'test', 'paolo', 'pabilona', 'Sta Clara Oton, Iloilo', '09093235625', 'paolopabilona7@gmail.com', '$2y$10$CgOMSZ2SGymyOX4g5FGGYe.Se1gpVYcYUA97yEjis2gx/EwO5/G/C', 'pic1.jpg', 'Deactivated'),
(13, 'renz', 'Renz', 'Minerva', 'Sta Monica Oton Iloilo', '09091234', 'renzyjohnm1@gmail.com', '$2y$10$stD2Jd1OHucIpwVT8qzV...8ill/BrSkRiZQXxUFyHOi7iHH4d4QW', 'bim.jpg', 'Activated');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_table`
--

CREATE TABLE `transaction_table` (
  `transaction_id` int(11) NOT NULL,
  `librarian_id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `transaction_borrow_datetime` varchar(100) DEFAULT NULL,
  `transaction_due_datetime` varchar(100) DEFAULT NULL,
  `transaction_datetime_return` varchar(100) DEFAULT NULL,
  `transaction_datetime_lapse` varchar(100) DEFAULT NULL,
  `transaction_penalty` varchar(50) DEFAULT NULL,
  `transaction_paid` varchar(50) DEFAULT NULL,
  `transaction_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction_table`
--

INSERT INTO `transaction_table` (`transaction_id`, `librarian_id`, `borrower_id`, `book_id`, `transaction_borrow_datetime`, `transaction_due_datetime`, `transaction_datetime_return`, `transaction_datetime_lapse`, `transaction_penalty`, `transaction_paid`, `transaction_status`) VALUES
(3, 10, 27, 6, '2023-04-08 6:44 am', '2023-04-15 6:44 am', '2023-04-08 06:46 am', '-7 days & -23 hours', '----', '----', 'Returned'),
(4, 10, 27, 6, '2023-04-08 6:53 am', '2023-04-08 6:53 am', '2023-04-09 09:35 am', '1 day & 02 hours', '10', 'Yes', 'Returned'),
(5, 11, 27, 6, '2023-04-09 9:39 am', '2023-04-09 9:39 am', '2023-04-09 10:06 am', '0 days & 00 hours', '----', '----', 'Returned'),
(6, 11, 26, 5, '2023-04-09 10:18 am', '2023-04-09 10:18 am', '2023-04-09 03:19 pm', '0 days & 05 hours', '----', '----', 'Returned'),
(7, 11, 26, 7, '2023-04-09 10:33 am', '2023-04-09 10:33 am', '2023-04-09 07:12 pm', '0 days & 08 hours', '----', '----', 'Returned'),
(8, 11, 26, 5, '2023-04-09 10:50 am', '2023-04-09 10:50 am', '2023-04-09 07:14 pm', '0 days & 08 hours', '----', '----', 'Returned'),
(9, 11, 27, 6, '2023-04-09 10:52 am', '2023-04-09 10:52 am', '2023-04-09 07:13 pm', '0 days & 08 hours', '----', '----', 'Returned'),
(10, 10, 26, 8, '2023-04-09 12:36 pm', '2023-04-09 12:36 pm', '2023-04-10 12:25 am', '0 days & 11 hours', '----', '----', 'Returned'),
(11, 10, 28, 9, '2023-04-09 12:37 pm', '2023-04-09 12:37 pm', '------', '------', '----', '----', 'On Borrow'),
(12, 10, 27, 9, '2023-04-09 12:53 pm', '2023-04-09 12:53 pm', '------', '------', '----', '----', 'On Borrow'),
(13, 10, 33, 5, '2023-04-09 3:20 pm', '2023-04-09 3:20 pm', '2023-04-10 02:39 pm', '0 days & 23 hours', '----', '----', 'Returned'),
(14, 12, 33, 7, '2023-04-09 7:12 pm', '2023-04-09 7:12 pm', '------', '------', '----', '----', 'On Borrow'),
(15, 12, 33, 5, '2023-04-09 7:14 pm', '2023-04-09 7:14 pm', '2023-04-11 11:10 am', '1 day & 15 hours', '10', 'No', 'Returned'),
(16, 12, 33, 6, '2023-04-09 7:17 pm', '2023-04-09 7:17 pm', '------', '------', '----', '----', 'On Borrow'),
(17, 10, 26, 8, '2023-04-07 12:25 am', '2023-04-11 12:25 am', '------', '------', '----', '----', 'On Borrow'),
(18, 10, 44, 5, '2023-04-10 2:39 pm', '2023-04-10 2:39 pm', '2023-04-11 11:15 am', '0 days & 20 hours', '----', '----', 'Returned'),
(20, 10, 50, 5, '2023-04-11 12:50 pm', '2023-04-13 12:50 pm', '2023-04-11 12:56 pm', '-2 days & -23 hours', '----', '----', 'Returned'),
(21, 10, 50, 5, '2023-03-25 1:37 pm', '2023-03-31 1:37 pm', '2023-04-11 01:38 pm', '11 days & 00 hours', '110', 'No', 'Returned');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrower_table`
--
ALTER TABLE `borrower_table`
  ADD PRIMARY KEY (`borrower_id`);

--
-- Indexes for table `catalog_table`
--
ALTER TABLE `catalog_table`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `librarian_table`
--
ALTER TABLE `librarian_table`
  ADD PRIMARY KEY (`librarian_id`);

--
-- Indexes for table `transaction_table`
--
ALTER TABLE `transaction_table`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `transaction_table` (`borrower_id`),
  ADD KEY `librarian_id` (`librarian_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrower_table`
--
ALTER TABLE `borrower_table`
  MODIFY `borrower_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `catalog_table`
--
ALTER TABLE `catalog_table`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `librarian_table`
--
ALTER TABLE `librarian_table`
  MODIFY `librarian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaction_table`
--
ALTER TABLE `transaction_table`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction_table`
--
ALTER TABLE `transaction_table`
  ADD CONSTRAINT `transaction_table` FOREIGN KEY (`borrower_id`) REFERENCES `borrower_table` (`borrower_id`),
  ADD CONSTRAINT `transaction_table_ibfk_1` FOREIGN KEY (`librarian_id`) REFERENCES `librarian_table` (`librarian_id`),
  ADD CONSTRAINT `transaction_table_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `catalog_table` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
