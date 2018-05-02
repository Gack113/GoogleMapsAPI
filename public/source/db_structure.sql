SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for slide
-- ----------------------------
DROP TABLE IF EXISTS `slide`;
CREATE TABLE `slide`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(100)  NOT NULL,
  `image` varchar(100)  NOT NULL,
  PRIMARY KEY (`id`)
);

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100)  NOT NULL,
  `gender` varchar(10)  NOT NULL,
  `email` varchar(50)  NOT NULL,
  `address` varchar(100)  NOT NULL,
  `phone_number` varchar(20)  NOT NULL,
  `note` varchar(200)  NOT NULL,
  `lat` float(10, 6) NOT NULL,
  `lng` float(10, 6) NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`)
);

-- ----------------------------
-- Table structure for regions
-- ----------------------------
DROP TABLE IF EXISTS `regions`;
CREATE TABLE `regions`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60)  NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`)
);

-- ----------------------------
-- Table structure for provinces
-- ----------------------------
DROP TABLE IF EXISTS `provinces`;
CREATE TABLE `provinces`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60)  NOT NULL,
  `id_region` int(11) NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_provinces_id_region_regions` FOREIGN KEY (`id_region`) REFERENCES `regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ----------------------------
-- Table structure for districts
-- ----------------------------
DROP TABLE IF EXISTS `districts`;
CREATE TABLE `districts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60)  NOT NULL,
  `id_region` int(11) NOT NULL,
  `id_province` int(11) NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_districts_id_region_regions` FOREIGN KEY (`id_region`) REFERENCES `regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_districts_id_province_provinces` FOREIGN KEY (`id_province`) REFERENCES `provinces` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ----------------------------
-- Table structure for markers
-- ----------------------------
DROP TABLE IF EXISTS `markers`;
CREATE TABLE `markers`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60)  NOT NULL,
  `id_region` int(11) NOT NULL,
  `id_province` int(11) NOT NULL,
  `id_district` int(11) NOT NULL,
  `address` varchar(255)  NOT NULL,
  `phone` int(11) NOT NULL,
  `lat` float(10, 6) NOT NULL,
  `lng` float(10, 6) NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_markers_id_region_regions` FOREIGN KEY (`id_region`) REFERENCES `regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_markers_id_province_provinces` FOREIGN KEY (`id_province`) REFERENCES `provinces` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_markers_id_district_districts` FOREIGN KEY (`id_district`) REFERENCES `districts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE  
);

-- ----------------------------
-- Table structure for type_products
-- ----------------------------
DROP TABLE IF EXISTS `type_products`;
CREATE TABLE `type_products`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100)  NOT NULL,
  `description` text  NOT NULL,
  `image` varchar(255),
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`)
);

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100)  NOT NULL,
  `id_type` int(11) NOT NULL,
  `description` text  NULL,
  `unit_price` float NULL DEFAULT 0,
  `promotion_price` float NULL DEFAULT 0,
  `image` varchar(255)  NULL ,
  `unit` varchar(255)  NULL,
  `new` tinyint(4) NULL DEFAULT 0,
  `slug` varchar(255)  NOT NULL,
  `view` int(11) NULL DEFAULT 0,
  `last_visited` timestamp(0) NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`),
  CONSTRAINT `products_id_type_foreign` FOREIGN KEY (`id_type`) REFERENCES `type_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100)  NOT NULL,
  `description` text  NULL,
  `date_offer` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`)
);

-- ----------------------------
-- Table structure for new_detail
-- ----------------------------
DROP TABLE IF EXISTS `new_detail`;
CREATE TABLE `new_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_new` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_news_new_detail` FOREIGN KEY (`id_new`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_news_products` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ----------------------------
-- Table structure for bill_states
-- ----------------------------
DROP TABLE IF EXISTS `bill_states`;
CREATE TABLE `bill_states`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100)  NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`)
);

-- ----------------------------
-- Table structure for bills
-- ----------------------------
DROP TABLE IF EXISTS `bills`;
CREATE TABLE `bills`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_customer` int(11) NOT NULL,
  `id_marker` int(11) NOT NULL,
  `id_state` int(11) NOT NULL DEFAULT 1,
  `date_order` date NULL,
  `total` float NULL,
  `payment` varchar(255)  NULL,
  `note` varchar(255)  NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_bills_customers` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bills_markers` FOREIGN KEY (`id_marker`) REFERENCES `markers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bills_bill_states` FOREIGN KEY (`id_state`) REFERENCES `bill_states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);
-- ----------------------------
-- Table structure for bill_detail
-- ----------------------------
DROP TABLE IF EXISTS `bill_detail`;
CREATE TABLE `bill_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_bill` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` float NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_bills_bill_detail` FOREIGN KEY (`id_bill`) REFERENCES `bills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bills_products` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ----------------------------
-- Table structure for product_images
-- ----------------------------
DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `new` int(11) NULL ,
  `image` varchar(255)  NULL ,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_products_product_images` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- ----------------------------
-- Table structure for type_users
-- ----------------------------
DROP TABLE IF EXISTS `type_users`;
CREATE TABLE `type_users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255)  NULL ,
  `shop` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255)  NOT NULL,
  `username` varchar(255)  NOT NULL,
  `email` varchar(255)  NOT NULL,
  `password` varchar(255)  NOT NULL,
  `phone` varchar(20)  NULL ,
  `address` varchar(255)  NULL ,
  `remember_token` varchar(255)  NULL ,
  `type` int(11) NOT NULL DEFAULT 8,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_types_users` FOREIGN KEY (`type`) REFERENCES `type_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);
SET FOREIGN_KEY_CHECKS = 1;
