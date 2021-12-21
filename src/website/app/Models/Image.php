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
    /**
     * Creates an instance of the class based on the data provided
     *
     * The valid image types are:
     * T - A thumb image
     * M - A medium sized image
     * L - A large sized image
     * X - An extra large image
     *
     * @param int $id The id of the underlying record
     * @param int $lock_version The lock version of the underlying the record
     * @param Carbon $created_at The date and time of the record was created
     * @param Carbon $updated_at The date and time the record was last updated
     * @param string $url The url of the image stored in the database
     * @param string $image_type The type of image record stored in the database
     * @param int $product_image_id The id of the product image to which the image belongs
     */
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at,
                                private string $url, private string $image_type, private int $product_image_id)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at);
    }

    /**
     * Returns the image url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Sets the image url
     *
     * @param string $url The value to set the url to
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * Returns the image type
     *
     * @return string
     */
    public function getImageType(): string
    {
        return $this->image_type;
    }

    /**
     * Sets the image type value
     *
     * @param string $image_type The value to set the image type to
     * @return void
     */
    public function setImageType(string $image_type): void
    {
        $this->image_type = $image_type;
    }

    /**
     * Returns the product image id
     *
     * @return int
     */
    public function getProductImageId(): int
    {
        return $this->product_image_id;
    }

    /**
     * Sets the product image id to the given value
     *
     * @param int $product_image_id The value to set the product image id to
     * @return void
     */
    public function setProductImageId(int $product_image_id): void
    {
        $this->product_image_id = $product_image_id;
    }

    /**
     * This method creates an image of the instance based on the data provided
     * The data is normally read from the database
     *
     * @param stdClass $record The data needed to create the instance
     * @return Image The new instance based on the data provided
     */
    public static function fromRecord(stdClass $record): Image
    {
        $id = intval($record->id);
        $url = $record->url;
        $image_type = $record->image_type;
        $product_image_id = $record->product_image_id;
        $lock_version = intval($record->lock_version);
        $created_at = Carbon::parse($record->created_at);
        $updated_at = Carbon::parse($record->updated_at);

        return new Image($id, $lock_version, $created_at, $updated_at, $url, $image_type, $product_image_id);
    }

    /**
     * Creates an instance of class based on the data provided
     *
     * @param string $url The url of the image
     * @param string $image_type The type of image
     * @param int $product_image_id The product image that owns the image
     * @return Image The new image instance
     */
    public static function asNew(string $url, string $image_type, int $product_image_id): Image
    {
        $current_date = new Carbon();

        return new Image(-1, 1, $current_date, $current_date, $url, $image_type, $product_image_id);
    }
}
