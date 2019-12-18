<?php

namespace Tests;

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Request;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

}


