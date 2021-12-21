<?php
// *******************************************************************************************
//  File:  OpenFoodProduct.php
//
//  Created: 08-12-2021
//
//  Copyright (c) 2021 James Dooley
//
//  Distributed under the MIT License (http://opensource.org/licenses/MIT).
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

/**
 * Class OpenFoodProduct
 *
 * This class holds all the product lookup data returned from the lookup service
 *
 * @package App\Models
 */
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
     * Creates an instance of the class, based on the data provided
     *
     * @param stdClass $data The data needed to create instance
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

            $this->setCreatedAt(Carbon::parse($data->created_at));
            $this->setUpdatedAt(Carbon::parse($data->updated_at));
        } catch (Exception $e) {
            Log::error('Failed to parse Open Food Product data: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Returns the data stored in the instance as an array
     *
     * @return array
     */
    public function toArray(): array
    {
        $data = [];

        $image_list = $this->getImages();
        $images = [];

        foreach ($image_list as $image) {
            $image_data = array(
                'thumb' => $image->getThumb(),
                'medium' => $image->getMedium(),
                'large' => $image->getLarge(),
                'xlarge' => $image->GetXLarge(),
                'tags' => $image->getTags()
            );

            $images [] = $image_data;
        }
        $data['id'] = $this->getId();
        $data['country'] = $this->getCountry();
        $data['barcode'] = $this->getBarcode();
        $data['name'] = $this->getName();
        $data['status'] = $this->getStatus();
        $data['images'] = $images;
        $data['updated'] = $this->getUpdatedAt();

        return $data;
    }

    /**
     * Returns the Open Food Repo id for the product
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets the Open Food Repo id for the product
     *
     * @param int $id The value to set the id to
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns the country id as defined on the Open Food Repo
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Sets the country id
     *
     * @param string $country The value to set the country id to
     * @return void
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * Returns the barcode for the product as defined on the Open Food Repo
     *
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->barcode;
    }

    /**
     * Sets the barcode for the product
     *
     * @param string $barcode
     * @return void
     */
    public function setBarcode(string $barcode): void
    {
        $this->barcode = $barcode;
    }

    /**
     * Returns the status as defined on the Open Food Repo
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Sets the status value
     *
     * @param string $status The value to set the status to
     * @return void
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns the quantity as defined on the Open Food Repo
     *
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Sets the quantity value
     *
     * @param int $quantity The value to set the quantity to
     * @return void
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * Returns the unit value as defined on the Open Food Repo
     *
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * Sets the unit value for the product as defined on the Open Food Repo
     *
     * @param string $unit The value to set the unit to
     * @return void
     */
    public function setUnit(string $unit): void
    {
        $this->unit = $unit;
    }

    /**
     * Returns the hundred unit as defined on the Open Food Repo
     *
     * @return string
     */
    public function getHundredUnit(): string
    {
        return $this->hundred_unit;
    }

    /**
     * Sets the hundred unit
     *
     * @param string $hundred_unit The value to set the hundred unit to
     * @return void
     */
    public function setHundredUnit(string $hundred_unit): void
    {
        $this->hundred_unit = $hundred_unit;
    }

    /**
     * Returns the portion quantity as defined on the Open Food Repo
     *
     * @return float
     */
    public function getPortionQuantity(): float
    {
        return $this->portion_quantity;
    }

    /**
     * Sets the portion quantity
     *
     * @param float  The value to set the portion quantity to
     * @return void
     */
    public function setPortionQuantity(float $portion_quantity): void
    {
        $this->portion_quantity = $portion_quantity;
    }

    /**
     * Returns the portion unit as defined on the Open Food Repo
     *
     * @return string
     */
    public function getPortionUnit(): string
    {
        return $this->portion_unit;
    }

    /**
     * Sets the portion unit
     *
     * @param string $portion_unit The value to set the portion unit to
     * @return void
     */
    public function setPortionUnit(string $portion_unit): void
    {
        $this->portion_unit = $portion_unit;
    }

    /**
     * Returns the alcohol by volume as defined on the Open Food Repo
     *
     * @return float
     */
    public function getAlcoholByVolume(): float
    {
        return $this->alcohol_by_volume;
    }

    /**
     * Sets the alcohol by volume
     *
     * @param float $alcohol_by_volume The value to set the alcohol volume to
     * @return void
     */
    public function setAlcoholByVolume(float $alcohol_by_volume): void
    {
        $this->alcohol_by_volume = $alcohol_by_volume;
    }

    /**
     * Returns the date and time the entry was created as defined on the Open Food Repo
     *
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * Sets the date and time the entry was created
     *
     * @param Carbon $created_at The value to set the created at entry to
     * @return void
     */
    public function setCreatedAt(Carbon $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * Returns the date and time the entry was updated as defined on the Open Food Repo
     *
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    /**
     * Sets the date and time the entry was updated at
     *
     * @param Carbon $updated_at
     * @return void
     */
    public function setUpdatedAt(Carbon $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * Returns the images for the product as defined on the Open Food Repo
     *
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * Adds an image to the product instance
     *
     * @param OpenFoodImage $image The image to add
     * @return void
     */
    public function addImage(OpenFoodImage $image): void
    {
        $this->images []= $image;
    }

    /**
     * Returns the name of the product as defined on the Open Food Repo
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the product name
     *
     * @param string $name The value to set the name to
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns the ingredients for the product as defined on the Open Food Repo
     *
     * @return stdClass
     */
    public function getIngredients(): stdClass
    {
        return $this->ingredients;
    }

    /**
     * Sets the ingredients for the product
     *
     * @param stdClass $ingredients The value to set the ingredients to
     * @return void
     */
    public function setIngredients(stdClass $ingredients): void
    {
        $this->ingredients = $ingredients;
    }

    /**
     * Returns the nutrients as defined on the Open Food Repo
     *
     * @return stdClass
     */
    public function getNutrients(): stdClass
    {
        return $this->nutrients;
    }

    /**
     * Sets the nutrients value
     *
     * @param stdClass $nutrients The value to set the nutrients to
     * @return void
     */
    public function setNutrients(stdClass $nutrients): void
    {
        $this->nutrients = $nutrients;
    }
}
