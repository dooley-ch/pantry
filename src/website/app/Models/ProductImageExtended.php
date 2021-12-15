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

class ProductImageExtended extends ProductImage
{
    private array $images;

    public function __construct($id, $lock_version, $created_at, $updated_at, $product_id)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at, $product_id);
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(array $images): void
    {
        $this->images = $images;
    }
}
