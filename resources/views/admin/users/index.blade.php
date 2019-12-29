@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Users</h1>
    <form method="get" action="/admin/users" id="searchForm">
        <div class="row">
            <div class="col-sm-8 mb-2">
                <label for="name">Filter Name or email</label>
                <input type="text" class="form-control" name="name" id="name"
                       value="{{ request()->name}}" placeholder="Filter Name or email">
            </div>
            <div class="col-sm-4 mb-2">
                <label for="sort">Sort by</label>
                <select class="form-control" name="sort" id="sort">
                    @foreach($orderlist as $i => $sort )
                        <option value="{{$i}}"
                                {{ (request()->sort == $i ? 'selected' : '') }}>{{$sort['name']}}</option>
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
                            @if (Auth::user()->id === $user->id )
                                <div class="btn-group btn-group-sm">
                                    <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-outline-success disabled" id="edit"
                                       data-toggle="tooltip"
                                       title="Edit {{ $user->name }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger disabled" id="delete"
                                            data-toggle="tooltip"
                                            data-name = "{{$user->name}}"
                                            data-id = "{{$user->id}}"
                                            data-auth = "{{Auth::user()->id}}"
                                            title="Delete {{ $user->name }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                @else
                                <div class="btn-group btn-group-sm">
                                    <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-outline-success" id="edit"
                                       data-toggle="tooltip"
                                       title="Edit {{ $user->name }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger " id="delete"
                                            data-toggle="tooltip"
                                            data-name = "{{$user->name}}"
                                            data-id = "{{$user->id}}"
                                            data-auth = "{{Auth::user()->id}}"
                                            title="Delete {{ $user->name }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            @endif
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
            $('tbody').on('click', '.btn-outline-danger', function () {
                // Get data attributes from td tag
                let id = $(this).data('id');
                let name = $(this).data('name');
                // Set some values for Noty
                let text = `<p>Delete the user <b>${name}</b>?</p>`;
                let type = 'warning';
                let btnText = 'Delete User';
                let btnClass = 'btn-success';

                // Show Noty
                let modal = new Noty({
                    timeout: false,
                    layout: 'center',
                    modal: true,
                    type: type,
                    text: text,
                    buttons: [
                        Noty.button(btnText, `btn ${btnClass}`, function () {
                            // Delete user and close modal
                            deleteUser(id);
                            modal.close();
                        }),
                        Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
                            modal.close();
                        })
                    ]
                }).show();
            });
        });
        // Delete a user
        function deleteUser(id) {
            let pars = {
                '_token': '{{ csrf_token() }}',
                '_method': 'delete'
            };
            $.post(`/admin/users/${id}`, pars, 'json')
                .done(function (data) {
                    console.log('data', data);
                    // Show toast
                    new Noty({
                        type: data.type,
                        text: data.text
                    }).show();
                    setTimeout(function(){
                        location.reload();
                    },3000);
                })
                .fail(function (e) {
                    console.log('error', e);
                });
        }

    </script>
@endsection