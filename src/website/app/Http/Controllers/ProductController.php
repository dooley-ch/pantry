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

/**
 * Class ProductController
 *
 * This controller implements the product related pages:
 * - Product home page
 * - Product details page
 * - Add Product operation
 * - Remove Product operation
 * - Delete Product transactions
 * - Find a product by ID
 * - Find a product by Barcode
 * - Find a product by Name
 *
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    //region Find

    /**
     * This method implements the find by ID action
     *
     * @param Request $request The HTML request
     * @return ResponseView|Redirector The product list based on the name or a redirect to the find page if an error occurred
     */
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

    /**
     * This method implements the find by barcode action
     *
     * @param Request $request The HTML request
     * @return ResponseView|Redirector The product list based on the name or a redirect to the find page if an error occurred
     */
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

    /**
     * This method implements the find by name action
     *
     * @param Request $request The HTML request
     * @return ResponseView|Redirector The product list based on the name or a redirect to the find page if an error occurred
     */
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

    /**
     * This method returns the find by ID page
     *
     * @return ResponseView The find by name page
     */
    public function findById(): ResponseView
    {
        return View::make('product.find', ['find_by_title' => 'Id', 'action_url' => route('product-find-by-id-action'),
            'active_page' => 'product']);
    }

    /**
     * This method returns the find by barcode page
     *
     * @return ResponseView The find by name page
     */
    public function findByBarcode(): ResponseView
    {
        return View::make('product.find', ['find_by_title' => 'Barcode', 'action_url' => route('product-find-by-barcode-action'),
            'active_page' => 'product']);
    }

    /**
     * This method returns the find by name page
     *
     * @return ResponseView The find by name page
     */
    public function findByName(): ResponseView
    {
        return View::make('product.find', ['find_by_title' => 'Name', 'action_url' => route('product-find-by-name-action'),
            'active_page' => 'product']);
    }

    //endregion

    /**
     * This method returns the product home page
     *
     * @param string|null $letter The first letter of the products required in the page product's list
     * @return ResponseView The product home page
     */
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

    /**
     * This method returns the product details page
     *
     * @param Request $request The HTML request
     * @param int $id The id of the product for which details are required
     * @return ResponseView The product details page
     */
    public function details(Request $request, int $id): ResponseView
    {
        $msg = $request->session()->get('flash_message');

        if (isset($msg)) {
            $msg = json_decode($msg);
        }

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

    /**
     * This method adds a product to the application database and displays the product page
     *
     * @param Request $request The HTML request
     * @param string $barcode The barcode of the product to add
     * @return RedirectResponse|ResponseView The product details page or redirects back to the product home page if there was an error
     */
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

    // TODO - Need to implement the remove method
    public function remove(Request $request, int $id): ResponseView
    {
        return View::make('product.home', ['products' => [], 'active_page' => 'product', 'logged_in' => false]);
    }

    /**
     * This method deletes the product and redirects back to the product home page
     *
     * @param Request $request The HTML request
     * @param int $id The product id for which the transactions need to be deleted
     * @return RedirectResponse The redirection response returning the application to the Product home page
     */
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
