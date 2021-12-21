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
    /**
     * Creates an instance of the class using the given parameters
     *
     * @param int $id The id of the underlying record
     * @param Carbon $logged_at The date and time the audit action was recorded
     * @param string $action The action performed on the record under audit
     * @param int $record_id The id of the record being audited
     * @param int $lock_version The lock version number of the record under audit
     */
    public function __construct(private int $id, private Carbon $logged_at, private string $action,
                                private int $record_id, private int $lock_version)
    {
    }

    /**
     * Returns the record id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns the date and time the record was logged
     *
     * @return Carbon
     */
    public function getLoggedAt(): Carbon
    {
        return $this->logged_at;
    }

    /**
     * Returns the type of action performed on the record under audit:
     * I - Inserted
     * U - Updated
     * D - Deleted
     *
     * @return string I, U, or D, depending on the operation performed
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Returns the id of the record under audit
     *
     * @return int
     */
    public function getRecordId(): int
    {
        return $this->record_id;
    }

    /**
     * Returns the lock version of the record under audit
     *
     * @return int
     */
    public function getLockVersion(): int
    {
        return $this->lock_version;
    }
}
