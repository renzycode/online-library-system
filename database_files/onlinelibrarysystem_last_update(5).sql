-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2023 at 02:38 PM
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
  `borrower_status` varchar(100) DEFAULT NULL,
  `borrowed_books` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `borrower_table`
--

INSERT INTO `borrower_table` (`borrower_id`, `borrower_fname`, `borrower_lname`, `borrower_address`, `borrower_contact`, `borrower_email`, `borrower_id_image_name`, `borrower_status`, `borrowed_books`) VALUES
(26, 'Renzy John', 'Minerva', 'Sta. Monica', '09287412', 'renzyjohnm1@gmail.com', 'bim.jpg', 'accepted', 0);

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
(1, '', '982673', 'Harry Pota', 'Jake Brolin', 'Jake INc', '2003', '', '', '', '', '', '', '', '', '', '', '', 'Available'),
(2, '', '87823', 'Maze Runner', 'Don\'t Know', 'Jake INc', '2001', '', '', '', '', NULL, '', '', '', '', '', '', 'Available');

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
  `librarian_image_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `librarian_table`
--

INSERT INTO `librarian_table` (`librarian_id`, `librarian_uname`, `librarian_fname`, `librarian_lname`, `librarian_address`, `librarian_contact`, `librarian_email`, `librarian_password`, `librarian_image_name`) VALUES
(9, 'renz', 'Renzy', 'Minerva', 'Sta. Monica, Oton, Iloilo', '10292893', 'renzyjohnm1@gmail.com', '$2y$10$jFkDGtaMGMfyBc1PmnrOfOiAAcYAkN7/UY/QM6Q9WR3rHqNw80Oge', 'bim.jpg'),
(10, 'admin', 'admin', 'admin', 'admin', 'admin', 'admin@gmail.com', '$2y$10$3VPL8cQFiAfwzwQSmC8Qout4ijFiRvU5qiYXsy.swC152TBFxEBrq', 'Untitled-1.png');

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
(1, 10, 26, 2, '2023-04-04 12:19 am', '2023-04-06 12:19 pm', '2023-04-04 12:21 am', '-3 days & -11 hours', '----', '----', 'Returned');

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
  MODIFY `borrower_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `catalog_table`
--
ALTER TABLE `catalog_table`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `librarian_table`
--
ALTER TABLE `librarian_table`
  MODIFY `librarian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaction_table`
--
ALTER TABLE `transaction_table`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
