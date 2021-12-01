<?php
// *******************************************************************************************
//  File:  product.php
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

use Carbon\Carbon;

class Product
{
    public function __construct(private string $bar_code, private string $name, private string $url,
                                private string $countries, private Carbon $created_at, private Carbon $updated_at)
    {
    }

    public static function parseData(array $data): ?product
    {
        $code = $data[0];
        $url = $data[1];
        $created_t = $data[3];
        $last_modified_t = $data[5];
        $product_name = $data[7];
        $countries = $data[10];

        $created_at = Carbon::parse(intval($created_t));
        $updated_at = Carbon::parse(intval($last_modified_t));

        return new product($code, $product_name, $url, $countries, $created_at, $updated_at);
    }

    /**
     * @return string
     */
    public function getBarCode(): string
    {
        return $this->bar_code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    /**
     * @return string
     */
    public function getCountries(): string
    {
        return $this->countries;
    }
}