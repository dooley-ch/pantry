<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * This controller passes messages between response methods using the following message codes:
 *    INFO = 0
 *    SUCCESS = 1
 *    WARNING = 3
 *    ERROR = 4
 */
class Controller extends BaseController
{
    public const INFO = 0;
    public const SUCCESS = 1;
    public const WARNING = 3;
    public const ERROR = 4;
}
