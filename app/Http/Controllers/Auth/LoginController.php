<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

   public function redirectTo(){
    if(in_array(Auth::user()->role, [1, 2])){
        return '/admin/dashboard/index';
    }
    return '/login';
   }
     
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    public function logout(Request $request)
    {
        $redirect ='/login';
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect($redirect);
    }
}
