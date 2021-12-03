<?php
// *******************************************************************************************
//  File:  OpenFoodRepoLookup.php
//
//  Created: 03-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  03-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace App\Core;

class OpenFoodRepoLookup
{
    private string $api_key;

    public function __construct()
    {
        $this->api_key = env('OPEN_FOOD_REPO_API_KEY', '');
    }

    public function getByCode(string $code)
    {}

    public function getByBarcode(string $barcode)
    {}
}
