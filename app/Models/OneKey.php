<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class OneKey extends Authkeys
{
    protected $table = 'authkeys';

    protected $fillable = [ 'first_key' , 'account_id' ];
    protected $hidden   = [ 'second_key' , 'third_key', 'fourth_key' ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('oneKey', function (Builder $builder) {
            $builder->where('type', '1key');
        });

        static::creating(function ($article) { $article->type = '1key'; }); 
    }
}