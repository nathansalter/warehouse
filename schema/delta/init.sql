--
-- Init script for warehouse & products
--

--
-- Add Product Table
--
CREATE TABLE `product` (
	`id` CHAR(32) NOT NULL PRIMARY KEY,
	`name` VARCHAR(32) NOT NULL,
	`stock_level` INT UNSIGNED NOT NULL,
	`last_updated` DATETIME NOT NULL
);

-- Key
ALTER TABLE `product_stock` ADD CONSTRAINT FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Add Order Table
--
CREATE TABLE `order` (
	`id` CHAR(32) NOT NULL PRIMARY KEY,
	`created_time` DATETIME NOT NULL,
	`pick_sheet` BLOB NOT NULL,
	`completed` BOOLEAN NOT NULL
	`completed_time` DATETIME
);

--
-- Add Order Link Table
--
CREATE TABLE `order_product` (
	`order_id` CHAR(32) NOT NULL,
	`product_id` CHAR(32) NOT NULL
);

-- Key
ALTER TABLE `order_product` ADD CONSTRAINT FOREIGN KEY (`order_id`) REFERENCES `order` (`id`);
ALTER TABLE `order_product` ADD CONSTRAINT FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Add Warehouse Map Tables
--
CREATE TABLE `warehouse_bin` (
	`name` VARCHAR(6) NOT NULL PRIMARY KEY,
	`map_x` INT UNSIGNED NOT NULL,
	`map_y` INT UNSIGNED NOT NULL
);

CREATE TABLE `warehouse_station` (
	`name` VARCHAR(4) NOT NULL PRIMARY KEY,
	`map_x` INT UNSIGNED NOT NULL,
	`map_y` INT UNSIGNED NOT NULL
);

CREATE TABLE `warehouse_map` (
	`origin_x` INT UNSIGNED NOT NULL PRIMARY KEY,
	`origin_y` INT UNSIGNED NOT NULL PRIMARY KEY,
	`map` BLOB NOT NULL
);

--
-- Add product location table
--
CREATE TABLE `warehouse_product_bin` (
	`product_id` CHAR(32) NOT NULL,
	`bin_name` VARCHAR(6) NOT NULL
);

-- Key
ALTER TABLE `warehouse_product_bin` ADD CONSTRAINT FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);