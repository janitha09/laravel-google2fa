<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers
    {
        register as registration;
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'google2fa_secret' => $data['google2fa_secret'],
        ]);
    }

    // https://github.com/guiwoda/laravel-framework/blob/master/src/Illuminate/Foundation/Auth/RegistersUsers.php
    public function register(Request $request){
        $valid = $this->validator($request->all())->validate();
        // print_r($request->all());
        // fwrite(STDOUT,print_r($valid,true));
        $google2fa = app('pragmarx.google2fa');
        // fwrite(STDOUT,print_r($google2fa,true));
        $registration_data = $request->all();
        $registration_data["google2fa_secret"] = $google2fa->generateSecretKey();
        // fwrite(STDOUT,print_r($registration_data,true));
        $request->session()->flash('registration_data', $registration_data);
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $registration_data['email'],
            $registration_data['google2fa_secret']
        );
        return view('google2fa.register', ['QR_Image' => $QR_Image, 'secret' => $registration_data['google2fa_secret']]);
        
    }

    public function completeRegistration(Request $request){
        $request->merge(session('registration_data'));
        return $this->registration($request);
    }
}
