<?php
// *******************************************************************************************
//  File:  DatastoreInsertTests.php
//
//  Created: 05-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  05-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace data;

use App\Core\Datastore;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\StockSummary;
use App\Models\StockTransaction;
use TestCase;

class DatastoreInsertTests extends TestCase
{
    /**
     * @test
     */
    public function insert_product_is_valid()
    {
        $store = new Datastore();
        $record = Product::asNew('01234567896', 'Product 6', 'Product 6 Notes');

        $record = $store->insertProduct($record);

        $this->assertNotNull($record);
        $this->assertGreaterThan(5, $record->getId());
    }

    /**
     * @test
     */
    public function insert_stock_summary_is_valid()
    {
        $store = new Datastore();
        $product = Product::asNew('01234567897', 'Product 7', 'Product 7 Notes');
        $product = $store->insertProduct($product);
        $this->assertNotNull($product);

        $summary = StockSummary::asNew(0, $product->getId());
        $summary = $store->insertStockSummary($summary);

        $this->assertNotNull($summary);
        $this->assertGreaterThan(5, $summary->getId());
    }

    /**
     * @test
     */
    public function insert_stock_transaction_is_valid()
    {
        $store = new Datastore();
        $product = Product::asNew('01234567890', 'Product 8', 'Product 8 Notes');
        $product = $store->insertProduct($product);
        $this->assertNotNull($product);

        $summary = StockSummary::asNew(0, $product->getId());
        $summary = $store->insertStockSummary($summary);
        $this->assertNotNull($summary);

        $transaction = StockTransaction::asNew('A', 1, $summary->getId());
        $transaction = $store->insertStockTransaction($transaction);

        $this->assertNotNull($transaction);
        $this->assertGreaterThan(21, $transaction->getId());
    }

    /**
     * @test
     */
    public function insert_product_image_is_valid()
    {
        $store = new Datastore();
        $product = Product::asNew('01234567899', 'Product 9', 'Product 9 Notes');
        $product = $store->insertProduct($product);
        $this->assertNotNull($product);

        $product_image = ProductImage::asNew($product->getId());
        $product_image = $store->insertProductImage($product_image);

        $this->assertNotNull($product_image);
        $this->assertGreaterThan(9, $product_image->getId());
    }

    /**
     * @test
     */
    public function insert_image_is_valid()
    {
        $store = new Datastore();
        $product = Product::asNew('01234567901', 'Product 10', 'Product 10 Notes');
        $product = $store->insertProduct($product);
        $this->assertNotNull($product);

        $product_image = ProductImage::asNew($product->getId());
        $product_image = $store->insertProductImage($product_image);
        $this->assertNotNull($product_image);

        $image = Image::asNew('https://bulma.io/images/placeholders/24x124.png', 'T', $product_image->getId());
        $image = $store->insertImage($image);
        $this->assertGreaterThan(36, $image->getId());
    }
}
