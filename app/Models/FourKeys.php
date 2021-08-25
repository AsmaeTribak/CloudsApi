<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class FourKeys extends Authkeys
{
    protected $table = 'authkeys';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('fourkeys', function (Builder $builder) {
            $builder->where('type', '4key');
        });

        static::creating(function ($article) { $article->type = '4key'; }); 
    }
}