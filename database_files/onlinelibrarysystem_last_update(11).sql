-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2023 at 07:15 PM
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
-- Table structure for table `author_book_bridge_table`
--

CREATE TABLE `author_book_bridge_table` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `author_book_bridge_table`
--

INSERT INTO `author_book_bridge_table` (`id`, `author_id`, `book_id`) VALUES
(40, 1, 5),
(41, 3, 9),
(42, 1, 11),
(43, 4, 7),
(44, 6, 8),
(45, 3, 67),
(50, 6, 57),
(51, 4, 57),
(52, 1, 57),
(60, 6, 70),
(61, 4, 70),
(62, 1, 70);

-- --------------------------------------------------------

--
-- Table structure for table `author_table`
--

CREATE TABLE `author_table` (
  `author_id` int(11) NOT NULL,
  `librarian_id` int(11) DEFAULT NULL,
  `author_fullname` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `author_table`
--

INSERT INTO `author_table` (`author_id`, `librarian_id`, `author_fullname`) VALUES
(1, 10, 'Paolo'),
(3, 10, 'Renzy John Minerva'),
(4, 10, 'Muahamad'),
(6, 10, 'Arnold Ayos Yan Hehe'),
(7, 10, 'Batman');

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
  `librarian_id` int(11) DEFAULT NULL,
  `rfid_code` varchar(10) DEFAULT NULL,
  `catalog_number` varchar(30) DEFAULT NULL,
  `catalog_book_title` varchar(50) DEFAULT NULL,
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

INSERT INTO `catalog_table` (`book_id`, `librarian_id`, `rfid_code`, `catalog_number`, `catalog_book_title`, `catalog_publisher`, `catalog_year`, `catalog_date_received`, `catalog_class`, `catalog_edition`, `catalog_volumes`, `catalog_pages`, `catalog_source_of_fund`, `catalog_cost_price`, `catalog_location_symbol`, `catalog_class_number`, `catalog_author_number`, `catalog_copyright_date`, `catalog_status`) VALUES
(5, 10, '', 'D-2076CL', 'Falling Into Place', 'Greenwillow Books', '2014', '', '', '', '', '312', 'DO', '', '', '', '', '', 'Unavailable'),
(6, 10, '', 'D-2075 CL', 'History of Filipino People', 'GAROTECH PUBLISHING', '1990', 'June 28, 2022', '', '8th', '', '637', 'Anonymous', '', '', '', '', '', 'Available'),
(7, 10, '', 'D-2077 CL', 'The Son of Neptune', 'Disney Hyperion Book, New York', '2011', '', '', '', '', '521', 'DO', '', '', '', '', '', 'Available'),
(8, 10, '', 'D-2078 CL', 'The Treasure Map of Boys', 'Dela Corte Press', '2009', '', '', '', '', '244', 'DO', '', '', '', '', '', 'Available'),
(9, 10, '', 'D-2079 CLd', 'The Sky is Everywhere', 'asd', 'asdasd', '', '', '', '', '', '', '', '', '', '', '', 'Available'),
(11, 10, '', 'D-092aa', 'The Sky is Everywhere', 'asd', 'asdasd', '', '', '', '', '', '', '', '', '', '', '', 'Available'),
(45, 10, '', 'D-G76234', 'The Treasure Map of Boys', 'Dela Corte Press', '2009', '', '', '', '', NULL, 'DO', '', '', '', '', '', 'Unavailable'),
(57, 10, '', 'D-77123', 'Batman', 'Warner Brothers', '2022', '', '', '', '', '', '', '', '', '', '', '', 'Available'),
(67, 10, '353DE301', 'C-998234', 'Testing', 'Warner', '2019', '', '', '', '', NULL, '', '', '', '', '', '', 'Available'),
(70, 10, '45666B01', 'asdasd', 'Batman', 'asd', 'asdasd', '', '', '', '', '', '', '', '', '', '', '', 'Available');

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
(13, 'renz', 'Renz', 'Minerva', 'Sta Monica Oton Iloilo', '09091234', 'renzyjohnm1@gmail.com', '$2y$10$stD2Jd1OHucIpwVT8qzV...8ill/BrSkRiZQXxUFyHOi7iHH4d4QW', 'bim.jpg', 'Deactivated');

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
(35, 10, 28, 57, '2023-05-09 10:06 pm', '2023-05-11 10:06 pm', '2023-05-11 12:59 am', '-1 day & -21 hours', '----', '----', 'Returned'),
(36, 10, 28, 5, '2023-05-09 10:09 pm', '2023-05-11 10:06 pm', '------', '------', '----', '----', 'On Borrow');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author_book_bridge_table`
--
ALTER TABLE `author_book_bridge_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `author_table`
--
ALTER TABLE `author_table`
  ADD PRIMARY KEY (`author_id`),
  ADD KEY `librarian_id_author` (`librarian_id`);

--
-- Indexes for table `borrower_table`
--
ALTER TABLE `borrower_table`
  ADD PRIMARY KEY (`borrower_id`);

--
-- Indexes for table `catalog_table`
--
ALTER TABLE `catalog_table`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `librarian_id` (`librarian_id`);

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
-- AUTO_INCREMENT for table `author_book_bridge_table`
--
ALTER TABLE `author_book_bridge_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `author_table`
--
ALTER TABLE `author_table`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `borrower_table`
--
ALTER TABLE `borrower_table`
  MODIFY `borrower_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `catalog_table`
--
ALTER TABLE `catalog_table`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `librarian_table`
--
ALTER TABLE `librarian_table`
  MODIFY `librarian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaction_table`
--
ALTER TABLE `transaction_table`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `author_book_bridge_table`
--
ALTER TABLE `author_book_bridge_table`
  ADD CONSTRAINT `author_book_bridge_table_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `author_table` (`author_id`),
  ADD CONSTRAINT `author_book_bridge_table_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `catalog_table` (`book_id`);

--
-- Constraints for table `author_table`
--
ALTER TABLE `author_table`
  ADD CONSTRAINT `librarian_id_author` FOREIGN KEY (`librarian_id`) REFERENCES `librarian_table` (`librarian_id`);

--
-- Constraints for table `catalog_table`
--
ALTER TABLE `catalog_table`
  ADD CONSTRAINT `librarian_id` FOREIGN KEY (`librarian_id`) REFERENCES `librarian_table` (`librarian_id`);

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
