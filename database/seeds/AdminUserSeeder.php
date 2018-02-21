<?php

use Illuminate\Database\Seeder;
use App\User;

class AdminUserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (!$user = User::where('email', 'admin@todo.com')->first()) {
            /** @var User $user */
            $user = factory(User::class)->make([
                'email' => 'admin@todo.com',
            ]);
        }

        $user->password = bcrypt('admin');
        $user->save();
        if (!$user->hasRole('admin')) {
            $user->attachRole(\App\Role::where('name', 'admin')->first());
        }

        echo PHP_EOL;
        dump("Admin user credentials: admin@todo.com / admin");
        echo PHP_EOL;
    }

}
