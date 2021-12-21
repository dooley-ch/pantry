<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * This is the base class for all controllers in the application.  It provides the constant
 * definitions for flash messages displayed on the application pages.
 *
 * The following message constants are defined:
 *    INFO = 0
 *    SUCCESS = 1
 *    WARNING = 2
 *    ERROR = 3
 *
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    public const INFO = 0;
    public const SUCCESS = 1;
    public const WARNING = 2;
    public const ERROR = 3;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
