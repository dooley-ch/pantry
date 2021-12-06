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

    public function updateImage(Image $image): ?Image
    {
        DB::beginTransaction();

        try {
            $affected = DB::table('image')->where('id', $image->getId())->where('lock_version',
                $image->getLockVersion())->update(['url' => $image->getUrl(), 'image_type' => $image->getImageType(),
                'product_image_id' => $image->getProductImageId(), 'lock_version' => ($image->getLockVersion() + 1)]);

            if ($affected == 0) {
                // TODO - Log failure to update row
                return null;
            }

            DB::statement("INSERT INTO xxx_image (action, record_id, url, image_type, product_image_id, lock_version)
                                    SELECT 'U', id, url, image_type, product_image_id, lock_version FROM image
                                    WHERE (id = ?);", [$image->getId()]);

            DB::commit();

            return $this->getImage($image->getId());
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
        }

        return null;
    }

    public function deleteImage(Image $image): bool
    {
        DB::beginTransaction();

        try {
            DB::statement("INSERT INTO xxx_image (action, record_id, url, image_type, product_image_id, lock_version)
                                    SELECT 'D', id, url, image_type, product_image_id, lock_version FROM image
                                    WHERE (id = ?);", [$image->getId()]);

            $affected = DB::table('image')->where('id', $image->getId())->where('lock_version',
                $image->getLockVersion())->delete();

            if ($affected == 0) {
                // TODO - Log failure to update row
                return false;
            }

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
            return false;
        }

        return true;
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

    public function updateProduct(Product $product): ?Product
    {
        DB::beginTransaction();

        try {
            $affected = DB::table('product')->where('id', $product->getId())->where('lock_version',
                $product->getLockVersion())->update([
                'barcode' => $product->getBarcode(), 'name' => $product->getName(), 'description' => $product->getDescription(),
                'lock_version' => ($product->getLockVersion() + 1)]);

            if ($affected == 0) {
                // TODO - Log failure to update row
                return null;
            }

            DB::statement("INSERT INTO xxx_product (action, record_id, barcode, name, description, lock_version)
                    SELECT 'U', id, barcode, name, description, lock_version FROM product WHERE (id = ?);", [$product->getId()]);

            DB::commit();

            return $this->getProduct($product->getId());
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
        }

        return null;
    }

    public function deleteProduct(Product $product): bool
    {
        DB::beginTransaction();

        try {
            DB::statement("INSERT INTO xxx_product (action, record_id, barcode, name, description, lock_version)
                    SELECT 'D', id, barcode, name, description, lock_version FROM product WHERE (id = ?);", [$product->getId()]);

            $affected = DB::table('product')->where('id', $product->getId())->where('lock_version',
                $product->getLockVersion())->delete();

            if ($affected == 0) {
                // TODO - Log failure to update row
                return false;
            }


            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
            return false;
        }

        return true;
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

    public function updateProductImage(ProductImage $product_image): ?ProductImage
    {
        DB::beginTransaction();

        try {
            $affected = DB::table('product_image')->where('id', $product_image->getId())->where('lock_version',
                $product_image->getLockVersion())->update(['product_id' => $product_image->getProductId(),
                'lock_version' => ($product_image->getLockVersion() + 1)]);

            if ($affected == 0) {
                // TODO - Log failure to update row
                return null;
            }

            DB::statement("INSERT INTO xxx_product_image (action, record_id, product_id, lock_version)
                                    SELECT 'U', id, product_id, lock_version FROM product_image
                                    WHERE (id = ?);", [$product_image->getId()]);

            DB::commit();

            return $this->getProductImage($product_image->getId());
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
        }

        return null;
    }

    public function deleteProductImage(ProductImage $product_image): bool
    {
        DB::beginTransaction();

        try {
            DB::statement("INSERT INTO xxx_product_image (action, record_id, product_id, lock_version)
                                    SELECT 'D', id, product_id, lock_version FROM product_image
                                    WHERE (id = ?);", [$product_image->getId()]);

            $affected = DB::table('product_image')->where('id', $product_image->getId())->where('lock_version',
                $product_image->getLockVersion())->delete();

            if ($affected == 0) {
                // TODO - Log failure to update row
                return false;
            }

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
            return false;
        }

        return true;
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

    public function updateStockSummary(StockSummary $summary): ?StockSummary
    {
        DB::beginTransaction();

        try {
            $affected = DB::table('stock_summary')->where('id', $summary->getId())->where('lock_version',
                $summary->getLockVersion())->update(['amount' => $summary->getAmount(), 'product_id' => $summary->getProductId(),
                'lock_version' => ($summary->getLockVersion() + 1)]);

            if ($affected == 0) {
                // TODO - Log failure to update row
                return null;
            }

            DB::statement("INSERT INTO xxx_stock_summary (action, record_id, amount, product_id, lock_version)
                                    SELECT 'U', id, amount, product_id, lock_version FROM stock_summary
                                    WHERE (id = ?);", [$summary->getId()]);

            DB::commit();

            return $this->getStockSummary($summary->getId());
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
        }

        return null;
    }

    public function deleteStockSummary(StockSummary $summary): bool
    {
        DB::beginTransaction();

        try {
            DB::statement("INSERT INTO xxx_stock_summary (action, record_id, amount, product_id, lock_version)
                                    SELECT 'D', id, amount, product_id, lock_version FROM stock_summary
                                    WHERE (id = ?);", [$summary->getId()]);

            $affected = DB::table('stock_summary')->where('id', $summary->getId())->where('lock_version',
                $summary->getLockVersion())->delete();

            if ($affected == 0) {
                // TODO - Log failure to update row
                return false;
            }

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
            return false;
        }

        return true;
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

    public function updateStockTransaction(StockTransaction $transaction): ?StockTransaction
    {
        try {
            $affected = DB::table('stock_transaction')->where('id', $transaction->getId())->where('lock_version',
                $transaction->getLockVersion())->update(['operation' => $transaction->getOperation(),
                'amount' => $transaction->getAmount(), 'stock_summary_id' => $transaction->getStockSummaryId(),
                'lock_version' => ($transaction->getLockVersion() + 1)]);

            if ($affected == 0) {
                // TODO - Log failure to update row
                return null;
            }

            return $this->getStockTransaction($transaction->getId());
        } catch (QueryException $e) {
            // TODO - Log Error
        }

        return null;
    }

    public function deleteStockTransaction(StockTransaction $transaction): bool
    {
        try {
            $affected = DB::table('stock_transaction')->where('id', $transaction->getId())->where('lock_version',
                $transaction->getLockVersion())->delete();

            if ($affected == 1) {
                // TODO - Log failure to update row
                return true;
            }
        } catch (QueryException $e) {
            DB::rollBack();
            // TODO - Log Error
        }

        return false;
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
