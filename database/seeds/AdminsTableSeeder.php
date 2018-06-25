<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = Permission::all();
        $role = Role::find('1');
        $role->removePermissions('');
        foreach($permission as $key => $value) {
            echo $value->name;
            $perm = Permission::find($value->id);
            $role->addPermission($perm);
        }
        echo "\n";
    }
}
