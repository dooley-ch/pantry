<?php
// *******************************************************************************************
//  File:  OpenFoodImage.php
//
//  Created: 09-12-2021
//
//  Copyright (c) 2021 James Dooley
//
//  Distributed under the MIT License (http://opensource.org/licenses/MIT).
//
//  History:
//  09-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace App\Models;

/**
 * Class OpenFoodImage
 *
 * This class is used to hold data relating to an image entry in the product lookup record
 *
 * @package App\Models
 */
class OpenFoodImage
{
    /**
     * Creates an instance of the class based on the data provided
     *
     * @param string $thumb The url for the thumb image
     * @param string $medium The url for the medium image
     * @param string $large The url for the large image
     * @param string $xlarge The url for the xlarge image
     * @param array $tags The tags associated with the image
     */
    public function __construct(private string $thumb, private string $medium, private string $large,
                                private string $xlarge, private array $tags)
    {
    }

    /**
     * Returns the url for the thumb image
     *
     * @return string
     */
    public function getThumb(): string
    {
        return $this->thumb;
    }

    /**
     * Returns the url for the medium sized image
     *
     * @return string
     */
    public function getMedium(): string
    {
        return $this->medium;
    }

    /**
     * Returns the url for the large sized image
     *
     * @return string
     */
    public function getLarge(): string
    {
        return $this->large;
    }

    /**
     * Returns the url for the extra large sized image
     *
     * @return string
     */
    public function getXLarge(): string
    {
        return $this->xlarge;
    }

    /**
     * Returns the tags relating to the image
     *
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
