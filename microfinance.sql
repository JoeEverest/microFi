-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2020 at 02:56 PM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `microfinance`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_loans`
--

CREATE TABLE `active_loans` (
  `id` int(100) NOT NULL,
  `loan_id` varchar(100) NOT NULL,
  `customer_name` varchar(1000) NOT NULL,
  `customer_id` varchar(1000) NOT NULL,
  `loan_amount` int(100) NOT NULL,
  `amount_toPay` int(100) NOT NULL,
  `installment_amount` int(100) NOT NULL,
  `disbursment_date` date NOT NULL,
  `maturity_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `loginId` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`loginId`, `password`) VALUES
('admin', '1d9f16d051848d54edbe9549efc585bc1564cb66');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(100) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `branch_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branch_name`, `branch_id`) VALUES
(1, 'Arusha', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `centers`
--

CREATE TABLE `centers` (
  `id` int(100) NOT NULL,
  `branch_name` varchar(1000) NOT NULL,
  `center_name` varchar(1000) NOT NULL,
  `center_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centers`
--

INSERT INTO `centers` (`id`, `branch_name`, `center_name`, `center_id`) VALUES
(1, 'Arusha', 'Endeleza', 100);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(100) NOT NULL,
  `customer_name` varchar(1000) NOT NULL,
  `business_title` varchar(1000) NOT NULL,
  `group_name` varchar(1000) NOT NULL,
  `center_name` varchar(1000) NOT NULL,
  `branch_name` varchar(1000) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `registration_date` date NOT NULL,
  `phone_number` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deliquence`
--

CREATE TABLE `deliquence` (
  `id` int(100) NOT NULL,
  `loan_id` varchar(100) NOT NULL,
  `customer_name` varchar(1000) NOT NULL,
  `customer_id` varchar(1000) NOT NULL,
  `amount_left` int(100) NOT NULL,
  `disbursment_date` date NOT NULL,
  `maturity_date` date NOT NULL,
  `payments_skipped` int(100) NOT NULL,
  `phone_number` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fines`
--

CREATE TABLE `fines` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(1000) NOT NULL,
  `customer_id` varchar(1000) NOT NULL,
  `fine_amount` int(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(100) NOT NULL,
  `group_name` varchar(1000) NOT NULL,
  `center_name` varchar(1000) NOT NULL,
  `group_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` int(11) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `reference` varchar(1000) NOT NULL,
  `reciept` varchar(100) NOT NULL,
  `amount` int(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `operators`
--

CREATE TABLE `operators` (
  `id` int(100) NOT NULL,
  `operator_name` varchar(1000) NOT NULL,
  `center_name` varchar(1000) NOT NULL,
  `rank` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `operators`
--

INSERT INTO `operators` (`id`, `operator_name`, `center_name`, `rank`, `password`) VALUES
(1, 'Edward', 'Endeleza_Arusha', 'AUTHORIZER', '1d9f16d051848d54edbe9549efc585bc1564cb66'),
(2, 'Joseph', 'Endeleza_Arusha', 'OPERATOR', '1d9f16d051848d54edbe9549efc585bc1564cb66');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(100) NOT NULL,
  `loan_id` varchar(1000) NOT NULL,
  `customer_name` varchar(1000) NOT NULL,
  `customer_id` varchar(1000) NOT NULL,
  `amount_paid` int(100) NOT NULL,
  `reciept_number` varchar(1000) NOT NULL,
  `date` date NOT NULL,
  `principle` int(100) NOT NULL,
  `interest` int(100) NOT NULL,
  `next_payment` date NOT NULL,
  `amount_left` varchar(100) NOT NULL,
  `payments_left` int(100) NOT NULL,
  `operator_name` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pending_loans`
--

CREATE TABLE `pending_loans` (
  `id` int(11) NOT NULL,
  `loan_id` varchar(100) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `loan_amount` int(100) NOT NULL,
  `amount_due` int(100) NOT NULL,
  `installment_amount` int(100) NOT NULL,
  `reciept` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(100) NOT NULL,
  `variable` varchar(100) NOT NULL,
  `value` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `variable`, `value`) VALUES
(1, 'Loan Interest', 20),
(2, 'Loan Application Fee', 5000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_loans`
--
ALTER TABLE `active_loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `centers`
--
ALTER TABLE `centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliquence`
--
ALTER TABLE `deliquence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fines`
--
ALTER TABLE `fines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operators`
--
ALTER TABLE `operators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_loans`
--
ALTER TABLE `pending_loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_loans`
--
ALTER TABLE `active_loans`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `centers`
--
ALTER TABLE `centers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deliquence`
--
ALTER TABLE `deliquence`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fines`
--
ALTER TABLE `fines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operators`
--
ALTER TABLE `operators`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pending_loans`
--
ALTER TABLE `pending_loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
