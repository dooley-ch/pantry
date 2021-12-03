<?php
// *******************************************************************************************
//  File:  AuditRecord.php
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

class AuditRecord
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
