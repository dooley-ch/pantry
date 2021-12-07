<?php
// *******************************************************************************************
//  File:  HomeController.php
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
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ResponseView;

class HomeController extends \Laravel\Lumen\Routing\Controller
{
    public function homePage(Request $request): ResponseView
    {
        return View::make('home');
    }

    public function usagePage(Request $request): ResponseView
    {
        return View::make('usage');
    }

    public function aboutPage(Request $request): ResponseView
    {
        return View::make('about');
    }

    public function setupPage(Request $request): ResponseView
    {
        return View::make('setup');
    }
}
