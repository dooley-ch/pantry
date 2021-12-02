# *******************************************************************************************
#  File:  create.sql
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

CREATE USER IF NOT EXISTS 'pantry_user'@'localhost' IDENTIFIED BY 'w3lc0me*1';

GRANT SELECT, UPDATE, INSERT, DELETE ON product TO 'pantry_user'@'localhost';
GRANT SELECT, UPDATE, INSERT, DELETE ON product_image TO 'pantry_user'@'localhost';
GRANT SELECT, UPDATE, INSERT, DELETE ON stock_summary TO 'pantry_user'@'localhost';
GRANT SELECT, UPDATE, INSERT, DELETE ON stock_transaction TO 'pantry_user'@'localhost';
GRANT SELECT, UPDATE, INSERT, DELETE ON `version` TO 'pantry_user'@'localhost';
GRANT SELECT, UPDATE, INSERT, DELETE ON xxx_product TO 'pantry_user'@'localhost';
GRANT SELECT, UPDATE, INSERT, DELETE ON xxx_stock_summary TO 'pantry_user'@'localhost';
GRANT SELECT, UPDATE, INSERT, DELETE ON xxx_product_image TO 'pantry_user'@'localhost';
