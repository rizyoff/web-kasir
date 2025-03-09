-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_sekolah
CREATE DATABASE IF NOT EXISTS `db_sekolah` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_sekolah`;

-- Dumping structure for table db_sekolah.db_kasirbarang
CREATE TABLE IF NOT EXISTS `db_kasirbarang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Barcode` varchar(100) DEFAULT NULL,
  `nm_barang` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `stock` int DEFAULT NULL,
  `harga_beli` int DEFAULT NULL,
  `harga_jual` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_sekolah.db_kasirbarang: ~1 rows (approximately)
INSERT INTO `db_kasirbarang` (`id`, `Barcode`, `nm_barang`, `keterangan`, `stock`, `harga_beli`, `harga_jual`) VALUES
	(24, 'V9E0438991', 'hp', 'aeu', 0, 10000, 10500);

-- Dumping structure for table db_sekolah.detail_transaksi
CREATE TABLE IF NOT EXISTS `detail_transaksi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_barang` int DEFAULT NULL,
  `kd_penjualan` varchar(11) DEFAULT NULL,
  `jmlh` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_barang` (`id_barang`),
  KEY `kd_penjualan` (`kd_penjualan`),
  CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `db_kasirbarang` (`id`),
  CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`kd_penjualan`) REFERENCES `penjualan` (`kd_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_sekolah.detail_transaksi: ~1 rows (approximately)
INSERT INTO `detail_transaksi` (`id`, `id_barang`, `kd_penjualan`, `jmlh`) VALUES
	(92, 24, 'TRN0058', 2);

-- Dumping structure for table db_sekolah.kode_transaksi
CREATE TABLE IF NOT EXISTS `kode_transaksi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_sekolah.kode_transaksi: ~2 rows (approximately)
INSERT INTO `kode_transaksi` (`id`, `kode_transaksi`) VALUES
	(1, 'A00001'),
	(2, 'A00002'),
	(3, 'A00003');

-- Dumping structure for table db_sekolah.penjualan
CREATE TABLE IF NOT EXISTS `penjualan` (
  `kd_transaksi` varchar(11) NOT NULL,
  `tgl_transaksi` datetime DEFAULT NULL,
  `nm_pembeli` varchar(100) DEFAULT NULL,
  `total_belanja` int DEFAULT NULL,
  `uang_bayar` int DEFAULT NULL,
  `kembalian` int DEFAULT NULL,
  PRIMARY KEY (`kd_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_sekolah.penjualan: ~14 rows (approximately)
INSERT INTO `penjualan` (`kd_transaksi`, `tgl_transaksi`, `nm_pembeli`, `total_belanja`, `uang_bayar`, `kembalian`) VALUES
	('TRN0030', '2024-10-11 00:00:00', 'rizky', 350000, 400000, 50000),
	('TRN0031', '2024-10-11 00:00:00', 'shevan', 23350000, 24000000, 650000),
	('TRN0032', '2024-10-11 00:00:00', 'khelvin', 350000, 360000, 10000),
	('TRN0033', '2024-10-11 00:00:00', 'azka', 700000, 800000, 100000),
	('TRN0034', '2024-10-11 00:00:00', 'dami', 23000000, 24000000, 1000000),
	('TRN0035', '2024-10-12 00:00:00', 'wkwwk', 23000000, 24000000, 1000000),
	('TRN0036', '2024-10-12 00:00:00', 'wetw', 11500000, 12000000, 500000),
	('TRN0037', '2024-10-12 00:00:00', 'afef', 3600000, 4000000, 400000),
	('TRN0040', '2024-10-12 00:00:00', 'aegewg', 600000, 1000000, 400000),
	('TRN0044', '2024-10-12 00:00:00', 'kjegfe', 15000, 30000, 15000),
	('TRN0045', '2024-10-12 00:00:00', 'avgaeg', 15000, 20000, 5000),
	('TRN0049', '2024-10-13 00:00:00', 'radit', 10000, 11000, 1000),
	('TRN0050', NULL, 'knrnrkhnyj', NULL, NULL, NULL),
	('TRN0058', '2024-10-13 05:04:52', 'egljewl', 21000, 22000, 1000);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
