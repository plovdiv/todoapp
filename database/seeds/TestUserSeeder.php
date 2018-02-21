<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Task;
use App\TaskList;

class TestUserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // prepare lists
        $lists = [
            'Work',
            'Shopping',
            'Important Tasks',
            'Remainders',
            'Home tasks'
        ];
        // prepare users 
        $usersEmails = [
            'test@todo.com',
            'test2@todo.com'
        ];
        foreach ($usersEmails as $userEmail) {

            if (!$user = User::where('email', $userEmail)->first()) {
                /** @var User $user */
                $user = factory(User::class)->make([
                    'email' => $userEmail,
                ]);
            }

            $user->password = bcrypt('test');

            $user->save();

            if (!$user->hasRole(App\Role::ROLE_OWNER)) {
                $user->attachRole(\App\Role::where('name', App\Role::ROLE_OWNER)->first());
            }

            foreach ($lists as $list) {
                $list = factory(TaskList::class)->create([
                    'user_id' => $user->id,
                    'name' => $list
                ]);

                factory(Task::class, 5)->states('completed')->create([
                    'task_list_id' => $list->id,
                ]);

                factory(Task::class, 5)->states('uncompleted')->create([
                    'task_list_id' => $list->id,
                ]);
            }
        }
        echo PHP_EOL;
        dump("Test users credentials: test@todo.com / test and test2@todo.com / test");
        echo PHP_EOL;
    }

}
