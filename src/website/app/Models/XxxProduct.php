<?php
// *******************************************************************************************
//  File:  XxxProduct.php
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
 * Class XxxProduct
 *
 * This class maps to the xxx_product table in the database
 *
 * @package App\Models
 */
class XxxProduct extends AuditRecord
{
    /**
     * Creates an instance of the class, based on the data provided
     *
     * @param int $id The id of the underlying database record
     * @param Carbon $logged_at The date and time the audited action was performed
     * @param string $action The action performed on the record being audited
     * @param int $record_id The id of the record being audited
     * @param int $lock_version The lock version of the record being audited
     * @param string $barcode The barcode of the product
     * @param string $name The name of the product
     * @param string $description The description of the product
     */
    public function __construct(int $id, Carbon $logged_at, string $action, int $record_id, int $lock_version,
                                private string $barcode, private string $name, private string $description)
    {
        parent::__construct($id, $logged_at, $action, $record_id, $lock_version);
    }

    /**
     * Returns barcode for the product
     *
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->barcode;
    }

    /**
     * Returns the name of the product
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the description of the product
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * This method creates an instance of the class based on the data provided.
     * The data is normally read from the database
     *
     * @param stdClass $record The data needed to build the instance
     * @return XxxProduct The new instance based on the data provided
     */
    public static function fromRecord(stdClass $record): XxxProduct
    {
        $id = intval($record->id);
        $logged_at = Carbon::parse($record->logged_at);
        $action = $record->action;
        $record_id = intval($record->record_id);
        $barcode = $record->barcode;
        $name = $record->name;
        $description = $record->description;
        $lock_version = intval($record->lock_version);

        return new XxxProduct($id, $logged_at, $action, $record_id, $lock_version, $barcode, $name, $description);
    }
}
