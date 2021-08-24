<?php

namespace App;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;

class SSHkey extends Model
{
    public function account()
    {
        return $this->hasOne( Account::class , 'sshkey_id');

    }}
