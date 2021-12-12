<?php
// *******************************************************************************************
//  File:  AuditRecord.php
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

use Carbon\Carbon;

/**
 * Class AuditRecord
 *
 * This class is the base class for all audit records.  It provides the common fields present in
 * all audit records
 *
 * @package App\Models
 */
abstract class AuditRecord
{
    public function __construct(private int $id, private Carbon $logged_at, private string $action,
                                private int $record_id, private int $lock_version)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLoggedAt(): Carbon
    {
        return $this->logged_at;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getRecordId(): int
    {
        return $this->record_id;
    }

    public function getLockVersion(): int
    {
        return $this->lock_version;
    }
}
