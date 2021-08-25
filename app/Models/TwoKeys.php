<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class TwoKeys extends Authkeys
{
    protected $table = 'authkeys';

    protected $fillable = [ 'first_key' , 'second_key' , 'account_id' ];
    protected $hidden   = [ 'third_key' , 'fourth_key' ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('twokeys', function (Builder $builder) {
            $builder->where('type', '2key');
        });

        static::creating(function ($article) { $article->type = '2key'; }); 
    }
}