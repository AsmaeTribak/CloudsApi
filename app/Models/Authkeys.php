<?php

namespace App\Models;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;

class Authkeys extends Model
{

    public $timestamps = false;

    public function account()
    {
        return $this->belongsTo( Account::class , 'account_id');
    }
}
