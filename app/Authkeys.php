<?php

namespace App;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;

class Authkeys extends Model
{
    public function account()
    {
        return $this->belongsTo( Account::class , 'account_id');

    }
}
