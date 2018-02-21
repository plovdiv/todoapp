<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\TaskList;

class TaskListPolicy
{

    use HandlesAuthorization;
    
    /**
     *  Determine if the given user can update the given task list.
     *
     * @param  User  $user
     * @param  TaskList  $taskList
     * @return bool
     */
    public function update(User $user, TaskList $taskList)
    {      
        return $user->id === $taskList->user_id;
    }
    
    /**
     *  Determine if the given user can delete the given task list.
     *
     * @param  User  $user
     * @param  TaskList  $taskList
     * @return bool
     */
    public function destroy(User $user, TaskList $taskList)
    {
        return $user->id === $taskList->user_id;
    }

}
