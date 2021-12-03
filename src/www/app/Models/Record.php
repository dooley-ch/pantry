<?php
// *******************************************************************************************
//  File:  Record.php
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

class Record
{
    private int $id;
    private int $lock_version;
    private Carbon $created_at;
    private Carbon $updated_at;

    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at)
    {
        $this->id = $id;
        $this->lock_version = $lock_version;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getLockVersion(): int
    {
        return $this->lock_version;
    }

    public function setLockVersion(int $lock_version): void
    {
        $this->lock_version = $lock_version;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function setCreatedAt(Carbon $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(Carbon $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
