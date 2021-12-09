<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication(): \Laravel\Lumen\Application
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
