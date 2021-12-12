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
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ResponseView;

class ProductController extends Controller
{
    public function homePage(Request $request): ResponseView
    {
        return View::make('product.home', ['active_page' => 'product', 'logged_in' => false]);
    }

    public function details(Request $request, string $barcode): ResponseView
    {
        return View::make('product.detail', ['active_page' => 'product', 'logged_in' => false]);
    }

    public function add(Request $request, string $barcode): ResponseView
    {
        return View::make('product.home', ['active_page' => 'product', 'logged_in' => false]);
    }

    public function remove(Request $request, string $barcode): ResponseView
    {
        return View::make('product.home', ['active_page' => 'product', 'logged_in' => false]);
    }

    public function delete(Request $request, string $barcode): ResponseView
    {
        return View::make('product.home', ['active_page' => 'product', 'logged_in' => false]);
    }
}