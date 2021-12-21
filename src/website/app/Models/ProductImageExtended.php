<?php
// *******************************************************************************************
//  File:  ProductImageExtended.php
//
//  Created: 15-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  15-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

/**
 * Class ProductImageExtended
 *
 * This class extends the product image with the images it owns
 *
 * @package App\Models
 */
class ProductImageExtended extends ProductImage
{
    private array $images;

    /**
     * Creates an instance of the class using the data provided
     *
     * @param int $id The id of the underlying record
     * @param int $lock_version The lock version value for the underlying record
     * @param Carbon $created_at The date and time the record was created
     * @param Carbon $updated_at The date and time the record was last updated
     * @param int $product_id The product that owns the product images
     */
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at, int $product_id)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at, $product_id);
    }

    /**
     * Returns the images associated with the Product Image
     *
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * Sets the images associated with the product image
     *
     * @param array $images The value to set the images to
     * @return void
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
    }
}
