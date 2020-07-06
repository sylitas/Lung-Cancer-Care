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
-- Cấu trúc bảng cho bảng `ctfilepath`
--

CREATE TABLE `ctfilepath` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `path` varchar(225) NOT NULL,
  `checkpatient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `ctfilepath`
--

INSERT INTO `ctfilepath` (`id`, `date`, `path`, `checkpatient`) VALUES
(2, '2020-07-07 01:45:38', 'ctfiles/Desktop.rar', 30);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `ctfilepath`
--
ALTER TABLE `ctfilepath`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `ctfilepath`
--
ALTER TABLE `ctfilepath`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
