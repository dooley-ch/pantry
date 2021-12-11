<?php
// *******************************************************************************************
//  File:  Product.php
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
 * Class Product
 *
 * This class maps to the product table in the database
 *
 * @package App\Models
 */
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

    public static function fromRecord(stdClass $record): Product
    {
        $id = intval($record->id);
        $barcode = $record->barcode;
        $name = $record->name;
        $description = $record->description;
        $lock_version = intval($record->lock_version);
        $created_at = Carbon::createFromTimestamp($record->created_at);
        $updated_at = Carbon::createFromTimestamp($record->updated_at);

        return new Product($id, $lock_version, $created_at, $updated_at, $barcode, $name, $description);
    }

    public static function asNew(string $barcode, string $name, string $description): Product
    {
        $current_date = new Carbon();

        return new Product(-1, 1, $current_date, $current_date, $barcode, $name, $description);
    }
}
