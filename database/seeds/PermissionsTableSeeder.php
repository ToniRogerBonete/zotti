<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Permission::firstOrCreate([
            'name' =>'dashboard-view',
            'description' =>'Acesso ao dashboard'
        ]);

        //usuário
        Permission::firstOrCreate([
            'name' =>'usuario-view',
            'description' =>'Acesso a lista de Usuários'
        ]);
        Permission::firstOrCreate([
            'name' =>'usuario-create',
            'description' =>'Adicionar Usuários'
        ]);
        Permission::firstOrCreate([
            'name' =>'usuario-edit',
            'description' =>'Editar Usuários'
        ]);
        Permission::firstOrCreate([
            'name' =>'usuario-delete',
            'description' =>'Deletar Usuários'
        ]);

        //papel
        Permission::firstOrCreate([
            'name' =>'papel-view',
            'description' =>'Acesso a lista de pepéis'
        ]);
        Permission::firstOrCreate([
            'name' =>'papel-create',
            'description' =>'Adicionar Papel'
        ]);
        Permission::firstOrCreate([
            'name' =>'papel-edit',
            'description' =>'Editar Papel'
        ]);
        Permission::firstOrCreate([
            'name' =>'papel-delete',
            'description' =>'Deletar Papel'
        ]);

    }
}
