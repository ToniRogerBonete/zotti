<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\ListaPreco;
use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Auth;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdutoRequest $request)
    {
        if(Gate::denies('produto-create')) {
            abort(403);
        }

        $produto = new Produto();
        $produto->account_id = Auth::user()->account_id;
        $produto->nome = $request->nome;
        $produto->codigo = $request->codigo;
        $produto->codigo_original = $request->codigo_original;
        $produto->unidade_estoque = $request->unidade_estoque;
        $produto->prateleira = $request->prateleira;
        $produto->gaveta = $request->gaveta;
        $produto->natureza_operacao = $request->natureza_operacao;
        $produto->ncm = $request->ncm;
        $produto->origem = $request->origem;
        $produto->cest = $request->cest;
        $produto->observacao = $request->observacao;
        $produto->save();
        $this->listas($request,$produto);
        return response()->json('Produto cadastrado com sucesso!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if(Gate::denies('produto-view')) {
            abort(403);
        }

        $produto = new Produto();

        if($request->tipo!=1) {
            $produto = $this->filtroPorTipo($produto, $request);
        } else {
            $produto = $this->filtroPorTipoTodos($produto, $request);
        }

        $produto = $produto->paginate(13);
        return response()->json($produto);
    }

    public function filtroPorTipo($query, $request) {
        if($request->tipo==2) {
            $query = $query->with('lista_precos','lista_precos.lista');
            $query = $query->where('codigo', '=', $request->filtro);
        }
        if($request->tipo==3) {
            $query = $query->with('lista_precos','lista_precos.lista');
            $query = $query->where('nome', 'like', '%' . $request->filtro . '%');
        }
        if($request->tipo==4) {
            $query = $query->whereHas('lista_precos', function ($q) use ($request) {
                $q->where('codigo_material', $request->filtro);
            })
                ->with('lista_precos.lista');
        }
        if($request->tipo==5) {
            $query = $query->with('lista_precos','lista_precos.lista');
            $query = $query->where('codigo_original', '=', $request->filtro);
        }
        return $query;
    }

    public function filtroPorTipoTodos($query, $request) {
        $query = $query->whereHas('lista_precos', function($q) use ($request) {
            $q->where('codigo_material', $request->filtro);
        })
        ->with('lista_precos.lista');
        $query = $query->orWhere('codigo', 'like', '%' . $request->filtro . '%');
        $query = $query->orWhere('nome', 'like', '%' . $request->filtro . '%');
        $query = $query->orWhere('codigo_original', 'like', '%' . $request->filtro . '%');
        return $query;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('produto-edit')) {
            abort(403);
        }

        $produto = Produto::with('lista_precos')
            ->find($id);
        return response()->json($produto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(ProdutoRequest $request, $id)
    {

        if(Gate::denies('produto-edit')) {
            abort(403);
        }

        $produto = Produto::find($id);
        $produto->account_id = Auth::user()->account_id;
        $produto->nome = $request->nome;
        $produto->codigo = $request->codigo;
        $produto->codigo_original = $request->codigo_original;
        $produto->unidade_estoque = $request->unidade_estoque;
        $produto->prateleira = $request->prateleira;
        $produto->gaveta = $request->gaveta;
        $produto->natureza_operacao = $request->natureza_operacao;
        $produto->ncm = $request->ncm;
        $produto->origem = $request->origem;
        $produto->cest = $request->cest;
        $produto->observacao = $request->observacao;
        $produto->save();
        $this->listas($request,$produto);
        return response()->json('Produto adicionado com sucesso!');
    }

    public function listas($request, $produto) {
            foreach ($request->precos as $key => $value) {
                ListaPreco::updateOrCreate(
                    [
                        'id' => $value['id']
                    ],
                    [
                        'account_id' => Auth::user()->account_id,
                        'produto_id' => $produto->id,
                        'lista_id' => $value['lista_id'],
                        'indice_venda' => $value['indice_venda'],
                        'preco' => $value['preco'],
                        'tipo' => $value['tipo'],
                        'indice_compra' => $value['indice_compra'],
                        'codigo_material' => $value['codigo_material']
                    ]
                )->save();
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('produto-delete')) {
            abort(403);
        }

        $produto = Produto::find($id)
            ->delete();
        return response()->json('Produto excluído com sucesso!');
    }
}
