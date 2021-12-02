# *******************************************************************************************
#  File:  uninstall.sql
#
#  Created: 28-11-2021
#
#  Copyright (c) 2021 James Dooley <james@dooley.ch>
#
#  History:
#  28-11-2021: Initial version
#
# *******************************************************************************************

USE pantry;

DROP TABLE IF EXISTS xxx_image;
DROP TABLE IF EXISTS xxx_product;
DROP TABLE IF EXISTS xxx_product_image;
DROP TABLE IF EXISTS xxx_stock_summary;

DROP TABLE IF EXISTS stock_transaction;
DROP TABLE IF EXISTS stock_summary;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS product_image;
DROP TABLE IF EXISTS product;

DROP TABLE IF EXISTS version;
