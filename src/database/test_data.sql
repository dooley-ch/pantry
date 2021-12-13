-- *******************************************************************************************
--  File:  test_data.sql
--
--  Created: 04-12-2021
--
--  Copyright (c) 2021 James Dooley <james@dooley.ch>
--
--  History:
--  04-12-2021: Initial version
--
-- *******************************************************************************************

USE pantry;

INSERT INTO product (id, barcode, name, description) VALUES (1, '01234567891', 'Product 1', 'Product 1 Notes');
INSERT INTO product (id, barcode, name, description) VALUES (2, '01234567892', 'Product 2', 'Product 2 Notes');
INSERT INTO product (id, barcode, name, description) VALUES (3, '01234567893', 'Product 3', 'Product 3 Notes');
INSERT INTO product (id, barcode, name, description) VALUES (4, '01234567894', 'Product 4', 'Product 4 Notes');
INSERT INTO product (id, barcode, name, description) VALUES (5, '01234567895', 'Product 5', 'Product 5 Notes');

INSERT INTO xxx_product (action, record_id, barcode, name, description, lock_version)
    SELECT 'I', id, barcode, name, description, lock_version FROM product;

INSERT INTO stock_summary (id, amount, product_id) VALUES (1, 3, 1);
INSERT INTO stock_summary (id, amount, product_id) VALUES (2, 5, 2);
INSERT INTO stock_summary (id, amount, product_id) VALUES (3, 2, 3);
INSERT INTO stock_summary (id, amount, product_id) VALUES (4, 1, 4);
INSERT INTO stock_summary (id, amount, product_id) VALUES (5, 2, 5);

INSERT INTO xxx_stock_summary (action, record_id, amount, product_id, lock_version)
    SELECT 'I', id, amount, product_id, lock_version FROM stock_summary;

INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (1, 'A', 1, 1);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (2, 'A', 1, 1);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (3, 'A', 1, 1);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (4, 'R', 1, 1);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (5, 'R', 1, 1);

INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (6, 'A', 1, 2);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (7, 'A', 1, 2);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (8, 'A', 1, 2);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (9, 'R', 1, 2);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (10, 'R', 1, 2);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (11, 'A', 1, 2);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (12, 'A', 1, 2);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (13, 'A', 1, 2);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (14, 'A', 1, 2);

INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (15, 'A', 1, 3);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (16, 'A', 1, 3);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (17, 'R', 1, 3);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (18, 'A', 1, 3);

INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (19, 'A', 1, 4);

INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (20, 'A', 1, 5);
INSERT INTO stock_transaction (id, operation, amount, stock_summary_id) VALUES (21, 'A', 1, 5);

INSERT INTO product_image (id, product_id) VALUES (1, 1);
INSERT INTO product_image (id, product_id) VALUES (2, 1);

INSERT INTO product_image (id, product_id) VALUES (3, 2);

INSERT INTO product_image (id, product_id) VALUES (4, 3);
INSERT INTO product_image (id, product_id) VALUES (5, 3);
INSERT INTO product_image (id, product_id) VALUES (6, 3);

INSERT INTO product_image (id, product_id) VALUES (7, 4);
INSERT INTO product_image (id, product_id) VALUES (8, 4);

INSERT INTO product_image (id, product_id) VALUES (9, 5);

INSERT INTO xxx_product_image (action, record_id, product_id, lock_version) SELECT 'I', id, product_id, lock_version FROM product_image;

INSERT INTO image (id, url, image_type, product_image_id) VALUES (1, 'https://bulma.io/images/placeholders/24x124.png', 'T', 1);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (2, 'https://bulma.io/images/placeholders/48x48.png', 'M', 1);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (3, 'https://bulma.io/images/placeholders/96x96.png', 'L', 1);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (4, 'https://bulma.io/images/placeholders/128x128.png', 'X', 1);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (5, 'https://bulma.io/images/placeholders/24x124.png', 'T', 2);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (6, 'https://bulma.io/images/placeholders/48x48.png', 'M', 2);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (7, 'https://bulma.io/images/placeholders/96x96.png', 'L', 2);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (8, 'https://bulma.io/images/placeholders/128x128.png', 'X', 2);

INSERT INTO image (id, url, image_type, product_image_id) VALUES (9, 'https://bulma.io/images/placeholders/24x124.png', 'T', 3);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (10, 'https://bulma.io/images/placeholders/48x48.png', 'M', 3);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (11, 'https://bulma.io/images/placeholders/96x96.png', 'L', 3);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (12, 'https://bulma.io/images/placeholders/128x128.png', 'X', 3);

INSERT INTO image (id, url, image_type, product_image_id) VALUES (13, 'https://bulma.io/images/placeholders/24x124.png', 'T', 4);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (14, 'https://bulma.io/images/placeholders/48x48.png', 'M', 4);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (15, 'https://bulma.io/images/placeholders/96x96.png', 'L', 4);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (16, 'https://bulma.io/images/placeholders/128x128.png', 'X', 4);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (17, 'https://bulma.io/images/placeholders/24x124.png', 'T', 5);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (18, 'https://bulma.io/images/placeholders/48x48.png', 'M', 5);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (19, 'https://bulma.io/images/placeholders/96x96.png', 'L', 5);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (20, 'https://bulma.io/images/placeholders/128x128.png', 'X', 5);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (21, 'https://bulma.io/images/placeholders/24x124.png', 'T', 6);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (22, 'https://bulma.io/images/placeholders/48x48.png', 'M', 6);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (23, 'https://bulma.io/images/placeholders/96x96.png', 'L', 6);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (24, 'https://bulma.io/images/placeholders/128x128.png', 'X', 6);

INSERT INTO image (id, url, image_type, product_image_id) VALUES (25, 'https://bulma.io/images/placeholders/24x124.png', 'T', 7);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (26, 'https://bulma.io/images/placeholders/48x48.png', 'M', 7);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (27, 'https://bulma.io/images/placeholders/96x96.png', 'L', 7);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (28, 'https://bulma.io/images/placeholders/128x128.png', 'X', 7);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (29, 'https://bulma.io/images/placeholders/24x124.png', 'T', 8);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (30, 'https://bulma.io/images/placeholders/48x48.png', 'M', 8);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (31, 'https://bulma.io/images/placeholders/96x96.png', 'L', 8);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (32, 'https://bulma.io/images/placeholders/128x128.png', 'X', 8);

INSERT INTO image (id, url, image_type, product_image_id) VALUES (33, 'https://bulma.io/images/placeholders/24x124.png', 'T', 9);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (34, 'https://bulma.io/images/placeholders/48x48.png', 'M', 9);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (35, 'https://bulma.io/images/placeholders/96x96.png', 'L', 9);
INSERT INTO image (id, url, image_type, product_image_id) VALUES (36, 'https://bulma.io/images/placeholders/128x128.png', 'X', 9);

INSERT INTO xxx_image (action, record_id, url, image_type, product_image_id, lock_version)
    SELECT 'I', id, url, image_type, product_image_id, lock_version FROM image;
