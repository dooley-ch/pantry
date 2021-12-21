<?php
// *******************************************************************************************
//  File:  Record.php
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
 * Class Record
 *
 * This class is the base class for all business records.  It provides the common fields present in
 * all business records
 *
 * @package App\Models
 */
abstract class Record
{
    private int $id;
    private int $lock_version;
    private Carbon $created_at;
    private Carbon $updated_at;

    /**
     * Creates an instance of the class based on the data provided
     *
     * @param int $id The id of the underlying record
     * @param int $lock_version The lock version of the underlying database record
     * @param Carbon $created_at The date and time the record was created
     * @param Carbon $updated_at The date and time the record was last updated
     */
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at)
    {
        $this->id = $id;
        $this->lock_version = $lock_version;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    /**
     * Returns the id of the record
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets the id of the record
     *
     * @param int $id The value to set the id to
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns the lock version of the record
     *
     * @return int
     */
    public function getLockVersion(): int
    {
        return $this->lock_version;
    }

    /**
     * Sets the lock version of the record
     *
     * @param int $lock_version The value to set the lock version to
     * @return void
     */
    public function setLockVersion(int $lock_version): void
    {
        $this->lock_version = $lock_version;
    }

    /**
     * Returns the date and time of the record
     *
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * Sets the date and time the record was created
     *
     * @param Carbon $created_at The value to set the date and time of the record to
     * @return void
     */
    public function setCreatedAt(Carbon $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * Returns the date and time the record was last updated
     *
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    /**
     * Sets the value of the date and time the record was last updated
     *
     * @param Carbon $updated_at The value to set the date and time last updated to
     * @return void
     */
    public function setUpdatedAt(Carbon $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
