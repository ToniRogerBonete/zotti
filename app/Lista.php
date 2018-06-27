<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Lista extends Model
{
    protected $fillable = [
        'account_id',
        'descricao',
        'contato',
        'telefone',
        'observacao',
    ];

    protected $hidden = [
        'account_id',
    ];

    protected $guarded = ['id', 'created_at', 'update_at'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('active', function (Builder $builder){
            if(Auth::check()){
                $builder->where('listas.account_id', Auth::user()->account_id);
            }
        });
    }
}
