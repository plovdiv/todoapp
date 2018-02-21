@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="col-sm-offset-1 col-sm-12">
        <h3> {{$taskList->name}}</h3>
        <div class="panel panel-default">
            <div class="panel-heading">
                New Task
                <a class="btn btn-primary btn-sm pull-right" href="{{url(route('lists.export', $taskList))}}">Export tasks </a>
            </div>

            <div class="panel-body">

                <form action="{{ url(route('tasks.create', $taskList)) }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="task-name" class="col-sm-3 control-label">Task</label>

                        <div class="col-sm-6">
                            <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>


                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-btn fa-plus"></i> Add Task
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Uncompleted Tasks
            </div>
            @if (count($tasksNotCompleted) > 0)
            <div class="panel-body">
                <table class="table table-striped task-table">
                    <thead>
                    <th>Task</th>
                    <th>Created</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($tasksNotCompleted as $task)
                        <tr>
                            <td class="table-text"><div>{{ $task->name }}</div></td>
                            <td class="table-text"><div>{{ $task->created_at->format('l d.m.y') }}</div></td>

                            <td>
                                <button type="button" data-toggle="modal" data-target="#deleteModal-{{$task->id}}" class="btn btn-danger">
                                    <i class="fa fa-btn fa-trash"></i>Delete
                                </button>
                                <div class="modal fade" id="deleteModal-{{$task->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete  task with name <b>{{$task->name}}</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <strong> Are you sure you want to delete this task ? </strong>
                                            </div>
                                            <form action="{{url(route('tasks.delete', $task))}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger" >Yes</button>
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal" >No</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <form action="{{url(route('tasks.complete', $task))}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    <button type="submit"  class="btn btn-default">
                                        <i class="fa fa-btn fa-check"></i> Complete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-center">  No uncompleted task for <b> {{$taskList->name}} </b> list</p>
            @endif
        </div>
        <div class="text-center">
            {{$tasksNotCompleted->links()}}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Completed Tasks
            </div>
            @if (count($tasksCompleted) > 0)
            <div class="panel-body">
                <table class="table table-striped task-table">
                    <thead>
                    <th>Task</th>
                    <th>Created</th>
                    <th>Completed</th>
                    <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($tasksCompleted as $task)
                        <tr>
                            <td class="table-text"><div>{{ $task->name }}</div></td>
                            <td class="table-text"><div>{{ $task->created_at->format('l d.m.y') }}</div></td>
                            <td class="table-text"><div>{{ $task->completed_at->format('l d.m.y') }}</div></td>
                            <td>
                                <button type="button" data-toggle="modal" data-target="#deleteModal-{{$task->id}}" class="btn btn-danger">
                                    <i class="fa fa-btn fa-trash"></i>Delete
                                </button>
                                <div class="modal fade" id="deleteModal-{{$task->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete  task with name <b>{{$task->name}}</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <strong> Are you sure you want to delete this task ? </strong>
                                            </div>
                                            <form action="{{url(route('tasks.delete', $task))}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger" >Yes</button>
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal" >No</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-center">  No completed task for <b> {{$taskList->name}} </b> list</p>
            @endif
        </div>
        <div class="text-center">
            {{$tasksCompleted->links()}} 
        </div>
    </div>
</div>
@endsection