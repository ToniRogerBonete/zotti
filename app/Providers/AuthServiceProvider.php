<?php

namespace App\Providers;

use App\Permission;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Funcionario' => 'App\Policies\FuncionarioPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        foreach ($this->listPermissions() as $permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                return $user->hasRoleThis($permission->roles) || $user->andAdministrator();
            });
        }
    }

    public function listPermissions()
    {
        return Permission::with('roles')->get();
    }
}