<?php

namespace Tests;

use App\User;
use App\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    use CreatesApplication;
    use DatabaseMigrations;

    /**
     * SignIn a user with role owner
     *
     * @param User|null $user
     * @param Role|null $role
     *
     * @return $this
     */
    protected function signInOwner(User $user = null, Role $role = null)
    {
        $user = $user ?: factory(User::class)->create();
        $role = $role ?: factory(Role::class)->states('owner')->create();
        $user->attachRole($role);

        $this->actingAs($user);

        return $this;
    }

    /**
     * SignIn a user with role admin
     *
     * @param User|null $user
     * @param Role|null $role
     *
     * @return $this
     */
    protected function signInAdmin(User $user = null, Role $role = null)
    {
        $user = $user ?: factory(User::class)->create();
        $role = $role ?: factory(Role::class)->states('admin')->create();
        $user->attachRole($role);

        $this->actingAs($user);

        return $this;
    }

}
