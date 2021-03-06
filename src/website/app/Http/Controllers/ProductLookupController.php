<?php
// *******************************************************************************************
//  File:  ProductLookupController.php
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ResponseView;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

use Exception;

/**
 * Class ProductLookupController
 *
 * This controller provides the Open Food Repo lookup functions for the
 * application.  The controller provides two functions:
 * - The search home page
 * - The lookup function
 *
 * @package App\Http\Controllers
 */
class ProductLookupController extends Controller
{
    /**
     * This method displays the product lookup search page
     *
     * @param Request $request The HTML request
     * @return ResponseView The lookup search page
     */
    public function homePage(Request $request): ResponseView
    {
        $msg = $request->session()->get('flash_message');

        if (isset($msg)) {
            $msg = json_decode($msg);
        } else {
            $msg = null;
        }

        return View::make('product_lookup', ['product' => null, 'active_page' => 'lookup', 'logged_in' => false, 'message' => $msg]);
    }

    /**
     * This method performs the product lookup by barcode or code and displays the results page
     *
     * @param Request $request The HTML request
     * @return RedirectResponse|ResponseView The product details or the lookup search page if none found
     */
    public function lookup(Request $request): RedirectResponse|ResponseView
    {
        $lookup = new OpenFoodRepoLookup();
        $request_data = $request->all('search-type', 'search-value');
        $type = $request_data['search-type'];
        $search_value = $request_data['search-value'];

        if (!isset($type) or !isset($search_value)) {
            $msg = json_encode(['type' => Controller::WARNING,
                'content' => 'Incorrect or missing parameters supplied for the search.  Please try again.']);
            $request->session()->flash('flash_message', $msg);
            return redirect(route('lookup-homepage'));
        }

        try {
            if ($type == 'Code') {
                $product = $lookup->getByCode($search_value);
            } else {
                $product = $lookup->getByBarcode($search_value);
            }
        } catch (Exception $ex) {
            Log::error('Failed to lookup product (' . $search_value . '): ' . $ex->getMessage());
            $msg = json_encode(['type' => Controller::ERROR,
                'content' => 'An error occurred while looking up the product, see the log file for details.']);
            $request->session()->flash('flash_message', $msg);
            return redirect(route('lookup-homepage'));
        }

        if ($product == null) {
            $search_type = 'barcode';
            if ($type == 'Code')
                $search_type = 'code';

            $msg = json_encode(['type' => Controller::INFO,
                'content' => 'There is no product on the Open Food Repo website with the provided ' . $search_type . '.']);
            $request->session()->flash('flash_message', $msg);
            return redirect(route('lookup-homepage'));
        }

        // Check if product has already been added
        $store = new Datastore();
        $database_product = $store->getProductByBarcode($product->getBarcode());
        $can_add = true;
        if ($database_product)
            $can_add = false;

        return View::make('product_lookup', ['product' => $product, 'can_add' => $can_add, 'active_page' => 'lookup',
            'logged_in' => false, 'message' => null]);
    }
}
