<?php
// *******************************************************************************************
//  File:  ProductImage.php
//
//  Created: 03-12-2021
//
//  Copyright (c) 2021 James Dooley
//
//  Distributed under the MIT License (http://opensource.org/licenses/MIT).
//
//  History:
//  03-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace App\Models;

use \stdClass;
use Carbon\Carbon;

/**
 * Class ProductImage
 *
 * This class maps to the product image table
 *
 * @package App\Models
 */
class ProductImage extends Record
{
    /**
     * Creates an instance of class based on the data provided
     *
     * @param int $id The id of the underlying record
     * @param int $lock_version The lock version value for the underlying record
     * @param Carbon $created_at The date and time the record was created
     * @param Carbon $updated_at The date and time the record was last updated
     * @param int $product_id The id of the product to which the images belong
     */
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at, private int $product_id)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at);
    }

    /**
     * Returns the product id
     *
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * Sets the product id
     *
     * @param int $product_id The value to which product id should be set to
     * @return void
     */
    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    /**
     * This method creates an instance of the class based on the data provided
     * This data is normally read from the database
     *
     * @param stdClass $record The data needed to create an instance of the class
     * @return ProductImage The new instance
     */
    public static function fromRecord(stdClass $record): ProductImage
    {
        $id = intval($record->id);
        $product_id = intval($record->id);
        $lock_version = intval($record->lock_version);
        $created_at = Carbon::parse($record->created_at);
        $updated_at = Carbon::parse($record->updated_at);

        return new ProductImage($id, $lock_version, $created_at, $updated_at, $product_id);
    }

    /**
     * Creates an instance of the class based on the data provided
     *
     * @param int $product_id The id of the product who owns the product image
     * @return ProductImage The new instance of the class
     */
    public static function asNew(int $product_id): ProductImage
    {
        $current_date = new Carbon();

        return new ProductImage(-1, 1, $current_date, $current_date, $product_id);
    }
}
