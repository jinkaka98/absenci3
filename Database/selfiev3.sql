-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 05 Agu 2023 pada 14.18
-- Versi server: 10.6.14-MariaDB-cll-lve
-- Versi PHP: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1541084_selfiev3`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `building`
--

CREATE TABLE `building` (
  `building_id` int(8) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `latitude_longtitude` varchar(100) NOT NULL,
  `radius` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `building`
--

INSERT INTO `building` (`building_id`, `code`, `name`, `address`, `latitude_longtitude`, `radius`) VALUES
(1, 'SWUKZ/2021', 'timkoding.com', 'Jakarta Indonesia', '-3.8070092191698577,102.27342758357426', 1000),
(7, 'SW3V7/2022', 'Padang Sambian', 'Jl. Tunjung Sari, Gg menuri II no 3', '-8.6463245,115.1840956', 100),
(9, 'SW7F5/2022', 'Test lokasi 2', 'jl test lokasi 2', '-6.2291968,106.807296', 100),
(10, 'SWRZI/2022', 'Test Lokasi 2', 'jl test lokasi 1', '-6.2291968,106.807296', 100),
(11, 'SWAB1/2023', 'a', 'a', '2.129358,117.4568133', 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cuty`
--

CREATE TABLE `cuty` (
  `cuty_id` int(11) NOT NULL,
  `employees_id` int(11) NOT NULL,
  `cuty_start` date NOT NULL,
  `cuty_end` date NOT NULL,
  `date_work` date NOT NULL,
  `cuty_total` int(5) NOT NULL,
  `cuty_description` varchar(100) NOT NULL,
  `cuty_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cuty`
--

INSERT INTO `cuty` (`cuty_id`, `employees_id`, `cuty_start`, `cuty_end`, `date_work`, `cuty_total`, `cuty_description`, `cuty_status`) VALUES
(3, 6, '2023-05-04', '2023-05-04', '2023-05-05', 2, 'Kerumah nenek', 3),
(4, 6, '2023-07-23', '2023-06-28', '2023-06-29', 2, 'Tes', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employees_code` varchar(20) NOT NULL,
  `employees_email` varchar(30) NOT NULL,
  `employees_password` varchar(100) NOT NULL,
  `employees_name` varchar(50) NOT NULL,
  `position_id` int(5) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `created_login` datetime NOT NULL,
  `created_cookies` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `employees_code`, `employees_email`, `employees_password`, `employees_name`, `position_id`, `shift_id`, `building_id`, `photo`, `created_login`, `created_cookies`) VALUES
(6, 'OM001-2021', 'wijaya@gmail.com', '00f03f70968c0788843b2735310897d06936bb76572b98f344d04d32c6791c24', 'wijaya', 2, 1, 1, '2022-09-17f9376ddb8db938b4e907811a471fc7d4.jpg', '2023-08-04 12:54:32', '8c4dc97fdce1b3a3bc4da7100f4b8fc2'),
(14, '123456789', 'intan@gmail.com', 'acd2bcf0a751e78ba7a1904d55cb26b00b7b5c21ea1c7a91b373c2cf44ae0b29', 'Intan', 1, 1, 1, '2022-09-17b08b9e55bb3a68bb04314e87aede7fcc.jpg', '2021-12-03 14:38:48', '4c6c453e7a58b5fc11908a3916f944e1'),
(15, '17050102030188', 'tim@koding', '33cc10835fca32f3d207abb1d57e0bf8fdfbc12865a0f060834e7a1585badb5c', 'reza arapan', 2, 1, 1, '2022-09-1732a35407213713da65bf3891ce0f9b7e.jpg', '2022-09-17 02:34:53', '-'),
(19, '435438597', 'contohemail@gmail.com', '00f03f70968c0788843b2735310897d06936bb76572b98f344d04d32c6791c24', 'Example', 1, 1, 1, '', '2023-08-04 12:54:32', '8c4dc97fdce1b3a3bc4da7100f4b8fc2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `holiday`
--

CREATE TABLE `holiday` (
  `holiday_id` int(11) NOT NULL,
  `holiday_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `holiday`
--

INSERT INTO `holiday` (`holiday_id`, `holiday_date`) VALUES
(1, '2022-02-28'),
(2, '2022-03-03'),
(4, '2022-07-09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permission`
--

CREATE TABLE `permission` (
  `permission_id` int(11) NOT NULL,
  `employees_id` int(11) NOT NULL,
  `permission_name` varchar(35) NOT NULL,
  `permission_date` date NOT NULL,
  `permission_date_finish` date NOT NULL,
  `permission_description` text NOT NULL,
  `files` varchar(150) NOT NULL,
  `type` varchar(20) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `permission`
--

INSERT INTO `permission` (`permission_id`, `employees_id`, `permission_name`, `permission_date`, `permission_date_finish`, `permission_description`, `files`, `type`, `date`) VALUES
(18, 6, 'wijaya', '2023-05-04', '2023-05-05', 'Sakit maagh', '', 'Izin', '2023-05-04'),
(19, 6, 'wijaya', '2023-07-27', '2023-07-29', 'cek', '', 'Izin', '2023-07-26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `position`
--

CREATE TABLE `position` (
  `position_id` int(5) NOT NULL,
  `position_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `position`
--

INSERT INTO `position` (`position_id`, `position_name`) VALUES
(1, 'STAFF'),
(2, 'ACCOUNTING'),
(7, 'MARKETING');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presence`
--

CREATE TABLE `presence` (
  `presence_id` int(11) NOT NULL,
  `employees_id` int(11) NOT NULL,
  `presence_date` date NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `picture_in` text NOT NULL,
  `picture_out` varchar(150) NOT NULL,
  `present_id` int(11) NOT NULL COMMENT 'Masuk,Pulang,Tidak Hadir',
  `latitude_longtitude_in` varchar(200) NOT NULL,
  `latitude_longtitude_out` varchar(200) NOT NULL,
  `information` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `presence`
--

INSERT INTO `presence` (`presence_id`, `employees_id`, `presence_date`, `time_in`, `time_out`, `picture_in`, `picture_out`, `present_id`, `latitude_longtitude_in`, `latitude_longtitude_out`, `information`) VALUES
(1, 6, '2021-08-10', '21:48:19', '22:45:54', '2021-08-10-in-1628606899-6.jpeg', '2021-08-10-out-1628610354-6.jpeg', 1, '-4.5585849,105.40680789999999', '-4.5585849,105.40680789999999', ''),
(2, 6, '2021-08-11', '00:19:18', '00:22:11', '2021-08-11-in-1628615958-6.jpeg', '2021-08-11-out-1628616131-6.jpeg', 1, '-4.5585849,105.40680789999999', '-4.5585849,105.40680789999999', ''),
(3, 6, '2021-12-03', '14:43:21', '00:00:00', '2021-12-03-in-1638517401-6.jpeg', '', 1, '-5.3870592,105.2803072', '', ''),
(4, 6, '2022-09-09', '22:48:53', '22:51:17', '2022-09-09-in-1662738533-6.jpeg', '2022-09-09-out-1662738677-6.jpeg', 2, '-8.6463083,115.1840895', '-8.6463083,115.1840895', ''),
(5, 6, '2023-05-04', '06:51:18', '00:00:00', '', '', 3, '', '', ''),
(6, 6, '2023-05-05', '06:51:18', '00:00:00', '', '', 3, '', '', ''),
(7, 6, '2023-05-16', '10:08:22', '14:35:06', '2023-05-16-in-1684206502-6.jpeg', '2023-05-16-out-1684206515-6.jpeg', 1, '-3.7995644,102.2695523', '-3.7992395,102.2696073', ''),
(8, 6, '2023-07-17', '14:18:47', '14:19:00', '2023-07-17-in-1689578327-6.jpeg', '2023-07-17-out-1689578340-6.jpeg', 3, '-3.7868456,102.3120415', '-3.7868456,102.3120415', ''),
(11, 6, '2023-07-19', '10:33:57', '00:00:00', '2023-07-19-in-1689737637-6.jpeg', '', 1, '-3.8068899,102.2734648', '', 'Hh'),
(12, 6, '2023-07-27', '14:44:28', '00:00:00', '', '', 3, '', '', ''),
(13, 6, '2023-07-28', '14:44:28', '00:00:00', '', '', 3, '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `present_status`
--

CREATE TABLE `present_status` (
  `present_id` int(6) NOT NULL,
  `present_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `present_status`
--

INSERT INTO `present_status` (`present_id`, `present_name`) VALUES
(1, 'Hadir'),
(2, 'Sakit'),
(3, 'Izin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `shift`
--

CREATE TABLE `shift` (
  `shift_id` int(11) NOT NULL,
  `shift_name` varchar(20) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `shift`
--

INSERT INTO `shift` (`shift_id`, `shift_name`, `time_in`, `time_out`) VALUES
(1, 'FULL TIME', '07:30:00', '14:00:00'),
(5, 'MALAM', '19:00:00', '05:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sw_site`
--

CREATE TABLE `sw_site` (
  `site_id` int(4) NOT NULL,
  `site_url` varchar(100) NOT NULL,
  `site_name` varchar(50) NOT NULL,
  `site_company` varchar(30) NOT NULL,
  `site_manager` varchar(30) NOT NULL,
  `site_director` varchar(30) NOT NULL,
  `site_phone` char(12) NOT NULL,
  `site_address` text NOT NULL,
  `site_description` text NOT NULL,
  `site_logo` varchar(50) NOT NULL,
  `site_email` varchar(30) NOT NULL,
  `site_email_domain` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sw_site`
--

INSERT INTO `sw_site` (`site_id`, `site_url`, `site_name`, `site_company`, `site_manager`, `site_director`, `site_phone`, `site_address`, `site_description`, `site_logo`, `site_email`, `site_email_domain`) VALUES
(1, 'https://selfiev4.timkoding.com/', 'Absensi v.3', 'TIM KODING INDONESIA', 'Reza Wijaya', 'Megi Ardianto', '085383609504', 'Jakarta Indonesia', 'Absensi v.3', 'whiteswlogowebpng.png', 'admin@gmail.com', 'info@timkoding.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `registered` datetime NOT NULL,
  `created_login` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `session` varchar(100) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `browser` varchar(30) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password`, `fullname`, `registered`, `created_login`, `last_login`, `session`, `ip`, `browser`, `level`) VALUES
(1, 'admin', 'admin@gmail.com', '88222999e01f1910a5ac39fa37d3b8b704973d503d0ff7c84d46305b92cfa0f6', 'administrator', '2021-02-03 10:22:00', '2023-08-04 12:48:19', '2023-07-10 13:47:20', '-', '1', 'Google Crome', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_level`
--

CREATE TABLE `user_level` (
  `level_id` int(4) NOT NULL,
  `level_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_level`
--

INSERT INTO `user_level` (`level_id`, `level_name`) VALUES
(1, 'Administrator'),
(2, 'Operator');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`building_id`);

--
-- Indeks untuk tabel `cuty`
--
ALTER TABLE `cuty`
  ADD PRIMARY KEY (`cuty_id`);

--
-- Indeks untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indeks untuk tabel `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indeks untuk tabel `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indeks untuk tabel `presence`
--
ALTER TABLE `presence`
  ADD PRIMARY KEY (`presence_id`);

--
-- Indeks untuk tabel `present_status`
--
ALTER TABLE `present_status`
  ADD PRIMARY KEY (`present_id`);

--
-- Indeks untuk tabel `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`shift_id`);

--
-- Indeks untuk tabel `sw_site`
--
ALTER TABLE `sw_site`
  ADD PRIMARY KEY (`site_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeks untuk tabel `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`level_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `building`
--
ALTER TABLE `building`
  MODIFY `building_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `cuty`
--
ALTER TABLE `cuty`
  MODIFY `cuty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `holiday`
--
ALTER TABLE `holiday`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `permission`
--
ALTER TABLE `permission`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `position`
--
ALTER TABLE `position`
  MODIFY `position_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `presence`
--
ALTER TABLE `presence`
  MODIFY `presence_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `present_status`
--
ALTER TABLE `present_status`
  MODIFY `present_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `shift`
--
ALTER TABLE `shift`
  MODIFY `shift_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `sw_site`
--
ALTER TABLE `sw_site`
  MODIFY `site_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_level`
--
ALTER TABLE `user_level`
  MODIFY `level_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
