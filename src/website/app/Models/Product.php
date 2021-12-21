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
    /**
     * Creates an instance of the class based on the data provided
     *
     * @param int $id The id of the underlying record
     * @param int $lock_version The lock version value for the underlying record
     * @param Carbon $created_at The date and time the record was created
     * @param Carbon $updated_at The date and time the record was last updated
     * @param string $code The Open Food Repo code for the product
     * @param string $barcode The barcode for the product
     * @param string $name The product name
     * @param string $description The product description
     */
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at,
                                private string $code, private string $barcode, private string $name, private string $description)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at);
    }

    /**
     * Returns the barcode for the product
     *
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->barcode;
    }

    /**
     * Sets the barcode for the product
     *
     * @param string $barcode The value to set the barcode to
     * @return void
     */
    public function setBarcode(string $barcode): void
    {
        $this->barcode = $barcode;
    }

    /**
     * Returns the product name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets te product name
     *
     * @param string $name The value to set the name to
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns the product description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Sets the product description
     *
     * @param string $description The value to set the description to
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns the product code
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Sets the product code
     *
     * @param string $code The value to set the code to
     * @return void
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * Creates instance of the product from the data provided
     *
     * @param stdClass $record The data needed to create the instance
     * @return Product The new instance
     */
    public static function fromRecord(stdClass $record): Product
    {
        $id = $record->id;
        $code = $record->code;
        $barcode = $record->barcode;
        $name = $record->name;
        $description = $record->description;
        $lock_version = intval($record->lock_version);
        $created_at = Carbon::parse($record->created_at);
        $updated_at = Carbon::parse($record->updated_at);

        return new Product($id, $lock_version, $created_at, $updated_at, $code, $barcode, $name, $description);
    }

    /**
     * Creates a new instance of the class using the data provided
     *
     * @param string $code The Open Food Repo code for the product
     * @param string $barcode The product barcode
     * @param string $name The product name
     * @param string $description The product description
     * @return Product The new product instance
     */
    public static function asNew(string $code, string $barcode, string $name, string $description): Product
    {
        $current_date = new Carbon();

        return new Product(-1, 1, $current_date, $current_date, $code, $barcode, $name, $description);
    }
}
