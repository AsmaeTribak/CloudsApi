<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
    public function resetUserPassword(  $userid ){

        $user = User::find($userid);
        

        if(  $user == null )
        return redirect()->back()->withFail('User not found');
        

        $response = $this->broker()->sendResetLink(
            [ "email" => $user->email ]  );

        return redirect()->back()->with('success',"well done");
        ;

    }
    public function desactivate ( $userid ){

        $user=User::find($userid);

        if($user == null)
            return Redirect::to("/users")->withFail('Users not found ');
        if (in_array($user->role, ['leader', 'admin']))
            return Redirect::to("/users")->withFail(" you don't have permission ");

        $user->is_active=false;
        $isUpdated = $user->update();


        if( $isUpdated )
            return Redirect::to("/users")->with('success',"user desactivate successfuly ");
        else  
            return Redirect::to("/users")->withFail('Something wrong  ');
        // return $user;   



    }
}
