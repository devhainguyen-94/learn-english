<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login (Request $request){

      return redirect('test1');
//        $request->validate([
//            'user_name' => 'required',
//            'password' => 'required',
//        ]);
//        $credentials = $request->only('user_name', 'password');
//        if (Auth::attempt($credentials)) {
//            return redirect()->intended('dashboard')
//                ->withSuccess('Signed in');
//            $this->redirectTo = '/home2';
//        }
//        $this->redirectTo = '/home1';
//        return redirect("login")->withSuccess('Login details are not valid');
    }
}
