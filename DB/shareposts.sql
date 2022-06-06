-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jun 06, 2022 at 04:06 PM
-- Server version: 8.0.29
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shareposts`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_post`
--

CREATE TABLE `t_post` (
  `ID` int NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `UserFK` int NOT NULL,
  `CreationDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `t_post`
--

INSERT INTO `t_post` (`ID`, `Title`, `Description`, `UserFK`, `CreationDate`) VALUES
(3, 'Prima postare', 'Continut prima postare', 5, '2022-06-06 19:00:37');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `ID` int NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `CreationDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`ID`, `Name`, `Email`, `Password`, `CreationDate`) VALUES
(5, 'Cosmin Ionite', 'cosmin.ionite@gmail.com', '$2y$10$QvjXVVCmBK187U8tLeRo7.BY0zU6cE54TGrIpJsX7dmFYM6P/E.Va', '2022-06-06 16:00:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_post`
--
ALTER TABLE `t_post`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserFK` (`UserFK`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_post`
--
ALTER TABLE `t_post`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_post`
--
ALTER TABLE `t_post`
  ADD CONSTRAINT `t_post_ibfk_1` FOREIGN KEY (`UserFK`) REFERENCES `t_user` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
