<?php
/** @noinspection PhpUnhandledExceptionInspection */
// *******************************************************************************************
//  File:  DataOperationsTest.php
//
//  Created: 13-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  13-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace Tests\data;

use App\Core\Datastore;
use App\Core\OpenFoodRepoLookup;
use Tests\TestCase;

class DataOperationsTest extends TestCase
{
    /**
     * @test
     */
    public function insert_product_from_open_food_repo_is_valid()
    {
        // Get the product details
        $lookup = new OpenFoodRepoLookup();
        $lookup_product = $lookup->getByBarcode('');

        $this->assertNotNull($lookup_product);

        // Store the product
        $store = new Datastore();
        $id = $store->addProduct($lookup_product);

        $this->assertNotNull($id);
        $this->assertGreaterThan(0, $id);
    }
}
