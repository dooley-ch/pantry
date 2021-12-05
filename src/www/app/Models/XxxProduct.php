<?php
// *******************************************************************************************
//  File:  XxxProduct.php
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

class XxxProduct extends AuditRecord
{
    public function __construct(int $id, Carbon $logged_at, string $action, int $record_id, int $lock_version,
                                private string $barcode, private string $name, private string $description)
    {
        parent::__construct($id, $logged_at, $action, $record_id, $lock_version);
    }

    public function getBarcode(): string
    {
        return $this->barcode;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public static function fromRecord(stdClass $record): XxxProduct
    {
        $id = intval($record->id);
        $logged_at = Carbon::createFromTimestamp($record->logged_at);
        $action = $record->action;
        $record_id = intval($record->record_id);
        $barcode = $record->barcode;
        $name = $record->name;
        $description = $record->description;
        $lock_version = intval($record->lock_version);

        return new XxxProduct($id, $logged_at, $action, $record_id, $lock_version, $barcode, $name, $description);
    }
}
