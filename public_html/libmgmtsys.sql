-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2020 at 09:03 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `libmgmtsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE `auth` (
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`username`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bkid` int(5) NOT NULL,
  `bkname` varchar(40) NOT NULL,
  `author` varchar(100) NOT NULL,
  `section` varchar(30) NOT NULL,
  `rack` int(3) NOT NULL,
  `row` int(3) NOT NULL,
  `status` varchar(15) NOT NULL,
  `expected` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bkid`, `bkname`, `author`, `section`, `rack`, `row`, `status`, `expected`) VALUES
(3, 'java', 'swamy', 'progg books', 1, 1, 'issued', '2020-02-02'),
(4, 'abc', 'pqr', 'progg bks', 3, 1, 'available', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `issuebk`
--

CREATE TABLE `issuebk` (
  `userid` int(5) NOT NULL,
  `bkid` int(5) NOT NULL,
  `issuedate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `returndate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `issuebk`
--

INSERT INTO `issuebk` (`userid`, `bkid`, `issuedate`, `returndate`) VALUES
(5, 3, '2020-01-16 06:55:53', '2020-02-02');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(5) NOT NULL,
  `uname` varchar(20) NOT NULL,
  `uaddr` varchar(200) NOT NULL,
  `ucontact` varchar(10) NOT NULL,
  `uadhar` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `uname`, `uaddr`, `ucontact`, `uadhar`) VALUES
(5, 'swamy', 'mumbai central', '23456789', '234523452345'),
(6, 'abc', 'pqr xyx', '12345', '12345789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bkid`);

--
-- Indexes for table `issuebk`
--
ALTER TABLE `issuebk`
  ADD PRIMARY KEY (`bkid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bkid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
