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
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ResponseView;

class ReportsController extends Controller
{
    public function homePage(Request $request): ResponseView
    {
        return View::make('reports.home', ['active_page' => 'reports', 'logged_in' => false]);
    }
}