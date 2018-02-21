<?php

namespace App\Http\Controllers\Admin;

use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\Controller;
use App\TaskList;

class HomeController extends Controller
{

    /**
     * 
     * @param Request $request
     * @return Request
     */
    public function index(Request $request)
    {
        
        $taskList = (new TaskList())->newQuery();
        
        if ($email = $request->get('email')) {
            
            $taskList->whereHas('user', function ($query) use ($email) {
                $query->where('users.email', 'LIKE', "%{$email}%");
            });
        }

        if ($deleted = $request->get('deleted')) {
            $taskList->onlyTrashed();
        } else {
            $taskList->withTrashed();
        }

        $lists = $taskList->latest()->paginate(5);

        return view('admin.home.index', compact('lists', 'email', 'deleted'));
    }

    /**
     * Destroy the given task list.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $list = TaskList::withTrashed()->find($id);
        
        $list->forceDelete();
        
        flash('List has been deleted successfully!')->success();
        
        return redirect(route('admin.home'));
    }

}
