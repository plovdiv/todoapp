@extends('layouts.layout')

@section('content')
<div class="container">

    <div class="col-sm-offset-1 col-sm-12">

        <!--  Lists -->
        @if (!count($lists) > 0)
        <h3> No Archived lists</h3>
        @else
        <div class="panel panel-default">
            <div class="panel-heading">
                Your archived lists
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
                                <button type="button" class="btn btn-info" data-toggle="modal"  data-target="#archiveModal-{{$list->id}}">
                                    <i class="fa fa-btn fa-archive"></i> Unarchived
                                </button>
                                <div class="modal fade" id="archiveModal-{{$list->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Unarchived  list with name <b>{{$list->name}}</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <strong> Are you sure you want to unarchived this list ? </strong>
                                            </div>
                                            <form action="{{url(route('lists.edit', $list))}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('PUT') }}
                                                <input type="hidden" name="archived" value="0">
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