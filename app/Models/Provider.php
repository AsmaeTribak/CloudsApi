<?php

namespace App\Models;
use App\Models\Entity;


use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{        
    protected $primaryKey = "id_provider";

    public function entities(){


        return $this->belongstoMany( Entity::class , 'entity-provider' , 'provider_id' , 'entity_id');
    }
    public function accounts()
    {
        return $this->hasMany(Account::class , 'provider_id');
    }
}
