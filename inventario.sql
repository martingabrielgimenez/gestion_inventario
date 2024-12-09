/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `inventario` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `inventario`;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
	(1, 'Electronics', '2024-12-08 06:00:21'),
	(2, 'Ropa', '2024-12-08 06:00:21'),
	(3, 'Alimentos', '2024-12-08 06:00:21'),
	(4, 'Categoría Test', '2024-12-08 08:20:06'),
	(5, 'Muebles', '2024-12-08 08:20:06'),
	(6, 'Array', '2024-12-08 10:51:55');

CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `category` (`id`, `name`, `created_at`) VALUES
	(1, 'Categoría de prueba', '2024-12-08 03:23:57'),
	(2, 'Ropa', '2024-12-08 01:08:36'),
	(3, 'Muebles', '2024-12-08 10:20:47'),
	(5, 'Salud y Belleza', '2024-12-08 10:38:35'),
	(20, 'Electronics', '2024-12-08 02:00:31'),
	(113, 'Alimentos', '2024-12-08 09:40:08'),
	(152, 'Categoría Test', '2024-12-08 12:26:47');

CREATE TABLE IF NOT EXISTS `inventario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `type` enum('in','out') NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category_id` int DEFAULT NULL,
  `stock` int DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_category_id` (`category_id`),
  CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `products` (`id`, `name`, `category_id`, `stock`, `price`, `created_at`) VALUES
	(20, 'Smartphone', 20, 10, 299.99, '2024-12-08 02:00:31'),
	(59, 'camisa', 3, 34, 35.00, '2024-12-08 10:20:56'),
	(60, 'Camiseta', 2, 45, 234.00, '2024-12-08 10:33:59'),
	(82, 'Smartphone', 20, 10, 299.99, '2024-12-08 11:37:32'),
	(85, 'Smartphone', 20, 10, 299.99, '2024-12-08 11:52:41'),
	(87, 'Smartphone', 20, 10, 299.99, '2024-12-08 12:26:47');

CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `user` (`id`, `username`, `password`, `role`, `created_at`) VALUES
	(1, 'martin', '$2y$10$f2fkOgilpHV0j1SdGdkRfuab7qXcChN6TUBLAhDpJfswXqdNGY8DG', 'user', '2024-12-07 17:21:56'),
	(2, 'gabriel', '$2y$10$LmBT9N6aoFqKSBaKBKdmhOdiImTZGju.4JkJt5PLd7NgIZzKOt4T2', 'admin', '2024-12-07 17:22:57'),
	(3, 'mauro', '$2y$10$mfzvbC9yvkOFaabmyz2AxesaTYUZRxq7Mzv7KvBu0LL5FAL8pR1Se', 'admin', '2024-12-07 17:24:16'),
	(4, 'testuser', '$2y$10$0KXYYMEqu4MpgorSWbmmyOqIEa0dgUazzPetnGG2pOd2JSPpIrbmS', 'user', '2024-12-07 17:47:02'),
	(63, 'Marcelo', '$2y$10$jt2qIdNAVY6rc0yNkhPeFeFrey9wezzKccBptkvLlvUG7.0MJX0Bu', 'user', '2024-12-08 12:15:43'),
	(64, 'testuser67559087f252e', '$2y$10$znIdSJTglxq5jYv5CbjwiOitmgQ98455R9DP3QRwFCUVjdMJCBeUa', 'user', '2024-12-08 12:26:48'),
	(65, 'Marisa', '$2y$10$SWbcBSt6O.oX0vaAZPayH.K6f60j/7XbwMjYFOsWE7ZTomir2Qcci', 'user', '2024-12-08 12:37:23');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
