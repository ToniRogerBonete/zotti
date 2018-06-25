<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'name',
        'email',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function account()
    {
        return $this->BelongsTo(Account::class); //Relacionamento de um usuario pra uma empresa (um pra um)
    }

    public function andAdministrator()
    {
        //return $this->id == 1;
        return $this->existRole('Admin');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class); //Relacionamento de vários usuários para papéis (varios para vários)
    }

    public function addRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', '=', $role)->firstOrFail();
        }
        if($this->existRole($role)){
            return;
        }
        return $this->roles()->attach($role);
    }

    public function existRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name','=',$role)->firstOrFail();
        }
        return (boolean) $this->roles()->find($role->id);
    }

    public function removeRole()
    {
        return $this->roles()->detach();
    }

    public function removeRoles($role)
    {
        $papel = Role::where('name','!=',$papel)->firstOrFail();
        return $this->roles()->detach();
    }

    public function hasRoleThis($roles)
    {
        $userRoles = $this->roles;
        return $roles->intersect($userRoles)->count();
    }

}
