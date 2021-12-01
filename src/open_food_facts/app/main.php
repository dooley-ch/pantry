<?php
// *******************************************************************************************
//  File:  main.php
//
//  Created: 26-11-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  26-11-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace OpenFoodFacts;

require "vendor/autoload.php";

use Symfony\Component\Yaml\Yaml;

// -------------------------------------------------------------------------------------------
// Load Config
$config_file = join(DIRECTORY_SEPARATOR, array(trim(getcwd()), 'config.yaml'));
$config_data = Yaml::parseFile($config_file);
$config_info = new ConfigInfo($config_data);

// -------------------------------------------------------------------------------------------
// Setup database
$datastore = new Datastore($config_info->getHost(), $config_info->getPort(),
                            $config_info->getDatabase(),  $config_info->getUser(), $config_info->getPassword());

// -------------------------------------------------------------------------------------------
// Process CSV file
$code = 0;
$url = 0;
$name = 0;
$countries = 0;

$rows_read = 0;
$rows_written = 0;
$objects = [];
$first_line = true;
$handle = fopen($config_info->getDataFile(), "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $rows_read += 1;

        if ($first_line) {
            $first_line = false;
            continue;
        }

        $data = str_getcsv($line, "\t");
        $last = array_slice($data, 184, 3);
        $data = array_slice($data, 0, 10);

        $countries = $last[0];

        if (strlen($countries)) {
            array_push($data, $countries);
        } else {
            array_push($data, "");
        }

        $product = product::parseData($data);

        if ($product) {
            $code = max($code, strlen($product->getBarCode()));
            $url = max($url, strlen($product->getUrl()));
            $name = max($name, strlen($product->getName()));
            $countries = max($countries, strlen($product->getCountries()));

            $objects []= $product;

            if (count($objects) >= $config_info->getBatchSize()) {
                $datastore->postBatch($objects);

                $rows_written += count($objects);
                printf("Records written: %s\n", number_format($rows_written));

                $objects = [];
            }
        } else {
            print("Failed to create product:\n");
            var_dump($data);
        }
    }

    fclose($handle);
}

printf("Total number of rows read: %s\n", number_format($rows_read));
printf("Total number of rows written: %s\n", number_format($rows_written));

printf("Field lengths: code: %s, url: %s, name: %s, countries: %s\n", number_format($code), number_format($url),
            number_format($name), number_format($countries));