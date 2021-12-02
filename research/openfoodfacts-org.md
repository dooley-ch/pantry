# Introduction

[Open Food Facts](https://world.openfoodfacts.org) is a collaborative project built by volunteers and managed
by a non-profit organisation.  The project provides a comprehensive database providing product names,
descriptions, images and barcodes.  The project is an idea source of data for projects such as this one.

# Data File

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

# API Calls

The API is documented here: [https://wiki.openfoodfacts.org/API#NEW_version_of_the_documentation](https://wiki.openfoodfacts.org/API#NEW_version_of_the_documentation)

There is no need to have an api key to make calls.  The following calls are useful:

https://world.openfoodfacts.org/api/v2/product/<barcode>

Testing three random barcodes did not go well:

Barcode       | Status | Comment
------------- | ------ | ---------------------------
7610809098257 | OK     | Name was OK, but not great
7611100428439 | NOK    | No name
3165440007082 | NOK    | No name







