-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 16-05-2024 a las 05:11:16
-- Versión del servidor: 8.4.0
-- Versión de PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `osms_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adminlogin_tb`
--

CREATE TABLE `adminlogin_tb` (
  `a_login_id` int NOT NULL,
  `a_name` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `a_email` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `a_password` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Volcado de datos para la tabla `adminlogin_tb`
--

INSERT INTO `adminlogin_tb` (`a_login_id`, `a_name`, `a_email`, `a_password`) VALUES
(1, 'Admin Kumar', 'admin@admin.com', '123456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assets_tb`
--

CREATE TABLE `assets_tb` (
  `pid` int NOT NULL,
  `pname` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `pdop` date NOT NULL,
  `pava` int NOT NULL,
  `ptotal` int NOT NULL,
  `poriginalcost` int NOT NULL,
  `psellingcost` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Volcado de datos para la tabla `assets_tb`
--

INSERT INTO `assets_tb` (`pid`, `pname`, `pdop`, `pava`, `ptotal`, `poriginalcost`, `psellingcost`) VALUES
(1, 'Keyboard', '2018-10-03', 3, 10, 400, 500),
(3, 'Mouse', '2018-10-02', 18, 30, 500, 600),
(4, 'Rode Mic', '2018-10-20', 9, 10, 15000, 18000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assignwork_tb`
--

CREATE TABLE `assignwork_tb` (
  `rno` int NOT NULL,
  `request_id` int NOT NULL,
  `request_info` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `request_desc` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_name` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_add1` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_add2` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_city` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_state` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_zip` int NOT NULL,
  `requester_email` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_mobile` bigint NOT NULL,
  `assign_tech` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `assign_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Volcado de datos para la tabla `assignwork_tb`
--

INSERT INTO `assignwork_tb` (`rno`, `request_id`, `request_info`, `request_desc`, `requester_name`, `requester_add1`, `requester_add2`, `requester_city`, `requester_state`, `requester_zip`, `requester_email`, `requester_mobile`, `assign_tech`, `assign_date`) VALUES
(6, 49, 'Mic not working', 'my mic is not working', 'Jay', '6565', 'Col', 'Bokaro', 'Jh', 6565, 'jay@gmail.com', 656567, 'Jay Kisan', '2018-10-14'),
(7, 50, 'Jack and Jones', 'Hello There have you seen this movie', 'Raj', '123', 'Sector Five', 'Bokaro', 'Jharkhand', 123456, 'raj@gmail.com', 234234234, 'Kabir', '2018-10-16'),
(8, 50, 'Jack and Jones', 'Hello There have you seen this movie', 'Raj', '123', 'Sector Five', 'Bokaro', 'Jharkhand', 123456, 'raj@gmail.com', 234234234, 'Jay', '2018-10-21'),
(9, 52, 'LCD Not working', 'my lcd is not working properly', 'Rahul', 'HOuse No. 123', 'Railway', 'Bokaro', 'Jh', 12345, 'rahul@gmail.com', 234566, 'Kunal', '2018-10-21'),
(10, 52, 'Rode Mic Note Working', 'my rode mic is not working properly', 'Sam', 'house no 234', 'Sec 3', 'Kolkata', 'West Bengal', 674534, 'user@gmail.com', 1234566782, 'Tech1', '2018-10-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer_tb`
--

CREATE TABLE `customer_tb` (
  `custid` int NOT NULL,
  `custname` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `custadd` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `cpname` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `cpquantity` int NOT NULL,
  `cpeach` int NOT NULL,
  `cptotal` int NOT NULL,
  `cpdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Volcado de datos para la tabla `customer_tb`
--

INSERT INTO `customer_tb` (`custid`, `custname`, `custadd`, `cpname`, `cpquantity`, `cpeach`, `cptotal`, `cpdate`) VALUES
(1, 'Shukla', 'Bokaro', 'Mouse', 1, 600, 600, '2018-10-13'),
(2, 'Pandey ji', 'Ranchi', 'Mouse', 2, 600, 600, '2018-10-13'),
(3, 'Musaddi Lal', 'Bokaro', 'Mouse', 5, 600, 3000, '2018-10-13'),
(4, 'Jay Ho', 'Ranchi', 'Mouse', 2, 600, 1200, '2018-10-13'),
(5, 'something', 'somethingadd', 'Mouse', 1, 600, 600, '2018-10-13'),
(6, 'someone', 'someoneadd', 'Keyboard', 1, 500, 500, '2018-10-13'),
(7, 'jay', 'jay ho', 'Keyboard', 1, 500, 500, '2018-10-09'),
(8, 'Jay', 'Bokaro', 'Keyboard', 2, 500, 1000, '2018-10-21'),
(9, 'Kumar', 'Bokaro', 'Keyboard', 1, 500, 500, '2018-10-20'),
(10, 'kkk', 'asdsa', 'Keyboard', 1, 500, 500, '2018-10-20'),
(11, 'Shukla Ji', 'Ranchi', 'Samsung LCD', 1, 12000, 12000, '2018-10-20'),
(19, 'sdsads', 'dasdsa', 'Keyboard', 1, 500, 500, '2018-10-20'),
(20, 'asdas', 'asdsad', 'Keyboard', 1, 500, 500, '2018-10-20'),
(21, 'dsadas', 'asdasd', 'Samsung LCD', 1, 12000, 12000, '2018-10-20'),
(22, 'sdfsdf', 'dfsdf', 'Samsung LCD', 1, 12000, 12000, '2018-10-20'),
(23, 'Ramu', 'sadsad', 'Samsung LCD', 1, 12000, 12000, '2018-10-20'),
(24, 'gfdgfdg', 'fgfdgfdg', 'Samsung LCD', 1, 12000, 12000, '2018-10-20'),
(25, 'rrr', 'fgdf', 'Mouse', 1, 600, 600, '2018-10-20'),
(26, 'Jay', 'ranchi', 'Samsung LCD', 1, 12000, 12000, '2018-10-20'),
(27, 'dfsdfsd', 'sdfdsf', 'Mouse', 1, 600, 600, '2018-10-20'),
(28, 'Kunal', 'Ranchi', 'Rode Mic', 1, 18000, 18000, '2018-10-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requesterlogin_tb`
--

CREATE TABLE `requesterlogin_tb` (
  `r_login_id` int NOT NULL,
  `r_name` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `r_email` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `r_password` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Volcado de datos para la tabla `requesterlogin_tb`
--

INSERT INTO `requesterlogin_tb` (`r_login_id`, `r_name`, `r_email`, `r_password`) VALUES
(9, '  Rajesh', 'raj@gmail.com', 'user'),
(10, '  User', 'user@gmail.com', 'user'),
(11, 'Jay', 'jay@gmail.com', 'jay123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `submitrequest_tb`
--

CREATE TABLE `submitrequest_tb` (
  `request_id` int NOT NULL,
  `request_info` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `request_desc` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_name` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_add1` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_add2` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_city` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_state` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_zip` int NOT NULL,
  `requester_email` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `requester_mobile` bigint NOT NULL,
  `request_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Volcado de datos para la tabla `submitrequest_tb`
--

INSERT INTO `submitrequest_tb` (`request_id`, `request_info`, `request_desc`, `requester_name`, `requester_add1`, `requester_add2`, `requester_city`, `requester_state`, `requester_zip`, `requester_email`, `requester_mobile`, `request_date`) VALUES
(50, 'Jack and Jones', 'Hello There have you seen this movie', 'Raj', '123', 'Sector Five', 'Bokaro', 'Jharkhand', 123456, 'raj@gmail.com', 234234234, '2018-10-13'),
(51, 'asdsadsa', 'asdsadsa', 'dasdsad', 'asdasd', 'sdsadsa', 'asdsad', 'sadasd', 1413123, 'dsadas@gmail.com', 4131323, '2018-10-20'),
(52, 'Rode Mic Note Working', 'my rode mic is not working properly', 'Sam', 'house no 234', 'Sec 3', 'Kolkata', 'West Bengal', 674534, 'user@gmail.com', 1234566782, '2018-10-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `technician_tb`
--

CREATE TABLE `technician_tb` (
  `empid` int NOT NULL,
  `empName` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `empCity` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `empMobile` bigint NOT NULL,
  `empEmail` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Volcado de datos para la tabla `technician_tb`
--

INSERT INTO `technician_tb` (`empid`, `empName`, `empCity`, `empMobile`, `empEmail`) VALUES
(12, 'Tech12', 'Delhi 4', 1234, 'tech@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adminlogin_tb`
--
ALTER TABLE `adminlogin_tb`
  ADD PRIMARY KEY (`a_login_id`);

--
-- Indices de la tabla `assets_tb`
--
ALTER TABLE `assets_tb`
  ADD PRIMARY KEY (`pid`);

--
-- Indices de la tabla `assignwork_tb`
--
ALTER TABLE `assignwork_tb`
  ADD PRIMARY KEY (`rno`);

--
-- Indices de la tabla `customer_tb`
--
ALTER TABLE `customer_tb`
  ADD PRIMARY KEY (`custid`);

--
-- Indices de la tabla `requesterlogin_tb`
--
ALTER TABLE `requesterlogin_tb`
  ADD PRIMARY KEY (`r_login_id`);

--
-- Indices de la tabla `submitrequest_tb`
--
ALTER TABLE `submitrequest_tb`
  ADD PRIMARY KEY (`request_id`);

--
-- Indices de la tabla `technician_tb`
--
ALTER TABLE `technician_tb`
  ADD PRIMARY KEY (`empid`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adminlogin_tb`
--
ALTER TABLE `adminlogin_tb`
  MODIFY `a_login_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `assets_tb`
--
ALTER TABLE `assets_tb`
  MODIFY `pid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `assignwork_tb`
--
ALTER TABLE `assignwork_tb`
  MODIFY `rno` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `customer_tb`
--
ALTER TABLE `customer_tb`
  MODIFY `custid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `requesterlogin_tb`
--
ALTER TABLE `requesterlogin_tb`
  MODIFY `r_login_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `submitrequest_tb`
--
ALTER TABLE `submitrequest_tb`
  MODIFY `request_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `technician_tb`
--
ALTER TABLE `technician_tb`
  MODIFY `empid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
