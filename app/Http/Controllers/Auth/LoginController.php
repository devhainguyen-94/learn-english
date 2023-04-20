<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
//      return redirect('test1');
//        $request->validate([
//            'email' => 'required',
//            'password' => 'required',
//        ]);
        $credentials = $request->only('email','password');
        if (Auth::attempt($credentials)) {
//            $user = Auth::getUser();
//            $token = $user->createToken('authToken')->plainTextToken;
            $user = User::where('email', $request->email)->first();
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return redirect()->route('home2')->with(['token'=>$tokenResult ,'role'=>1]);
        }
        return redirect("login")->withSuccess('Login details are not valid');
    }
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }
}
