<?php
// *******************************************************************************************
//  File:  XxxImage.php
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
 * Class XxxImage
 *
 * This class maps to the xxx_image table in the database
 *
 * @package App\Models
 */
class XxxImage extends AuditRecord
{
    /**
     * Creates a new instance of the class based on the data provided
     *
     * @param int $id The id of the underlying database record
     * @param Carbon $logged_at The date and time the action was logged
     * @param string $action The type of action performed on the record
     * @param int $record_id The id of the record being audited
     * @param int $lock_version The lock version of the record being audited
     * @param string $url The url of the actual image
     * @param string $image_type The type of image represented by the record
     * @param int $product_image_id The id of the product image id to which the image belongs
     */
    public function __construct(int $id, Carbon $logged_at, string $action, int $record_id, int $lock_version,
                                private string $url, private string $image_type, private int $product_image_id)
    {
        parent::__construct($id, $logged_at, $action, $record_id, $lock_version);
    }

    /**
     * Returns the url for the image
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Returns the type of the image represented by the record
     *
     * @return string
     */
    public function getImageType(): string
    {
        return $this->image_type;
    }

    /**
     * Returns the product image id to which the images belong
     *
     * @return int
     */
    public function getProductImageId(): int
    {
        return $this->product_image_id;
    }

    /**
     * This method creates an instance of the class, based on the data provided.
     * The data is usually read from the database.
     *
     * @param stdClass $record The source data to use in creating the XxxImage
     * @return XxxImage An instance of the class created from the data supplied
     */
    public static function fromRecord(stdClass $record): XxxImage
    {
        $id = intval($record->id);
        $logged_at = Carbon::parse($record->logged_at);
        $action = $record->action;
        $record_id = intval($record->record_id);
        $url = $record->url;
        $image_type = $record->image_type;
        $product_image_id = intval($record->product_image_id);
        $lock_version = intval($record->lock_version);

        return new XxxImage($id, $logged_at, $action, $record_id, $lock_version, $url, $image_type, $product_image_id);
    }
}
