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
        return View::make('product_lookup', ['product' => null, 'active_page' => 'lookup', 'logged_in' => false, 'message' => null]);
    }

    public function lookup(Request $request): RedirectResponse|Redirector|Response|ResponseView
    {
        return View::make('product_lookup', ['product' => null, 'active_page' => 'lookup', 'logged_in' => false, 'message' => null]);
    }
}
