-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2023 at 10:02 PM
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
-- Database: `dms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient`
--

CREATE TABLE `tbl_patient` (
  `P_ID` int(32) NOT NULL,
  `P_Name` varchar(16) NOT NULL,
  `P_Gender` varchar(16) NOT NULL,
  `P_Age` int(16) NOT NULL,
  `P_Phone` int(16) NOT NULL,
  `P_Address` varchar(16) NOT NULL,
  `P_RegDate` date NOT NULL DEFAULT current_timestamp(),
  `P_Note` varchar(16) NOT NULL,
  `U_ID` int(32) NOT NULL,
  `PT_ID` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_patient`
--

INSERT INTO `tbl_patient` (`P_ID`, `P_Name`, `P_Gender`, `P_Age`, `P_Phone`, `P_Address`, `P_RegDate`, `P_Note`, `U_ID`, `PT_ID`) VALUES
(1, 'Emran', 'male', 21, 2342343, 'kabul', '2023-05-30', 'sadadsaasd', 1, 4),
(2, 'Ahmad ', 'male ', 21, 12312313, 'dadasd', '2023-05-30', '', 1, 1),
(3, 'Saeed', 'male', 0, 2342343, 'kabul', '2023-05-30', 'sadadsaasd', 1, 4),
(4, 'ali', 'male', 22, 2342343, 'kabul', '2023-05-30', 'sadadsaasd', 2, 1),
(5, 'Eidres Jan', 'Male', 25, 99887711, 'Kabul karti parw', '2023-05-31', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient_balance`
--

CREATE TABLE `tbl_patient_balance` (
  `PB_ID` int(32) NOT NULL,
  `PB_Total` int(16) NOT NULL,
  `PB_Receive` int(16) NOT NULL,
  `PB_ReceiveDate` date NOT NULL DEFAULT current_timestamp(),
  `U_ID` int(32) NOT NULL,
  `P_ID` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_patient_balance`
--

INSERT INTO `tbl_patient_balance` (`PB_ID`, `PB_Total`, `PB_Receive`, `PB_ReceiveDate`, `U_ID`, `P_ID`) VALUES
(5, 500, 300, '2023-05-30', 1, 1),
(10, 1500, 0, '2023-05-30', 2, 2),
(11, 500, 100, '2023-05-30', 2, 3),
(12, 500, 100, '2023-05-30', 1, 1),
(13, 1000, 500, '2023-05-31', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient_treatment`
--

CREATE TABLE `tbl_patient_treatment` (
  `PT_ID` int(32) NOT NULL,
  `PT_Name` varchar(16) NOT NULL,
  `PT_Price` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_patient_treatment`
--

INSERT INTO `tbl_patient_treatment` (`PT_ID`, `PT_Name`, `PT_Price`) VALUES
(1, 'CBC', 1000),
(2, 'BBCS', 1500),
(3, 'ADS', 500),
(4, 'CLEANING', 600);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `UserId` int(32) NOT NULL,
  `Type` varchar(16) NOT NULL,
  `Name` varchar(16) NOT NULL,
  `Passwrod` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`UserId`, `Type`, `Name`, `Passwrod`) VALUES
(1, 'Admin', 'Emran', 'admin'),
(2, 'User', 'Ahmad', 'admin');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_patient`
-- (See below for the actual view)
--
CREATE TABLE `view_patient` (
`P_ID` int(32)
,`P_Name` varchar(16)
,`P_Phone` int(16)
,`P_Address` varchar(16)
,`PT_Name` varchar(16)
,`PB_Total` int(16)
,`PB_Receive` int(16)
);

-- --------------------------------------------------------

--
-- Structure for view `view_patient`
--
DROP TABLE IF EXISTS `view_patient`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_patient`  AS SELECT `p`.`P_ID` AS `P_ID`, `p`.`P_Name` AS `P_Name`, `p`.`P_Phone` AS `P_Phone`, `p`.`P_Address` AS `P_Address`, `c`.`PT_Name` AS `PT_Name`, `x`.`PB_Total` AS `PB_Total`, `x`.`PB_Receive` AS `PB_Receive` FROM ((`tbl_patient` `p` join `tbl_patient_balance` `x`) join `tbl_patient_treatment` `c`) WHERE `p`.`P_ID` = `x`.`P_ID` AND `p`.`PT_ID` = `c`.`PT_ID``PT_ID`  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  ADD PRIMARY KEY (`P_ID`),
  ADD KEY `U_ID` (`U_ID`),
  ADD KEY `PT_ID` (`PT_ID`);

--
-- Indexes for table `tbl_patient_balance`
--
ALTER TABLE `tbl_patient_balance`
  ADD PRIMARY KEY (`PB_ID`),
  ADD KEY `P_ID` (`P_ID`),
  ADD KEY `U_ID` (`U_ID`);

--
-- Indexes for table `tbl_patient_treatment`
--
ALTER TABLE `tbl_patient_treatment`
  ADD PRIMARY KEY (`PT_ID`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  MODIFY `P_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_patient_balance`
--
ALTER TABLE `tbl_patient_balance`
  MODIFY `PB_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_patient_treatment`
--
ALTER TABLE `tbl_patient_treatment`
  MODIFY `PT_ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `UserId` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  ADD CONSTRAINT `tbl_patient_ibfk_1` FOREIGN KEY (`U_ID`) REFERENCES `tbl_user` (`UserId`),
  ADD CONSTRAINT `tbl_patient_ibfk_2` FOREIGN KEY (`PT_ID`) REFERENCES `tbl_patient_treatment` (`PT_ID`);

--
-- Constraints for table `tbl_patient_balance`
--
ALTER TABLE `tbl_patient_balance`
  ADD CONSTRAINT `tbl_patient_balance_ibfk_2` FOREIGN KEY (`P_ID`) REFERENCES `tbl_patient` (`P_ID`),
  ADD CONSTRAINT `tbl_patient_balance_ibfk_3` FOREIGN KEY (`U_ID`) REFERENCES `tbl_user` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
