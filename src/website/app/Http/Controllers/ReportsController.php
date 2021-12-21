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

use App\Core\Datastore;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ResponseView;
use Exception;
use stdClass;

/**
 * Class ReportsController
 *
 * This controller implements the reporting functionality of the application
 *
 * @package App\Http\Controllers
 */
class ReportsController extends Controller
{
    /**
     * The method implements the reports home page
     *
     * @return ResponseView The reports home page
     */
    public function homePage(): ResponseView
    {
        $msg = null;

        try {
            $store = new Datastore();
            $records = $store->getStockReport();
        }catch (Exception $ex) {
            Log::error('Failed to load stock summary: ' . $ex->getMessage());
            $records = [];
            $msg = new stdClass();
            $msg->type = Controller::ERROR;
            $msg->content = 'An error occurred while loading the stock summary report, see the log file for details.';
        }
        return View::make('reports.home', ['records' => $records, 'active_page' => 'reports', 'logged_in' => false, 'message' => $msg]);
    }
}
