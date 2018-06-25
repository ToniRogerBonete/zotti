<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Role;
use App\User;
use App\Usuario;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Gate::denies('dashboard-view')) {
            abort(403);
        }

        $user = new User();
        $user = $this->filtro($user,$request)
            ->paginate(13);
        return response()->json($user);
    }

    public function filtro($query,$request){
        if($request->filtro) {
            $query = $query->where('name', 'like', '%' . $request->filtro . '%');
        }
        return $query;
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
    public function store(UsuarioRequest $request)
    {
        if(Gate::denies('dashboard-view')) {
            abort(403);
        }

        $user = new User;
        $user->account_id = Auth::user()->account_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        //$this->papelStore($request, $usuario->id);
        return response()->json(['data'=>'Usuário cadastrado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('roles')->find($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioRequest $request, $id)
    {
        if(Gate::denies('dashboard-view')) {
            abort(403);
        }
        $user = User::find($id);
        $user->name = $request->name;
        if($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        $this->roleStore($request, $id);
        return response()->json(['data'=>'Alterado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        //
    }

    //Papel store
    public function roleStore(Request $request, $id)
    {
        if(Gate::denies('dashboard-view')) {
            abort(403);
        }
        $user = User::find($id);
        $role = Role::find($request->role);
        $user->removeRole();
        $user->addRole($role);
        return $request->role;
    }

}
