<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListaRequest;
use App\Lista;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;

class ListaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('lista-view')) {
            abort(403);
        }

        $lista = Lista::all();
        return response()->json($lista);
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
    public function store(ListaRequest $request)
    {
        if(Gate::denies('lista-create')) {
            abort(403);
        }

        $lista = new Lista();
        $lista->account_id = Auth::user()->account_id;
        $lista->descricao = $request->descricao;
        $lista->contato = $request->contato;
        $lista->telefone = $request->telefone;
        $lista->observacao = $request->observacao;
        $lista->save();
        return response()->json('Produto cadastrado com sucesso!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if(Gate::denies('lista-view')) {
            abort(403);
        }

        $lista = new Lista();
        $lista = $this->filtro($lista, $request)
            ->paginate(13);
        return response()->json($lista);
    }

    public function filtro($query, $request){
        if($request->filtro) {
            $query = $query->where('descricao', 'like', '%' . $request->filtro . '%');
        }
        return $query;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('lista-edit')) {
            abort(403);
        }

        $lista = Lista::find($id);
        return response()->json($lista);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function update(ListaRequest $request, $id)
    {
        if(Gate::denies('lista-edit')) {
            abort(403);
        }

        $lista = Lista::find($id);
        $lista->account_id = Auth::user()->account_id;
        $lista->descricao = $request->descricao;
        $lista->contato = $request->contato;
        $lista->telefone = $request->telefone;
        $lista->observacao = $request->observacao;
        $lista->save();
        return response()->json('Lista adicionado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('lista-delete')) {
            abort(403);
        }

        $lista = Lista::find($this)
            ->delete();
        return response()->json('Lista excluído com sucesso!');
    }
}
