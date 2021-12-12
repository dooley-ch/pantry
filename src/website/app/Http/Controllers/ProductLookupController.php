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

use App\Core\OpenFoodRepoLookup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ResponseView;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

use Exception;

class ProductLookupController extends Controller
{
    public function homePage(Request $request): ResponseView
    {
        $msg = $request->session()->get('lookup_message');

        if (isset($msg)) {
            $msg = json_decode($msg);
        } else {
            $msg = null;
        }

        return View::make('product_lookup', ['product' => null, 'active_page' => 'lookup', 'logged_in' => false, 'message' => $msg]);
    }

    public function lookup(Request $request): RedirectResponse|Redirector|Response|ResponseView
    {
        $lookup = new OpenFoodRepoLookup();
        $request_data = $request->all('search-type', 'search-value');
        $type = $request_data['search-type'];
        $search_value = $request_data['search-value'];

        if (!isset($type) or !isset($search_value)) {
            $msg = json_encode(['type' => Controller::WARNING,
                'content' => 'Incorrect or missing parameters supplied for the search.  Please try again.']);
            $request->session()->flash('lookup_message', $msg);
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
            $request->session()->flash('lookup_message', $msg);
            return redirect(route('lookup-homepage'));
        }

        if ($product == null) {
            $search_type = 'barcode';
            if ($type == 'Code')
                $search_type = 'code';

            $msg = json_encode(['type' => Controller::INFO,
                'content' => 'There is no product on the Open Food Repo website with the provided ' . $search_type . '.']);
            $request->session()->flash('lookup_message', $msg);
            return redirect(route('lookup-homepage'));
        }

        return View::make('product_lookup', ['product' => $product, 'active_page' => 'lookup',
            'logged_in' => false, 'message' => null]);
    }
}
