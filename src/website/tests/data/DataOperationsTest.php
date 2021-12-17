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
use App\Models\Product;
use App\Models\StockSummary;
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
        $lookup_product = $lookup->getByBarcode('7610809098257');

        $this->assertNotNull($lookup_product);

        // Store the product
        $store = new Datastore();
        $id = $store->addProduct($lookup_product);

        $this->assertNotNull($id);
        $this->assertGreaterThan(0, $id);
    }

    /**
     * @test
     */
    public function get_full_product_is_valid()
    {
        $store = new Datastore();
        $full = $store->getFullProduct(1);

        $this->assertNotNull($full);
    }

    /**
     * @test
     */
    public function add_product_item_is_valid()
    {
        $store = new Datastore();

        // Set up the product and the summary
        $code = strval(random_int(1000, 8700));
        $barcode = '761080909' . $code;
        $name = 'Product ' . $code;
        $description = 'Description for product ' . $code;

        $product = Product::asNew($code, $barcode, $name, $description);
        $product = $store->insertProduct($product);

        $summary = StockSummary::asNew(0, $product->getId());
        $store->insertStockSummary($summary);

        // Execute test
        $result = $store->alterProductItems($product->getId(), 'A');

        // Validate operation
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function remove_product_item_is_valid()
    {
        $store = new Datastore();

        // Set up the product and the summary
        $code = strval(random_int(1000, 8700));
        $barcode = '761080909' . $code;
        $name = 'Product ' . $code;
        $description = 'Description for product ' . $code;

        $product = Product::asNew($code, $barcode, $name, $description);
        $product = $store->insertProduct($product);

        $summary = StockSummary::asNew(0, $product->getId());
        $store->insertStockSummary($summary);

        // Execute test
        $result = $store->alterProductItems($product->getId(), 'R');

        // Validate operation
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function clear_product_items_is_valid()
    {
        $store = new Datastore();

        // Set up the product and the summary
        $code = strval(random_int(1000, 8700));
        $barcode = '761080909' . $code;
        $name = 'Product ' . $code;
        $description = 'Description for product ' . $code;

        $product = Product::asNew($code, $barcode, $name, $description);
        $product = $store->insertProduct($product);

        $summary = StockSummary::asNew(0, $product->getId());
        $store->insertStockSummary($summary);

        // Execute test
        $store->alterProductItems($product->getId(), 'R');
        $store->alterProductItems($product->getId(), 'R');
        $store->alterProductItems($product->getId(), 'R');
        $store->alterProductItems($product->getId(), 'A');

        // Validate operation
        $result = $store->clearProductItems($product->getId());
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function get_stock_report_is_valid()
    {
        $store = new Datastore();
        $list = $store->getStockReport();

        $this->assertGreaterThan(4, count($list));
    }
}
