<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

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

    use RegistersUsers , SendsPasswordResetEmails;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('managerRole');
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
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            'entity_id'=> ['required'],
            'ref_user'=> ['required'],
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
            // 'password' => Hash::make($data['password']),
            'entity_id'=> $data['entity_id'],
            'ref_user'=>$data['ref_user'],
        ]);
    }
    
/**
 * Handle a registration request for the application.
 * this method is costumised for reasons 
 *  - after manager / adminer has register this register system don't auth new user 
 *  - after user register send email reset password for new user   
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
*/
public function register(Request $request)
{
    // validate request user data 
    $this->validator($request->all())->validate();
    
    // store user in database // register user 
    event(new Registered($user = $this->create($request->all())));
    
    // if registered return null  so the register user is success 
    // else if not null  mean that this is a problems in register / feild  
    $registered = $this->registered($request, $user) ;

    // check if user is regester 
    // if so then send email of reset password to the new user 
    if( $registered == null ){   
        $this->sendResetpassword( $user );
    }

    // if user register continue else redirect with flash errors  
    return $registered ?: redirect($this->redirectPath());
}


private function sendResetpassword( User $user ){
    

    // We will send the password reset link to this user. Once we have attempted
    // to send the link, we will examine the response then see the message we
    // need to show to the user. Finally, we'll send out a proper response.
    $response = $this->broker()->sendResetLink(
        [ "email" => $user->email ]
    );

    return $response ;

}
 
}
