<?php
// *******************************************************************************************
//  File:  Product.php
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

class Product extends Record
{
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at,
                                private string $barcode, private string $name, private string $description)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at);
    }

    public function getBarcode(): string
    {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): void
    {
        $this->barcode = $barcode;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

   public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
