# Introduction

Food Repo is an open, freely accessible database on barcoded food products. Importantly, Food Repo is accessible 
through a high-performing API, ensuring that it can be used easily as a data source in web and phone applications. 
Food Repo is currently limited to Switzerland, but plans to eventually expand to other countries.

# Account

Create an account at the following URL: https://www.foodrepo.org/en/sign_up.  For some reason I could only get an
account setup with a Swiss email address.

# API Calls

The API calls must be authorized via a custom header:

    Authorization: Token token="<API-KEY>"

The following calls are used to access product data:

API Call           | URL                                                         | Comment
------------------ | ----------------------------------------------------------- | ----------------------------------------------
Product by ID      | https://www.foodrepo.org/api/v3/products/{id}               | You can get the product id via the barcode API
Product by Barcode | https://www.foodrepo.org/api/v3/products?barcodes={barcode} | You can get the product id via the barcode API

