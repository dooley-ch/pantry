<?php
// *******************************************************************************************
//  File:  OpenFoodRepoLookup.php
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

namespace App\Core;

use App\Models\OpenFoodProduct;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Class OpenFoodRepoLookup
 *
 * This class provides the interface to the Open Food Repo website.  It provides two methods:
 * - A method to look up a product by its id or code
 * - A method to look up a product by its barcode
 *
 * @package App\Core
 */
class OpenFoodRepoLookup
{
    /**
     * The URI used to make product lookup requests
     */
    private const PRODUCT_URI = 'products/';

    /**
     * Holds the common part of the URL used to access the service website
     *
     * @var string
     */
    private string $base_url;

    /**
     * Holds the api key needed to make lookup requests to the service website
     *
     * @var string
     */
    private string $api_key;

    /**
     * Holds the common headers that are required to submit a request to the service website
     *
     * @var string[]
     */
    private array $headers;

    /**
     * Creates an instance of the class:
     * - Retrieves the required parameters from the application environment (defined in the .env file)
     * - Sets up the common headers to be used in submitting queries to the service website
     */
    public function __construct()
    {
        $this->api_key = env('OPEN_FOOD_REPO_API_KEY', '');
        $this->base_url = env('OPEN_FOOD_BASE_URL', '');

        $this->headers = [
            'User-Agent' => 'pantry/1.0',
            'Accept'     => 'application/json',
            'Authorization' => 'Token token="' . $this->api_key . '"'];
    }

    /**
     * This method performs a product lookup based on the product's code or id.
     *
     * @param string $code The code or id of the product being looked up
     * @return OpenFoodProduct|null Returns the product details if found, otherwise null
     * @throws Exception Raised after logging any error that occurred
     */
    public function getByCode(string $code): ?OpenFoodProduct
    {
        $uri = OpenFoodRepoLookup::PRODUCT_URI . $code;

        $client = new Client(['base_uri' => $this->base_url, 'timeout'  => 10000.0]);

        try {
            $response = $client->get($uri, ['headers' => $this->headers]);

            if ($response->getStatusCode() == 200) {
                $body = $response->getBody();
                $data = json_decode((string)$body);
                return new OpenFoodProduct($data->data);
            }

            Log::warning('Product lookup by code not found (' . $code . '): ');
        } catch (GuzzleException|ClientException $e) {
            Log::error('Failed to get product lookup by code (' . $code . '): ' . $e->getMessage());
        }

        return null;
    }

    /**
     * This method performs a product lookup based on the product's barcode.  The underlying
     * API call supports querying multiple barcodes and returns an array of product records,
     * but this method only supports the querying of a single barcode at a time.
     *
     * @param string $barcode The barcode of the product being looked up
     * @return OpenFoodProduct|null Returns the product details if found, otherwise null
     * @throws Exception Raised after logging any error that occurred
     */
    public function getByBarcode(string $barcode): ?OpenFoodProduct
    {
        $client = new Client(['base_uri' => $this->base_url, 'timeout'  => 10000.0]);

        try {
            $response = $client->get(OpenFoodRepoLookup::PRODUCT_URI, ['query' => ['barcodes' => $barcode], 'headers' => $this->headers]);

            if ($response->getStatusCode() == 200) {
                $body = $response->getBody();
                $data = json_decode((string)$body);
                if (count($data->data) != 0) {
                    return new OpenFoodProduct($data->data[0]);
                }
            }

            Log::warning('Product lookup by barcode not found (' . $barcode . '): ');
        } catch (GuzzleException|ClientException $e) {
            Log::error('Failed to get product lookup by barcode (' . $barcode . '): ' . $e->getMessage());
        }

        return null;
    }
}
