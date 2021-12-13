<?php
// *******************************************************************************************
//  File:  ProductExtended.php
//
//  Created: 13-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  13-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use stdClass;

/**
 * Class ProductExtended
 *
 * This class extends the product class to include the amount of the product in stock
 *
 * @package App\Models
 */
class ProductExtended extends Product
{
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at,
                                string $barcode, string $name, string $description, private int $amount)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at, $barcode, $name, $description);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public static function fromRecord(stdClass $record): ProductExtended
    {
        $id = $record->id;
        $barcode = $record->barcode;
        $name = $record->name;
        $description = $record->description;
        $amount = $record->amount;
        $lock_version = intval($record->lock_version);
        $created_at = Carbon::createFromTimestamp($record->created_at);
        $updated_at = Carbon::createFromTimestamp($record->updated_at);

        return new ProductExtended($id, $lock_version, $created_at, $updated_at, $barcode, $name, $description, $amount);
    }
}
