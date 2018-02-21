<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Instead of seeding table by table and ending with not well related data
         * we use a custom functionality to make well structured and related data
         */
        $this->call(RolesSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(TestUserSeeder::class);
    }

}
