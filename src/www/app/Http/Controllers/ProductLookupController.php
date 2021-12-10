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
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ResponseView;
use Illuminate\Http\RedirectResponse;
use Laravel\Lumen\Http\Redirector;
use function PHPUnit\Framework\isNull;

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
        if (!$request->hasAny('search-type', 'search-value')) {
            $msg = json_encode(['type' => Controller::WARNING, 'message' => 'Incorrect or missing parameters supplied for the search.']);
            $request->session()->flash('lookup_message', $msg);
            return redirect(route('lookup-homepage'));
        }

        $lookup = new OpenFoodRepoLookup();
        $request_data = $request->all('search-type', 'search-value');

        if ($request_data['search-type'] == 'Code') {
            $product = $lookup->getByCode($request_data['search-value']);
        } else {
            $product = $lookup->getByBarcode($request_data['search-value']);
        }

        if (isNull($product)) {
            $msg = json_encode(['type' => Controller::INFO, 'message' => 'Product not found.']);
            $request->session()->flash('lookup_message', $msg);
            return redirect(route('lookup-homepage'));
        }

        return View::make('product_lookup', ['product' => $product, 'active_page' => 'lookup',
                                'logged_in' => false, 'message' => null]);
    }
}
