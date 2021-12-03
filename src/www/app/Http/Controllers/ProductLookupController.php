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

class ProductLookupController extends Controller
{
    private OpenFoodRepoLookup $repoLookup;

    public function __construct()
    {
        $this->repoLookup = new OpenFoodRepoLookup();
    }

    public function getProductByCode(Request $request, string $code): Response
    {
        if ($request->wantsJson()) {
            // TODO - Return JSON
            return new Response("JSON Not Implemented: " . $code, 401);
        }

        return new Response("Product By Code: " . $code, 200);
    }

    public function getProductByBarcode(Request $request, string $barcode): Response
    {
        if ($request->wantsJson()) {
            // TODO - Return JSON
            return new Response("JSON Not Implemented: " . $barcode, 401);
        }

        return Response("Product By Barcode: " . $barcode, 200);
    }
}
