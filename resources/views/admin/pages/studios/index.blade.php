@extends('admin.layouts.app')

@section('content')
    @include('admin.includes.studio-delete-modal')
    <div class="right-sidebar">
        <div class="page-title">Переговорные комнаты</div>
        <div class="card">
            <div class="card-header">
                <div class="add-button-block">
                    {{-- Кнопка для добавления комнат --}}
                    <a class="btn btn-primary" href="{{ url('/admin/studios/create') }}">Добавить комнату</a>
                </div>
            </div>
            <div class="card-body">
                {{-- Session popup --}}
                @include('admin.includes.toastr-session-messages')
                <table id="theTable" class="table table-striped table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Создана</th>
                        <th>Обновлёна</th>
                        <th>Ссылка</th>
                        <th>Действия</th>
                    </tr>
                    @foreach($studios as $studio)
                        <tr id="trID_{{$studio->id}}">
                            <td>{{ $studio->id }}</td>
                            <td>{{ $studio->name }}</td>
                            <td>{{ $studio->description }}</td>
                            <td>{{ $studio->created_at }}</td>
                            <td>{{ $studio->updated_at }}</td>
                            <td>{{ $studio->slug }}</td>
                            <td class="actions">
                                <a class="btn btn-primary" href="{{ route('studios.edit', $studio->id) }}"></a>
                                <div class="delete-item">
                                    <input type="hidden" name="_method" value="delete"/>
                                    <a class="btn btn-danger btn-sm" title="Delete" data-toggle="modal"
                                       href="#modalDelete"
                                       data-id="{{$studio->id}}"
                                       data-token="{{csrf_token()}}">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
