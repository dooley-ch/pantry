<?php
// *******************************************************************************************
//  File:  Datastore.php
//
//  Created: 04-12-2021
//
//  Copyright (c) 2021 James Dooley
//
//  Distributed under the MIT License (http://opensource.org/licenses/MIT).
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
use Illuminate\Support\Facades\Log;

/**
 * Class Datastore
 *
 * This class handles all access to the database for the application
 *
 * @package App\Core
 */
class Datastore
{
    //region Image

    /**
     * This method returns an image record from the database based on it's id
     *
     * @param int $id The id of the image record being requested
     * @return Image|null The image record if found, otherwise null
     */
    public function getImage(int $id): ?Image
    {
        $record = DB::table('image')->find($id);

        if ($record) {
            return Image::fromRecord($record);
        }

        return null;
    }

    /**
     * This method returns the images for a given product image based on the product image id.
     *
     * @param int $product_image_id The product
     * @return array
     */
    public function getImages(int $product_image_id): array
    {
        $list = [];

        $records = DB::table('image')->where('product_image_id', $product_image_id)->get();

        foreach ($records as $record) {
            $list []= Image::fromRecord($record);
        }

        return $list;
    }

    /**
     * This method inserts a new image in the database.
     *
     * @param Image $image The image to be stored in the database
     * @return Image|null The image record, populated with the new database values for id, lock_version etc.
     *                    or null if the record can't be inserted
     */
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
            Log::error('Failed to insert Image (' . $image->getUrl() . '): ' . $e->getMessage());
        }

        return null;
    }

    /**
     * This method updates the given image record in the database
     *
     * @param Image $image The image to be updated
     * @return Image|null The updated image containing new values for the lock_version and updated_at fields or null if the update fails.
     */
    public function updateImage(Image $image): ?Image
    {
        DB::beginTransaction();

        try {
            $affected = DB::table('image')->where('id', $image->getId())->where('lock_version',
                $image->getLockVersion())->update(['url' => $image->getUrl(), 'image_type' => $image->getImageType(),
                'product_image_id' => $image->getProductImageId(), 'lock_version' => ($image->getLockVersion() + 1)]);

            if ($affected == 0) {
                Log::warning('Failed to update image (' . $image->getId() . ') - No errors');
                return null;
            }

            DB::statement("INSERT INTO xxx_image (action, record_id, url, image_type, product_image_id, lock_version)
                                    SELECT 'U', id, url, image_type, product_image_id, lock_version FROM image
                                    WHERE (id = ?);", [$image->getId()]);

            DB::commit();

            return $this->getImage($image->getId());
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Failed to update Image (' . $image->getId() . '): ' . $e->getMessage());
        }

        return null;
    }

    /**
     * This method deletes the given image, provided the record has not been changed since it was loaded
     * from the database.  To check this the lock_version value is checked
     *
     * @param Image $image The image to be updated
     * @return bool True if the update is successful otherwise False
     */
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
                Log::warning('Failed to delete image (' . $image->getId() . ') - No errors');
                return false;
            }

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Failed to delete Image (' . $image->getId() . '): ' . $e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * This method returns the audit records for the given image id
     *
     * @param int $record_id The id of the image record for which the audit records are required
     * @return array A collection of audit records
     */
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

    /**
     * This method returns the product record for the given id
     *
     * @param int $id The id of the record to return
     * @return Product|null The product record if found, otherwise null
     */
    public function getProduct(int $id): ?Product
    {
        $record = DB::table('product')->find($id);

        if ($record) {
            return Product::fromRecord($record);
        }

        return null;
    }

    /**
     * This method returns the product record for the given barcode
     *
     * @param string $barcode The barcode of the record to return
     * @return Product|null The product record if found, otherwise null
     */
    public function getProductByBarcode(string $barcode): ?Product
    {
        $records = DB::table('product')->where('barcode', $barcode)->get();

        if (count($records) > 0) {
            return Product::fromRecord($records[0]);
        }

        return null;
    }

    /**
     * This method inserts a new product in the database
     *
     * @param Product $product The product to insert into the database
     * @return Product|null The product record, populated with the new database values for id, lock_version etc.
     *                      or null if the record can't be inserted
     */
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
            Log::error('Failed to insert Product (' . $product->getName() . '): ' . $e->getMessage());
        }

        return null;
    }

    /**
     * This method updates the given product record in the database
     *
     * @param Product $product The product to update
     * @return Product|null The product record, populated with the new database values for lock_version and updated_at etc.
     *                      or null if the record can't be updated
     */
    public function updateProduct(Product $product): ?Product
    {
        DB::beginTransaction();

        try {
            $affected = DB::table('product')->where('id', $product->getId())->where('lock_version',
                $product->getLockVersion())->update([
                'barcode' => $product->getBarcode(), 'name' => $product->getName(), 'description' => $product->getDescription(),
                'lock_version' => ($product->getLockVersion() + 1)]);

            if ($affected == 0) {
                Log::warning('Failed to insert Product (' . $product->getName() . '): No Errors');
                return null;
            }

            DB::statement("INSERT INTO xxx_product (action, record_id, barcode, name, description, lock_version)
                    SELECT 'U', id, barcode, name, description, lock_version FROM product WHERE (id = ?);", [$product->getId()]);

            DB::commit();

            return $this->getProduct($product->getId());
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Failed to update Product (' . $product->getName() . '): ' . $e->getMessage());
        }

        return null;
    }

    /**
     * This method deletes the given product record from the database
     *
     * @param Product $product The product to be deleted
     * @return bool True if the record is deleted otherwise False
     */
    public function deleteProduct(Product $product): bool
    {
        DB::beginTransaction();

        try {
            DB::statement("INSERT INTO xxx_product (action, record_id, barcode, name, description, lock_version)
                    SELECT 'D', id, barcode, name, description, lock_version FROM product WHERE (id = ?);", [$product->getId()]);

            $affected = DB::table('product')->where('id', $product->getId())->where('lock_version',
                $product->getLockVersion())->delete();

            if ($affected == 0) {
                Log::warning('Failed to delete Product (' . $product->getName() . '): No Errors');
                return false;
            }


            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Failed to delete Product (' . $product->getName() . '): ' . $e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * This method returns the audit records for a given product id
     *
     * @param int $record_id The id of the product for which the audit records are requested
     * @return array The audit records
     */
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

    /**
     * This method returns the product image record from the database based on it's id
     *
     * @param int $id The id of the product image record being requested
     * @return ProductImage|null The product image record if found, otherwise null
     */
    public function getProductImage(int $id): ?ProductImage
    {
        $record = DB::table('product_image')->find($id);

        if ($record) {
            return ProductImage::fromRecord($record);
        }

        return null;
    }

    /**
     * This method returns the product images for a given product
     *
     * @param int $product_id The id of the product for which the images are required
     * @return array The product images
     */
    public function getProductImages(int $product_id): array
    {
        $list = [];

        $records = DB::table('product_image')->where('product_id', $product_id)->get();

        foreach ($records as $record) {
            $list []= ProductImage::fromRecord($record);
        }

        return $list;
    }

    /**
     * This method inserts a new product image in the database
     *
     * @param ProductImage $product_image The product image to be inserted into the database
     * @return ProductImage|null The product image record, populated with the new database values for id, lock_version etc.
     *                           or null if the record can't be inserted
     */
    public function insertProductImage(ProductImage $product_image): ?ProductImage
    {
        DB::beginTransaction();

        try {
            $id = DB::table('product_image')->insertGetId(['product_id' => $product_image->getProductId()]);

            DB::statement("INSERT INTO xxx_product_image (action, record_id, product_id, lock_version)
                                    SELECT 'I', id, product_id, lock_version FROM product_image WHERE (id = ?);", [$id]);

            DB::commit();

            return $this->getProductImage($id);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Failed to insert Product Image (' . $product_image->getId() . '): ' . $e->getMessage());
        }

        return null;
    }

    /**
     * This method updates the product image record in the database
     *
     * @param ProductImage $product_image The product image to update
     * @return ProductImage|null The product image record, populated with the new database values for lock_version, updated_at etc.
     *                           or null if the record can't be inserted
     */
    public function updateProductImage(ProductImage $product_image): ?ProductImage
    {
        DB::beginTransaction();

        try {
            $affected = DB::table('product_image')->where('id', $product_image->getId())->where('lock_version',
                $product_image->getLockVersion())->update(['product_id' => $product_image->getProductId(),
                'lock_version' => ($product_image->getLockVersion() + 1)]);

            if ($affected == 0) {
                Log::warning('Failed to update Product Image (' . $product_image->getId() . '): No Errors');
                return null;
            }

            DB::statement("INSERT INTO xxx_product_image (action, record_id, product_id, lock_version)
                                    SELECT 'U', id, product_id, lock_version FROM product_image
                                    WHERE (id = ?);", [$product_image->getId()]);

            DB::commit();

            return $this->getProductImage($product_image->getId());
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Failed to update Product Image (' . $product_image->getId() . '): ' . $e->getMessage());
        }

        return null;
    }

    /**
     * This method deletes the given product image record
     *
     * @param ProductImage $product_image The product image to delete
     * @return bool True if the record was deleted, otherwise False
     */
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
                Log::warning('Failed to delete Product Image (' . $product_image->getId() . '): No Errors');
                return false;
            }

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Failed to delete Product Image (' . $product_image->getId() . '): ' . $e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * This method returns the audit records for a given product image
     *
     * @param int $record_id The product image id for which audit records are required
     * @return array A collection of audit records
     */
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

    /**
     * This method returns the stock summary record based on it's record id
     *
     * @param int $id The id of the stock summary required
     * @return StockSummary|null The stock summary record or null if no record is required
     */
    public function getStockSummary(int $id): ?StockSummary
    {
        $record = DB::table('stock_summary')->find($id);

        if ($record) {
            return StockSummary::fromRecord($record);
        }

        return null;
    }

    /**
     * This method returns the stock summary for a given product id
     *
     * @param int $product_id The product id for which the summary record is required
     * @return StockSummary|null The stock summary record or null if no record is required
     */
    public function getStockSummaryByProduct(int $product_id): ?StockSummary
    {
        $record = DB::table('stock_summary')->where('product_id', $product_id)->first();

        if ($record) {
            return StockSummary::fromRecord($record);
        }

        return null;
    }

    /**
     * This method inserts a stock summary record into the database
     * @param StockSummary $summary The stock summary record to insert
     * @return StockSummary|null The stock summary record, populated with the new database values for id, lock_version etc.
     *                           or null if the record can't be inserted
     */
    public function insertStockSummary(StockSummary $summary): ?StockSummary
    {
        DB::beginTransaction();

        try {
            $id = DB::table('stock_summary')->insertGetId(
                ['amount' => $summary->getAmount(), 'product_id' => $summary->getProductId()]);

            DB::statement("INSERT INTO xxx_stock_summary (action, record_id, amount, product_id, lock_version)
                                    SELECT 'I', id, amount, product_id, lock_version FROM stock_summary WHERE (id = ?);", [$id]);

            DB::commit();

            return $this->getStockSummary($id);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Failed to insert Stock Summary (' . $summary->getId() . '): ' . $e->getMessage());
        }

        return null;
    }

    /**
     * This method updates a stock summary record in the database
     *
     * @param StockSummary $summary The stock summary record to update
     * @return StockSummary|null The stock summary record, populated with the new database values for lock_version, updated_at etc.
     *                           or null if the record can't be updated
     */
    public function updateStockSummary(StockSummary $summary): ?StockSummary
    {
        DB::beginTransaction();

        try {
            $affected = DB::table('stock_summary')->where('id', $summary->getId())->where('lock_version',
                $summary->getLockVersion())->update(['amount' => $summary->getAmount(), 'product_id' => $summary->getProductId(),
                'lock_version' => ($summary->getLockVersion() + 1)]);

            if ($affected == 0) {
                Log::warning('Failed to update Stock Summary (' . $summary->getId() . '): No Errors');
                return null;
            }

            DB::statement("INSERT INTO xxx_stock_summary (action, record_id, amount, product_id, lock_version)
                                    SELECT 'U', id, amount, product_id, lock_version FROM stock_summary
                                    WHERE (id = ?);", [$summary->getId()]);

            DB::commit();

            return $this->getStockSummary($summary->getId());
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Failed to update Stock Summary (' . $summary->getId() . '): ' . $e->getMessage());
        }

        return null;
    }

    /**
     * This method deletes a given stock summary record from the database
     *
     * @param StockSummary $summary The stock summary record to delete
     * @return bool True if the record was deleted, otherwise False
     */
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
                Log::warning('Failed to delete Stock Summary (' . $summary->getId() . '): No Errors');
                return false;
            }

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Failed to delete Stock Summary (' . $summary->getId() . '): ' . $e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * This method returns the audit records for the given stock summary record
     *
     * @param int $record_id The id of the stock summary record for which audit records are required
     * @return array The audit records
     */
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

    /**
     * This method returns the stock transaction by id
     *
     * @param int $id The id of the stock transaction to return
     * @return StockTransaction|null The stock transaction record or null if not found
     */
    public function getStockTransaction(int $id): ?StockTransaction
    {
        $record = DB::table('stock_transaction')->find($id);

        if ($record) {
            return StockTransaction::fromRecord($record);
        }

        return null;
    }

    /**
     * This method returns the transaction records for a given stock summary
     *
     * @param int $stock_summary_id The id of the stock summary for which the transaction records are required
     * @return array A collection of stock summary records
     */
    public function getStockTransactionsBySummary(int $stock_summary_id): array
    {
        $list = [];

        $records = DB::table('stock_transaction')->where('stock_summary_id', $stock_summary_id)->get();

        foreach ($records as $record) {
            $list []= ProductImage::fromRecord($record);
        }

        return $list;
    }

    /**
     * This method inserts a new transaction record in the database
     *
     * @param StockTransaction $transaction The transaction record to insert
     * @return StockTransaction|null The stock transaction record, populated with the new database values for id, lock_version etc.
     *                               or null if the record can't be inserted
     */
    public function insertStockTransaction(StockTransaction $transaction): ?StockTransaction
    {
        try {
            $id = DB::table('stock_transaction')->insertGetId(
                ['operation' => $transaction->getOperation(), 'amount' => $transaction->getAmount(),
                    'stock_summary_id' => $transaction->getStockSummaryId()]);

            return $this->getStockTransaction($id);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Failed to insert Stock Transaction (' . $transaction->getId() . '): ' . $e->getMessage());
        }

        return null;
    }

    /**
     * This method updates a stock transaction record in the database
     *
     * @param StockTransaction $transaction The stock transaction to be updated
     * @return StockTransaction|null The stock transaction record, populated with the new database values for lock_version, updated_at etc.
     *                               or null if the record can't be inserted
     */
    public function updateStockTransaction(StockTransaction $transaction): ?StockTransaction
    {
        try {
            $affected = DB::table('stock_transaction')->where('id', $transaction->getId())->where('lock_version',
                $transaction->getLockVersion())->update(['operation' => $transaction->getOperation(),
                'amount' => $transaction->getAmount(), 'stock_summary_id' => $transaction->getStockSummaryId(),
                'lock_version' => ($transaction->getLockVersion() + 1)]);

            if ($affected == 0) {
                Log::warning('Failed to update Stock Transaction (' . $transaction->getId() . '): No Errors');
                return null;
            }

            return $this->getStockTransaction($transaction->getId());
        } catch (QueryException $e) {
            Log::error('Failed to update Stock Transaction (' . $transaction->getId() . '): ' . $e->getMessage());
        }

        return null;
    }

    /**
     * This method deletes a given stock transaction record from the database
     *
     * @param StockTransaction $transaction The transaction to be deleted
     * @return bool True if the record was deleted otherwise False
     */
    public function deleteStockTransaction(StockTransaction $transaction): bool
    {
        try {
            $affected = DB::table('stock_transaction')->where('id', $transaction->getId())->where('lock_version',
                $transaction->getLockVersion())->delete();

            if ($affected == 1) {
                Log::warning('Failed to delete Stock Transaction (' . $transaction->getId() . '): No Errors');
                return true;
            }
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Failed to delete Stock Transaction (' . $transaction->getId() . '): ' . $e->getMessage());
        }

        return false;
    }

    //endregion

    //region Version

    /**
     * This method returns the database version number
     *
     * @return Version|null The current database version number or null if none is available
     */
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
