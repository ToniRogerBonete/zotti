<?php

use App\Role_user;
use Illuminate\Database\Seeder;

class RoleUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role_user::firstOrCreate([
            'role_id' => 1,
            'user_id' => 1
        ]);
    }
}
