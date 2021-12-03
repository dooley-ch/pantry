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
}
