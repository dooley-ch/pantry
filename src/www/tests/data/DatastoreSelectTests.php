<?php
// *******************************************************************************************
//  File:  DatastoreSelectTests.php
//
//  Created: 04-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  04-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);


namespace data;

use App\Core\Datastore;
use TestCase;

class DatastoreSelectTests extends TestCase
{
    //region Image

    /**
     * @test
     */
    public function get_image_is_valid()
    {
        $store = new Datastore();
        $image = $store->getImage(1);

        $this->assertNotNull($image);
        $this->assertEquals(1, $image->getId());
    }

    /**
     * @test
     */
    public function get_images_is_valid()
    {
        $store = new Datastore();
        $images = $store->getImages(1);

        $this->assertCount(4, $images);
    }

    /**
     * @test
     */
    public function get_image_audit_is_valid()
    {
        $store = new Datastore();
        $list = $store->getImageAudit(1);

        $this->assertCount(1, $list);
    }

    //endregion

    //region Product

    /**
     * @test
     */
    public function get_product_by_id_is_valid()
    {
        $store = new Datastore();
        $product = $store->getProduct(1);

        $this->assertNotNull($product);
        $this->assertEquals(1, $product->getId());
    }

    /**
     * @test
     */
    public function get_product_by_barcode_is_valid()
    {
        $store = new Datastore();
        $product = $store->getProductByBarcode('01234567894');

        $this->assertNotNull($product);
        $this->assertEquals(4, $product->getId());
    }

    /**
     * @test
     */
    public function get_product_audit_is_valid()
    {
        $store = new Datastore();
        $list = $store->getProductAudit(1);

        $this->assertCount(1, $list);
    }

    //endregion

    //region Product Image

    /**
     * @test
     */
    public function get_product_image_is_valid()
    {
        $store = new Datastore();
        $productImage = $store->getProductImage(1);

        $this->assertNotNull($productImage);
        $this->assertEquals(1, $productImage->getId());
    }

    /**
     * @test
     */
    public function get_product_images_is_valid()
    {
        $store = new Datastore();
        $list = $store->getProductImages(1);

        $this->assertGreaterThanOrEqual(2, $list);
    }

    /**
     * @test
     */
    public function get_product_image_audit_is_valid()
    {
        $store = new Datastore();
        $list = $store->getProductImageAudit(1);

        $this->assertCount(1, $list);
    }

    //endregion

    //region Stock Summary

    /**
     * @test
     */
    public function get_stock_summary_is_valid()
    {
        $store = new Datastore();
        $stock_summary = $store->getStockSummary(1);

        $this->assertNotNull($stock_summary);
        $this->assertEquals(1, $stock_summary->getId());
    }

    /**
     * @test
     */
    public function get_stock_summary_by_product_is_valid()
    {
        $store = new Datastore();
        $stock_summary = $store->getStockSummaryByProduct(1);

        $this->assertNotNull($stock_summary);
        $this->assertEquals(1, $stock_summary->getProductId());
    }

    /**
     * @test
     */
    public function get_stock_summary_audit_is_valid()
    {
        $store = new Datastore();
        $list = $store->getStockSummaryAudit(1);

        $this->assertCount(1, $list);
    }

    //endregion

    //region Stock Transaction

    /**
     * @test
     */
    public function get_stock_transaction_is_valid()
    {
        $store = new Datastore();
        $stock_transaction = $store->getStockTransaction(1);

        $this->assertNotNull($stock_transaction);
        $this->assertEquals(1, $stock_transaction->getId());
    }

    /**
     * @test
     */
    public function get_stock_transactions_by_summary_is_valid()
    {
        $store = new Datastore();
        $transactions = $store->getStockTransactionsBySummary(1);

        $this->assertCount(5, $transactions);
    }

    //endregion

    //region Version

    /**
     * @test
     */
    public function version_is_valid()
    {
        $store = new Datastore();
        $version = $store->getVersion();

        $this->assertNotNull($version);
        $this->assertEquals(1, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(1, $version->getBuild());
        $this->assertEquals('Initial version', $version->getComment());
    }

    //endregion
}
