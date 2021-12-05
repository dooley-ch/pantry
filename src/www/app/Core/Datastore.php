<?php
// *******************************************************************************************
//  File:  Datastore.php
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

namespace App\Core;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\StockSummary;
use App\Models\StockTransaction;
use App\Models\Version;
use App\Models\Image;
use App\Models\XxxImage;
use App\Models\XxxProduct;
use App\Models\XxxProductImage;
use App\Models\XxxStockSummary;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Datastore
{
    //region Image

    public function getImage(int $id): ?Image
    {
        $record = DB::table('image')->find($id);

        if ($record) {
            return Image::fromRecord($record);
        }

        return null;
    }

    public function getImages(int $product_image_id): array
    {
        $list = [];

        $records = DB::table('image')->where('product_image_id', $product_image_id)->get();

        foreach ($records as $record) {
            $list []= Image::fromRecord($record);
        }

        return $list;
    }

    public function insertImage(Image $image): ?Image
    {
        DB::beginTransaction();

        try {
            $id = DB::table('image')->insertGetId(['url' => $image->getUrl(), 'image_type' => $image->getImageType(),
                'product_image_id' => $image->getProductImageId()]);

            DB::statement("INSERT INTO xxx_image (action, record_id, url, image_type, product_image_id, lock_version)
                    SELECT 'I', id, url, image_type, product_image_id, lock_version FROM image WHERE (id = ?);", [$id]);

            DB::commit();

            return $this->getImage($id);
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
        }

        return null;
    }

    public function getImageAudit(int $record_id): array
    {
        $list = [];

        $records = DB::table('xxx_image')->where('record_id', $record_id)->get();

        foreach ($records as $record) {
            $list []= XxxImage::fromRecord($record);
        }

        return $list;
    }

    //endregion

    //region Product

    public function getProduct(int $id): ?Product
    {
        $record = DB::table('product')->find($id);

        if ($record) {
            return Product::fromRecord($record);
        }

        return null;
    }

    public function getProductByBarcode(string $barcode): ?Product
    {
        $records = DB::table('product')->where('barcode', $barcode)->get();

        if (count($records) > 0) {
            return Product::fromRecord($records[0]);
        }

        return null;
    }

    public function insertProduct(Product $product): ?Product
    {
        DB::beginTransaction();

        try {
            $id = DB::table('product')->insertGetId(['barcode' => $product->getBarcode(),
                'name' => $product->getName(), 'description' => $product->getDescription()]);

            DB::statement("INSERT INTO xxx_product (action, record_id, barcode, name, description, lock_version)
                    SELECT 'I', id, barcode, name, description, lock_version FROM product WHERE (id = ?);", [$id]);

            DB::commit();

            return $this->getProduct($id);
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
        }

        return null;
    }

    public function getProductAudit(int $record_id): array
    {
        $list = [];

        $records = DB::table('xxx_product')->where('record_id', $record_id)->get();

        foreach ($records as $record) {
            $list []= XxxProduct::fromRecord($record);
        }

        return $list;
    }

    //endregion

    //region Product Image

    public function getProductImage(int $id): ?ProductImage
    {
        $record = DB::table('product_image')->find($id);

        if ($record) {
            return ProductImage::fromRecord($record);
        }

        return null;
    }

    public function getProductImages(int $product_id): array
    {
        $list = [];

        $records = DB::table('product_image')->where('product_id', $product_id)->get();

        foreach ($records as $record) {
            $list []= ProductImage::fromRecord($record);
        }

        return $list;
    }

    public function insertProductImage(ProductImage $record): ?ProductImage
    {
        DB::beginTransaction();

        try {
            $id = DB::table('product_image')->insertGetId(['product_id' => $record->getProductId()]);

            DB::statement("INSERT INTO xxx_product_image (action, record_id, product_id, lock_version)
                                    SELECT 'I', id, product_id, lock_version FROM product_image WHERE (id = ?);", [$id]);

            DB::commit();

            return $this->getProductImage($id);
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
        }

        return null;
    }

    public function getProductImageAudit(int $record_id): array
    {
        $list = [];

        $records = DB::table('xxx_product_image')->where('record_id', $record_id)->get();

        foreach ($records as $record) {
            $list []= XxxProductImage::fromRecord($record);
        }

        return $list;
    }

    //endregion

    //region Stock Summary

    public function getStockSummary(int $id): ?StockSummary
    {
        $record = DB::table('stock_summary')->find($id);

        if ($record) {
            return StockSummary::fromRecord($record);
        }

        return null;
    }

    public function getStockSummaryByProduct(int $product_id): ?StockSummary
    {
        $record = DB::table('stock_summary')->where('product_id', $product_id)->first();

        if ($record) {
            return StockSummary::fromRecord($record);
        }

        return null;
    }

    public function getStockSummaryAudit(int $record_id): array
    {
        $list = [];

        $records = DB::table('xxx_stock_summary')->where('record_id', $record_id)->get();

        foreach ($records as $record) {
            $list []= XxxStockSummary::fromRecord($record);
        }

        return $list;
    }

    public function insertStockSummary(StockSummary $record): ?StockSummary
    {
        DB::beginTransaction();

        try {
            $id = DB::table('stock_summary')->insertGetId(
                ['amount' => $record->getAmount(), 'product_id' => $record->getProductId()]);

            DB::statement("INSERT INTO xxx_stock_summary (action, record_id, amount, product_id, lock_version)
                                    SELECT 'I', id, amount, product_id, lock_version FROM stock_summary WHERE (id = ?);", [$id]);

            DB::commit();

            return $this->getStockSummary($id);
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
        }

        return null;
    }

    //endregion

    //region Stock Transaction

    public function getStockTransaction(int $id): ?StockTransaction
    {
        $record = DB::table('stock_transaction')->find($id);

        if ($record) {
            return StockTransaction::fromRecord($record);
        }

        return null;
    }

    public function getStockTransactionsBySummary(int $stock_summary_id): array
    {
        $list = [];

        $records = DB::table('stock_transaction')->where('stock_summary_id', $stock_summary_id)->get();

        foreach ($records as $record) {
            $list []= ProductImage::fromRecord($record);
        }

        return $list;
    }

    public function insertStockTransaction(StockTransaction $record): ?StockTransaction
    {
        try {
            $id = DB::table('stock_transaction')->insertGetId(
                ['operation' => $record->getOperation(), 'amount' => $record->getAmount(),
                    'stock_summary_id' => $record->getStockSummaryId()]);

            return $this->getStockTransaction($id);
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
        }

        return null;
    }

    //endregion

    //region Version

    public function getVersion(): ?Version
    {
        $record = DB::table('version')->select('id', 'major', 'minor', 'build', 'comment', 'created_at')->first();

        if ($record) {
            return Version::fromRecord($record);
        }

        return null;
    }

    //endregion
}
