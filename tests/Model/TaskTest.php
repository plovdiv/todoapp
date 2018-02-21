<?php

namespace Tests\Model;

use App\Task;
use App\TaskList;
use Tests\TestCase;

class TaskTest extends TestCase
{

    /**
     * @test
     * @covers App\Task::scopeCompleted()
     */
    public function scope_completed_returns_only_completed_tasks()
    {

        factory(Task::class)->create(['done' => 0]);
        factory(Task::class)->create(['done' => 1]);

        $this->assertEquals(1, Task::completed()->count());
    }
    
    /**
     * @test
     * @covers \App\Task::taskList()
     */
    public function a_task_belongs_to_a_task_list()
    {

        $taskList = factory(TaskList::class)->create();

        $task = factory(Task::class)->create([
            'task_list_id' => $taskList->id
        ]);

        // reload from the db to clear 'wasRecentlyCreated' property
        $this->assertEquals($taskList->fresh(), $task->taskList);
    }
}
