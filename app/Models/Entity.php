<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    /**
     * To redifine default primarykey of entities table
     */
    protected $primaryKey = "id_entity";

    /**
     * 
     */
    public function users()
    {
        return $this->hasMany( User::class , 'entity_id');
    }
    public function providers(){


        return $this->belongstoMany( Provider::class  ,'entity-provider' , 'entity_id' , 'provider_id' );
    }
}
