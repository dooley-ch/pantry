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
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at, private int $product_id)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at);
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    public static function fromRecord(stdClass $record): ProductImage
    {
        $id = intval($record->id);
        $product_id = intval($record->id);
        $lock_version = intval($record->lock_version);
        $created_at = Carbon::parse($record->created_at);
        $updated_at = Carbon::parse($record->updated_at);

        return new ProductImage($id, $lock_version, $created_at, $updated_at, $product_id);
    }

    public static function asNew(int $product_id): ProductImage
    {
        $current_date = new Carbon();

        return new ProductImage(-1, 1, $current_date, $current_date, $product_id);
    }
}
