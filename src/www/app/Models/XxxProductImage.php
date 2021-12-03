<?php
// *******************************************************************************************
//  File:  XxxProductImage.php
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
}
