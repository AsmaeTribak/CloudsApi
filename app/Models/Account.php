<?php

namespace App\Models;

use App\Models\Provider;
use App\SSHkey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    // use SoftDeletes;
    protected $primaryKey = "id_account";

    public function provider()
    {
        return $this->belongsTo( Provider::class , 'provider_id');

    }
    public function sshkey()
    {
        return $this->belongsTo( SSHkey::class , 'sshkey_id');

    }
    public function authkey()
    {
        return $this->hasOne( Authkeys::class );

    }

    public function getAuth(){

        switch( $this->provider->type ) {
                
            case '1key':
                $keys = OneKey::where('account_id', $this->id_account )->first();
                break;

            case '2key': 
                $keys = TwoKeys::where('account_id', $this->id_account )->first();
                break;

            case '4key': 
                $keys = FourKeys::where('account_id', $this->id_account )->first();
                break;

            default : $keys = null ;
        }

        return $keys;
        
    }
}
