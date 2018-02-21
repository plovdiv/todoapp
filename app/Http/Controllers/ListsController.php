<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskList;
use App\Services\TaskListsService;

class ListsController extends Controller
{

    /**
     * The task list service.
     *
     * @var TaskListsService
     */
    protected $taskListsService;

    public function __construct(TaskListsService $taskListsService)
    {
        $this->taskListsService = $taskListsService;
        parent::__construct();
    }

    /**
     * Display a list of all of the user's lists.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $lists = $request->user()
                ->taskLists()
                ->archived(false)
                ->latest()
                ->paginate(5);

        return view('lists.index', compact('lists'));
    }

    /**
     * Create a new task list.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        $request->user()->taskLists()->create([
            'name' => $request->name,
        ]);
        flash('Your task list has been saved successfully!')->success();
        return redirect(route('lists'));
    }

    /**
     * Archive task list
     * 
     * @param Request $request
     * @param TaskList $list
     * @return Response
     */
    public function edit(Request $request, TaskList $list)
    {
        $this->authorize('update', $list);
        
        $archive = (int) $request->input('archived');
        // check only when archived e.g. $archive = true
        if (!$list->canArchive() && $archive) {

            flash('Your task list is empty to archive list need to have min 1 task!')->error();

            return redirect(route('lists'));
        }

        $list->setArchived($archive);

        if (!$list->isArchive()) {

            flash('Your task list has been unarchived successfully!')->success();

            return redirect(route('lists.archived'));
        }
        flash('Your task list has been archived successfully!')->success();

        return redirect(route('lists'));
    }

    /**
     * Archive task list
     * 
     * @param Request $request
     * @param TaskList $list
     * @return Response
     */
    public function archived(Request $request)
    {
        $lists = $request->user()
                ->taskLists()
                ->archived(true)
                ->latest()
                ->paginate(5);

        return view('lists.archived', compact('lists'));
    }

    /**
     * Export tasks
     * 
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function export(Request $request, $id)
    {
        $this->taskListsService
                ->export(
                        $request->user()
                        ->taskLists()
                        ->findOrFail($id)
                )
                ->download();
    }

    /**
     * Destroy the given task list.
     *
     * @param  Request  $request
     * @param  TaskList  $list
     * @return Response
     */
    public function destroy(Request $request, TaskList $list)
    {
        $this->authorize('destroy', $list);

        $list->delete();

        flash('Your task list  has been deleted successfully!')->success();

        return redirect(route('lists'));
    }

}
