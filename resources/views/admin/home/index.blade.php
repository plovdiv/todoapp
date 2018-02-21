@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="col-sm-offset-1 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Filters
            </div>

            <div class="panel-body">
                <form action="" method="GET" class="form-horizontal">
                    <div class="row">

                        {{ csrf_field() }}
                        <div class="col-sm-offset-1 col-sm-4">
                            <div class="form-group ">
                                <label  class=" control-label">Search by owner`s email</label>
                                <input type="input" name="email" class="form-control" placeholder="john.doe@example.com" value="{{$email}}">

                            </div>
                        </div>
                        <div class="col-sm-offset-1 col-sm-4">
                            <div class="form-group">
                                <label  class="control-label">Show only lists awaiting for deletion</label>
                                <input type="checkbox" name="deleted" class="" {{ ($deleted) ? "checked='true'" : '' }} value="true" >
                            </div>
                        </div>

                    </div>

                    <button type="submit"  class="col-sm-offset-1 btn btn-default pull-right">
                        <i class="fa fa-btn fa-search"></i> Search
                    </button>
                    <a href="{{url(route('admin.home'))}}" class="  btn btn-default pull-right">
                        <i class="fa fa-btn fa-plus"></i> Clear filters
                    </a>
                </form>
            </div>
        </div>

        <!--  Lists -->
        @if (count($lists) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Users lists
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">
                    <thead>
                    <th>Owner name</th>
                    <th>Owner email</th>
                    <th>List</th>
                    <th>Tasks</th>
                    <th>Completed Tasks</th>
                    <th>Uncomleted Tasks</th>
                    <th>&nbsp;</th>
                    </thead>
                    <tbody>
                        @foreach ($lists as $list)
                        <tr>
                            <td class="table-text"><div>{{ $list->user->name }}</div></td>
                            <td class="table-text"><div>{{ $list->user->email }}</div></td>
                            <td class="table-text"><div>{{ $list->name }}</div></td>
                            <td class="table-text"><div>{{ $list->tasks()->withTrashed()->count() }}</div></td>
                            <td class="table-text"><div>{{ $list->tasks()->completed(true)->withTrashed()->count() }}</div></td>
                            <td class="table-text"><div>{{ $list->tasks()->completed(false)->withTrashed()->count() }}</div></td>

                            <td>
                                @if($list->trashed())
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
                                            <form action="{{url(route('admin.list.delete', $list))}}" method="POST">
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
                                @endif
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