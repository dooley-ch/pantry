<?php
// *******************************************************************************************
//  File:  ApiController.php
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

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    public function getProductDetails(Request $request, string $barcode): Response
    {
        return new Response("Get Product By Barcode: " . $barcode, 200);
    }

    public function addProduct(Request $request, string $barcode): Response
    {
        return new Response("Add Product By Barcode: " . $barcode, 200);
    }

    public function removeProduct(Request $request, string $barcode): Response
    {
        return new Response("Remove Product By Barcode: " . $barcode, 200);
    }
}
