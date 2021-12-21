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

use stdClass;
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
    /**
     * Creates an instance of the class using the given data
     *
     * @param int $id The id of the underlying record
     * @param Carbon $logged_at The date and time the action was logged
     * @param string $action The type of action performed on the record being audited
     * @param int $record_id The id of the record being audited
     * @param int $lock_version The lock version of the record being audited
     * @param int $amount The amount included in the underlying record
     * @param int $product_id The product id included in the underlying record
     */
    public function __construct(int $id, Carbon $logged_at, string $action, int $record_id, int $lock_version,
                                private int $amount, private int $product_id)
    {
        parent::__construct($id, $logged_at, $action, $record_id, $lock_version);
    }

    /**
     * Returns the amount entered in the underlying database record
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Returns the id of the product to which the summary belongs
     *
     * @return int The product id
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * Creates an instance of the class based on the data provided.
     * The data is normally read from the database.
     *
     * @param stdClass $record The data used to create the instance
     * @return XxxStockSummary The new class instance
     */
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
