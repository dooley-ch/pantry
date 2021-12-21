<?php
// *******************************************************************************************
//  File:  StockSummaryExtended.php
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

use Carbon\Carbon;

/**
 * Class StockSummaryExtended
 *
 * Extends the StockSummary class with the individual transactions
 *
 * @package App\Models
 */
class StockSummaryExtended extends StockSummary
{
    private array $transactions;

    /**
     * Creates an instance of the class using the data provided
     *
     * @param int $id The id of the underlying record
     * @param int $lock_version The lock version of the underlying database record
     * @param Carbon $created_at The date and time the record was created
     * @param Carbon $updated_at The date and time the record was last updated
     * @param int $amount The number of units in stock
     * @param int $product_id The product to which the summary relates
     */
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at, int $amount, int $product_id)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at, $amount, $product_id);
    }

    /**
     * Returns the transactions associated with the summary
     *
     * @return array
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }

    /**
     * Sets the transactions associated with the summary
     *
     * @param array $transactions The value to set the transactions to
     * @return void
     */
    public function setTransactions(array $transactions): void
    {
        $this->transactions = $transactions;
    }
}
