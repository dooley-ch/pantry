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
    /**
     * Creates a new instance of the class using the data provided
     *
     * @param int $id The id of the underlying record
     * @param int $lock_version The lock version value for the underlying record
     * @param Carbon $created_at The date and time the record was created
     * @param Carbon $updated_at The date and time the record was last updated
     * @param string $code The Open Food Repo code for the product
     * @param string $barcode The product barcode
     * @param string $name The product name
     * @param string $description The product description
     * @param int $amount The number of units the product in stock
     */
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at,
                                string $code, string $barcode, string $name, string $description, private int $amount)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at, $code, $barcode, $name, $description);
    }

    /**
     * Returns the number of units of the product on hand
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * This method creates an instance of the class based on the data provided
     *
     * @param stdClass $record The data needed to create the instance
     * @return ProductExtended The new instance of class
     */
    public static function fromRecord(stdClass $record): ProductExtended
    {
        $id = $record->id;
        $code = $record->code;
        $barcode = $record->barcode;
        $name = $record->name;
        $description = $record->description;
        $amount = $record->amount;
        $lock_version = intval($record->lock_version);
        $created_at = Carbon::parse($record->created_at);
        $updated_at = Carbon::parse($record->updated_at);

        return new ProductExtended($id, $lock_version, $created_at, $updated_at, $code, $barcode, $name, $description, $amount);
    }
}
