<?php
// *******************************************************************************************
//  File:  XxxProductImage.php
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
 * Class XxxProductImage
 *
 * This class maps to the xxx_product_image table in the database
 *
 * @package App\Models
 */
class XxxProductImage extends AuditRecord
{
    /**
     * This method creates an instance of the class, based on the data provided
     *
     * @param int $id The id of the underlying database record
     * @param Carbon $logged_at The date and time the action was logged
     * @param string $action The type of action performed on the underlying record
     * @param int $record_id The id of the record being audited
     * @param int $lock_version The lock version of the record being audited
     * @param int $product_id The product id included in the record being audited
     */
    public function __construct(int $id, Carbon $logged_at, string $action, int $record_id, int $lock_version,
                                private int $product_id)
    {
        parent::__construct($id, $logged_at, $action, $record_id, $lock_version);
    }

    /**
     * Returns the product image id of the product that owns the image
     *
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * This method creates an instance of the class based on the data provided.
     * The data is usually read from the database
     *
     * @param stdClass $record The data needed to create the new instance
     * @return XxxProductImage The new instance of the class based on the data provided
     */
    public static function fromRecord(stdClass $record): XxxProductImage
    {
        $id = intval($record->id);
        $logged_at = Carbon::parse($record->logged_at);
        $action = $record->action;
        $record_id = intval($record->record_id);
        $product_id = intval($record->product_id);
        $lock_version = intval($record->lock_version);

        return new XxxProductImage($id, $logged_at, $action, $record_id, $product_id, $lock_version);
    }
}
