<?php
// *******************************************************************************************
//  File:  StockReportItem.php
//
//  Created: 17-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  17-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use stdClass;

class StockReportItem
{
    public function __construct(private int $id, private string $name, private Carbon $updated_at, private int $amount)
    {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public static function fromRecord(stdClass $data): StockReportItem
    {
        $id = $data->id;
        $name = $data->name;
        $updated_at = Carbon::parse($data->updated_at);
        $amount = $data->amount;

        return new StockReportItem($id, $name, $updated_at, $amount);
    }
}
