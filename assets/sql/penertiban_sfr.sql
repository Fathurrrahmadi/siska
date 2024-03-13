-- -- phpMyAdmin SQL Dump
-- -- version 5.2.1
-- -- https://www.phpmyadmin.net/
-- --
-- -- Host: 127.0.0.1
-- -- Waktu pembuatan: 01 Mar 2024 pada 05.42
-- -- Versi server: 10.4.28-MariaDB
-- -- Versi PHP: 8.1.17

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
-- SET time_zone = "+00:00";


-- /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
-- /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
-- /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
-- /*!40101 SET NAMES utf8mb4 */;

-- --
-- -- Database: `siska_a`
-- --

-- -- --------------------------------------------------------

-- --
-- -- Struktur dari tabel `penertiban_sfr`
-- --

-- CREATE TABLE `penertiban_sfr` (
--   `idsfr` int(11) NOT NULL,
--   `NAMA PENGGUNA` varchar(255) NOT NULL,
--   `FREKUENSI(MHz)` double DEFAULT NULL,
--   `DINAS` varchar(255) NOT NULL DEFAULT '',
--   `SUBSERVICE` varchar(255) DEFAULT NULL,
--   `LOKASI` varchar(255) NOT NULL,
--   `PROVINSI` varchar(255) NOT NULL,
--   `KAB/KOTA` varchar(255) NOT NULL,
--   `JENIS PELANGGARAN` enum('ILEGAL','LEGAL') DEFAULT NULL,
--   `TINDAKAN` varchar(255) NOT NULL,
--   `STATUS` varchar(255) NOT NULL,
--   `TGL OPERASI STASIUN` date DEFAULT NULL,
--   `NO ISR SETELAH PENINDAKAN` varchar(255) NOT NULL,
--   `NO SURAT PENINDAKAN` varchar(255) NOT NULL,
--   `TANGGAL TINDAKAN` date DEFAULT NULL,
--   `KETERANGAN` text DEFAULT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --
-- -- Dumping data untuk tabel `penertiban_sfr`
-- --

-- INSERT INTO `penertiban_sfr` (`idsfr`, `NAMA PENGGUNA`, `FREKUENSI(MHz)`, `DINAS`, `SUBSERVICE`, `LOKASI`, `PROVINSI`, `KAB/KOTA`, `JENIS PELANGGARAN`, `TINDAKAN`, `STATUS`, `TGL OPERASI STASIUN`, `NO ISR SETELAH PENINDAKAN`, `NO SURAT PENINDAKAN`, `TANGGAL TINDAKAN`, `KETERANGAN`) VALUES
-- (1001, 'Yayasan Pendidikan Bina Prestasi Mandiri (BGV FM)', 98.4, 'BROADCAST', 'EZ', 'Bandung', 'KEPULAUAN RIAU', 'KARIMUN', 'ILEGAL', 'PERINGATAN', 'OF AIR', '2023-03-09', '234ERS', '2345', '2023-03-15', 'PPNS Loka Monitor Padang telah membuat Berita Acara Pemeriksaan dan memberikan peringatan agar menghentikan sementara penggunaan frekuensi radio sampai Izin Stasiun Radio (ISR) dimiliki'),
-- (1002, 'Yayasan Pendidikan Bina Bandung (BGV SHF)', 98.44, 'BROADCAST', 'AM', 'Jakarta Selatan', 'JAKARTA', 'TANJUNG PERIOK', 'LEGAL', 'PERINGATAN', 'ON AIR', '2023-03-01', '243EKR', '3243', '2023-11-28', 'PPNS Loka Monitor Padang telah membuat Berita Acara Pemeriksaan dan memberikan peringatan agar menghentikan sementara penggunaan frekuensi radio sampai Izin Stasiun Radio (ISR) dimiliki'),
-- (1003, 'Yayasan Pendidikan Bina Prestasi Mandiri SOLO (BGV FM)', 92.43, 'BROADCAST', 'FM', 'Jakarta Timur', 'JAKARTA', 'PONDOK GEDE', 'LEGAL', 'PERINGATAN', 'OF AIR', '2024-03-04', '243EKR', '3243', '2023-11-28', 'PPNS Loka Monitor Padang telah membuat Berita Acara Pemeriksaan dan memberikan peringatan agar menghentikan sementara penggunaan frekuensi radio sampai Izin Stasiun Radio (ISR) dimiliki'),
-- (1004, 'Yayasan Pendidikan Bina Prestasi Mandiri (BGV FM)', 98.46, 'BROADCAST', 'FM', 'Cibubur', 'KEPULAUAN RIAU', 'KARIMUN', 'ILEGAL', 'PERINGATAN', 'OF AIR', '2024-03-07', '243EKR', '3243', '2023-11-28', 'PPNS Loka Monitor Padang telah membuat Berita Acara Pemeriksaan dan memberikan peringatan agar menghentikan sementara penggunaan frekuensi radio sampai Izin Stasiun Radio (ISR) dimiliki'),
-- (1005, 'Yayasan Pendidikan Bina Prestasi Mandiri ', 98.34, 'BROADCAST', 'FM', 'Batam', 'JAWA BARAT', 'PEKAN BARU ', 'ILEGAL', 'PERINGATAN', 'ON AIR ', '2024-03-01', '234RXZ', '2432', '2023-03-08', 'PPNS Loka Monitor Padang telah membuat Berita Acara Pemeriksaan dan memberikan peringatan agar menghentikan sementara penggunaan frekuensi radio sampai  Izin Stasiun Radio (ISR) dimiliki.'),
-- (1006, 'Bina Bangsa Mandiri ', 34.34, 'BROADCAST', 'EK', 'Bekasi', 'BEKASI', 'BEKASI', 'LEGAL', 'PERINGATAN', 'OFF AIR', '2023-03-22', '324EYS', '2346', '2023-03-31', 'SUDAH MEMBUAT BERITA ACARA '),
-- (1007, 'Tester', 43.54, 'BROADCAST', 'FM', 'Bandung', 'JAWA BARAT', 'BUAHBATU', 'ILEGAL', 'PERINGATAN', 'ON AIR', '2024-03-23', '267ESZ', '3242', '2023-03-29', 'PPNS Loka Monitor Padang telah membuat Berita Acara Pemeriksaan dan memberikan peringatan agar menghentikan sementara penggunaan frekuensi radio sampai  Izin Stasiun Radio (ISR) dimiliki.');

-- --
-- -- Indexes for dumped tables
-- --

-- --
-- -- Indeks untuk tabel `penertiban_sfr`
-- --
-- ALTER TABLE `penertiban_sfr`
--   ADD PRIMARY KEY (`idsfr`);

-- --
-- -- AUTO_INCREMENT untuk tabel yang dibuang
-- --

-- --
-- -- AUTO_INCREMENT untuk tabel `penertiban_sfr`
-- --
-- ALTER TABLE `penertiban_sfr`
--   MODIFY `idsfr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1013;
-- COMMIT;

-- /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
-- /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
-- /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
