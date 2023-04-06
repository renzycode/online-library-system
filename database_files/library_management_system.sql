CREATE TABLE librarian_table (
  librarian_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  librarian_uname varchar(100) DEFAULT NULL,
  librarian_pass varchar(255) DEFAULT NULL
)

CREATE TABLE borrower_table (
  borrower_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  borrower_fname varchar(100) DEFAULT NULL,
  borrower_lname varchar(100) DEFAULT NULL,
  borrower_address varchar(100) DEFAULT NULL,
  borrower_contact varchar(100) DEFAULT NULL,
  borrower_email varchar(100) DEFAULT NULL,
  borrower_id_image_name varchar(255) DEFAULT NULL,
  borrower_no_books_borrowed varchar(100) DEFAULT NULL,
  borrower_status varchar(100) DEFAULT NULL
)

CREATE TABLE catalog_table (
  catalog_id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  librarian_id int(11) NOT NULL,
  catalog_number varchar(100) DEFAULT NULL,
  catalog_rfid_code varchar(100) DEFAULT NULL,
  catalog_book_title varchar(100) DEFAULT NULL,
  catalog_author varchar(100) DEFAULT NULL,
  catalog_publisher varchar(100) DEFAULT NULL,
  catalog_year varchar(100) DEFAULT NULL,
  catalog_date_received varchar(100) DEFAULT NULL,
  catalog_class varchar(100) DEFAULT NULL,
  catalog_edition varchar(100) DEFAULT NULL,
  catalog_volumes varchar(100) DEFAULT NULL,
  catalog_pages varchar(100) DEFAULT NULL,
  catalog_source_of_fund varchar(100) DEFAULT NULL,
  catalog_cost_price varchar(100) DEFAULT NULL,
  catalog_location_symbol varchar(100) DEFAULT NULL,
  catalog_class_number varchar(100) DEFAULT NULL,
  catalog_author_number varchar(100) DEFAULT NULL,
  catalog_copyright_date varchar(100) DEFAULT NULL,
  catalog_status varchar(100) DEFAULT NULL,
  CONSTRAINT catalog_table FOREIGN KEY (librarian_id) REFERENCES librarian_table(librarian_id)
)

CREATE TABLE `transaction_table` (
  `transaction_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `librarian_id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `transaction_borrow_datetime` varchar(100) DEFAULT NULL,
  `transaction_due_datetime` varchar(100) DEFAULT NULL,
  `transaction_datetime_return` varchar(100) DEFAULT NULL,
  `transaction_datetime_lapse` varchar(100) DEFAULT NULL,
  `transaction_penalty` varchar(50) DEFAULT NULL,
  `transaction_paid` varchar(50) DEFAULT NULL,
  `transaction_status` varchar(100) DEFAULT NULL,
  CONSTRAINT `transaction_table` FOREIGN KEY (`borrower_id`) REFERENCES `borrower_table` (`borrower_id`),
  FOREIGN KEY (`librarian_id`) REFERENCES `librarian_table` (`librarian_id`),
  FOREIGN KEY (`book_id`) REFERENCES `catalog_table` (`book_id`)
)


INSERT INTO librarian_table(librarian_id, librarian_uname, librarian_pass) VALUES (1,'admin','$2y$10$CsJsu2L5XPYMdbEX.aYO7OER4oRT85bk94chDttVAGGVBDzaq5oM2');
