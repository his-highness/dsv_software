-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2018 at 06:12 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tinker_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_absent`
--

CREATE TABLE `all_absent` (
  `p_code` int(11) NOT NULL,
  `dated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `name` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `name`) VALUES
(1, 'Plumber'),
(2, 'Carpenter'),
(3, 'Labourer'),
(4, 'Security'),
(5, 'Administration');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `d_num` int(11) NOT NULL,
  `d_name` varchar(30) DEFAULT NULL,
  `mgr_id` int(11) DEFAULT NULL,
  `mgr_st_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`d_num`, `d_name`, `mgr_id`, `mgr_st_date`) VALUES
(1, 'Finance', 24, '2018-10-05'),
(2, 'Legal', 25, '2018-08-15'),
(3, 'Repair', 21, '2018-08-10'),
(4, 'Construction', 22, '2018-08-10');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `e_id` int(11) NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `cont_name` varchar(40) DEFAULT NULL,
  `d_wage` float(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`e_id`, `name`, `cat_id`, `cont_name`, `d_wage`) VALUES
(1, 'Aakash', 1, 'Plum Pvt. Ltd.', 500.00),
(2, 'Ramesh', 1, 'Plum Pvt. Ltd.', 500.00),
(3, 'Dinesh', 1, 'Waterworks Enterprises', 400.00),
(4, 'Suresh', 1, 'Waterworks Enterprises', 400.00),
(5, 'Mukesh', 1, 'Waterworks Enterprises', 400.00),
(6, 'Akshay', 2, 'Woodworks Pvt. Ltd.', 800.00),
(7, 'Akram', 2, 'Woodworks Pvt. Ltd.', 800.00),
(8, 'Rahul', 2, 'Woodworks Pvt. Ltd.', 800.00),
(9, 'Raman', 2, 'Crafts Enterprises', 1000.00),
(10, 'Kaartoos', 2, 'Crafts Enterprises', 1000.00),
(11, 'Madan', 3, 'Best Services Pvt. Ltd.', 300.00),
(12, 'Mohan', 3, 'Best Services Pvt. Ltd.', 300.00),
(13, 'Malviya', 3, 'Best Services Pvt. Ltd.', 300.00),
(14, 'Vikram', 3, 'Best Services Pvt. Ltd.', 300.00),
(15, 'Vikas', 3, 'Best Services Pvt. Ltd.', 300.00),
(16, 'Malik', 3, 'Best Services Pvt. Ltd.', 300.00),
(17, 'Veer', 4, 'Tiger Security Inc.', 800.00),
(18, 'Yodha', 4, 'Tiger Security Inc.', 800.00),
(19, 'Chander', 4, 'Tiger Security Inc.', 800.00),
(20, 'Gupta', 4, 'Tiger Security Inc.', 800.00),
(21, 'Gautam Ghosh', 5, NULL, NULL),
(22, 'Ahmed Khan', 5, NULL, NULL),
(23, 'Dev Kumar', 5, NULL, NULL),
(24, 'Ashish Kumar', 5, NULL, NULL),
(25, 'Visha Jeet', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emp_atten`
--

CREATE TABLE `emp_atten` (
  `emp_id` int(11) NOT NULL,
  `p_code` int(11) NOT NULL,
  `dated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_atten`
--

INSERT INTO `emp_atten` (`emp_id`, `p_code`, `dated`) VALUES
(1, 101, '2018-10-17'),
(1, 101, '2018-10-18'),
(1, 101, '2018-10-19'),
(1, 101, '2018-11-07'),
(1, 201, '2018-11-07'),
(2, 101, '2018-10-17'),
(2, 101, '2018-10-18'),
(2, 101, '2018-11-07'),
(2, 201, '2018-11-07'),
(3, 102, '2018-10-18'),
(3, 102, '2018-11-07'),
(4, 102, '2018-10-17'),
(4, 102, '2018-10-18'),
(4, 102, '2018-11-07'),
(4, 201, '2018-11-07'),
(5, 201, '2018-11-07'),
(6, 101, '2018-10-17'),
(6, 101, '2018-10-18'),
(6, 101, '2018-10-19'),
(6, 101, '2018-11-07'),
(7, 101, '2018-10-17'),
(7, 101, '2018-10-18'),
(7, 101, '2018-10-19'),
(7, 101, '2018-11-07'),
(7, 201, '2018-11-07'),
(8, 101, '2018-10-17'),
(8, 101, '2018-10-18'),
(8, 101, '2018-10-19'),
(9, 102, '2018-10-17'),
(9, 102, '2018-10-18'),
(9, 102, '2018-10-19'),
(9, 102, '2018-11-07'),
(10, 102, '2018-10-17'),
(10, 102, '2018-10-18'),
(10, 102, '2018-10-19'),
(10, 102, '2018-11-07'),
(11, 101, '2018-10-18'),
(11, 101, '2018-10-19'),
(12, 101, '2018-10-19'),
(14, 102, '2018-10-17'),
(14, 102, '2018-10-18'),
(14, 102, '2018-10-19'),
(15, 102, '2018-10-19'),
(16, 102, '2018-10-19');

-- --------------------------------------------------------

--
-- Table structure for table `emp_cost`
--

CREATE TABLE `emp_cost` (
  `emp_id` int(11) NOT NULL,
  `p_code` int(11) NOT NULL,
  `dated` date NOT NULL,
  `bf` float(6,2) DEFAULT NULL,
  `lc` float(6,2) DEFAULT NULL,
  `dn` float(6,2) DEFAULT NULL,
  `tn` float(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_cost`
--

INSERT INTO `emp_cost` (`emp_id`, `p_code`, `dated`, `bf`, `lc`, `dn`, `tn`) VALUES
(1, 101, '2018-10-18', 1.00, 1.00, 1.00, 1.00),
(2, 101, '2018-10-18', 1.00, 1.00, 1.00, 1.00),
(3, 102, '2018-10-18', 1.00, 1.00, 1.00, 1.00),
(4, 102, '2018-10-18', 1.00, 1.00, 1.00, 1.00),
(6, 101, '2018-10-18', 1.00, 1.00, 1.00, 1.00),
(7, 101, '2018-10-18', 1.00, 1.00, 1.00, 1.00),
(8, 101, '2018-10-18', 1.00, 1.00, 1.00, 1.00),
(9, 102, '2018-10-18', 1.00, 1.00, 1.00, 1.00),
(10, 102, '2018-10-18', 1.00, 1.00, 1.00, 1.00),
(11, 101, '2018-10-18', 1.00, 1.00, 1.00, 1.00),
(14, 102, '2018-10-18', 1.00, 1.00, 1.00, 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `emp_time`
--

CREATE TABLE `emp_time` (
  `emp_id` int(11) NOT NULL,
  `p_code` int(11) NOT NULL,
  `dated` date NOT NULL,
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_time`
--

INSERT INTO `emp_time` (`emp_id`, `p_code`, `dated`, `in_time`, `out_time`) VALUES
(1, 101, '2018-10-18', '02:55:00', '04:57:00'),
(2, 101, '2018-10-18', '04:57:00', '03:57:00'),
(6, 101, '2018-10-18', '04:56:00', '03:56:00'),
(7, 101, '2018-10-18', '03:56:00', '15:56:00'),
(8, 101, '2018-10-18', '15:56:00', '13:54:00'),
(11, 101, '2018-10-18', '21:52:00', '12:53:00');

-- --------------------------------------------------------

--
-- Table structure for table `on_project`
--

CREATE TABLE `on_project` (
  `emp_id` int(11) NOT NULL,
  `p_code` int(11) NOT NULL,
  `join_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `on_project`
--

INSERT INTO `on_project` (`emp_id`, `p_code`, `join_date`) VALUES
(1, 101, '2018-08-05'),
(1, 201, '2018-08-02'),
(2, 101, '2018-08-05'),
(2, 201, '2018-08-02'),
(3, 102, '2018-08-15'),
(4, 102, '2018-08-15'),
(4, 201, '2018-08-02'),
(5, 201, '2018-08-02'),
(6, 101, '2018-08-05'),
(7, 101, '2018-08-05'),
(7, 201, '2018-08-02'),
(8, 101, '2018-08-05'),
(8, 201, '2018-08-02'),
(9, 102, '2018-08-15'),
(9, 201, '2018-08-02'),
(10, 102, '2018-08-15'),
(10, 201, '2018-08-02'),
(11, 101, '2018-08-05'),
(11, 201, '2018-08-02'),
(12, 101, '2018-08-05'),
(12, 201, '2018-08-02'),
(13, 101, '2018-08-05'),
(13, 201, '2018-08-02'),
(14, 102, '2018-08-15'),
(14, 201, '2018-08-02'),
(15, 102, '2018-08-15'),
(15, 201, '2018-08-02'),
(16, 102, '2018-08-15'),
(17, 101, '2018-08-05'),
(18, 102, '2018-08-15'),
(19, 201, '2018-08-02'),
(20, 201, '2018-08-05');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `p_code` int(11) NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `p_st_date` date DEFAULT NULL,
  `p_end_date` date DEFAULT NULL,
  `hd_id` int(11) DEFAULT NULL,
  `hd_join_date` date DEFAULT NULL,
  `status` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`p_code`, `name`, `p_st_date`, `p_end_date`, `hd_id`, `hd_join_date`, `status`) VALUES
(101, 'Park Maintenance', '2018-08-05', '2018-09-04', 21, '2018-08-05', '1'),
(102, 'Gym Maintenance', '2018-08-15', '2018-09-24', 22, '2018-08-15', '1'),
(201, 'Garage Construction', '2018-08-02', '2018-11-30', 23, '2018-08-02', '1'),
(202, 'Road Repair', '2018-05-02', '2018-11-30', NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `with_department`
--

CREATE TABLE `with_department` (
  `emp_id` int(11) NOT NULL,
  `d_num` int(11) NOT NULL,
  `join_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `with_department`
--

INSERT INTO `with_department` (`emp_id`, `d_num`, `join_date`) VALUES
(1, 1, '2018-08-02'),
(1, 4, '2018-07-14'),
(2, 2, '2018-08-01'),
(2, 4, '2018-07-10'),
(3, 3, '2018-07-14'),
(3, 4, '2018-07-10'),
(4, 3, '2018-07-18'),
(5, 3, '2018-07-18'),
(6, 1, '2018-08-02'),
(6, 4, '2018-07-08'),
(7, 2, '2018-08-01'),
(7, 4, '2018-07-18'),
(8, 3, '2018-07-20'),
(8, 4, '2018-07-05'),
(9, 3, '2018-07-20'),
(10, 3, '2018-07-20'),
(11, 1, '2018-08-04'),
(11, 4, '2018-07-02'),
(12, 1, '2018-08-04'),
(12, 3, '2018-07-12'),
(13, 2, '2018-08-13'),
(13, 4, '2018-07-12'),
(14, 2, '2018-08-13'),
(14, 3, '2018-07-08'),
(15, 3, '2018-07-18'),
(15, 4, '2018-07-02'),
(16, 3, '2018-07-18'),
(16, 4, '2018-07-02'),
(17, 4, '2018-07-05'),
(18, 1, '2018-08-02'),
(19, 2, '2018-08-08'),
(19, 3, '2018-07-20'),
(20, 3, '2018-07-20'),
(21, 3, '2018-07-11'),
(22, 4, '2018-07-02'),
(23, 2, '2018-09-25'),
(24, 1, '2018-08-02'),
(25, 2, '2018-08-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_absent`
--
ALTER TABLE `all_absent`
  ADD PRIMARY KEY (`p_code`,`dated`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`d_num`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`e_id`);

--
-- Indexes for table `emp_atten`
--
ALTER TABLE `emp_atten`
  ADD PRIMARY KEY (`emp_id`,`p_code`,`dated`);

--
-- Indexes for table `emp_cost`
--
ALTER TABLE `emp_cost`
  ADD PRIMARY KEY (`emp_id`,`p_code`,`dated`);

--
-- Indexes for table `emp_time`
--
ALTER TABLE `emp_time`
  ADD PRIMARY KEY (`emp_id`,`p_code`,`dated`);

--
-- Indexes for table `on_project`
--
ALTER TABLE `on_project`
  ADD PRIMARY KEY (`emp_id`,`p_code`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`p_code`);

--
-- Indexes for table `with_department`
--
ALTER TABLE `with_department`
  ADD PRIMARY KEY (`emp_id`,`d_num`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `e_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
