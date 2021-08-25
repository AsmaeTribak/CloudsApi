<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\FourKeys;
use App\Models\OneKey;
use App\Models\Provider;
use App\Models\TwoKeys;
use App\SSHkey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AccountsController extends Controller
{
    public function index($providerid)
    {
        $provider = Provider::findOrFail($providerid);

        $accounts = $provider->accounts ;

    //    $accounts[0]->getAuth() 

        return view('gestion.accounts', ['accounts' => $accounts , 'provider' => $provider ]);
    }

    public function addaccount( $providerid , Request $request)
    {   
        
        $provider = Provider::findOrFail($providerid);

        $authKey = null ;
        try{
            DB::beginTransaction();

            switch( $provider->type ){

                case "1key":
                        $authKey = new OneKey();
                        $authKey->first_key = $request->keys["firstKey"];
                    break ;

                case "2key": 
                    $authKey = new TwoKeys();
                    $authKey->first_key = $request->keys["firstKey"];
                    $authKey->second_key = $request->keys["secondKey"];
                    break;


                case "4key": 
                    $authKey = new FourKeys();
                    $authKey->first_key = $request->keys["firstKey"];
                    $authKey->second_key = $request->keys["secondKey"];
                    $authKey->third_key = $request->keys["threadKey"];
                    $authKey->fourth_key = $request->keys["fourthKey"];
                    break;

            }

            $account = new Account;
            $account->name=$request->name;
            $account->proxy=$request->proxy;
            $account->provider_id= $providerid;
            $is_saved = $account->save();

            if( $is_saved ) {
                $authKey->account_id =  $account->id ;
                $authKey->save();
            }
            DB::commit();
            return $is_saved ?
                redirect()->back()->with('success','account added successfuly') :
                redirect()->back()->withfail('hopelessly' );
        }catch(\Exception $e){       
            DB::rollback();
            return redirect()->back()->withfail("hopelessly , Transaction error " );
        }


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
    public function listes(){
        $providers= Provider::all();

        return view('gestion.listes' ,['providers' => $providers]);




    }

}
