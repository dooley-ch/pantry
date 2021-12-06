<?php
// *******************************************************************************************
//  File:  DatastoreUpdateTests.php
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

class DatastoreUpdateTests extends TestCase
{
    /**
     * @test
     */
    public function update_product_is_valid()
    {
        $store = new Datastore();
        $product = Product::asNew('01234567901', 'Product 21', 'Product 21 Notes');

        $product = $store->insertProduct($product);
        $this->assertNotNull($product);

        $product->setDescription('Product 21 update notes');

        $product = $store->updateProduct($product);

        $this->assertNotNull($product);
        $this->assertEquals(2, $product->getLockVersion());
    }

    /**
     * @test
     */
    public function update_stock_summary_is_valid()
    {
        $store = new Datastore();
        $product = Product::asNew('01234567902', 'Product 22', 'Product 22 Notes');
        $product = $store->insertProduct($product);
        $this->assertNotNull($product);

        $summary = StockSummary::asNew(0, $product->getId());
        $summary = $store->insertStockSummary($summary);
        $this->assertNotNull($summary);

        $summary->setAmount(25);
        $summary = $store->updateStockSummary($summary);

        $this->assertNotNull($summary);
        $this->assertEquals(2, $summary->getLockVersion());
    }

    /**
     * @test
     */
    public function update_stock_transaction_is_valid()
    {
        $store = new Datastore();
        $product = Product::asNew('01234567903', 'Product 23', 'Product 23 Notes');
        $product = $store->insertProduct($product);
        $this->assertNotNull($product);

        $summary = StockSummary::asNew(0, $product->getId());
        $summary = $store->insertStockSummary($summary);
        $this->assertNotNull($summary);

        $transaction = StockTransaction::asNew('A', 2, $summary->getId());
        $transaction = $store->insertStockTransaction($transaction);

        $transaction->setAmount(34);
        $transaction = $store->updateStockTransaction($transaction);

        $this->assertNotNull($transaction);
        $this->assertEquals(2, $transaction->getLockVersion());
    }

    /**
     * @test
     */
    public function update_product_image_is_valid()
    {
        $store = new Datastore();
        $product = Product::asNew('01234567904', 'Product 24', 'Product 24 Notes');
        $product = $store->insertProduct($product);
        $this->assertNotNull($product);

        $product_image = ProductImage::asNew($product->getId());
        $product_image = $store->insertProductImage($product_image);
        $this->assertNotNull($product_image);

        $product_image->setProductId(1);
        $product_image = $store->updateProductImage($product_image);

        $this->assertNotNull($product_image);
        $this->assertEquals(2, $product_image->getLockVersion());
    }

    /**
     * @test
     */
    public function update_image_is_valid()
    {
        $store = new Datastore();
        $product = Product::asNew('01234567905', 'Product 25', 'Product 25 Notes');
        $product = $store->insertProduct($product);
        $this->assertNotNull($product);

        $product_image = ProductImage::asNew($product->getId());
        $product_image = $store->insertProductImage($product_image);
        $this->assertNotNull($product_image);

        $image = Image::asNew('https://bulma.io/images/placeholders/128x128.png', 'T', $product_image->getId());
        $image = $store->insertImage($image);

        $image->setImageType('X');
        $image = $store->updateImage($image);

        $this->assertNotNull($image);
        $this->assertEquals(2, $image->getLockVersion());
    }
}
