# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.0.0                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          storage_db_design.dez                           #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2012-11-12 00:17                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "storage"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `storage` (
    `storage_id` INTEGER NOT NULL AUTO_INCREMENT,
    `st_name` VARCHAR(255) NOT NULL,
    `st_address` VARCHAR(25) NOT NULL,
    `map` VARCHAR(255),
    `st_phone` VARCHAR(20),
    `contact_peolpe` VARCHAR(255),
    CONSTRAINT `PK_storage` PRIMARY KEY (`storage_id`)
);

# ---------------------------------------------------------------------- #
# Add table "range"                                                      #
# ---------------------------------------------------------------------- #

CREATE TABLE `range` (
    `range_id` INTEGER NOT NULL AUTO_INCREMENT,
    `range_name` VARCHAR(40) NOT NULL,
    `storage_id` INTEGER NOT NULL,
    `floor` TINYINT NOT NULL DEFAULT 0,
    `range_column` TINYINT NOT NULL,
    `pressed_wall` BOOL NOT NULL,
    CONSTRAINT `PK_range` PRIMARY KEY (`range_id`)
);

# ---------------------------------------------------------------------- #
# Add table "contain"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `contain` (
    `contain_id` INTEGER NOT NULL AUTO_INCREMENT,
    `range_id` INTEGER NOT NULL,
    `direction` VARCHAR(40) NOT NULL,
    `column` VARCHAR(40) NOT NULL,
    `cell` VARCHAR(40) NOT NULL,
    CONSTRAINT `PK_contain` PRIMARY KEY (`contain_id`, `range_id`)
);

# ---------------------------------------------------------------------- #
# Add table "floor"                                                      #
# ---------------------------------------------------------------------- #

CREATE TABLE `floor` (
    `floor_id` INTEGER NOT NULL AUTO_INCREMENT,
    `floor_name` VARCHAR(40) NOT NULL,
    `contain_id` INTEGER NOT NULL,
    `sub_floor` VARCHAR(10) NOT NULL,
    `location_code` VARCHAR(40) NOT NULL,
    `range_id` INTEGER,
    `status` TINYINT NOT NULL DEFAULT 0,
    CONSTRAINT `PK_floor` PRIMARY KEY (`floor_id`)
);

# ---------------------------------------------------------------------- #
# Add table "customer"                                                   #
# ---------------------------------------------------------------------- #

CREATE TABLE `customer` (
    `cus_id` INTEGER NOT NULL AUTO_INCREMENT,
    `company_name` VARCHAR(40) NOT NULL,
    `tax_code` VARCHAR(15),
    `comp_phone` VARCHAR(15) NOT NULL,
    `comp_email` VARCHAR(255) NOT NULL,
    `comp_fax` VARCHAR(20) NOT NULL,
    `comp_address` VARCHAR(255) NOT NULL,
    `comp_contact_info` TEXT NOT NULL,
    `status` INTEGER NOT NULL DEFAULT 1,
    CONSTRAINT `PK_customer` PRIMARY KEY (`cus_id`)
);

# ---------------------------------------------------------------------- #
# Add table "customer_dossier"                                           #
# ---------------------------------------------------------------------- #

CREATE TABLE `customer_dossier` (
    `dossier_id` INTEGER NOT NULL AUTO_INCREMENT,
    `cus_id` INTEGER NOT NULL,
    `barcode` VARCHAR(255),
    `dossier_name` VARCHAR(255) NOT NULL,
    `storage_id` INTEGER NOT NULL,
    `floor_id` VARCHAR(40) NOT NULL,
    `create_time` INTEGER NOT NULL,
    `update_time` INTEGER,
    `status` INTEGER NOT NULL,
    `destruction_time` INTEGER,
    CONSTRAINT `PK_customer_dossier` PRIMARY KEY (`dossier_id`, `cus_id`)
);

# ---------------------------------------------------------------------- #
# Add table "dossier_track"                                              #
# ---------------------------------------------------------------------- #

CREATE TABLE `dossier_track` (
    `track_id` INTEGER NOT NULL AUTO_INCREMENT,
    `dossier_id` INTEGER NOT NULL,
    `create_time` INTEGER NOT NULL,
    `old_location` VARCHAR(40),
    `new_location` VARCHAR(40),
    `status` INTEGER NOT NULL,
    `command` TEXT NOT NULL,
    `incharge_info` TEXT NOT NULL,
    `cus_id` INTEGER,
    CONSTRAINT `PK_dossier_track` PRIMARY KEY (`track_id`, `dossier_id`)
);

# ---------------------------------------------------------------------- #
# Add table "price"                                                      #
# ---------------------------------------------------------------------- #

CREATE TABLE `price` (
    `price_id` INTEGER NOT NULL AUTO_INCREMENT,
    `price_name` VARCHAR(40) NOT NULL,
    `value` FLOAT NOT NULL,
    `status` INTEGER NOT NULL,
    `type_price` VARCHAR(40) NOT NULL DEFAULT 'GENERAL',
    CONSTRAINT `PK_price` PRIMARY KEY (`price_id`)
);

# ---------------------------------------------------------------------- #
# Add table "dependence_price"                                           #
# ---------------------------------------------------------------------- #

CREATE TABLE `dependence_price` (
    `dependence_id` INTEGER NOT NULL AUTO_INCREMENT,
    `cus_id` INTEGER NOT NULL,
    `create_time` INTEGER NOT NULL,
    `command` TEXT,
    `type_price` VARCHAR(40) NOT NULL,
    `tracker` INTEGER NOT NULL,
    `price` FLOAT NOT NULL DEFAULT 0,
    CONSTRAINT `PK_dependence_price` PRIMARY KEY (`dependence_id`, `cus_id`)
);

# ---------------------------------------------------------------------- #
# Add table "storage_distribute"                                         #
# ---------------------------------------------------------------------- #

CREATE TABLE `storage_distribute` (
    `storage_id` INTEGER NOT NULL AUTO_INCREMENT,
    `dossier_id` INTEGER NOT NULL,
    `floor_id` INTEGER NOT NULL,
    `cus_id` INTEGER,
    CONSTRAINT `PK_storage_distribute` PRIMARY KEY (`storage_id`, `dossier_id`, `floor_id`)
);

# ---------------------------------------------------------------------- #
# Add table "contract_price"                                             #
# ---------------------------------------------------------------------- #

CREATE TABLE `contract_price` (
    `contract_id` INTEGER NOT NULL,
    `contract_code` VARCHAR(100),
    `cus_id` INTEGER NOT NULL,
    `price` FLOAT NOT NULL,
    `create_time` INTEGER NOT NULL,
    `note` TEXT NOT NULL,
    `contract_flag` BOOL NOT NULL,
    CONSTRAINT `PK_contract_price` PRIMARY KEY (`contract_id`)
);

# ---------------------------------------------------------------------- #
# Add table "role"                                                       #
# ---------------------------------------------------------------------- #

CREATE TABLE `role` (
    `role_id` INTEGER NOT NULL,
    `role_name` VARBINARY(40) NOT NULL,
    `user_id` INTEGER NOT NULL,
    `create_time` INTEGER NOT NULL,
    CONSTRAINT `PK_role` PRIMARY KEY (`role_id`)
);

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `range` ADD CONSTRAINT `storage_range` 
    FOREIGN KEY (`storage_id`) REFERENCES `storage` (`storage_id`);

ALTER TABLE `contain` ADD CONSTRAINT `range_contain` 
    FOREIGN KEY (`range_id`) REFERENCES `range` (`range_id`);

ALTER TABLE `floor` ADD CONSTRAINT `contain_floor` 
    FOREIGN KEY (`contain_id`, `range_id`) REFERENCES `contain` (`contain_id`,`range_id`);

ALTER TABLE `customer_dossier` ADD CONSTRAINT `customer_customer_dossier` 
    FOREIGN KEY (`cus_id`) REFERENCES `customer` (`cus_id`);

ALTER TABLE `dossier_track` ADD CONSTRAINT `customer_dossier_dossier_track` 
    FOREIGN KEY (`dossier_id`, `cus_id`) REFERENCES `customer_dossier` (`dossier_id`,`cus_id`);

ALTER TABLE `dependence_price` ADD CONSTRAINT `customer_dependence_price` 
    FOREIGN KEY (`cus_id`) REFERENCES `customer` (`cus_id`);

ALTER TABLE `storage_distribute` ADD CONSTRAINT `storage_storage_distribute` 
    FOREIGN KEY (`storage_id`) REFERENCES `storage` (`storage_id`);

ALTER TABLE `storage_distribute` ADD CONSTRAINT `floor_storage_distribute` 
    FOREIGN KEY (`floor_id`) REFERENCES `floor` (`floor_id`);

ALTER TABLE `storage_distribute` ADD CONSTRAINT `customer_dossier_storage_distribute` 
    FOREIGN KEY (`dossier_id`, `cus_id`) REFERENCES `customer_dossier` (`dossier_id`,`cus_id`);

ALTER TABLE `contract_price` ADD CONSTRAINT `customer_contract_price` 
    FOREIGN KEY (`cus_id`) REFERENCES `customer` (`cus_id`);
