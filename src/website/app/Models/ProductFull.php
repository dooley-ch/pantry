<?php
// *******************************************************************************************
//  File:  ProductFull.php
//
//  Created: 15-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  15-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

/**
 * Class ProductFull
 *
 * This class holds all the data related to a product stored in the database
 *
 * @package App\Models
 */
class ProductFull extends Product
{
    private StockSummaryExtended $stockSummary;
    private array $product_images;

    /**
     * Creates an instance of the class based on the data provided
     *
     * @param int $id The id of the underlying product record
     * @param int $lock_version The lock version of the underlying product record
     * @param Carbon $created_at The date and time the underlying product record was created
     * @param Carbon $updated_at The date and time the  of the underlying product record was updated
     * @param string $code The code of the underlying product record
     * @param string $barcode The barcode of the underlying product record
     * @param string $name The name of the underlying product record
     * @param string $description The description of the underlying product record
     */
    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at,
                                string $code, string $barcode, string $name, private string $description)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at, $code, $barcode, $name, $this->description);
    }

    /**
     * Returns the stock summary record of the underlying product record
     *
     * @return StockSummaryExtended
     */
    public function getStockSummary(): StockSummaryExtended
    {
        return $this->stockSummary;
    }

    /**
     * Sets the stock summary record for the underlying product record
     * @param StockSummaryExtended $stockSummary
     * @return void
     */
    public function setStockSummary(StockSummaryExtended $stockSummary): void
    {
        $this->stockSummary = $stockSummary;
    }

    /**
     * Returns the product images for the underlying product record
     *
     * @return array
     */
    public function getProductImages(): array
    {
        return $this->product_images;
    }

    /**
     * Sets the product images for the underlying product record
     *
     * @param array $product_images
     * @return void
     */
    public function setProductImages(array $product_images): void
    {
        $this->product_images = $product_images;
    }
}
