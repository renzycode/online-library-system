-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2023 at 03:40 PM
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
-- Database: `library_management_system`
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
  `borrower_id_image_name` varchar(255) DEFAULT NULL,
  `borrower_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `borrower_table`
--

INSERT INTO `borrower_table` (`borrower_id`, `borrower_fname`, `borrower_lname`, `borrower_address`, `borrower_contact`, `borrower_email`, `borrower_id_image_name`, `borrower_status`) VALUES
(1, 'sad', 'asdasd', 'asd', 'asdas', 'dasdasd', '7e9bbb29445847.55f311a0d4ba2.jpg', 'rejected'),
(2, 'asda', 'sdasd', 'asda', 'sda', 'sdasd', '4_17bb11f41f544ae6ad9713a3d18a05f3madeit2.jpg', 'accepted'),
(3, 'ASDASD', 'ASDASD', 'ASD', 'ASDASDADS', 'ASDASD', '95263279_10217592297866967_2546775723738136576_n.jpg', 'accepted'),
(4, 'Renzy', 'Minerva', 'Sta mo inc', '1827491', 'renzyjohnm1@gmail.com', '314600671_838403990630555_7146047954243435484_n.jpg', 'rejected'),
(5, 'asdasd', 'asd', 'asdas', 'dasd', 'asd', '7f4feade6fced13c309276e4ed631616.jpg', 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `catalog_table`
--

CREATE TABLE `catalog_table` (
  `catalog_id` int(11) NOT NULL,
  `librarian_id` int(11) NOT NULL,
  `catalog_number` varchar(100) DEFAULT NULL,
  `catalog_book_title` varchar(100) DEFAULT NULL,
  `catalog_author` varchar(100) DEFAULT NULL,
  `catalog_publisher` varchar(100) DEFAULT NULL,
  `catalog_year` varchar(100) DEFAULT NULL,
  `catalog_date_received` varchar(100) DEFAULT NULL,
  `catalog_class` varchar(100) DEFAULT NULL,
  `catalog_edition` varchar(100) DEFAULT NULL,
  `catalog_volumes` varchar(100) DEFAULT NULL,
  `catalog_pages` varchar(100) DEFAULT NULL,
  `catalog_source_of_fund` varchar(100) DEFAULT NULL,
  `catalog_cost_price` varchar(100) DEFAULT NULL,
  `catalog_location_symbol` varchar(100) DEFAULT NULL,
  `catalog_class_number` varchar(100) DEFAULT NULL,
  `catalog_author_number` varchar(100) DEFAULT NULL,
  `catalog_copyright_date` varchar(100) DEFAULT NULL,
  `catalog_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `catalog_table`
--

INSERT INTO `catalog_table` (`catalog_id`, `librarian_id`, `catalog_number`, `catalog_book_title`, `catalog_author`, `catalog_publisher`, `catalog_year`, `catalog_date_received`, `catalog_class`, `catalog_edition`, `catalog_volumes`, `catalog_pages`, `catalog_source_of_fund`, `catalog_cost_price`, `catalog_location_symbol`, `catalog_class_number`, `catalog_author_number`, `catalog_copyright_date`, `catalog_status`) VALUES
(1, 1, '02947', 'Noland', 'asdas', 'dasdasd', 'asdasdads', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unavailable'),
(4, 1, 'asd', 'asdas', 'Sapsap', 'asd', 'asdasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available'),
(5, 1, 'asdasd', 'asd', 'asd', 'asd', 'asdasdasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available'),
(6, 1, 'asd', '1982387', 'asd', 'asda', 'sdasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'unavailable'),
(7, 1, 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasdasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'available');

-- --------------------------------------------------------

--
-- Table structure for table `librarian_table`
--

CREATE TABLE `librarian_table` (
  `librarian_id` int(11) NOT NULL,
  `librarian_uname` varchar(100) DEFAULT NULL,
  `librarian_pass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `librarian_table`
--

INSERT INTO `librarian_table` (`librarian_id`, `librarian_uname`, `librarian_pass`) VALUES
(1, 'admin', '$2y$10$CsJsu2L5XPYMdbEX.aYO7OER4oRT85bk94chDttVAGGVBDzaq5oM2'),
(5, 'bimbim', '$2y$10$e3UiDHLXYayhXOuann/vg.auouXJAgAxXUV8p/HZzWgZ/B/qGyMqS');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_table`
--

CREATE TABLE `transaction_table` (
  `transaction_id` int(11) NOT NULL,
  `catalog_id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `transaction_borrow_datetime` varchar(100) DEFAULT NULL,
  `transaction_return_datetime` varchar(100) DEFAULT NULL,
  `transaction_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  ADD PRIMARY KEY (`catalog_id`),
  ADD KEY `catalog_table` (`librarian_id`);

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
  ADD KEY `transaction_table` (`catalog_id`),
  ADD KEY `borrower_id` (`borrower_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrower_table`
--
ALTER TABLE `borrower_table`
  MODIFY `borrower_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `catalog_table`
--
ALTER TABLE `catalog_table`
  MODIFY `catalog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `librarian_table`
--
ALTER TABLE `librarian_table`
  MODIFY `librarian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction_table`
--
ALTER TABLE `transaction_table`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `catalog_table`
--
ALTER TABLE `catalog_table`
  ADD CONSTRAINT `catalog_table` FOREIGN KEY (`librarian_id`) REFERENCES `librarian_table` (`librarian_id`);

--
-- Constraints for table `transaction_table`
--
ALTER TABLE `transaction_table`
  ADD CONSTRAINT `transaction_table` FOREIGN KEY (`catalog_id`) REFERENCES `catalog_table` (`catalog_id`),
  ADD CONSTRAINT `transaction_table_ibfk_1` FOREIGN KEY (`borrower_id`) REFERENCES `borrower_table` (`borrower_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
