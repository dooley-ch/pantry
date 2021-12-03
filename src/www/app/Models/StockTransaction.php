<?php
// *******************************************************************************************
//  File:  StockTransaction.php
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

class StockTransaction extends Record
{
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at,
                                private string $operation, private int $amount, private int $stock_summary_id)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at);
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function setOperation(string $operation): void
    {
        $this->operation = $operation;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getStockSummaryId(): int
    {
        return $this->stock_summary_id;
    }

    public function setStockSummaryId(int $stock_summary_id): void
    {
        $this->stock_summary_id = $stock_summary_id;
    }
}
