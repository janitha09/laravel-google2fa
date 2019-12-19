<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    public function __construct(){
        $this->middleware('2fa');
    }
    public function doSomething(){
        return redirect(URL()->previous());
    }
}
