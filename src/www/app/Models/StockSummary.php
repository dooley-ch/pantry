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

use \stdClass;
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

    public static function fromRecord(stdClass $record): StockSummary
    {
        $id = intval($record->id);
        $amount = intval($record->amount);
        $product_id = intval($record->product_id);
        $lock_version = intval($record->lock_version);
        $created_at = Carbon::createFromTimestamp($record->created_at);
        $updated_at = Carbon::createFromTimestamp($record->updated_at);

        return new StockSummary($id, $lock_version, $created_at, $updated_at, $amount, $product_id);
    }

    public static function asNew(): StockSummary
    {
        $current_date = new Carbon();

        return new StockSummary(-1, 1, $current_date, $current_date, 0, -1);
    }
}
