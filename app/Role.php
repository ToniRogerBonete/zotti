<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function permissionsDefault()
    {
        return $this->belongsToMany(Permission::class)->select('name');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function addPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name','=',$permission)->firstOrFail();
        }
        if($this->existPermission($permission)){
            return;
        }
        return $this->permissions()->attach($permission);
    }

    public function existPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name','=',$permission)->firstOrFail();
        }
        return (boolean) $this->permissions()->find($permission->id);
    }

    public function removePermissions($permission)
    {
        $papel = Permission::where('name','!=',$permission)->firstOrFail();
        return $this->permissions()->detach();
    }

    public function removePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name','=',$permission)->firstOrFail();
        }
        return $this->permissions()->detach($permission);
    }

}
