<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Task;

class TaskPolicy
{

    use HandlesAuthorization;

    /**
     *  Determine if the given user can update the given task.
     *
     * @param  User  $user
     * @param  Task  $task
     * @return bool
     */
    public function update(User $user, Task $task)
    {
        return $user->id === $task->taskList->user_id;
    }

    /**
     *  Determine if the given user can delete the given task.
     *
     * @param  User  $user
     * @param  Task  $task
     * @return bool
     */
    public function destroy(User $user, Task $task)
    {

        return $user->id === $task->taskList->user_id;
    }

}
