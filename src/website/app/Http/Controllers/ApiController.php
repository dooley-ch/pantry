<?php
// *******************************************************************************************
//  File:  ApiController.php
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

namespace App\Http\Controllers;

use App\Core\Datastore;
use App\Core\OpenFoodRepoLookup;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class ApiController
 *
 * This controller implements the REST functionality for the application.  The controller provides three
 * methods:
 * - getProductDetails
 * - addProduct
 * - removeProduct
 *
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{
    /**
     * This method provides product details from the Open Food Repo website (OFR) using the product barcode.
     * The method returns messages with three status codes:
     * - 200, with the product details
     * - 404, if the product can't be found on the OFR website
     * - 500, An unexpected error occurred
     *
     * @param string $barcode The barcode of the product for which details are required
     * @return JsonResponse
     */
    public function getProductDetails(string $barcode): JsonResponse
    {
        $content = [];
        $status = 200;

        $lookup = new OpenFoodRepoLookup();

        try {
            $product = $lookup->getByBarcode($barcode);

            if ($product) {
                $content = ['product' => $product->toArray()];
            } else {
                $content['code'] = 404;
                $content['message'] = 'No product found with the barcode: ' . $barcode;
            }
        } catch (Exception $e) {
            Log::error('Unexpected error while responding to getProductDetails API call (' . $barcode . ')' . $e->getMessage());
            $content['code'] = 500;
            $content['message'] = 'An unexpected error occurred, see the log file for details.';
        }

        return new JsonResponse($content, $status);
    }

    /**
     * This method increases the quantity of a product on the application database by one based on the barcode provided.
     * The method returns messages with two status codes:
     * - 200, if the operation was completed successfully
     * - 500, An unexpected error occurred
     *
     * @param string $barcode The barcode of the product for which details are required
     * @return JsonResponse
     */
    public function addProduct(string $barcode): JsonResponse
    {
        $content = [];
        $status = 200;
        $product_id = 0;

        try {
            $store = new Datastore();
            $product = $store->getProductByBarcode($barcode);

            if (empty($product)) {
                $lookup = new OpenFoodRepoLookup();
                $lookup_product = $lookup->getByBarcode($barcode);

                if ($lookup_product) {
                    $product_id = $store->addProduct($lookup_product);

                    if (empty($product_id)) {
                        Log::warning('Failed to add product for barcode (' . $barcode . '). addProduct failed.');
                        $content['code'] = 500;
                        $content['message'] = 'Failed to add product (' . $barcode . ').';
                        $product_id = 0;
                    }
                }
            } else {
                $product_id = $product->getId();
            }

            if ($product_id > 0) {
                $result = $store->alterProductItems($product_id, 'A');

                if ($result) {
                    $content['code'] = 200;
                    $content['message'] = 'Product item added.';
                } else {
                    $content['code'] = 500;
                    $content['message'] = 'Failed to add product item.';
                }
            } else {
                    Log::warning('Product not found or could not be added (' . $barcode . '). addProduct failed.');
                    $content['code'] = 500;
                    $content['message'] = 'Product not found or could not be added (' . $barcode . ').';
            }
        } catch (Exception $e) {
            Log::error('Unexpected error while responding to addProduct API call (' . $barcode . ')' . $e->getMessage());
            $content['code'] = 500;
            $content['message'] = 'An unexpected error occurred, see the log file for details.';
        }

        return new JsonResponse($content, $status);
    }

    /**
     * This method decreases the quantity of a product on the application database by one based on the barcode provided.
     * The method returns messages with two status codes:
     * - 200, if the operation was completed successfully
     * - 500, An unexpected error occurred
     *
     * @param string $barcode The barcode of the product for which details are required
     * @return JsonResponse
     */
    public function removeProduct(string $barcode): JsonResponse
    {
        $content = [];
        $status = 200;

        try {
            $store = new Datastore();
            $product = $store->getProductByBarcode($barcode);

            if (empty($product)) {
                $content['code'] = 404;
                $content['message'] = 'Product not found.';
            } else {
                $result = $store->alterProductItems($product->getId(), 'R');

                if ($result) {
                    $content['code'] = 200;
                    $content['message'] = 'Product item removed.';
                } else {
                    $content['code'] = 500;
                    $content['message'] = 'Failed to remove product item.';
                }
            }
        } catch (Exception $e) {
            Log::error('Unexpected error while responding to removeProduct API call (' . $barcode . ')' . $e->getMessage());
            $content['code'] = 500;
            $content['message'] = 'An unexpected error occurred, see the log file for details.';
        }

        return new JsonResponse($content, $status);
    }
}
