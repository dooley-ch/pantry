<?php
// *******************************************************************************************
//  File:  StockSummary.php
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

class StockSummary extends Record
{
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at,
                                private int $amount, private int $product_id)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }
}
