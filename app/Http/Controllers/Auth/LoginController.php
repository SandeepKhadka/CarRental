<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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

    public function credentials(Request $request)
    {
        return ['email' => $request->email, 'password' => $request->password, 'status' => 'active'];
    }

    // public function username()
    // {
    //     return 'email';
    // }

    // protected function attemptLogin(Request $request)
    // {
    //     $user = User::where('email', $request->email)->first();
    //     $seller = Seller::where('email', $request->email)->first();

    //     if ($user && Hash::check($request->password, $user->password)) {
    //         Auth::guard('web')->login($user);
    //         return true;
    //     } elseif ($seller && Hash::check($request->password, $seller->password)) {
    //         Auth::guard('seller')->login($seller);
    //         return true;
    //     }

    //     return false;
    // }

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');
    //     // dd($credentials);

    //     if (Auth::guard('seller')->attempt($credentials)) {
    //         // The user is authenticated using the seller guard
    //         return view('layouts.vendor');
    //     }
    //     if (Auth::attempt($credentials)) {
    //         // The user is authenticated using the default guard
    //         return redirect()->intended('/customer');
    //     }

    //     return redirect('/login')->withErrors([
    //         'email' => 'These credentials do not match our records.',
    //     ]);
    // }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/login');
    }
}
