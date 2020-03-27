@extends('admin.layouts.app')

@section('content')
    <div class="right-sidebar">
        <div class="page-title">Добавить комнату</div>
        <div class="card">
            <div class="card-body">
                <div class="studio-form">
                    <div class="errors-block">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                    </div>
                    {!! Form::open(['route' => 'studios.store']) !!}
                    <div class="form-group">
                        {{ Form::label('studio-name', 'Название') }}
                        {{ Form::text('studio-name', null, ['id' => 'studio-name', 'class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', 'Описание') }}
                        {{ Form::text('description', null, ['id' => 'description', 'class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('slug', 'Slug') }}
                        {{ Form::text('slug', null, ['id' => 'slug', 'class' => 'form-control']) }}
                    </div>
                    {{ Form::submit('Сохранить', ['class' => 'btn btn-primary']) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
