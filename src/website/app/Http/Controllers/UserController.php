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

use Illuminate\Support\Facades\View;
use Illuminate\View\View as ResponseView;

/**
 * Class UserController
 *
 * This controller implements the User functionality for the application
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * This method displays the user home page
     *
     * @return ResponseView
     */
    public function homePage(): ResponseView
    {
        return View::make('user.home', ['active_page' => 'user', 'logged_in' => false]);
    }
}
