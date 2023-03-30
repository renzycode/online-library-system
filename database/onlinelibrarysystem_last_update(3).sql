-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2023 at 02:33 PM
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
(8, 'Renz', 'De Jesus', 'Sta. Monica Oton', '0982742', 'renzyjohnm@gmail.com', 'png-clipart-flader-82-default-icons-for-apple-app-mac-os-x-dictionary-maroon-and-white-book-logo.png', 'accepted'),
(9, 'asdas', 'dasd', 'asdasd', 'asdasdasd', 'renz@gmail.com', 'php-logo-php-elephant-logo-vectors-download-5.png', 'accepted'),
(10, 'asdasda', 'sdas', 'dasda', 'sdasda', 'sdasdasd@gmail.com', 'images.png', 'accepted'),
(12, 'asdas', 'dasd', 'asd', 'asdasd', 'asdasd@gmail.com', 'pic1.jpg', 'accepted'),
(18, 'asda', 'sdas', 'dasd', 'asdasd', 'asdasd@gmail.com', 'pic1.jpg', 'accepted'),
(20, 'asd', 'asda', 'sdas', 'dasdasd', 'renz@gmail.com', 'Philippines_road_sign_R3-1.svg.png', 'accepted'),
(21, 'bimbim', 'minerva', 'sta. Monica', '09092341234', 'renzy@gmail.com', '337152463_1523351591528126_8336744458032820143_n.jpg', 'accepted'),
(22, 'asd', 'asd', 'asdasd', 'asdasd', 'asd@gmail.com', '337152463_1523351591528126_8336744458032820143_n (1).jpg', 'rejected'),
(23, 'asdfs', 'dfsdf', 'sdfsdf', 'sdfsdfsdf', 'asdasdas@gmail.com', 'bim2.jpg', 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `catalog_table`
--

CREATE TABLE `catalog_table` (
  `book_id` int(11) NOT NULL,
  `librarian_id` int(11) NOT NULL,
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

INSERT INTO `catalog_table` (`book_id`, `librarian_id`, `rfid_code`, `catalog_number`, `catalog_book_title`, `catalog_author`, `catalog_publisher`, `catalog_year`, `catalog_date_received`, `catalog_class`, `catalog_edition`, `catalog_volumes`, `catalog_pages`, `catalog_source_of_fund`, `catalog_cost_price`, `catalog_location_symbol`, `catalog_class_number`, `catalog_author_number`, `catalog_copyright_date`, `catalog_status`) VALUES
(1, 1, '93CA3BB7', '09339', 'Harry Pota', 'Jake gowling', 'jake INC', '2000', '', '', '', '', '', '', '', '', '', '', '', 'Available'),
(5, 1, 'C3F722B7', 'asda', 'sda', 'sdasdas', 'sda', 'dasdasd', '', '', '', '', '', '', '', '', '', '', '', 'Available');

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
  `borrower_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `transaction_borrow_datetime` varchar(100) DEFAULT NULL,
  `transaction_return_datetime` varchar(100) DEFAULT NULL,
  `transaction_datetime_return` varchar(100) DEFAULT NULL,
  `transaction_datetime_lapse` varchar(100) DEFAULT NULL,
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
  ADD PRIMARY KEY (`book_id`),
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
  ADD KEY `librarian_id` (`librarian_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrower_table`
--
ALTER TABLE `borrower_table`
  MODIFY `borrower_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `catalog_table`
--
ALTER TABLE `catalog_table`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `transaction_table_ibfk_1` FOREIGN KEY (`librarian_id`) REFERENCES `librarian_table` (`librarian_id`),
  ADD CONSTRAINT `transaction_table_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `catalog_table` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
