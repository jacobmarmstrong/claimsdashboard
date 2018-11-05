-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2018 at 11:40 PM
-- Server version: 5.7.17
-- PHP Version: 7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `claims`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `loanType` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `userID`, `loanType`) VALUES
(1, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `ffr`
--

CREATE TABLE `ffr` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `softDelete` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ffr`
--

INSERT INTO `ffr` (`id`, `description`, `softDelete`) VALUES
(1, 'Foreclosure to Lender', 0),
(2, 'Foreclosure to Third Party', 0),
(3, 'Pre-foreclosure Sale', 0),
(4, 'Deed-in-Lieu of Foreclosure', 0),
(5, 'Manual Entry', 0);

-- --------------------------------------------------------

--
-- Table structure for table `loanleveltaskdatadate`
--

CREATE TABLE `loanleveltaskdatadate` (
  `id` int(11) NOT NULL,
  `loanID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `dataName` varchar(50) NOT NULL,
  `dataValue` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loanleveltaskdatadate`
--

INSERT INTO `loanleveltaskdatadate` (`id`, `loanID`, `taskID`, `dataName`, `dataValue`) VALUES
(1, 1, 1, 'Acquisition Date', '2018-11-04');

-- --------------------------------------------------------

--
-- Table structure for table `loanleveltaskdatadecimal`
--

CREATE TABLE `loanleveltaskdatadecimal` (
  `id` int(11) NOT NULL,
  `loanID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `dataName` varchar(50) NOT NULL,
  `dataValue` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loanleveltaskdatatext`
--

CREATE TABLE `loanleveltaskdatatext` (
  `id` int(11) NOT NULL,
  `loanID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `dataName` varchar(50) NOT NULL,
  `dataValue` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loanleveltaskdatatext`
--

INSERT INTO `loanleveltaskdatatext` (`id`, `loanID`, `taskID`, `dataName`, `dataValue`) VALUES
(17, 1, 24, 'Supplemental necessary?', 'Yes'),
(16, 1, 23, 'Supplemental necessary?', 'No'),
(15, 1, 22, 'Supplemental necessary?', 'No'),
(14, 1, 21, 'Supplemental necessary?', 'No'),
(13, 1, 8, 'Supplemental necessary?', 'Yes'),
(18, 1, 27, 'Supplemental necessary?', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `loanleveltasks`
--

CREATE TABLE `loanleveltasks` (
  `id` int(11) NOT NULL,
  `loanID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `createdDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dueDate` date DEFAULT NULL,
  `completedDate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loanleveltasks`
--

INSERT INTO `loanleveltasks` (`id`, `loanID`, `taskID`, `createdDate`, `dueDate`, `completedDate`) VALUES
(1, 1, 1, '2018-11-04 00:34:19', '2018-11-05', '2018-11-04 03:03:21'),
(2, 1, 2, '2018-11-04 03:03:21', '2018-11-05', '2018-11-04 13:55:06'),
(3, 1, 3, '2018-11-04 13:55:06', '2018-11-05', '2018-11-04 14:27:20'),
(4, 1, 4, '2018-11-04 14:27:20', '2018-11-09', '2018-11-04 14:27:24'),
(5, 1, 5, '2018-11-04 14:27:24', '2018-11-09', '2018-11-04 14:27:29'),
(6, 1, 6, '2018-11-04 14:27:29', '2018-11-05', '2018-11-04 14:46:56'),
(7, 1, 7, '2018-11-04 14:32:21', '2018-11-09', '2018-11-04 14:34:13'),
(8, 1, 6, '2018-11-04 14:34:13', '2018-11-05', '2018-11-04 15:08:08'),
(22, 1, 6, '2018-11-04 15:13:17', '2018-11-09', '2018-11-04 15:14:47'),
(21, 1, 6, '2018-11-04 15:08:38', '2018-11-05', '2018-11-04 15:13:17'),
(20, 1, 8, '2018-11-04 15:08:32', '2018-11-09', '2018-11-04 15:08:38'),
(19, 1, 7, '2018-11-04 15:08:08', '2018-11-09', '2018-11-04 15:08:32'),
(23, 1, 6, '2018-11-04 15:14:47', '2018-11-09', '2018-11-04 15:18:25'),
(24, 1, 6, '2018-11-04 15:18:25', '2018-11-05', '2018-11-04 15:18:43'),
(25, 1, 7, '2018-11-04 15:18:43', '2018-11-09', '2018-11-04 15:19:19'),
(26, 1, 8, '2018-11-04 15:19:19', '2018-11-09', '2018-11-04 15:19:23'),
(27, 1, 6, '2018-11-04 15:19:23', '2018-11-05', '2018-11-04 15:19:28'),
(28, 1, 9, '2018-11-04 15:19:28', '2018-11-05', '2018-11-04 15:19:32'),
(29, 1, 10, '2018-11-04 15:19:32', '2018-11-09', '2018-11-04 15:19:36');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `loanNumber` int(11) NOT NULL COMMENT 'Loan number',
  `loanType` int(11) NOT NULL COMMENT 'Loan type: 1 - FHA; 2 - VA; 3 - Conventional; 4 - Conventional with PMI; 5 - USDA; 6 - Title I',
  `investor` varchar(25) NOT NULL COMMENT 'The loan''s investor',
  `borrowerName` varchar(100) NOT NULL COMMENT 'Primary borrower''s first and last name',
  `paidToDate` date NOT NULL COMMENT 'The paid to date of the loan',
  `upb` decimal(10,2) NOT NULL COMMENT 'Current unpaid principal balance',
  `escrowBalance` decimal(10,2) NOT NULL COMMENT 'Current escrow balance',
  `ffrType` int(11) NOT NULL COMMENT 'Type of foreclosure/forfeiture: 1 - Foreclosure to Lender; 2 - Foreclosure to Third Party; 3 - Pre-foreclosure Sale; 4 - Deed-in-Lieu of Foreclosure; 5 - Manual Entry',
  `ffrDate` date NOT NULL COMMENT 'Date of foreclosure/forfeiture',
  `acquisitionDate` date DEFAULT NULL COMMENT 'Date of acquisition',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT 'Loan''s status: 0 - inactive (completed); 1 - active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `loanNumber`, `loanType`, `investor`, `borrowerName`, `paidToDate`, `upb`, `escrowBalance`, `ffrType`, `ffrDate`, `acquisitionDate`, `status`) VALUES
(1, 100, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(2, 101, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(3, 102, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(4, 103, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(5, 104, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(6, 105, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(7, 106, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(8, 107, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(9, 108, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(10, 109, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(11, 110, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(12, 111, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(13, 112, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(14, 113, 3, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(15, 114, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(16, 115, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(17, 116, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(18, 117, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(19, 118, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(20, 119, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(21, 120, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(22, 121, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(23, 122, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(24, 123, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(25, 124, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(26, 125, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(27, 126, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(28, 127, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(29, 128, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(30, 129, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(31, 130, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1),
(32, 131, 1, 'FNMA', 'TEST BORROWER', '2017-11-01', '100000.54', '-5641.54', 1, '2018-10-01', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `loantypes`
--

CREATE TABLE `loantypes` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `softDelete` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loantypes`
--

INSERT INTO `loantypes` (`id`, `description`, `softDelete`) VALUES
(1, 'FHA', 0),
(2, 'VA', 0),
(3, 'Conventional (FNMA)', 0),
(4, 'Conventional with PMI (FNMA)', 0),
(5, 'USDA', 0),
(6, 'Title I', 0),
(7, 'Test Loan Type', 1);

-- --------------------------------------------------------

--
-- Table structure for table `repeattask`
--

CREATE TABLE `repeattask` (
  `id` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `nextTaskID` int(11) NOT NULL,
  `conditionName` varchar(100) NOT NULL,
  `conditionTask` int(11) NOT NULL,
  `conditionValue` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `repeattask`
--

INSERT INTO `repeattask` (`id`, `taskID`, `nextTaskID`, `conditionName`, `conditionTask`, `conditionValue`) VALUES
(1, 6, 7, 'loanleveltaskdatatext.dataValue', 6, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `roledefinitions`
--

CREATE TABLE `roledefinitions` (
  `id` int(11) NOT NULL,
  `roleName` varchar(50) NOT NULL COMMENT 'Name of the role',
  `roleDefinition` varchar(1000) NOT NULL COMMENT 'Definition of the role'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roledefinitions`
--

INSERT INTO `roledefinitions` (`id`, `roleName`, `roleDefinition`) VALUES
(1, 'Claim Specialist', 'User responsible for filing claims'),
(2, 'Claims Manager', 'User responsible for managing claims');

-- --------------------------------------------------------

--
-- Table structure for table `taskdata`
--

CREATE TABLE `taskdata` (
  `id` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `dataName` varchar(50) NOT NULL,
  `dataType` varchar(50) NOT NULL,
  `possibleValues` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taskdata`
--

INSERT INTO `taskdata` (`id`, `taskID`, `dataName`, `dataType`, `possibleValues`) VALUES
(1, 1, 'Acquisition Date', 'date', NULL),
(3, 6, 'Supplemental necessary?', 'select', 'No,Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tasklist`
--

CREATE TABLE `tasklist` (
  `id` int(11) NOT NULL,
  `loanType` int(11) NOT NULL,
  `ffrType` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `body` varchar(1000) NOT NULL,
  `days` int(11) NOT NULL,
  `nextTaskID` int(11) DEFAULT NULL,
  `listOrder` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasklist`
--

INSERT INTO `tasklist` (`id`, `loanType`, `ffrType`, `title`, `body`, `days`, `nextTaskID`, `listOrder`) VALUES
(1, 3, 1, 'Acquire Title', 'Acquire title to property and transfer to FNMA.', 5, 2, 1),
(2, 3, 1, 'Cancel HI and Taxes', 'Cancel hazard insurance and taxes.', 1, 3, 2),
(3, 3, 1, 'Pay Final Invoice', 'Pay final attorney invoice.', 1, 4, 3),
(4, 3, 1, 'File Expense Claim', 'File expense claim.', 5, 5, 4),
(5, 3, 1, 'Receive Expense Claim Results', 'Receive expense claim results.', 5, 6, 5),
(6, 3, 1, 'Supplemental Claim', 'Determine if supplemental claim is necessary.', 1, 9, 6),
(7, 3, 1, 'File Supplemental Claim', 'File supplemental claim.', 5, 8, 7),
(8, 3, 1, 'Receive Supplemental Claim Results', 'Receive supplemental claim results.', 5, 6, 8),
(9, 3, 1, 'Loss Analysis', 'Complete loss analysis.', 1, 10, 9),
(10, 3, 1, 'Write-Off', 'Write-off.', 5, NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(11) NOT NULL,
  `firstName` varchar(50) NOT NULL COMMENT 'User''s first name',
  `lastName` varchar(50) NOT NULL COMMENT 'User''s last name',
  `email` varchar(100) NOT NULL COMMENT 'User''s email address used to login',
  `password` varchar(255) NOT NULL COMMENT 'User''s password hashed',
  `isActive` int(1) NOT NULL DEFAULT '1' COMMENT 'User''s status: 0 - inactive; 1 - active',
  `createdDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date the user was created',
  `modifiedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date the user was last modified',
  `roleID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `isActive`, `createdDate`, `modifiedDate`, `roleID`) VALUES
(1, 'Test', 'Person', 'test.person@company.com', '$2y$10$YgbZZQOT3MR7t3Me/jgIk.T.xBigGWGWdbJXq/kxG2EiiovZwneF2', 1, '2018-11-03 18:56:48', '2018-11-03 18:56:48', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ffr`
--
ALTER TABLE `ffr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loanleveltaskdatadate`
--
ALTER TABLE `loanleveltaskdatadate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loanleveltaskdatadecimal`
--
ALTER TABLE `loanleveltaskdatadecimal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loanleveltaskdatatext`
--
ALTER TABLE `loanleveltaskdatatext`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loanleveltasks`
--
ALTER TABLE `loanleveltasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loantypes`
--
ALTER TABLE `loantypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repeattask`
--
ALTER TABLE `repeattask`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roledefinitions`
--
ALTER TABLE `roledefinitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taskdata`
--
ALTER TABLE `taskdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasklist`
--
ALTER TABLE `tasklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roleID` (`roleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ffr`
--
ALTER TABLE `ffr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `loanleveltaskdatadate`
--
ALTER TABLE `loanleveltaskdatadate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `loanleveltaskdatadecimal`
--
ALTER TABLE `loanleveltaskdatadecimal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `loanleveltaskdatatext`
--
ALTER TABLE `loanleveltaskdatatext`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `loanleveltasks`
--
ALTER TABLE `loanleveltasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `loantypes`
--
ALTER TABLE `loantypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `repeattask`
--
ALTER TABLE `repeattask`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `roledefinitions`
--
ALTER TABLE `roledefinitions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `taskdata`
--
ALTER TABLE `taskdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tasklist`
--
ALTER TABLE `tasklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
