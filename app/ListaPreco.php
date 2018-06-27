<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Auth;

class ListaPreco extends Model
{
    protected $fillable = [
        'account_id',
        'produto_id',
        'lista_id',
        'indice_venda',
        'preco',
        'tipo',
        'indice_compra',
        'codigo_material'
    ];

    protected $hidden = [
        'account_id',
    ];

    protected $guarded = ['id', 'created_at', 'update_at'];

    public function lista()
    {
        return $this->BelongsTo('App\Lista'); //Relacionamento (um pra um)
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('active', function (Builder $builder){
            if(Auth::check()){
                $builder->where('lista_precos.account_id', Auth::user()->account_id);
            }
        });
    }
}
