<?php
// *******************************************************************************************
//  File:  StockTransaction.php
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
 * Class StockTransaction
 *
 * This class maps to the stock transaction table in the database
 *
 * @package App\Models
 */
class StockTransaction extends Record
{
    /**
     * This method creates a new instance of the class with the data provided
     *
     * The operation flags are:
     * A - Add
     * @param int $id The id of the underlying record
     * @param int $lock_version The lock version of the underlying database record
     * @param Carbon $created_at The date and time the record was created
     * @param Carbon $updated_at The date and time the record was last updated
     * @param string $operation The type of the transaction represented by the record
     * @param int $amount The number of units in the transaction
     * @param int $stock_summary_id The summary id to which the transactions relate
     */
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at,
                                private string $operation, private int $amount, private int $stock_summary_id)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at);
    }

    /**
     * Returns the operation flag
     *
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * Sets the operation flag
     *
     * @param string $operation The value to set the operation flag to
     * @return void
     */
    public function setOperation(string $operation): void
    {
        $this->operation = $operation;
    }

    /**
     * Returns the number of units in the transaction
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Sets the number of units in the transaction
     *
     * @param int $amount The value to set the amount to
     * @return void
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Returns the stock summary id
     *
     * @return int
     */
    public function getStockSummaryId(): int
    {
        return $this->stock_summary_id;
    }

    /**
     * Sets the stock summary id
     *
     * @param int $stock_summary_id The value to set the stock summary id
     * @return void
     */
    public function setStockSummaryId(int $stock_summary_id): void
    {
        $this->stock_summary_id = $stock_summary_id;
    }

    /**
     * Creates an instance of the class from the given data
     * The data is normally read from the database
     *
     * @param stdClass $record The data needed to create the instance
     * @return StockTransaction The new instance
     */
    public static function fromRecord(stdClass $record): StockTransaction
    {
        $id = intval($record->id);
        $operation = $record->operation;
        $amount = intval($record->amount);
        $stock_summary_id = intval($record->stock_summary_id);
        $lock_version = intval($record->lock_version);
        $created_at = Carbon::parse($record->created_at);
        $updated_at = Carbon::parse($record->updated_at);

        return new StockTransaction($id, $lock_version, $created_at, $updated_at, $operation, $amount, $stock_summary_id);
    }

    /**
     * Creates a new instance of the class with the given data
     *
     * @param string $operation The type of the transaction represented by the record
     * @param int $amount The number of units in the transaction
     * @param int $stock_summary_id The summary id to which the transactions relate
     * @return StockTransaction The new instance
     */
    public static function asNew(string $operation, int $amount, int $stock_summary_id): StockTransaction
    {
        $current_date = new Carbon();

        return new StockTransaction(-1, 1, $current_date, $current_date, $operation, $amount, $stock_summary_id);
    }
}
