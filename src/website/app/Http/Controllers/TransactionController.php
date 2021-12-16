<?php
// *******************************************************************************************
//  File:  TransactionController.php
//
//  Created: 15-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  15-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Datastore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class TransactionController
 *
 * This controller hands the product transactions, similar to a product item being scanned on entry or exit to the pantry.
 * It also provides an option to clear down the transactions for the product in the database
 *
 * @package App\Http\Controllers
 */
class TransactionController extends Controller
{
    /**
     * Adds a product item to the transaction records for a given product
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function add(Request $request, int $id): RedirectResponse
    {
        try {
            $store = new Datastore();

            if ($store->alterProductItems($id, 'A')) {
                $msg['type'] = Controller::INFO;
                $msg['content'] = 'New item added to the product details.';
            } else {
                $msg['type'] = Controller::WARNING;
                $msg['content'] = 'An error occurred while adding a product item, see the log file for details.';
            }
        } catch (Exception $e) {
            Log::error('An error occurred while adding a product item (' . $id . '): ' . $e->getMessage());
            $msg['type'] = Controller::ERROR;
            $msg['content'] = 'An unhandled error occurred while adding a product item, see the log file for details.';
        }

        $msg = json_encode($msg);
        $request->session()->flash('flash_message', $msg);
        return redirect(route('product-detail', $id));
    }

    /**
     * Removes a product item from the transaction records for a given product
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function remove(Request $request, int $id): RedirectResponse
    {
        try {
            $store = new Datastore();

            if ($store->alterProductItems($id, 'R')) {
                $msg['type'] = Controller::INFO;
                $msg['content'] = 'An item was removed from the product details.';
            } else {
                $msg['type'] = Controller::WARNING;
                $msg['content'] = 'An error occurred while removing a product item, see the log file for details.';
            }
        } catch (Exception $e) {
            Log::error('An error occurred while removing a product item (' . $id . '): ' . $e->getMessage());
            $msg['type'] = Controller::ERROR;
            $msg['content'] = 'An unhandled error occurred while removing a product item, see the log file for details.';
        }

        $msg = json_encode($msg);
        $request->session()->flash('flash_message', $msg);
        return redirect(route('product-detail', $id));
    }

    /**
     * Deletes all the transaction records for a given product
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function clear(Request $request, int $id): RedirectResponse
    {
        try {
            $store = new Datastore();

            if ($store->clearProductItems($id)) {
                $msg['type'] = Controller::INFO;
                $msg['content'] = 'All transactions deleted for this product.';
            } else {
                $msg['type'] = Controller::WARNING;
                $msg['content'] = 'An error occurred while deleting product items, see the log file for details.';
            }
        } catch (Exception $e) {
            Log::error('An error occurred while deleting product items (' . $id . '): ' . $e->getMessage());
            $msg['type'] = Controller::ERROR;
            $msg['content'] = 'An unhandled error occurred while deleting product items, see the log file for details.';
        }

        $msg = json_encode($msg);
        $request->session()->flash('flash_message', $msg);
        return redirect(route('product-detail', $id));
    }
}
