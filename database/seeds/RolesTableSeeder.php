<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate([
            'name' =>'Admin',
            'description' =>'Acesso total ao sistema'
        ]);

        Role::firstOrCreate([
            'name' =>'Usuario',
            'description' =>'Acesso ao site como usuário'
        ]);

        Role::firstOrCreate([
            'name' =>'Admin Empresa',
            'description' =>'Acesso ao modulolos da empresa'
        ]);
    }
}
