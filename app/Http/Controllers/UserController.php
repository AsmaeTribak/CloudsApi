<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    use SendsPasswordResetEmails;


    public function __construct()
    {
        $this->middleware("managerRole");
    }

    public function index(){

        $usersOfCurrentEntity = \Auth::user()->entity->users;

        return view('users.users' , [ 'usersOfCurrentEntity' => $usersOfCurrentEntity ] );
    }
    public function reseUsertPassword(  $userid ){

        $user = User::find($userid);
        // return $user ;

        if(  $user == null )
        return redirect()->back()->withFail('User not found');
        

        $response = $this->broker()->sendResetLink(
            [ "email" => $user->email ]  );

        return redirect()->back()->with('success',"well done");
        ;

    }
}
