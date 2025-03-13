--
-- Table structure for table `orders`
--
CREATE TABLE IF NOT EXISTS `customer`
(
	`customer_id`   INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`customer_name` VARCHAR(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `address_type`
(
	`address_type_id`  INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`address_type_key` VARCHAR(30) NOT NULL,
	UNIQUE KEY (`address_type_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `address`
(
	`address_id`  INT PRIMARY KEY AUTO_INCREMENT,
	`address`     VARCHAR(255) NOT NULL,
	`address_type_id` INT(10) UNSIGNED NOT NULL,
	`customer_id` INT(10) UNSIGNED NOT NULL,
	CONSTRAINT FK_customer_id FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
	CONSTRAINT FK_address_type_id FOREIGN KEY (`address_type_id`) REFERENCES `address_type` (`address_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `order_status`
(
	`order_status_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`order_status_key` VARCHAR(20) NOT NULL,
	UNIQUE KEY (`order_status_key`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `order`
(
	`order_id`     INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`customer_id`  INT(10) UNSIGNED NOT NULL,
	`order_status_id` INT(10) UNSIGNED NOT NULL,
	`order_date`   DATETIME    NOT NULL,
	CONSTRAINT FK_order_customer_id FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
	CONSTRAINT FK_order_status_id FOREIGN KEY (`order_status_id`) REFERENCES `order_status` (`order_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `product_category`
(
	`product_category_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`product_category_name` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `product` (
	`product_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`product_name` VARCHAR(255) NOT NULL,
	`product_category_id` INT(10) UNSIGNED NOT NULL,
	`product_image` VARCHAR(255),
	CONSTRAINT FK_product_category_id FOREIGN KEY (`product_category_id`) REFERENCES `product_category` (`product_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `product_size` (
	`product_size_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`product_id` INT(10) UNSIGNED NOT NULL,
	`product_size_height` SMALLINT,
	`product_size_width` SMALLINT,
	CONSTRAINT FK_product_size_product_id FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `order_item`
(
	`order_item_id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`order_id`      INT(10) UNSIGNED NOT NULL,
	`product_id`    INT(10) UNSIGNED NOT NULL,
	`product_size_id` INT(10) UNSIGNED NOT NULL,
	`quantity`      INT            NOT NULL,
	`price`         DECIMAL(10, 2) NOT NULL,
	CONSTRAINT FK_order_id FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`),
	CONSTRAINT FK_product_id FOREIGN KEY (`product_id`) REFERENCES `product`(`product_id`),
	CONSTRAINT FK_product_size_id FOREIGN KEY (`product_size_id`) REFERENCES `product_size` (`product_size_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data for table `orders`
--

INSERT INTO `customer` (`customer_id`, `customer_name`)
VALUES
	(1000001, 'Bruce Wayne'),
	(1000002, 'Peter Parker');

INSERT INTO `address_type` (`address_type_key`) VALUES ('delivery'), ('invoice');

INSERT INTO `address` (`address`, `address_type_id`, `customer_id`)
VALUES
	('Bruce Wayne, 1007 Mountain Drive, Gotham', 1, 1000001),
	('Bruce Wayne, 1007 Mountain Drive, Gotham', 2, 1000001),
	('Maybelle Parker, 15th Street, Queens, New York City, New York', 1, 1000002),
	('Peter Parker, 20 Ingram Street, Forest Hills, Queens, New York City, New York', 2, 1000002);

INSERT INTO `order_status` (order_status_key) VALUES ('ordered'), ('shipped'), ('slicing');

INSERT INTO `order` (`order_date`, `order_status_id`, `customer_id`)
VALUES
	( '2021-01-01 00:00:00', 1, 1000001),
	('2021-01-01 00:00:00', 2, 1000001),
	('2021-01-01 00:00:00', 3, 1000002);

INSERT INTO `product_category` (`product_category_name`) VALUES ('poster'), ('canvas');

INSERT INTO `product` (`product_name`, `product_category_id`, `product_image`)
VALUES
        ('poster 1', 1, '/files/poster_1.jpg'),
        ('poster 2', 1, '/files/poster_2.jpg'),
        ('canvas 1', 2, '/files/canvas_1.jpg'),
        ('canvas 2', 2, '/files/canvas_2.jpg');

INSERT INTO `product_size` (`product_id`, `product_size_height`, `product_size_width`)
VALUES (1, 80, 60), (2, 80, 60), (3, 80, 80), (4, 80, 80);

INSERT INTO `order_item` (`order_id`, `product_id`, `product_size_id`, `quantity`, `price`)
VALUES
	(1, 1, 1, 2, 10.00),
	(1, 2, 1, 1, 5.00),
	(2, 3, 3, 1, 20.00),
	(3, 4, 4, 3, 30.00);
