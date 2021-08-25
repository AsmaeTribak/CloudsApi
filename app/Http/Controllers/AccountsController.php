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
        $provider = Provider::findOrFail($providerid);

        $accounts = $provider->accounts ;

        return view('gestion.accounts', ['accounts' => $accounts , 'provider' => $provider ]);
        // return view('gestion.accounts', ['accounts' => $accounts , 'provider_id' => $providerid]);
    }

    public function addaccount( $providerid , Request $request)
    {
        
        $provider = Provider::findOrFail($providerid);

        return [ $provider , $request->all() ];
        // $account = new Account;

        // $account->name=$request->name;
        // $account->proxy=$request->proxy;
        // $account->provider_id= $providerid;

        // $is_saved = $account->save();


        // return $is_saved ?
        //     redirect()->back()->with('success','account added successfuly') :
        //     redirect()->back()->withfail('hopelessly' );
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
