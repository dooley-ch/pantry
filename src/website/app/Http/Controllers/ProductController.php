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
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ResponseView;
use Exception;
use stdClass;

class ProductController extends Controller
{
    //region Find

    public function findByIdAction(Request $request): ResponseView|Redirector
    {
        $param = $request->input('search-value');

        if (!isset($param)) {
            $msg = json_encode(['type' => Controller::WARNING,
                'content' => 'Incorrect or missing search parameter supplied for the search.  Please try again.']);
            $request->session()->flash('flash_message', $msg);
            return redirect(route('product-find-by-id-action'));
        }

        try {
            $id = intval($param);

            $store = new Datastore();
            $products = $store->findProductsById($id);
        }  catch (Exception $ex) {
            Log::error('Failed to find products by id (' . $param . '): ' . $ex->getMessage());
            $msg = json_encode(['type' => Controller::ERROR,
                'content' => 'An error occurred while searching for products, see the log file for details.']);
            $request->session()->flash('flash_message', $msg);
            return redirect(route('product-find-by-id-action'));
        }

        $msg = null;
        if (count($products) == 0) {
            $msg = new stdClass();
            $msg->type = Controller::INFO;
            $msg->content = 'Products found with the id: ' . $id;
        }

        return View::make('product.find', ['find_by_title' => 'Id', 'products' => $products, 'message' => $msg,
            'action_url' => route('product-find-by-id-action' ), 'active_page' => 'product']);
    }

    public function findByBarcodeAction(Request $request): ResponseView|Redirector
    {
        $param = $request->input('search-value');

        if (!isset($param)) {
            $msg = json_encode(['type' => Controller::WARNING,
                'content' => 'Incorrect or missing search parameter supplied for the search.  Please try again.']);
            $request->session()->flash('flash_message', $msg);
            return redirect(route('product-find-by-barcode-action'));
        }

        try {
            $store = new Datastore();
            $products = $store->findProductsByBarcode($param);
        }  catch (Exception $ex) {
            Log::error('Failed to find products by barcode (' . $param . '): ' . $ex->getMessage());
            $msg = json_encode(['type' => Controller::ERROR,
                'content' => 'An error occurred while searching for products, see the log file for details.']);
            $request->session()->flash('flash_message', $msg);
            return redirect(route('product-find-by-barcode-action'));
        }

        $msg = null;
        if (count($products) == 0) {
            $msg = new stdClass();
            $msg->type = Controller::INFO;
            $msg->content = 'Products found with the barcode: ' . $param;
        }

        return View::make('product.find', ['find_by_title' => 'Barcode', 'products' => $products, 'message' => $msg,
            'action_url' => route('product-find-by-barcode-action'), 'active_page' => 'product']);
    }

    public function findByNameAction(Request $request): ResponseView|Redirector
    {
        $param = $request->input('search-value');

        if (!isset($param)) {
            $msg = json_encode(['type' => Controller::WARNING,
                'content' => 'Incorrect or missing search parameter supplied for the search.  Please try again.']);
            $request->session()->flash('flash_message', $msg);
            return redirect(route('product-find-by-name-action'));
        }

        try {
            $store = new Datastore();
            $products = $store->findProductsByName($param);
        }  catch (Exception $ex) {
            Log::error('Failed to find products by name (' . $param . '): ' . $ex->getMessage());
            $msg = json_encode(['type' => Controller::ERROR,
                'content' => 'An error occurred while searching for products, see the log file for details.']);
            $request->session()->flash('flash_message', $msg);
            return redirect(route('product-find-by-name-action'));
        }

        $msg = null;
        if (count($products) == 0) {
            $msg = new stdClass();
            $msg->type = Controller::INFO;
            $msg->content = 'Products found with the name: ' . $param;
        }

        return View::make('product.find', ['find_by_title' => 'Name', 'products' => $products, 'message' => $msg,
            'action_url' => route('product-find-by-name-action'), 'active_page' => 'product']);
    }

    public function findById(): ResponseView
    {
        return View::make('product.find', ['find_by_title' => 'Id', 'action_url' => route('product-find-by-id-action'),
            'active_page' => 'product']);
    }

    public function findByBarcode(): ResponseView
    {
        return View::make('product.find', ['find_by_title' => 'Barcode', 'action_url' => route('product-find-by-barcode-action'),
            'active_page' => 'product']);
    }

    public function findByName(): ResponseView
    {
        return View::make('product.find', ['find_by_title' => 'Name', 'action_url' => route('product-find-by-name-action'),
            'active_page' => 'product']);
    }

    //endregion

    public function homePage(string $letter = null): ResponseView
    {
        $store = new Datastore();
        $letters = $store->getProductLetters();

        if (!isset($letter)) {
            if (count($letters)) {
                $letter = $letters[0];
            } else {
                $letter = 'A';
            }
        } else {
            $letter = strtoupper($letter);
        }

        $records = $store->getProductExtended($letter);

        return View::make('product.home',
            ['products' => $records, 'letters' => $letters, 'current_letter' => $letter, 'active_page' => 'product',
                'logged_in' => false, 'message' => null]);
    }

    public function details(int $id): ResponseView
    {
        $msg = null;
        $product = null;
        $store = new Datastore();

        try {
            $product = $store->getFullProduct($id);

            if (empty($product)) {
                $msg = new stdClass();
                $msg->type = Controller::WARNING;
                $msg->content = 'Product not found (' . $id . ')';
            }
        } catch (Exception $ex) {
            Log::error('An error occurred while loading the product details (' . $id . '): ' . $ex->getMessage());

            $msg = new stdClass();
            $msg->type = Controller::ERROR;
            $msg->content = 'An error occurred while loading the product details.  See the log file for details.';
        }

        return View::make('product.detail', ['product' => $product, 'active_page' => 'product',
            'logged_in' => false, 'message' => $msg]);
    }

    public function add(Request $request, string $barcode): RedirectResponse|ResponseView
    {
        // Look up the product details
        $lookup = new OpenFoodRepoLookup();

        try {
            $lookup_product = $lookup->getByBarcode($barcode);
        } catch (Exception $ex) {
            Log::error('Failed to lookup product (' . $barcode . '): ' . $ex->getMessage());
            $msg = json_encode(['type' => Controller::ERROR,
                'content' => 'An error occurred while looking up the product, see the log file for details.']);
            $request->session()->flash('flash_message', $msg);
            return redirect(route('lookup-homepage'));
        }

        // Create the database records
        $store = new Datastore();

        try {
            $product_id = $store->addProduct($lookup_product);

            if (!$product_id) {
                Log::error('Failed to add product to the database (' . $barcode . ')');
                $msg = json_encode(['type' => Controller::ERROR,
                    'content' => 'An error occurred while adding the product to the database, see the log file for details.']);
                $request->session()->flash('flash_message', $msg);
                return redirect(route('lookup-homepage'));
            }
        } catch (Exception $ex) {
            Log::error('Failed to add product to the database (' . $barcode . '): ' . $ex->getMessage());
            $msg = json_encode(['type' => Controller::ERROR,
                'content' => 'An error occurred while adding the product to the database, see the log file for details.']);
            $request->session()->flash('flash_message', $msg);
            return redirect(route('lookup-homepage'));
        }

        // Display the product page
        $letters = $store->getProductLetters();
        $letter = strtoupper(substr($lookup_product->getName(), 0, 1));
        $records = $store->getProductExtended($letter);

        $msg = new stdClass();
        $msg->type = Controller::INFO;
        $msg->content = 'New product successfully added to the application (' . $product_id . ')';

        return View::make('product.home', ['products' => $records, 'letters' => $letters, 'current_letter' => $letter,
            'active_page' => 'product', 'logged_in' => false, 'message' => $msg]);
    }

    public function remove(Request $request, int $id): ResponseView
    {

        return View::make('product.home', ['products' => [], 'active_page' => 'product', 'logged_in' => false]);
    }

    public function delete(Request $request, int $id): RedirectResponse
    {
        $msg = null;
        $store = new Datastore();

        // Delete the product
        try {
            $product = $store->getProduct($id);

            if ($product) {
                if (!$store->deleteProduct($product))
                    $msg = json_encode(['type' => Controller::WARNING, 'content' => 'Product not deleted (' . $id . '), see log for details.']);
            } else {
                $msg = json_encode(['type' => Controller::WARNING, 'content' => 'Product not found in database (' . $id . ')']);
            }
        } catch (Exception $ex) {
            Log::error('Failed to delete product (' . $id . '): ' . $ex->getMessage());
            $msg = json_encode(['type' => Controller::ERROR,
                'content' => 'An error occurred while deleting a product, see the log file for details.']);
        }

        if (!isset($msg)) {
            $msg = json_encode(['type' => Controller::SUCCESS, 'content' => 'Product deleted successfully: ' . $id]);
        }

        $request->session()->flash('flash_message', $msg);
        return redirect(route('product-home'));
    }
}
