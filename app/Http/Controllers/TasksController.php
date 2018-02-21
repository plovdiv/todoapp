<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\TaskList;

class TasksController extends Controller
{

    /**
     * Display a tasks of all of the tasklist user.
     *
     * @param  int  $taskListId
     * @return Response
     */
    public function index(Request $request, $taskListId)
    {
        $taskList = $request->user()
                ->taskLists()
                ->findOrFail($taskListId);

        // get completed tasks
        $tasksCompleted = Task::completed(true)
                ->where('task_list_id', $taskList->id)
                ->latest()
                ->paginate(5);

        // get uncompleted tasks
        $tasksNotCompleted = Task::completed(false)
                ->where('task_list_id', $taskList->id)
                ->latest()
                ->paginate(5);

        return view('tasks.index ', compact('taskList', 'tasksCompleted', 'tasksNotCompleted'));
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @param int $taskListId
     * @return Response
     */
    public function store(Request $request, $taskListId)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $taskList = $request->user()
                ->taskLists()
                ->findOrFail($taskListId);

        Task::create(['name' => $request->name, 'task_list_id' => $taskList->id]);

        flash('Your task  has been saved successfully!')->success();

        return redirect(route('tasks', $taskList->id));
    }

    /**
     * Complete  task
     * 
     * @param Request $request
     * @param Task $task
     * @return Response
     */
    public function complete(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        
        $task->setCompleted();

        flash("Your task <b>{$task->name}</b> has been marked completed successfully!")->success();

        return redirect(route('tasks', $task->task_list_id));
    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        flash('Your task  has been deleted successfully!')->success();

        return redirect(route('tasks', $task->task_list_id));
    }

}
