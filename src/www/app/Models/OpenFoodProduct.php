<?php
// *******************************************************************************************
//  File:  OpenFoodProduct.php
//
//  Created: 08-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  08-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\Log;
use stdClass;
use Carbon\Carbon;

class OpenFoodProduct
{
    private int $id;
    private string $country;
    private string $barcode;
    private string $name;
    private stdClass $ingredients;
    private string $status;
    private int $quantity;
    private string $unit;
    private string $hundred_unit;
    private float $portion_quantity;
    private string $portion_unit;
    private float $alcohol_by_volume;
    private array $images;
    private stdClass $nutrients;
    private Carbon $created_at;
    private Carbon $updated_at;

    /**
     * @throws Exception
     */
    public function __construct(stdClass $data)
    {
        try {
            $this->setId($data->id);
            $this->setCountry($data->country);
            $this->setBarcode($data->barcode);

            $name = '';
            if (isset($data->display_name_translations->en)) {
                $name = $data->display_name_translations->en;
            } elseif (isset($data->display_name_translations->de)) {
                $name = $data->display_name_translations->de;
            } elseif (isset($data->display_name_translations->fr)) {
                $name = $data->display_name_translations->fr;
            } elseif (isset($data->display_name_translations->it)) {
                $name = $data->display_name_translations->it;
            }
            $this->setName($name);

            $this->setIngredients($data->ingredients_translations);
            $this->setStatus($data->status);
            $this->setQuantity(intval($data->quantity));
            $this->setUnit($data->unit);
            $this->setHundredUnit($data->hundred_unit);
            $this->setPortionQuantity(floatval($data->portion_quantity));
            $this->setPortionUnit($data->portion_unit);
            $this->setAlcoholByVolume(floatval($data->alcohol_by_volume));

            foreach ($data->images as $image) {
                $img = new OpenFoodImage($image->thumb, $image->medium, $image->large, $image->xlarge, $image->categories);
                $this->addImage($img);
            }

            $this->setNutrients($data->nutrients);

            $this->setCreatedAt(Carbon::createFromTimestampUTC($data->created_at));
            $this->setUpdatedAt(Carbon::createFromTimestampUTC($data->updated_at));
        } catch (Exception $e) {
            Log::error('Failed to parse Open Food Product data: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getBarcode(): string
    {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): void
    {
        $this->barcode = $barcode;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): void
    {
        $this->unit = $unit;
    }

    public function getHundredUnit(): string
    {
        return $this->hundred_unit;
    }

    public function setHundredUnit(string $hundred_unit): void
    {
        $this->hundred_unit = $hundred_unit;
    }

    public function getPortionQuantity(): float
    {
        return $this->portion_quantity;
    }

    public function setPortionQuantity(float $portion_quantity): void
    {
        $this->portion_quantity = $portion_quantity;
    }

    public function getPortionUnit(): string
    {
        return $this->portion_unit;
    }

    public function setPortionUnit(string $portion_unit): void
    {
        $this->portion_unit = $portion_unit;
    }

    public function getAlcoholByVolume(): float
    {
        return $this->alcohol_by_volume;
    }

    public function setAlcoholByVolume(float $alcohol_by_volume): void
    {
        $this->alcohol_by_volume = $alcohol_by_volume;
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

    public function getImages(): array
    {
        return $this->images;
    }

    public function addImage(OpenFoodImage $image): void
    {
        $this->images []= $image;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getIngredients(): stdClass
    {
        return $this->ingredients;
    }

    public function setIngredients(stdClass $ingredients): void
    {
        $this->ingredients = $ingredients;
    }

    public function getNutrients(): stdClass
    {
        return $this->nutrients;
    }

    public function setNutrients(stdClass $nutrients): void
    {
        $this->nutrients = $nutrients;
    }
}
