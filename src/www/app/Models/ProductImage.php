<?php
// *******************************************************************************************
//  File:  ProductImage.php
//
//  Created: 03-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  03-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace App\Models;

use \stdClass;
use Carbon\Carbon;

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
        $created_at = Carbon::createFromTimestamp($record->created_at);
        $updated_at = Carbon::createFromTimestamp($record->updated_at);

        return new ProductImage($id, $lock_version, $created_at, $updated_at, $product_id);
    }

    public static function asNew(): Image
    {
        $current_date = new Carbon();

        return new Image(-1, 1, $current_date, $current_date, '', '', -1);
    }
}
