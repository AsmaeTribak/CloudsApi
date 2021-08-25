<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class FourKeys extends Authkeys
{
    protected $table = 'authkeys';


    protected $fillable = [ 'first_key' , 'second_key' ,'third_key' , 'fourth_key' , 'account_id' ];



    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('fourkeys', function (Builder $builder) {
            $builder->where('type', '4key');
        });

        static::creating(function ($article) { $article->type = '4key'; }); 
    }
}