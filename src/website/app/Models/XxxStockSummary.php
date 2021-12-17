<?php
// *******************************************************************************************
//  File:  XxxStockSummary.php
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

use \stdClass;
use Carbon\Carbon;

/**
 * Class XxxStockSummary
 *
 * This class maps to the xxx_stock_summary table in the database
 *
 * @package App\Models
 */
class XxxStockSummary extends AuditRecord
{
    public function __construct(int $id, Carbon $logged_at, string $action, int $record_id, int $lock_version,
                                private int $amount, private int $product_id)
    {
        parent::__construct($id, $logged_at, $action, $record_id, $lock_version);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public static function fromRecord(stdClass $record): XxxStockSummary
    {
        $id = intval($record->id);
        $logged_at = Carbon::parse($record->logged_at);
        $action = $record->action;
        $record_id = intval($record->record_id);
        $amount = intval($record->amount);
        $product_id = intval($record->product_id);
        $lock_version = intval($record->lock_version);

        return new XxxStockSummary($id, $logged_at, $action, $record_id, $amount, $product_id, $lock_version);
    }
}
