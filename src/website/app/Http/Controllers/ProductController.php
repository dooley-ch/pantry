<?php
// *******************************************************************************************
//  File:  ProductController.php
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ResponseView;
use Exception;

class ProductController extends Controller
{
    public function homePage(Request $request): ResponseView
    {
        return View::make('product.home', ['active_page' => 'product', 'logged_in' => false]);
    }

    public function details(Request $request, string $barcode): ResponseView
    {
        return View::make('product.detail', ['active_page' => 'product', 'logged_in' => false]);
    }

    public function add(Request $request, string $barcode): RedirectResponse|Redirector|Response|ResponseView
    {
        // Look up the product details
        $lookup = new OpenFoodRepoLookup();

        try {
            $lookup_product = $lookup->getByBarcode($barcode);
        } catch (Exception $ex) {
            Log::error('Failed to lookup product (' . $barcode . '): ' . $ex->getMessage());
            $msg = json_encode(['type' => Controller::ERROR,
                'content' => 'An error occurred while looking up the product, see the log file for details.']);
            $request->session()->flash('lookup_message', $msg);
            return redirect(route('lookup-homepage'));
        }

        // Create the database records
        $store = new Datastore();

        try {
            $product_id = $store->addProduct($lookup_product);
        } catch (Exception $ex) {
            Log::error('Failed to add product to the database (' . $barcode . '): ' . $ex->getMessage());
            $msg = json_encode(['type' => Controller::ERROR,
                'content' => 'An error occurred while adding the product to the database, see the log file for details.']);
            $request->session()->flash('lookup_message', $msg);
            return redirect(route('lookup-homepage'));
        }

        // Display the product page
        $msg = json_encode(['type' => Controller::INFO,
            'content' => 'New product successfully added to the application (' . $product_id . ')']);

        return View::make('product.home', ['active_page' => 'product', 'logged_in' => false, 'message' => $msg]);
    }

    public function remove(Request $request, string $barcode): ResponseView
    {
        return View::make('product.home', ['active_page' => 'product', 'logged_in' => false]);
    }

    public function delete(Request $request, string $barcode): ResponseView
    {
        return View::make('product.home', ['active_page' => 'product', 'logged_in' => false]);
    }
}
