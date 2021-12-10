<?php
// *******************************************************************************************
//  File:  OpenFoodRepoLookup.php
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

namespace App\Core;

use App\Models\OpenFoodProduct;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class OpenFoodRepoLookup
{
    private string $base_url;
    private string $api_key;
    private array $headers;

    public function __construct()
    {
        $this->api_key = env('OPEN_FOOD_REPO_API_KEY', '');
        $this->base_url = env('OPEN_FOOD_BASE_URL', '');

        $this->headers = [
            'User-Agent' => 'pantry/1.0',
            'Accept'     => 'application/json',
            'Authorization' => 'Token token="' . $this->api_key . '"'];
    }

    public function getByCode(string $code): ?OpenFoodProduct
    {
        $uri = 'products/' . $code;

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
     * @throws \Exception
     */
    public function getByBarcode(string $barcode): ?OpenFoodProduct
    {
        $uri = 'products/';
        $client = new Client(['base_uri' => $this->base_url, 'timeout'  => 10000.0]);

        try {
            $response = $client->get($uri, ['query' => ['barcodes' => $barcode], 'headers' => $this->headers]);

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
