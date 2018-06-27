<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Produto extends Model
{
    protected $fillable = [
        'account_id',
        'nome',
        'codigo',
        'codigo_original',
        'unidade_estoque',
        'prateleira',
        'gaveta',
        'natureza_operacao',
        'ncm',
        'origem',
        'cest',
        'observacao',
    ];


    protected $hidden = [
        'account_id',
    ];

    protected $guarded = ['id', 'created_at', 'update_at'];

    public function lista_precos()
    {
        return $this->hasMany('App\ListaPreco')
            ->orderBy('id','ASC');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('active', function (Builder $builder){
            if(Auth::check()){
                $builder->where('produtos.account_id', Auth::user()->account_id);
            }
        });
    }

}
