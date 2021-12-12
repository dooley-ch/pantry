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

class HomeController extends Controller
{
    public function homePage(Request $request): ResponseView
    {
        return View::make('home', ['active_page' => 'home', 'logged_in' => false]);
    }

    public function usagePage(Request $request): ResponseView
    {
        return View::make('usage', ['active_page' => 'usage', 'logged_in' => false]);
    }

    public function aboutPage(Request $request): ResponseView
    {
        return View::make('about', ['active_page' => 'about', 'logged_in' => false]);
    }

    public function setupPage(Request $request): ResponseView
    {
        return View::make('setup', ['active_page' => 'setup', 'logged_in' => false]);
    }
}
