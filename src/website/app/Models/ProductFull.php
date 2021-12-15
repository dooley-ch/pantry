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

class ProductFull extends Product
{
    private StockSummaryExtended $stockSummary;
    private array $product_images;

    public function __construct(int $id, int $lock_version, Carbon $created_at, Carbon $updated_at,
                                string $barcode, string $name, private string $description)
    {
        parent::__construct($id, $lock_version, $created_at, $updated_at, $barcode, $name, $this->description);
    }

    public function getStockSummary(): StockSummaryExtended
    {
        return $this->stockSummary;
    }

    public function setStockSummary(StockSummaryExtended $stockSummary): void
    {
        $this->stockSummary = $stockSummary;
    }

    public function getProductImages(): array
    {
        return $this->product_images;
    }

    public function setProductImages(array $product_images): void
    {
        $this->product_images = $product_images;
    }
}
