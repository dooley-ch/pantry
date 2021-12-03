<?php
// *******************************************************************************************
//  File:  Image.php
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

use Carbon\Carbon;

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
}
