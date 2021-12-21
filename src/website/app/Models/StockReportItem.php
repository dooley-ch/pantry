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

/**
 * Class StockReportItem
 *
 * This class represents a row in the stock report
 *
 * @package App\Models
 */
class StockReportItem
{
    /**
     * This method creates a new instance of class
     *
     * @param int $id The id of the product
     * @param string $name The name of the product
     * @param Carbon $updated_at The date the product was last updated
     * @param int $amount The number of units in stock
     */
    public function __construct(private int $id, private string $name, private Carbon $updated_at, private int $amount)
    {}

    /**
     * Returns the product id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns the product name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the date and time the product was updated
     *
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    /**
     * Returns the number of units in stock
     *
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * This method creates a new instance of the class based on the data provided
     *
     * @param stdClass $data The data needed to create a new instance of the class
     * @return StockReportItem The new instance
     */
    public static function fromRecord(stdClass $data): StockReportItem
    {
        $id = $data->id;
        $name = $data->name;
        $updated_at = Carbon::parse($data->updated_at);
        $amount = $data->amount;

        return new StockReportItem($id, $name, $updated_at, $amount);
    }
}
