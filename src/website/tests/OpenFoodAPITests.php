<?php /** @noinspection PhpUnhandledExceptionInspection */
// *******************************************************************************************
//  File:  OpenFoodAPITests.php
//
//  Created: 08-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  08-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace Tests;

use App\Core\OpenFoodRepoLookup;

class OpenFoodAPITests extends TestCase
{
    //region Code
    /**
     * @test
     */
    public function get_by_code_is_valid()
    {
        $provider = new OpenFoodRepoLookup();

        $product = $provider->getByCode('45187');

        $this->assertNotNull($product, 'Expected product by code not found');
        $this->assertEquals('45187', $product->getId());
    }

    //endregion

    //region Barcode

    /**
     * @test
     */
    public function get_by_barcode_is_valid()
    {
        $provider = new OpenFoodRepoLookup();

        $product = $provider->getByBarcode('3165440007082');

        $this->assertNotNull($product, 'Expected product by barcode not found');
        $this->assertEquals('3165440007082', $product->getBarcode());
    }

    //endregion
}
