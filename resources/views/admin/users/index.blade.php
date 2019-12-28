@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Users</h1>
    <form method="get" action="/admin/users" id="searchForm">
        <div class="row">
            <div class="col-sm-6 mb-2">
                <input type="text" class="form-control" name="name" id="name"
                       value="{{ request()->name}}" placeholder="Filter Name or email">
            </div>
            <div class="col-sm-4 mb-2">
                <select class="form-control" name="sort" id="sort">
                    @foreach($orderlist as $i => $sort )
                        <option value="{{$i}}">{{$sort['name']}}</option>
                        @endforeach
                </select>
            </div>
        </div>
    </form>
    <hr>
    @if ($users->count() == 0)
        <div class="alert alert-danger alert-dismissible fade show">
            Can't find any users or emails with <b>'{{ request()->name }}'</b>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif
    @include('shared.alert')
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>user</th>
                <th>Email</th>
                <th>Active</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td> @if ($user->active === 1)
                            <i class="fas fa-check"></i>
                    @endif</td>
                    <td>@if ($user->admin === 1)
                            <i class="fas fa-check"></i>
                    @endif</td>
                    <td>
                        <form action="/admin/users/{{ $user->id }}" method="post" class="deleteForm">
                            @method('delete')
                            @csrf
                            <div class="btn-group btn-group-sm">
                                <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-outline-success"
                                   data-toggle="tooltip"
                                   title="Edit {{ $user->name }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger"
                                        data-toggle="tooltip"
                                        data-name = "{{$user->name}}"
                                        title="Delete {{ $user->name }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
@endsection
@section('script_after')
    <script>
        $(function () {
            $('.deleteForm button').click(function () {
                let name = $(this).data('name');
                let msg = `Delete the user '${name}'?`;
                if(confirm(msg)) {
                    $(this).closest('form').submit();
                }
            })
        });
    </script>
@endsection