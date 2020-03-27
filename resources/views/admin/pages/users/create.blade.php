@extends('admin.layouts.app')

@section('content')
    <div class="right-sidebar">
        <div class="page-title">Добавить пользователя!</div>
        <div class="card">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="user-form">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br/>
                    @endif
                    {!! Form::open(['route' => 'users.store']) !!}
                    <div class="form-group bold-label">
                        {{ Form::label('name', 'Имя') }}
                        {{ Form::text('name', null, ['id' => 'name', 'class' => 'form-control']) }}
                    </div>
                    <div class="form-group bold-label">
                        {{ Form::label('roles', 'Роль') }}
                        {{ Form::text('roles', null, ['id' => 'roles', 'class' => 'form-control']) }}
                    </div>
                    {{ Form::submit('Сохранить', ['class' => 'btn btn-primary-outline']) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
