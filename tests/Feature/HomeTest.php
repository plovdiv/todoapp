<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Role;

class HomeTest extends TestCase
{

    /**
     * @test
     * @covers \App\Http\Controllers\ListsController::index()
     */
    public function unauthorized_user_redirected_to_login()
    {

        $this->get(route('lists'))
                ->assertRedirect(route('login'));

        $this->get(route('admin.home'))
                ->assertRedirect(route('login'));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\ListsController::index()
     */
    public function authorized_user_owner_can_access_home()
    {

        $this->signInOwner();

        $this->get(route('lists'))
                ->assertStatus(200);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\HomeController::index()
     */
    public function authorized_user_admin_can_access_home()
    {
        $this->signInAdmin();

        $this->get(route('admin.home'))
                ->assertStatus(200);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\ListsController::index()
     */
    public function authorized_user_admin_can_not_access_owner_home()
    {
        $this->signInAdmin();

        $this->get(route('lists'))
                ->assertStatus(403);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\HomeController::index()
     */
    public function authorized_user_owner_can_not_access_admin_home()
    {
        $this->signInOwner();

        $this->get(route('admin.home'))
                ->assertStatus(403);
    }

}
