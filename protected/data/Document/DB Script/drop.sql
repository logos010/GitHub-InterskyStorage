# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.0.0                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          storage_db_design.dez                           #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2012-11-12 00:17                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `range` DROP FOREIGN KEY `storage_range`;

ALTER TABLE `contain` DROP FOREIGN KEY `range_contain`;

ALTER TABLE `floor` DROP FOREIGN KEY `contain_floor`;

ALTER TABLE `customer_dossier` DROP FOREIGN KEY `customer_customer_dossier`;

ALTER TABLE `dossier_track` DROP FOREIGN KEY `customer_dossier_dossier_track`;

ALTER TABLE `dependence_price` DROP FOREIGN KEY `customer_dependence_price`;

ALTER TABLE `storage_distribute` DROP FOREIGN KEY `storage_storage_distribute`;

ALTER TABLE `storage_distribute` DROP FOREIGN KEY `floor_storage_distribute`;

ALTER TABLE `storage_distribute` DROP FOREIGN KEY `customer_dossier_storage_distribute`;

ALTER TABLE `contract_price` DROP FOREIGN KEY `customer_contract_price`;

# ---------------------------------------------------------------------- #
# Drop table "role"                                                      #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `role` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `role`;

# ---------------------------------------------------------------------- #
# Drop table "contract_price"                                            #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `contract_price` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `contract_price`;

# ---------------------------------------------------------------------- #
# Drop table "storage_distribute"                                        #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `storage_distribute` MODIFY `storage_id` INTEGER NOT NULL;

# Drop constraints #

ALTER TABLE `storage_distribute` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `storage_distribute`;

# ---------------------------------------------------------------------- #
# Drop table "dependence_price"                                          #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `dependence_price` MODIFY `dependence_id` INTEGER NOT NULL;

# Drop constraints #

ALTER TABLE `dependence_price` ALTER COLUMN `price` DROP DEFAULT;

ALTER TABLE `dependence_price` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `dependence_price`;

# ---------------------------------------------------------------------- #
# Drop table "price"                                                     #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `price` MODIFY `price_id` INTEGER NOT NULL;

# Drop constraints #

ALTER TABLE `price` ALTER COLUMN `type_price` DROP DEFAULT;

ALTER TABLE `price` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `price`;

# ---------------------------------------------------------------------- #
# Drop table "dossier_track"                                             #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `dossier_track` MODIFY `track_id` INTEGER NOT NULL;

# Drop constraints #

ALTER TABLE `dossier_track` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `dossier_track`;

# ---------------------------------------------------------------------- #
# Drop table "customer_dossier"                                          #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `customer_dossier` MODIFY `dossier_id` INTEGER NOT NULL;

# Drop constraints #

ALTER TABLE `customer_dossier` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `customer_dossier`;

# ---------------------------------------------------------------------- #
# Drop table "customer"                                                  #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `customer` MODIFY `cus_id` INTEGER NOT NULL;

# Drop constraints #

ALTER TABLE `customer` ALTER COLUMN `status` DROP DEFAULT;

ALTER TABLE `customer` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `customer`;

# ---------------------------------------------------------------------- #
# Drop table "floor"                                                     #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `floor` MODIFY `floor_id` INTEGER NOT NULL;

# Drop constraints #

ALTER TABLE `floor` ALTER COLUMN `status` DROP DEFAULT;

ALTER TABLE `floor` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `floor`;

# ---------------------------------------------------------------------- #
# Drop table "contain"                                                   #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `contain` MODIFY `contain_id` INTEGER NOT NULL;

# Drop constraints #

ALTER TABLE `contain` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `contain`;

# ---------------------------------------------------------------------- #
# Drop table "range"                                                     #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `range` MODIFY `range_id` INTEGER NOT NULL;

# Drop constraints #

ALTER TABLE `range` ALTER COLUMN `floor` DROP DEFAULT;

ALTER TABLE `range` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `range`;

# ---------------------------------------------------------------------- #
# Drop table "storage"                                                   #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `storage` MODIFY `storage_id` INTEGER NOT NULL;

# Drop constraints #

ALTER TABLE `storage` DROP PRIMARY KEY;

# Drop table #

DROP TABLE `storage`;
