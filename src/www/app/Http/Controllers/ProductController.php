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

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function homePage(Request $request): Response
    {
        return new Response("Product Home Page", 200);
    }

    public function details(Request $request, string $barcode): Response
    {
        return new Response("Product Details", 200);
    }

    public function add(Request $request, string $barcode): Response
    {
        return new Response("Add Product", 200);
    }

    public function remove(Request $request, string $barcode): Response
    {
        return new Response("Remove Product", 200);
    }

    public function delete(Request $request, string $barcode): Response
    {
        return new Response("Delete Product", 200);
    }
}
