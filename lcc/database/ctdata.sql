-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 06, 2020 lúc 09:13 PM
-- Phiên bản máy phục vụ: 10.4.11-MariaDB
-- Phiên bản PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `lcc`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ctdata`
--

CREATE TABLE `ctdata` (
  `id` int(11) NOT NULL,
  `checkaccount` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `id-patient` varchar(40) NOT NULL,
  `typedata` char(2) NOT NULL DEFAULT 'CT',
  `name` varchar(40) NOT NULL,
  `gender` char(1) DEFAULT 'n',
  `birthday` date DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `phonenumber` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `ctdata`
--

INSERT INTO `ctdata` (`id`, `checkaccount`, `date`, `id-patient`, `typedata`, `name`, `gender`, `birthday`, `address`, `phonenumber`) VALUES
(30, 4, '2020-07-06 22:27:08', 'K1.171057995', 'CT', 'Nguyen Tuan Duy', 'm', '1999-06-12', '87, Hà Trì 4, Hà Cầu, Hà Đông, Hà Nội', '0834120699'),
(31, 4, '2020-07-06 22:47:07', 'K1.171050199', 'CT', 'zxzxa', 'n', '1111-12-31', 'Ha Noi', '0123412069');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `ctdata`
--
ALTER TABLE `ctdata`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `ctdata`
--
ALTER TABLE `ctdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
