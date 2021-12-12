<?php
// *******************************************************************************************
//  File:  Image.php
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

use stdClass;
use Carbon\Carbon;

/**
 * Class Image
 *
 * This class maps to the image table in the database
 *
 * @package App\Models
 */
class Image extends Record
{
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at,
                                private string $url, private string $image_type, private int $product_image_id)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getImageType(): string
    {
        return $this->image_type;
    }

    public function setImageType(string $image_type): void
    {
        $this->image_type = $image_type;
    }

    public function getProductImageId(): int
    {
        return $this->product_image_id;
    }

    public function setProductImageId(int $product_image_id): void
    {
        $this->product_image_id = $product_image_id;
    }

    public static function fromRecord(stdClass $record): Image
    {
        $id = intval($record->id);
        $url = $record->url;
        $image_type = $record->image_type;
        $product_image_id = $record->product_image_id;
        $lock_version = intval($record->lock_version);
        $created_at = Carbon::createFromTimestamp($record->created_at);
        $updated_at = Carbon::createFromTimestamp($record->updated_at);

        return new Image($id, $lock_version, $created_at, $updated_at, $url, $image_type, $product_image_id);
    }

    public static function asNew(string $url, string $image_type, int $product_image_id): Image
    {
        $current_date = new Carbon();

        return new Image(-1, 1, $current_date, $current_date, $url, $image_type, $product_image_id);
    }
}
