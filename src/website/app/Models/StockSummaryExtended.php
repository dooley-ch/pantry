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

class StockSummaryExtended extends StockSummary
{
    private array $transactions;

    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at, int $amount, int $product_id)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at, $amount, $product_id);
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function setTransactions(array $transactions): void
    {
        $this->transactions = $transactions;
    }
}
