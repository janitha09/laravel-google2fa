<?php

namespace Tests;

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Request;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function testRegisterControllerRegister(){
        fwrite(STDOUT, __METHOD__ . "\n");

        $user = factory(User::class)->make([
            'email' => 'janitha@mailinator.com',
            'twofa_token' => 123456]);

        // fwrite(STDOUT,print_r($user,true));
        // $this->actingAs($user);
        // $this->session(['foo' => 'bar']);
        $registercontroller = new RegisterController();
        $request = Request::create('/','POST',[
            '_token' => 'PH628EPqOvm9bq7u7pCMKf6wJ7FfZ70yMmxTYJgt',
            'google2fa_secret' => 'google2fa_secret',
            'email' => 'janitha@mailinator.com',
            'name' => 'Janitha', 
            'password' => 'janitha@mailinator.com',
            'password_confirmation' => 'janitha@mailinator.com'
        ]);
        $reponse = $registercontroller->register($request);
        // fwrite(STDOUT,print_r($reponse->getName(),true));
        $this->assertEquals($reponse->getName(),'google2fa.register');
    }
}


