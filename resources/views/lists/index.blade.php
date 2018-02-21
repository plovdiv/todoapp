@extends('layouts.layout')

@section('content')
<div class="container">

    <div class="col-sm-offset-1 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                New List with tasks
            </div>

            <div class="panel-body">
                <form action="{{ url(route('lists.create')) }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="list-name" class="col-sm-3 control-label">List</label>

                        <div class="col-sm-6">
                            <input type="text" name="name" id="list-name" class="form-control" value="{{ old('list') }}">
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
                                <i class="fa fa-btn fa-plus"></i> Add List
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!--  Lists -->
        @if (count($lists) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Your lists
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">
                    <thead>
                    <th>List</th>
                    <th>Tasks</th>
                    <th>Completed Tasks</th>
                    <th>Uncomleted Tasks</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($lists as $list)
                        <tr>
                            <td class="table-text"><div>{{ $list->name }}</div></td>
                            <td class="table-text"><div>{{ $list->tasks->count() }}</div></td>
                            <td class="table-text"><div>{{ $list->tasks()->completed(true)->count() }}</div></td>
                            <td class="table-text"><div>{{ $list->tasks()->completed(false)->count() }}</div></td>

                            <!-- List Buttons -->
                            <td>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal-{{$list->id}}">
                                    <i class="fa fa-btn fa-trash"></i> Delete
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal-{{$list->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Deletion of list with name <b>{{$list->name}}</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <strong> Are you sure you want to delete this list ? </strong>
                                            </div>
                                            <form action="{{url(route('lists.delete', $list))}}" method="POST">
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
                                <a href="{{url(route('tasks', $list))}}"  class="btn btn-primary">
                                    <i class="fa fa-btn fa-info"></i> View and Create Tasks
                                </a>
                            </td>
                            <td>

                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#archiveModal-{{$list->id}}">
                                    <i class="fa fa-btn fa-archive"></i> Archive
                                </button>
                                <div class="modal fade" id="archiveModal-{{$list->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Archive  list with name <b>{{$list->name}}</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <strong> Are you sure you want to archive this list ? </strong>
                                                <p> If choose to archive this list, you will find all archived lists in "List archive" section </p>
                                            </div>
                                            <form action="{{url(route('lists.edit', $list))}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('PUT') }}
                                                <input type="hidden" name="archived" value="1">
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
        </div>
        <div class="text-center">
            {{$lists->links()}}
        </div>
        @endif
    </div>
</div>

@endsection