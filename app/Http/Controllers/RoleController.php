<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('dashboard-view')) {
            abort(403);
        }
        $roles = Role::all();
        return response()->json($roles);
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        if(Gate::denies('dashboard-view')) {
            abort(403);
        }
        $roles = new Role();
        $roles = $this->filtro($roles,$request)
            ->paginate(13);
        return response()->json($roles);
    }

    public function filtro($query,$request){
        if($request->filtro) {
            $query = $query->where('name', 'like', '%' . $request->filtro . '%');
        }
        return $query;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rule = Role::with('permissions')->find($id);
        return response()->json($rule);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Gate::denies('dashboard-view')) {
            abort(403);
        }
        $role = Role::find($id);
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();
        $this->permissionStore($request, $id);
        return response()->json(['data'=>'Alterado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }

    public function permissionStore(Request $request, $id)
    {
        if(Gate::denies('dashboard-view')) {
            abort(403);
        }
        $role = Role::find($id);
        $role->removePermissions('');
        foreach($request->permission as $key => $value) {
            $permission = Permission::find($value);
            $role->addPermission($permission);
        }
        return $request->permissao;
    }

}
