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
use Illuminate\Http\Response;

class HomeController extends \Laravel\Lumen\Routing\Controller
{
    public function homePage(Request $request): Response
    {
        return new Response("Home Page", 200);
    }

    public function usagePage(Request $request): Response
    {
        return new Response("Usage Page", 200);
    }

    public function aboutPage(Request $request): Response
    {
        return new Response("About Page", 200);
    }
}
