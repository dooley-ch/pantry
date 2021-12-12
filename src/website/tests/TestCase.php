<?php
// *******************************************************************************************
//  File:  TestCase.php
//
//  Created: 12-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  12-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
