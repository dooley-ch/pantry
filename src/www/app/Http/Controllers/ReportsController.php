<?php
// *******************************************************************************************
//  File:  ReportsController.php
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

class ReportsController extends Controller
{
    public function homePage(Request $request): Response
    {
        return new Response("Reports Home Page", 200);
    }

}
