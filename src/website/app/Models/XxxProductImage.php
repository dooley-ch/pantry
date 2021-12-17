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

use \stdClass;
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
    public function __construct(int $id, Carbon $logged_at, string $action, int $record_id, int $lock_version,
                                private int $product_id)
    {
        parent::__construct($id, $logged_at, $action, $record_id, $lock_version);
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

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
