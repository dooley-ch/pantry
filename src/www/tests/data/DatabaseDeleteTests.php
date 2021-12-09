<?php
// *******************************************************************************************
//  File:  DatabaseDeleteTests.php
//
//  Created: 06-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  06-12-2021: Initial version
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

class DatabaseDeleteTests extends TestCase
{
    /**
     * @test
     */
    public function delete_stock_transaction_stock_summary_product_is_valid()
    {
        $store = new Datastore();
        $product = Product::asNew('01234566005', 'Product 6005', 'Product 6005 Notes');
        $product = $store->insertProduct($product);
        $this->assertNotNull($product);

        $summary = StockSummary::asNew(0, $product->getId());
        $summary = $store->insertStockSummary($summary);
        $this->assertNotNull($summary);

        $transaction = StockTransaction::asNew('A', 1, $summary->getId());
        $transaction = $store->insertStockTransaction($transaction);
        $this->assertNotNull($transaction);

        $result = $store->deleteStockTransaction($transaction);
        $this->assertEquals(true, $result);

        $result = $store->deleteStockSummary($summary);
        $this->assertEquals(true, $result);

        $result = $store->deleteProduct($product);
        $this->assertEquals(true, $result);
    }

    /**
     * @test
     */
    public function insert_image_is_valid()
    {
        $store = new Datastore();
        $product = Product::asNew('01234566001', 'Product 6001', 'Product 6001 Notes');
        $product = $store->insertProduct($product);
        $this->assertNotNull($product);

        $product_image = ProductImage::asNew($product->getId());
        $product_image = $store->insertProductImage($product_image);
        $this->assertNotNull($product_image);

        $image = Image::asNew('https://bulma.io/images/placeholders/24x124.png', 'T', $product_image->getId());
        $image = $store->insertImage($image);
        $this->assertNotNull($image);

        $result = $store->deleteImage($image);
        $this->assertEquals(true, $result);

        $result = $store->deleteProductImage($product_image);
        $this->assertEquals(true, $result);

        $result = $store->deleteProduct($product);
        $this->assertEquals(true, $result);
    }

}
