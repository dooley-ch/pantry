<?php
// *******************************************************************************************
//  File:  UserController.php
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

class UserController extends Controller
{
    public function homePage(Request $request): Response
    {
        return new Response("User Home Page", 200);
    }

}
