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

/**
 * Class HomeController
 *
 * This controller implements the follow pages
 * - Home page
 * - Usage page
 * - About page
 *
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * This method returns the home page of application
     *
     * @return ResponseView
     */
    public function homePage(): ResponseView
    {
        return View::make('home', ['active_page' => 'home', 'logged_in' => false]);
    }

    /**
     * This method returns the usage page for the application
     *
     * @return ResponseView
     */
    public function usagePage(): ResponseView
    {
        return View::make('usage', ['active_page' => 'usage', 'logged_in' => false]);
    }

    /**
     * This method returns the about page for the application
     *
     * @return ResponseView
     */
    public function aboutPage(): ResponseView
    {
        return View::make('about', ['active_page' => 'about', 'logged_in' => false]);
    }
}
