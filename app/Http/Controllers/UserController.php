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

    public function index()
    {

        $usersOfCurrentEntity = \Auth::user()->entity->users()->paginate(5);

        // return $usersOfCurrentEntity;

        return view('vieww.users', ['usersOfCurrentEntity' => $usersOfCurrentEntity]);
    }
    public function resetUserPassword($userid)
    {

        $user = User::find($userid);


        if ($user == null)
            return redirect()->back()->withFail('User not found');


        $response = $this->broker()->sendResetLink(
            ["email" => $user->email]
        );

        return redirect()->back()->with('success', "well done");;
    }
    public function desactivate($userid)
    {

        $user = User::find($userid);

        if ($user == null)
            return Redirect::to("/users")->withFail('Users not found ');
        if (in_array($user->role, ['leader', 'admin']))
            return Redirect::to("/users")->withFail(" you don't have permission ");
        $user->is_active = false;
        $isUpdated = $user->update();


        if ($isUpdated)
            return Redirect::to("/users")->with('success', "user desactivate successfuly ");
        else
            return Redirect::to("/users")->withFail('Something wrong  ');
    }


    public function activate($userid)
    {

        $user = User::find($userid);

        if ($user == null)
            return Redirect::to("/users")->withFail('Users not found ');
        if (in_array($user->role, ['leader', 'admin']))
            return Redirect::to("/users")->withFail(" you don't have permission ");

        $user->is_active = true;
        $isUpdated = $user->update();


        if ($isUpdated)
            return Redirect::to("/users")->with('success', "user activate successfuly ");
        else
            return Redirect::to("/users")->withFail('Something wrong  ');
    }

    public function update(Request $request)
    {
        $user = User::find($request->id_user);
        // return $user ;
        if ($user == null)
            return redirect()->back()->withFail('User not exist');

        if (\Auth::user()->role != "admin")
            return redirect()->back()->withFail("you d'ont have permisson ");

        $user->role = $request->role;

        $saved = $user->update();
        if ($saved)
            return redirect()->back()->with("success", " role changed");
        else
            return redirect()->back()->withFail("something wrong ");
    }
}
