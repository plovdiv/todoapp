<?php

namespace Tests\Model;

use App\TaskList;
use App\User;
use App\Role;
use Tests\TestCase;

class UserTest extends TestCase
{

    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     * @covers User::taskLists()
     */
    public function a_user_has_task_lists()
    {

        factory(TaskList::class, 2)->create(['user_id' => $this->user->id]);

        $this->assertEquals(2, $this->user->taskLists()->count());
    }

    /**
     * @test
     * @covers User::roles()
     */
    public function a_user_has_roles_and_have_proper_role()
    {

        $admin = factory(Role::class)->states('admin')->create();
        $owner = factory(Role::class)->states('owner')->create();

        $userAdmin = $this->user;
        $userAdmin->attachRole($admin);

        $userOwner = factory(User::class)->create();
        $userOwner->attachRole($owner);

        $this->assertEquals(1, $userAdmin->roles->count());

        $this->assertEquals(1, $userOwner->roles->count());

        $this->assertTrue($userAdmin->hasRole($admin->name));

        $this->assertTrue($userOwner->hasRole($owner->name));
    }

}
