<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * This controller passes messages between response methods using the following message codes:
 *    INFO = 0
 *    SUCCESS = 1
 *    WARNING = 2
 *    ERROR = 3
 */
class Controller extends BaseController
{
    public const INFO = 0;
    public const SUCCESS = 1;
    public const WARNING = 2;
    public const ERROR = 3;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
