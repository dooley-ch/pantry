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

CREATE TABLE version(
  id INT NOT NULL AUTO_INCREMENT,
  major SMALLINT NOT NULL DEFAULT 1,
  minor SMALLINT NOT NULL DEFAULT 0,
  build SMALLINT NOT NULL DEFAULT 0,
  comment TEXT,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

CREATE UNIQUE INDEX version_ix_version ON version(major, minor, build);

CREATE TABLE product(
  id INT NOT NULL AUTO_INCREMENT,
  barcode VARCHAR(60) NOT NULL,
  name VARCHAR(300) NOT NULL,
  description TEXT,
  lock_version SMALLINT NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

CREATE UNIQUE INDEX product_ix_barcode ON product(barcode);

CREATE TABLE stock_summary(
  id INT NOT NULL AUTO_INCREMENT,
  amount INT NOT NULL,
  product_id INT NOT NULL,
  lock_version SMALLINT NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

CREATE TABLE stock_transaction(
  id BIGINT NOT NULL AUTO_INCREMENT,
  operation CHAR(1) NOT NULL,
  amount SMALLINT NOT NULL,
  stock_summary_id INT NOT NULL,
  lock_version SMALLINT NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

CREATE TABLE xxx_product(
  id BIGINT NOT NULL AUTO_INCREMENT,
  logged_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  action CHAR(1) NOT NULL,
  record_id INT NOT NULL,
  barcode VARCHAR(60),
  name VARCHAR(300),
  description TEXT,
  lock_version SMALLINT,
  PRIMARY KEY(id)
);

CREATE INDEX xxx_product_ix_record_id ON xxx_product(record_id);

CREATE TABLE xxx_stock_summary(
  id BIGINT NOT NULL AUTO_INCREMENT,
  logged_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  action CHAR(1) NOT NULL,
  record_id INT NOT NULL,
  amount INT,
  product_id INT,
  lock_version SMALLINT,
  PRIMARY KEY(id)
);

CREATE INDEX xxx_stock_summary_ix_record_id ON xxx_stock_summary(record_id);

CREATE TABLE image(
  id INT NOT NULL AUTO_INCREMENT,
  url TEXT NOT NULL,
  image_type CHAR(1) NOT NULL,
  product_image_id INT NOT NULL,
  lock_version SMALLINT NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

CREATE TABLE xxx_image(
  id BIGINT NOT NULL AUTO_INCREMENT,
  logged_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  action CHAR(1) NOT NULL,
  record_id INT NOT NULL,
  url TEXT,
  image_type CHAR(1),
  product_image_id INT,
  lock_version SMALLINT NOT NULL,
  PRIMARY KEY(id)
);

CREATE INDEX xxx_image_ix_record_id ON xxx_image(record_id);

CREATE TABLE product_image(
  id INT NOT NULL AUTO_INCREMENT,
  product_id INT NOT NULL,
  lock_version SMALLINT NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);

CREATE TABLE xxx_product_image(
  id BIGINT NOT NULL AUTO_INCREMENT,
  logged_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  action CHAR(1) NOT NULL,
  record_id INT NOT NULL,
  product_id INT,
  lock_version SMALLINT,
  PRIMARY KEY(id)
);

CREATE INDEX xxx_product_image_ix_record_id ON xxx_product_image(record_id);

ALTER TABLE stock_transaction
  ADD CONSTRAINT stock_summary_stock_transaction
    FOREIGN KEY (stock_summary_id) REFERENCES stock_summary (id);

ALTER TABLE stock_summary
  ADD CONSTRAINT product_stock_summary
    FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE Cascade
      ON UPDATE Cascade;

ALTER TABLE image
  ADD CONSTRAINT product_image_image
    FOREIGN KEY (product_image_id) REFERENCES product_image (id);

ALTER TABLE product_image
  ADD CONSTRAINT product_product_image
    FOREIGN KEY (product_id) REFERENCES product (id);

INSERT INTO version (major, minor, build, comment) VALUES (1, 0, 1, 'Initial version');
