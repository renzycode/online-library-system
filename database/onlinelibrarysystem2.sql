-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2023 at 04:20 PM
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
  `borrower_id_image_name` varchar(255) DEFAULT NULL,
  `borrower_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `borrower_table`
--

INSERT INTO `borrower_table` (`borrower_id`, `borrower_fname`, `borrower_lname`, `borrower_address`, `borrower_contact`, `borrower_email`, `borrower_id_image_name`, `borrower_status`) VALUES
(8, 'asda', 'sdas', 'dasd', 'asdasd', 'renzyjohnm@gmail.com', 'png-clipart-flader-82-default-icons-for-apple-app-mac-os-x-dictionary-maroon-and-white-book-logo.png', 'accepted'),
(9, 'asdas', 'dasd', 'asdasd', 'asdasdasd', 'renz@gmail.com', 'php-logo-php-elephant-logo-vectors-download-5.png', 'accepted'),
(10, 'asdasda', 'sdas', 'dasda', 'sdasda', 'sdasdasd@gmail.com', 'images.png', 'accepted'),
(12, 'asdas', 'dasd', 'asd', 'asdasd', 'asdasd@gmail.com', 'pic1.jpg', 'accepted'),
(18, 'asda', 'sdas', 'dasd', 'asdasd', 'asdasd@gmail.com', 'pic1.jpg', 'accepted');

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
(6, 1, 'asd', '1982387', 'asd', 'asda', 'sdasd', '', '', '', '', NULL, '', '', '', '', '', '', 'Available'),
(7, 1, 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'asdasdasd', '', '', '', '', NULL, '', '', '', '', '', '', 'Available'),
(11, 1, 'asd', 'asd', 'asd', 'asd', 'asd', '', '', '', '', NULL, '', '', '', '', '', '', 'Available'),
(14, 1, 'AS', 'as', 'asda', 'sdasd', 'asdasd', '', '', '', '', NULL, '', '', '', '', '', '', 'Available'),
(15, 1, 'xcv', 'xcvx', 'vxcv', 'xcvx', 'vxcvxcv', '', '', '', '', NULL, '', '', '', '', '', '', 'Available'),
(16, 1, 'vbnv', 'bnvbn', 'v', 'bnvbnvbn', 'vbnvbn', '', '', '', '', NULL, '', '', '', '', '', '', 'Unavailable'),
(17, 1, 'asdasd', 'asd', 'asdasd', 'asd', 'asdasd', '', '', '', '', NULL, '', '', '', '', '', '', 'Unavailable');

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
  `librarian_id` int(11) NOT NULL,
  `catalog_id_1` int(11) NOT NULL,
  `catalog_id_2` int(11) NOT NULL,
  `catalog_id_3` int(11) NOT NULL,
  `catalog_id_4` int(11) NOT NULL,
  `catalog_id_5` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `transaction_borrow_datetime` varchar(100) DEFAULT NULL,
  `transaction_return_datetime` varchar(100) DEFAULT NULL,
  `transaction_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction_table`
--

INSERT INTO `transaction_table` (`transaction_id`, `librarian_id`, `catalog_id_1`, `catalog_id_2`, `catalog_id_3`, `catalog_id_4`, `catalog_id_5`, `borrower_id`, `transaction_borrow_datetime`, `transaction_return_datetime`, `transaction_status`) VALUES
(16, 1, 6, 7, 15, 0, 0, 8, '2023-03-20|23:15', '2023-03-23|23:15', 'Returned');

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
  ADD KEY `transaction_table` (`borrower_id`),
  ADD KEY `librarian_id` (`librarian_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrower_table`
--
ALTER TABLE `borrower_table`
  MODIFY `borrower_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `catalog_table`
--
ALTER TABLE `catalog_table`
  MODIFY `catalog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `librarian_table`
--
ALTER TABLE `librarian_table`
  MODIFY `librarian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction_table`
--
ALTER TABLE `transaction_table`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  ADD CONSTRAINT `transaction_table` FOREIGN KEY (`borrower_id`) REFERENCES `borrower_table` (`borrower_id`),
  ADD CONSTRAINT `transaction_table_ibfk_1` FOREIGN KEY (`librarian_id`) REFERENCES `librarian_table` (`librarian_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
