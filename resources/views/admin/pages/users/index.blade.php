@extends('admin.layouts.app')

@section('content')
    @include('admin.includes.user-delete-modal')
    <div class="right-sidebar">
        <div class="page-title">Пользователи</div>
        <div class="card">
            <div class="card-body">
                {{-- Session popup --}}
                @include('admin.includes.toastr-session-messages')
                <table class="table table-striped table-hover" id="theTable">
                    <tr>
                        <th>ID</th>
                        <th>Имя пользователя</th>
                        <th>Email</th>
                        <th>Создан</th>
                        <th>Обновлён</th>
                        <th>Роль</th>
                        <th>Действия</th>
                    </tr>
                    @foreach($users as $user)
                        <tr id="trID_{{ $user->id }}">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td>
                                @if($user->isAdmin())
                                    Администратор
                                @else
                                    Пользователь
                                @endif
                            </td>
                            <td class="actions">
                                <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}"></a>
                                <input type="hidden" name="_method" value="delete"/>
                                <a class="btn btn-danger btn-sm" title="Delete" data-toggle="modal"
                                   href="#modalDelete"
                                   data-id="{{$user->id}}"
                                   data-token="{{ csrf_token() }}">
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
