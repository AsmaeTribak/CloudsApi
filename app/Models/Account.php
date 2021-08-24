<?php

namespace App\Models;

use App\Authkeys;
use App\Models\Provider;
use App\SSHkey;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function provider()
    {
        return $this->belongsTo( Provider::class , 'provider_id');

    }
    public function sshkey()
    {
        return $this->hasOne( SSHkey::class , 'sshkey_id');

    }
    public function authkey()
    {
        return $this->hasOne( Authkeys::class , 'account_id');

    }
}
