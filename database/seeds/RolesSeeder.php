<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [Role::ROLE_ADMIN, Role::ROLE_OWNER];

        foreach ($roles as $role) {
            if (!$user = Role::where('name', $role)->first()) {
                factory(Role::class)->states($role)->create();
            }
        }

        echo PHP_EOL;
        dump("Roles admin and owner created");
        echo PHP_EOL;
    }

}
