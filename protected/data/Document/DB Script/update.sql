-- 15/11/2012
ALTER TABLE price MODIFY type_price VARCHAR(40) NULL;
ALTER TABLE price ADD COLUMN description TEXT NULL;
ALTER TABLE dependence_price DROP COLUMN cus_id;
ALTER TABLE price ADD COLUMN contract_id INT NOT NULL;

ALTER TABLE dossier_track DROP COLUMN dossier_id;
ALTER TABLE dossier_track ADD COLUMN dossier_name VARCHAR(255);
ALTER TABLE dossier_track DROP COLUMN cus_id;
ALTER TABLE dossier_track ADD COLUMN company_name VARCHAR(40);
ALTER TABLE dossier_track DROP COLUMN incharge_info;
ALTER TABLE dossier_track ADD COLUMN user_name VARCHAR(20);
-- 19/11/2012
ALTER TABLE dossier_track DROP COLUMN dossier_name;
ALTER TABLE dossier_track ADD COLUMN dossier_id INTEGER;
ALTER TABLE customer_dossier DROP COLUMN contract_id;
ALTER TABLE customer_dossier ADD COLUMN cus_id INTEGER;
ALTER TABLE contract_price ADD COLUMN contract_range VARCHAR(40);
-- 20/11/2012
ALTER TABLE contract_price MODIFY price VARCHAR(12) NOT NULL;
ALTER TABLE price MODIFY value VARCHAR(12) NOT NULL;
ALTER TABLE contract_price DROP COLUMN contract_code;
ALTER TABLE customer ADD COLUMN contract_code VARCHAR(40) NOT NULL;
-- 21/11/2012
ALTER TABLE dossier_track DROP COLUMN company_name;
CREATE TABLE `service_price` (
    `service_id` INTEGER NOT NULL AUTO_INCREMENT,
    `service_name` VARCHAR(255) NOT NULL,
    `price` VARCHAR(12) NOT NULL,
    `note` TEXT,
    `status` VARCHAR(1),
	`cus_id` INTEGER NOT NULL,
    CONSTRAINT `PK_storage` PRIMARY KEY (`service_id`)
);
-- 22/11/2012
ALTER TABLE dependence_price DROP COLUMN command;
ALTER TABLE dependence_price DROP COLUMN type_price;
ALTER TABLE dependence_price DROP COLUMN tracker;
ALTER TABLE dependence_price ADD COLUMN name VARCHAR(255);
ALTER TABLE dependence_price ADD COLUMN service_id INTEGER NOT NULL;
ALTER TABLE dependence_price ADD COLUMN cus_id INTEGER NOT NULL;
ALTER TABLE dependence_price ADD COLUMN status VARCHAR(1);
ALTER TABLE customer_dossier ADD COLUMN dossier_no VARCHAR(40) NOT NULL;

-- 26/11/2012
ALTER TABLE dependence_price DROP COLUMN cus_id;
-- 27/11/2012
ALTER TABLE customer_dossier ADD COLUMN seal_no VARCHAR(40) NOT NULL;
-- 29/12/2012
ALTER TABLE customer ADD COLUMN contract_time INT NOT NULL;
-- 08-12/2012
ALTER TABLE customer MODIFY comp_fax varchar(20) null;
-- 28/12/2012
ALTER TABLE  `tbl_users` ADD  `cus_id` INT NOT NULL AFTER  `id`