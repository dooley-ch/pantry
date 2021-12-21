<?php
// *******************************************************************************************
//  File:  Version.php
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
 * Class Version
 *
 * This class maps to the version table in the database
 *
 * @package App\Models
 */
class Version
{
    /**
     * Creates an instance of the class with the given data
     *
     * @param int $id The id of the underlying database record
     * @param int $major The major version number of the application
     * @param int $minor The minor version number of the application
     * @param int $build The build number for the application
     * @param string $comment Comments relating to the version
     * @param Carbon $created_at The date and time the record was created
     */
    public function __construct(private int $id, private int $major, private int $minor, private int $build,
                                private string $comment, private Carbon $created_at)
    {}

    /**
     * Returns the id of the record
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns the major version number
     *
     * @return int
     */
    public function getMajor(): int
    {
        return $this->major;
    }

    /**
     * Returns minor version number
     *
     * @return int
     */
    public function getMinor(): int
    {
        return $this->minor;
    }

    /**
     * Returns the build number
     *
     * @return int
     */
    public function getBuild(): int
    {
        return $this->build;
    }

    /**
     * Returns the version comments
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Returns the data and time the record was created
     *
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * Creates an instance of the class with the given data
     *
     * @param stdClass $record The data needed to create the instance
     * @return Version The new instance
     */
    public static function fromRecord(stdClass $record): Version
    {
        $id = intval($record->id);
        $major = intval($record->major);
        $minor = intval($record->minor);
        $build = intval($record->build);
        $comment = $record->comment;
        $created_at = Carbon::parse($record->created_at);

        return new Version($id, $major, $minor, $build, $comment, $created_at);
    }
}
