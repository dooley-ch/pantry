<?php
// *******************************************************************************************
//  File:  StockSummary.php
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
 * Class StockSummary
 *
 * This class maps to the stock summary table in the database
 *
 * @package App\Models
 */
class StockSummary extends Record
{
    /**
     * This method creates a new instance of the class with the given data
     *
     * @param int $id The id of the underlying record
     * @param int $lock_version The lock version of the underlying database record
     * @param Carbon $created_at The date and time the record was created
     * @param Carbon $updated_at The date and time the record was last updated
     * @param int $amount The number of units in stock
     * @param int $product_id The id of the product to which this summary relates
     */
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at,
                                private int $amount, private int $product_id)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at);
    }

    /**
     * Returns the number of units in stock for the given product id
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Sets the number of units in stock
     *
     * @param int $amount The value to set the amount to
     * @return void
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Returns the product id which owns the summary
     *
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * Sets the product id
     *
     * @param int $product_id The value to set the product id to
     * @return void
     */
    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    /**
     * Creates an instance of the class based on the data provided
     *
     * @param stdClass $record The data needed to create the instance
     * @return StockSummary The new instance
     */
    public static function fromRecord(stdClass $record): StockSummary
    {
        $id = intval($record->id);
        $amount = intval($record->amount);
        $product_id = intval($record->product_id);
        $lock_version = intval($record->lock_version);
        $created_at = Carbon::parse($record->created_at);
        $updated_at = Carbon::parse($record->updated_at);

        return new StockSummary($id, $lock_version, $created_at, $updated_at, $amount, $product_id);
    }

    /**
     * Creates an instance of the class based on the data provided
     *
     * @param int $amount The number of units of the product in stock
     * @param int $product_id The product id
     * @return StockSummary The new instance
     */
    public static function asNew(int $amount,  int $product_id): StockSummary
    {
        $current_date = new Carbon();

        return new StockSummary(-1, 1, $current_date, $current_date, $amount, $product_id);
    }
}
