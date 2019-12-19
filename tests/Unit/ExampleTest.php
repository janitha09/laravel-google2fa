<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TwoFactorController;
// use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Request;
use App\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
    public function testRegisterControllerRegister(){
        fwrite(STDOUT, __METHOD__ . "\n");

        // $this->app->make('Illuminate\Contracts\Http\Kernel')
        // ->pushMiddleware('Illuminate\Session\Middleware\StartSession')
        // ->pushMiddleware('Illuminate\View\Middleware\ShareErrorsFromSession::class');

        // $user = factory(User::class)->make([
        //     'email' => 'janitha@mailinator.com',
        //     'twofa_token' => 123456]);

        // fwrite(STDOUT,print_r($user,true));
        // $this->actingAs($user);
        // $this->session(['foo' => 'bar']);

        // $this->loginUser();
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

    public function testRouteCompleteRegistration(){
        fwrite(STDOUT, __METHOD__ . "\n");
        $app_url = env('APP_URL');
        $url = '/complete-registration';
        $response = $this->get($url);
        $this->assertEquals($response->getStatusCode(),200);
    }

    public function testRoute2fa(){
        fwrite(STDOUT, __METHOD__ . "\n");
        $app_url = env('APP_URL');
        $url = '/2fa';
        $response = $this->post($url);
        $this->assertEquals($response->getStatusCode(),302);
    }

    public function testCompleteRegistration(){
        fwrite(STDOUT, __METHOD__ . "\n");

        $registercontroller = new RegisterController();
        $request = Request::create('/','POST',[
            '_token' => 'PH628EPqOvm9bq7u7pCMKf6wJ7FfZ70yMmxTYJgt',
            'google2fa_secret' => 'google2fa_secret',
            'email' => 'janitha@mailinator.com',
            'name' => 'Janitha', 
            'password' => 'janitha@mailinator.com',
            'password_confirmation' => 'janitha@mailinator.com'
        ]);
        $reponse = $registercontroller->completeRegistration($request);
        // fwrite(STDOUT,print_r($reponse->getName(),true));
        $this->assertEquals($reponse->getName(),'google2fa.register');
    }
    public function testTwoFactorController(){
        $twoFactorController = new TwoFactorController();
        $response = $twoFactorController->doSomething();
        $this->assertEquals($response->getStatusCode(),302);
    }
}
