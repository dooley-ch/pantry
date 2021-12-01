# *******************************************************************************************
#  File:  install.sql
#
#  Created: 28-11-2021
#
#  Copyright (c) 2021 James Dooley <james@dooley.ch>
#
#  History:
#  28-11-2021: Initial version
#
# *******************************************************************************************

CREATE DATABASE IF NOT EXISTS pantry;

USE pantry;

CREATE TABLE IF NOT EXISTS version (
  id INT NOT NULL AUTO_INCREMENT,
  major SMALLINT NOT NULL DEFAULT 1,
  minor SMALLINT NOT NULL DEFAULT 0,
  build SMALLINT NOT NULL DEFAULT 0,
  comment TEXT,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

CREATE UNIQUE INDEX version_ix_version ON `version`(major, minor, build);

CREATE TABLE IF NOT EXISTS barcode_lookup (
  id BIGINT NOT NULL AUTO_INCREMENT,
  code VARCHAR(60) NOT NULL,
  name VARCHAR(300) NOT NULL,
  url VARCHAR(2500),
  countries VARCHAR(2500),
  lock_version SMALLINT NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

CREATE UNIQUE INDEX barcode_lookup_ix_barcode ON barcode_lookup(`code`);

CREATE TABLE IF NOT EXISTS product (
  id INT NOT NULL AUTO_INCREMENT,
  barcode VARCHAR(60) NOT NULL,
  name VARCHAR(300) NOT NULL,
  description TEXT,
  image_url VARCHAR(3000),
  lock_version SMALLINT NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

CREATE UNIQUE INDEX product_ix_barcode ON product(barcode);

CREATE TABLE  IF NOT EXISTS stock_summary (
  id INT NOT NULL AUTO_INCREMENT,
  amount INT NOT NULL,
  product_id INT NOT NULL,
  lock_version SMALLINT NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS stock_transaction(
  id BIGINT NOT NULL AUTO_INCREMENT,
  operation CHAR(1) NOT NULL,
  amount SMALLINT NOT NULL,
  stock_summary_id INT NOT NULL,
  lock_version SMALLINT NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

CREATE TABLE  IF NOT EXISTS xxx_product(
  id BIGINT NOT NULL AUTO_INCREMENT,
  logged_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` CHAR(1) NOT NULL,
  record_id INT NOT NULL,
  barcode VARCHAR(60),
  `name` VARCHAR(300),
  `description` TEXT,
  image_url VARCHAR(3000),
  lock_version SMALLINT,
  PRIMARY KEY(id)
);

CREATE UNIQUE INDEX product_ix_barcode ON xxx_product(barcode);

CREATE TABLE IF NOT EXISTS xxx_stock_summary(
  id BIGINT NOT NULL AUTO_INCREMENT,
  logged_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` CHAR(1) NOT NULL,
  record_id INT NOT NULL,
  amount INT,
  lock_version SMALLINT,
  PRIMARY KEY(id)
);

ALTER TABLE stock_transaction
  ADD CONSTRAINT stock_summary_stock_transaction
    FOREIGN KEY (stock_summary_id) REFERENCES stock_summary (id);

ALTER TABLE stock_summary
  ADD CONSTRAINT product_stock_summary
    FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE Cascade
      ON UPDATE Cascade;
