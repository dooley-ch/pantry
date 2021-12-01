# Barcodes

## Introduction

For this project we need to be able to map barcodes to product names and if possible descriptions and images. 
The Open Food Facts database seems to be the most useful for these purposes.

## Open Food Facts

[Open Food Facts](https://world.openfoodfacts.org) is a collaborative project built by volunteers and managed 
by a non-profit organisation.  The project provides a comprehensive database providing product names, 
descriptions, images and barcodes.  The project is an idea source of data for projects such as this one.

## Data

The data is available on the openfoodfacts website at the following address 
[https://world.openfoodfacts.org/data](https://world.openfoodfacts.org/data).

For this project we will use the CSV file located at: 
[https://static.openfoodfacts.org/data/en.openfoodfacts.org.products.csv](https://static.openfoodfacts.org/data/en.openfoodfacts.org.products.csv)

### File Format

The CSV file contains the following fields:
- code	
- url	
- creator	
- created_t	
- created_datetime	
- last_modified_t	
- last_modified_datetime	
- product_name	
- abbreviated_product_name	
- generic_name

Plus several other fields that we will not store as part of the lookup function.

## Generate New Barcodes

Rolls of preprinted barcodes can be purchased on websites such as Amazon or EBay, but they tend to be very 
expensive.  If you just need a small quantity you can generate and download them from this 
website: [tec-it.com](https://barcode.tec-it.com/en).
