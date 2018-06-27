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

        //produtos
        Permission::firstOrCreate([
            'name' =>'produto-view',
            'description' =>'Acesso a lista de produto'
        ]);
        Permission::firstOrCreate([
            'name' =>'produto-create',
            'description' =>'Adicionar produto'
        ]);
        Permission::firstOrCreate([
            'name' =>'produto-edit',
            'description' =>'Editar produto'
        ]);
        Permission::firstOrCreate([
            'name' =>'produto-delete',
            'description' =>'Deletar produto'
        ]);

        //listas
        Permission::firstOrCreate([
            'name' =>'lista-view',
            'description' =>'Acesso a lista de lista'
        ]);
        Permission::firstOrCreate([
            'name' =>'lista-create',
            'description' =>'Adicionar lista'
        ]);
        Permission::firstOrCreate([
            'name' =>'lista-edit',
            'description' =>'Editar lista'
        ]);
        Permission::firstOrCreate([
            'name' =>'lista-delete',
            'description' =>'Deletar lista'
        ]);

        //lista preços
        Permission::firstOrCreate([
            'name' =>'lista-preco-view',
            'description' =>'Acesso a lista de lista de preço'
        ]);
        Permission::firstOrCreate([
            'name' =>'lista-preco-create',
            'description' =>'Adicionar lista de preço'
        ]);
        Permission::firstOrCreate([
            'name' =>'lista-preco-edit',
            'description' =>'Editar lista de preço'
        ]);
        Permission::firstOrCreate([
            'name' =>'lista-preco-delete',
            'description' =>'Deletar lista de preço'
        ]);

    }
}
