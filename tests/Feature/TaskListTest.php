<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\TaskList;
use App\Task;

class TaskListTest extends TestCase
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
     * @covers \App\Http\Controllers\ListsController::store()
     */
    public function authorized_user_owner_can_store_lists()
    {
        $this->signInOwner($this->user);

        $this->postJson(route('lists.create'), ['name' => 'Work'])
                ->assertRedirect(route('lists'));
        
        $list = $this->user->taskLists->last();
        
        $this->assertDatabaseHas($list->getTable(), [
            'id' => $list->id,
            'user_id' => $this->user->id,
            'name' => 'Work',
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\TasksController::edit()
     */
    public function task_list_archived_status()
    {
        $this->signInOwner($this->user);


        $taskList = factory(TaskList::class)->create([
            'archive' => 0,
            'user_id' => $this->user->id
        ]);

        $task = factory(Task::class)->create([
            'task_list_id' => $taskList->id,
        ]);

        $this->putJson(route('lists.edit', $taskList), ['archived' => 1])
                ->assertRedirect(route('lists'));

        $this->assertDatabaseHas($taskList->getTable(), [
            'id' => $taskList->id,
            'archive' => 1,
            'user_id' => $this->user->id
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\TasksController::edit()
     */
    public function task_list_archived_status_only_when_have_1_tasks()
    {
        $this->signInOwner($this->user);


        $taskList = factory(TaskList::class)->create([
            'archive' => 0,
            'user_id' => $this->user->id
        ]);


        $this->putJson(route('lists.edit', $taskList), ['archived' => 1])
                ->assertRedirect(route('lists'));

        $this->assertDatabaseHas($taskList->getTable(), [
            'id' => $taskList->id,
            'archive' => 0,
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\TasksController::edit()
     */
    public function task_list_unarchived_status()
    {
        $this->signInOwner($this->user);


        $taskList = factory(TaskList::class)->create([
            'archive' => 1,
            'user_id' => $this->user->id
        ]);


        $this->putJson(route('lists.edit', $taskList), ['archived' => 0])
                ->assertRedirect(route('lists.archived'));

        $this->assertDatabaseHas($taskList->getTable(), [
            'id' => $taskList->id,
            'archive' => 0,
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\TasksController::destroy()
     */
    public function authorized_user_owner_can_not_destroy_another_user_task_list_destroy()
    {
        $this->signInOwner($this->user);

        $anotherUser = factory(User::class)->create();

        $list = factory(TaskList::class)->create([
            'user_id' => $anotherUser->id
        ]);


        $this->deleteJson(route('lists.delete', $list))
                ->assertStatus(403);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\TasksController::archive()
     */
    public function authorized_user_owner_can_not_archived_another_user_task_list_archive()
    {
        $this->signInOwner($this->user);

        $anotherUser = factory(User::class)->create();

        $list = factory(TaskList::class)->create([
            'user_id' => $anotherUser->id
        ]);


        $this->putJson(route('lists.edit', $list), ['archived' => 1])
                ->assertStatus(403);
    }

}
