<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Role;
use App\User;
use App\TaskList;
use App\Task;

class TaskTest extends TestCase
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
     * @covers \App\Http\Controllers\TasksController::index()
     */
    public function unauthorized_user_can_access_tasks_index()
    {
        $list = factory(\App\TaskList::class)->create();

        $this->get(route('tasks', $list))
                ->assertRedirect(route('login'));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\TasksController::index()
     */
    public function authorized_user_owner_can_access_tasks_index()
    {
        $this->signInOwner($this->user);

        $list = factory(TaskList::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->get(route('tasks', $list))
                ->assertStatus(200);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\TasksController::index()
     */
    public function authorized_user_owner_can_not_access_another_user_tasks_index()
    {
        $this->signInOwner($this->user);

        $anotherUser = factory(User::class)->create();

        $list = factory(TaskList::class)->create([
            'user_id' => $anotherUser->id
        ]);

        $this->get(route('tasks', $list))
                ->assertStatus(404);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\TasksController::store()
     */
    public function authorized_user_owner_can_store_tasks()
    {
        $this->signInOwner($this->user);

        $list = factory(TaskList::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->postJson(route('tasks.create', $list->id), ['name' => 'Work'])
                ->assertRedirect(route('tasks', $list));
        
        $task = $list->tasks->last();
        
        $this->assertDatabaseHas($task->getTable(), [
            'id' => $task->id,
            'task_list_id' => $list->id,
            'name' => 'Work',
        ]);
    }
    
        /**
     * @test
     * @covers \App\Http\Controllers\TasksController::store()
     */
    public function authorized_user_owner_can_not_store_another_user_tasks()
    {
        $this->signInOwner($this->user);
        
        $anotherUser = factory(User::class)->create();
        
        $list = factory(TaskList::class)->create([
            'user_id' => $anotherUser->id
        ]);

        $this->postJson(route('tasks.create', $list->id), ['name' => 'Work'])
                ->assertStatus(404);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\TasksController::complete()
     */
    public function task_completed_status()
    {
        $this->signInOwner($this->user);

        $list = factory(TaskList::class)->create([
            'user_id' => $this->user->id
        ]);

        $task = factory(Task::class)->create([
            'task_list_id' => $list->id
        ]);

        $this->putJson(route('tasks.complete', $task))
                ->assertRedirect(route('tasks', $list));

        $this->assertDatabaseHas($task->getTable(), [
            'id' => $task->id,
            'done' => 1,
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\TasksController::complete()
     */
    public function authorized_user_owner_can_not_complete_another_user_task_complete()
    {
        $this->signInOwner($this->user);

        $anotherUser = factory(User::class)->create();

        $list = factory(TaskList::class)->create([
            'user_id' => $anotherUser->id
        ]);

        $task = factory(Task::class)->create([
            'task_list_id' => $list->id
        ]);

        $this->deleteJson(route('tasks.complete', $task))
                ->assertStatus(403);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\TasksController::destroy()
     */
    public function authorized_user_owner_can_not_destroy_another_user_task_destroy()
    {
        $this->signInOwner($this->user);

        $anotherUser = factory(User::class)->create();

        $list = factory(TaskList::class)->create([
            'user_id' => $anotherUser->id
        ]);

        $task = factory(Task::class)->create([
            'task_list_id' => $list->id
        ]);

        $this->deleteJson(route('tasks.delete', $task))
                ->assertStatus(403);
    }

}
