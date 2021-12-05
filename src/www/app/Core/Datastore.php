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
