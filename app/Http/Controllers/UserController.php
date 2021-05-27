<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    

    public function __construct()
    {
        $this->middleware("managerRole");
    }

    public function index(){

        $usersOfCurrentEntity = \Auth::user()->entity->users;

        return view('users.users' , [ 'usersOfCurrentEntity' => $usersOfCurrentEntity ] );
    }

}
