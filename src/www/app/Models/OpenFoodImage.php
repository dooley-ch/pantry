<?php
// *******************************************************************************************
//  File:  OpenFoodImage.php
//
//  Created: 09-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  09-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace App\Models;

class OpenFoodImage
{
    public function __construct(private string $thumb, private string $medium, private string $large,
                                private string $xlarge, private array $tags)
    {
    }

    public function getThumb(): string
    {
        return $this->thumb;
    }

    public function getMedium(): string
    {
        return $this->medium;
    }

    public function getLarge(): string
    {
        return $this->large;
    }

    public function getXlarge(): string
    {
        return $this->xlarge;
    }

    public function getTags(): array
    {
        return $this->tags;
    }
}
