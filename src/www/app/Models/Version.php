<?php
// *******************************************************************************************
//  File:  Version.php
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

class Version
{
    public function __construct(private int $id, private int $major, private int $minor, private int $build,
                                private string $comment, private Carbon $created_at)
    {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getMajor(): int
    {
        return $this->major;
    }

    public function getMinor(): int
    {
        return $this->minor;
    }

    public function getBuild(): int
    {
        return $this->build;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }
}
