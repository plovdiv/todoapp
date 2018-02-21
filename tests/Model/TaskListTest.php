<?php

namespace Tests\Model;

use App\TaskList;
use App\User;
use Tests\TestCase;

class TaskListTest extends TestCase
{

    /**
     * @test
     * @covers App\TaskList::scopeArchived()
     */
    public function scope_archived_returns_only_archived_task_lists()
    {

        factory(TaskList::class)->create(['archive' => 0]);
        factory(TaskList::class)->create(['archive' => 1]);

        $this->assertEquals(1, TaskList::archived(true)->count());
        $this->assertEquals(1, TaskList::archived(false)->count());
    }

    /**
     * @test
     * @covers \App\TaskList::user()
     */
    public function a_task_list_is_created_by_a_user()
    {

        $user = factory(User::class)->create();

        $taskList = factory(TaskList::class)->create([
            'user_id' => $user->id
        ]);

        // reload from the db to clear 'wasRecentlyCreated' property
        $this->assertEquals($user->fresh(), $taskList->user);
    }

}
