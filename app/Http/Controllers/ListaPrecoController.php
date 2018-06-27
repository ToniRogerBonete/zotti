<?php

namespace App\Http\Controllers;

use App\ListaPreco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Auth;

class ListaPrecoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('lista-preco-view')) {
            abort(403);
        }

        $fornecedor = ListaPreco::all();
        return response()->json($fornecedor);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ListaPreco  $listaPreco
     * @return \Illuminate\Http\Response
     */
    public function show(ListaPreco $listaPreco)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ListaPreco  $listaPreco
     * @return \Illuminate\Http\Response
     */
    public function edit(ListaPreco $listaPreco)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ListaPreco  $listaPreco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListaPreco $listaPreco)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ListaPreco  $listaPreco
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('lista-preco-view')) {
            abort(403);
        }

        $lista = ListaPreco::find($id)
            ->delete();
        return response()->json('Lista excluída com sucesso!');
    }
}
