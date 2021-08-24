<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Provider;
use App\SSHkey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AccountsController extends Controller
{
    public function index($providerid)
    {
        // $accounts = Account::all();
        $provider = Provider::findOrFail($providerid); 
        // $test= Accounts::all();

        $accounts = $provider->accounts ;
         
        // return [ $accounts[0]->sshkey == null ];
        return view('gestion.accounts', ['accounts' => $accounts , 'provider_id' => $providerid]);
    }
    public function addaccount( $providerid , Request $request)
    {
        // return [ $providerid , $request->all() ]; 
       $account = new Account;

        $account->name=$request->name;
        $account->proxy=$request->proxy;
        $account->provider_id= $providerid;
        // $account->sshkey_id=$request->sshkey_id;
        
        $is_saved = $account->save();

        if( $is_saved)
        return redirect()->back()->with('success','account added successfuly');
        else
        return redirect()->back()->withfail('hopelessly' );
    }
    public function desactivate($accountsid)
    {

        $account= Account::find($accountsid);

        if ($account == null)
            return Redirect::to("/accounts")->withFail('accounts not found ');
       else 
      $account->is_active = false;
        $isUpdated =$account->update();


        if ($isUpdated)
            return Redirect::to("/accounts")->with('success', "accounts desactivate successfuly ");
        else
            return Redirect::to("/accounts")->withFail('Something wrong  ');
    }


    public function activate($accountsid)
    {

        $account= Account::find($accountsid);

        if ($account== null)
            return Redirect::to("/accounts")->withFail('$account not found ');
        else 

        $account->is_active = true;
        $isUpdated = $account->update();


        if ($isUpdated)
            return Redirect::to("/accounts")->with('success', "account activate successfuly ");
        else
            return Redirect::to("/accounts")->withFail('Something wrong  ');
    }
    public function indexx($sshkeyid)
    {
        $sshkey= SSHkey::findOrFail($sshkeyid); 

        $accountss = $sshkey->account ;
         

        return view('gestion.accounts', ['accounts' => $accountss]);
    }

}
