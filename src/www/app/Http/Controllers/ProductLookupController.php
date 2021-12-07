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

class ProductLookupController extends Controller
{
    private OpenFoodRepoLookup $repoLookup;

    public function __construct()
    {
        $this->repoLookup = new OpenFoodRepoLookup();
    }

    public function getProductByCode(Request $request, string $code): mixed
    {
        if ($request->wantsJson()) {
            // TODO - Return JSON
            return new Response("JSON Not Implemented: " . $code, 401);
        }

        return View::make('product_lookup', ['active_page' => 'lookup', 'logged_in' => false]);
    }

    public function getProductByBarcode(Request $request, string $barcode): mixed
    {
        if ($request->wantsJson()) {
            // TODO - Return JSON
            return new Response("JSON Not Implemented: " . $barcode, 401);
        }

        return View::make('product_lookup', ['active_page' => 'lookup', 'logged_in' => false]);
    }
}
