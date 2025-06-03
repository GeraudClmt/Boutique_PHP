-- Adminer 5.3.0 MariaDB 10.11.11-MariaDB-0ubuntu0.24.04.2 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `Store`;
CREATE DATABASE `Store` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `Store`;

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(255) NOT NULL,
  `customers_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_fk2` (`customers_id`),
  CONSTRAINT `addresses_fk2` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `carrier`;
CREATE TABLE `carrier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `max_weight` int(11) NOT NULL,
  `shipping_cost` int(11) NOT NULL,
  `tracking` int(11) NOT NULL,
  `increase_shipping` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `carrier` (`id`, `name`, `max_weight`, `shipping_cost`, `tracking`, `increase_shipping`) VALUES
(1,	'Colissimo',	10000,	300,	1,	400),
(2,	'Chronopost',	1200,	15,	0,	0),
(3,	'Mondial Relay',	3000,	25,	1,	30),
(4,	'DHL',	3500,	17,	0,	0),
(5,	'UPS',	6000,	25,	1,	27),
(6,	'GLS',	600,	10,	1,	15);

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categories` (`id`, `name`, `image_url`) VALUES
(1,	'EPI',	'https://www.montagnes-magazine.com/media/Pedago/entretenir_epi3.jpg'),
(2,	'Accessoire',	'https://www.trophee-serrechevalier.com/wp-content/uploads/2022/03/0-2-550x325.jpg'),
(3,	'Utile',	'https://www.visionalis.fr/medias/images/lunettes-d-alpinisme-a-la-vue.jpg');

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(10) NOT NULL,
  `last_name` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `password`, `phone_number`) VALUES
(1,	'Chuck',	'Norris',	'chuck.norris.gmail.com',	'1234',	12345678),
(2,	'Charlize',	'Theron',	'charlize.theron@gmail.com',	'1234',	12345678),
(3,	'Ryan',	'Goslin',	'ryan.goslin@gmail.com',	'1234',	12345678);

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) DEFAULT NULL,
  `batch` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2020_11_24_145812_init_playground',	1);

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL DEFAULT 1,
  `total` float NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `shipping_cost` float NOT NULL,
  `total_weight` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `carrier_id` int(11) NOT NULL,
  `status` varchar(255) DEFAULT 'actif',
  PRIMARY KEY (`id`),
  KEY `orders_fk6` (`customer_id`),
  KEY `orders_fk7` (`carrier_id`),
  CONSTRAINT `orders_fk6` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `orders_fk7` FOREIGN KEY (`carrier_id`) REFERENCES `carrier` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `orders` (`id`, `number`, `total`, `date`, `shipping_cost`, `total_weight`, `customer_id`, `carrier_id`, `status`) VALUES
(1,	456875,	120,	'2025-05-28 10:08:51',	5,	3000,	1,	1,	'actif'),
(2,	452169,	600,	'2025-05-19 09:08:31',	10,	3600,	1,	1,	'actif'),
(3,	854639,	150,	'2025-05-19 11:08:21',	10,	2200,	2,	1,	'actif'),
(4,	8456923,	520,	'2025-05-19 10:08:51',	5,	3200,	2,	1,	'actif'),
(5,	856974,	600,	'2025-05-28 11:08:11',	5,	2200,	2,	1,	'actif');

DROP TABLE IF EXISTS `order_product`;
CREATE TABLE `order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_product_fk3` (`product_id`),
  KEY `order_product_fk4` (`order_id`),
  CONSTRAINT `order_product_fk3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `order_product_fk4` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `order_product` (`id`, `product_id`, `quantity`, `order_id`) VALUES
(1,	1,	1,	1),
(2,	3,	2,	1),
(3,	13,	1,	2),
(4,	10,	2,	2),
(5,	1,	1,	3),
(6,	10,	1,	3),
(7,	3,	2,	4),
(8,	13,	1,	4),
(9,	1,	1,	5),
(10,	12,	1,	5);

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `description` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `availability` int(255) NOT NULL,
  `categories_id` int(255) NOT NULL,
  `discount` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_id` (`categories_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` (`id`, `name`, `price`, `description`, `weight`, `img_url`, `quantity`, `availability`, `categories_id`, `discount`) VALUES
(1,	'Cordes',	112.99,	'Corde d\'assurance',	1000,	'https://contents.mediadecathlon.com/p2615071/k\\$b2f1933c71b675afddb50d80df8b4a9b/sq/corde-descalade-95-mm-x-80-m-vertika.jpg?format=auto&f=800x0',	10,	1,	1,	2),
(2,	'Piolet',	109.99,	'Piolet avec une supper acroche',	1000,	'https://skitour.fr/matos/photos/5508.jpg',	10,	1,	1,	0),
(3,	'Crampons',	110.99,	'Des crampons super confortable',	500,	'https://www.montagnes-magazine.com/media/MATOS/2021/novembre/petzl.jpeg',	1,	1,	1,	10),
(4,	'Corde',	149.99,	'Corde de 100m',	500,	'https://www.montania-sport.com/46348-thickbox_default/corde-a-simple-escalade-80m-karma-98mm-solid-orange-beal.jpg',	1,	1,	1,	0),
(5,	'Casque',	19.99,	'Casque aerodynamique',	500,	'https://glisshop-glisshop-fr-storage.omn.proximis.com/Imagestorage/imagesSynchro/735/735/be2c82cdff7da0ca122e9a1565fe7d0d73cc7b64_H25PETZESC4453545_0.jpeg',	1,	0,	1,	2),
(6,	'Gourde',	9.99,	'Gourde pour toujours avoir de l\'eau en montagne',	500,	'https://shop-ta-gourde.com/cdn/shop/products/gourde_motif_montagne_1200x1200.jpg?v=1576860033',	1,	0,	1,	20),
(7,	'Lampe',	13.99,	'Lanpe haute autonomie',	500,	'https://www.ekipro.fr/7020-productlist/lampe-frontale-rechargeable-par-usb-noir.jpg',	0,	1,	2,	0),
(8,	'Harnais',	34.99,	'Harnais haute résistance',	500,	'https://www.montagnes-magazine.com/media/guide_matos/accessoire/2024/blueice_2024_cuestaw.jpg',	0,	1,	2,	0),
(9,	'Sac à dos',	52.99,	'Sac étanche',	1200,	'https://www.pluceo.fr/4440-home_default/camp-sac-de-transport-epi-cargo-60l-blue.jpg',	2,	1,	2,	0),
(10,	'Sac',	156.99,	'Sac grosse capacité',	1200,	'https://media.rs-online.com/t_large/Y2442194-01.jpg',	2,	1,	2,	0),
(11,	'Lunette C4',	82.99,	'Lunette classe 4 ',	1200,	'https://www.visionalis.fr/medias/images/lunettes-de-montagne-avec-verres-correcteurs-julbo-legacy-noir-blanc.jpg',	5,	1,	3,	10),
(12,	'Lunette',	12.99,	'Lunette moche',	1200,	'https://www.silium-epi.com/wp-content/uploads/2020/09/LUNETTES-CONTOUR-POLARISE-BOLLE-600x450.jpg',	5,	1,	3,	0),
(13,	'Sac à pof',	19.99,	'Sac ultra léger',	1200,	'https://www.grimper.com/media/guide_equipement/img_2021/arcteryx_2021_ion_chalkbag_large__prop_1200x630.jpg',	5,	1,	3,	0);

DROP TABLE IF EXISTS `sql_playground_test`;
CREATE TABLE `sql_playground_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `batch` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `sql_playground_test` (`id`, `name`, `batch`) VALUES
(1,	'Campus Numérique In The Alps',	1);

-- 2025-06-03 13:51:54 UTC
