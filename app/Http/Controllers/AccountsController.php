<?php

namespace App\Http\Controllers;

use App\Accounts;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index()
    {
        $accounts = Accounts::all();
        

        return view('gestion.accounts', ['accounts' => $accounts]);
    }
}
