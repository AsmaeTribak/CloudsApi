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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    function checklogin(Request $request){

        $this->validate($request, [
            'email' => 'required|email|exists:users,email,is_active,1',
            'password' => 'required',
        ]);

        $user_data = array(
            'email'     => $request->get('email'),
            'password'  => $request->get('password') ,
            'is_active' => 1
        );  

        $authed = Auth::attempt($user_data);

        if(!$authed){
            return redirect()->route('login')->withFail('Something wrong !! check your password ');
        }

        if ( Auth::check() ) {
            return redirect($this->redirectTo);
        }
    }
}
